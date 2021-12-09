<?php

/**
 * @author Tony Frezza

 */


class Form
{
    
    private $CI;
    private $bsform;
    private $inputs;
    private $prop;
    private $initialized = false;
    
    public $query;
     
    function __construct()
    {
        
        $this->CI = &get_instance();
        $this->bsform = new BsForm;
                
        require_once(dirname(__FILE__).'/Form/PostgreQuery.php');
        $this->query = new Query_form;
        
        
    }
    
    public function addInputs($arrInputs){
        foreach($arrInputs as $input){
            $this->inputs[] = $input;
        }
        
    }
    public function getCheckDefaultInputs($arrProp = array()){
        
        if(!isset($arrProp['parent'])){
            $arrProp['parent'] = $this->prop;
            $arrProp['parent']['inputs'] = $this->inputs;
        }
        
        $arrProp['parent']['inputs'] = $this->getDecryptInputs(
            array(
                'values'    =>  $arrProp['parent']['inputs'],
            )
        ); 
        $arrProp['values'] = $this->getDecryptInputs($arrProp);    
        
        foreach($arrProp['parent']['inputs'] as $input){
            
            if(isset($input['encrypt']) AND $input['encrypt']){
                $keyValue = array_search($input['id'],array_column($arrProp['values'],'id'));
                
                if($keyValue === false){
                    return false;
                }
                
                
                if($this->bsform->{$input['input_type']}->getInputValue($input['value']) != $this->bsform->{$input['input_type']}->getInputValue($arrProp['values'][$keyValue]['value'])){
                    return false;
                }
                    
            }

        }
        
        return true;
        
    } 
    
    public function getCompareInputs($arrValues = array()){
        
        if(!isset($arrValues['inputs'])){
            $arrValues['inputs'] = $this->inputs;
            $arrValues['values'] = $arrValues;
        }
        
        foreach($arrValues['inputs'] as $input){
            //caso nao localize na coluna de id's dos values, erro
            if(!in_array($input['id'],array_column($arrValues['values'],'id'))){
                return false;
            }
            if(isset($input['inputs']) AND is_array($input['inputs'])){
                $arrInputValues = $arrValues[array_search($input['id'],array_column($arrValues,'id'))];
                
                foreach($arrInputValues['value'] as $row){
                    if(!self::getCompareInputs(array(
                        'inputs'    => $input['inputs'],
                        'values'    => $row 
                    ))){
                        
                        return false;
                    }
                    
                }
            }  
        } 
        
        //passou na verificacao, tudo ok!
        return true;

    }
    
    public function getDataGroup($arrProp = array()){
        
        
        if(!$arrProp){
            $arrProp = $this->prop;
            $arrProp['inputs'] = $this->inputs;
        }
        
        return $this->query->getDataGroup($arrProp);
            
    }    
    
    public function getDecryptValues($arrValues = array()){
        
        if(!$this->inputs OR !$arrValues){
            return $arrValues;
        }
        
        foreach($this->inputs as $input){
            
            $keyValue = array_search($input['id'],array_column($arrValues,'id'));
            
            if($keyValue===false || (!isset($input['encrypt']) || !$input['encrypt'])){
                continue;
            }
            
            if(isset($arrValues[$keyValue]['value'])){
                $arrValues[$keyValue]['value'] = $this->CI->encryption->decrypt($arrValues[$keyValue]['value']);   
            }
            
        }
        
        return $arrValues;
        
    }
    public function getInputsDifferenceValue($arrProp = array()){
         
        $arrInputsReturn = array();
        
        if(!isset($arrProp['parent'])){
            $arrProp['parent'] = array(
                'prop'      =>  $this->prop,
                'inputs'    =>  $this->inputs,
            );
        }
        
        
        $arrProp['parent']['inputs'] = $this->getDecryptInputs(
            array(
                'values'    =>  $arrProp['parent']['inputs'],
            )
        ); 
        $arrProp['values'] = $this->getDecryptInputs($arrProp);    
        
        foreach($arrProp['parent']['inputs'] as $input){
            
            if(isset($input['no_form']) AND $input['no_form']){
                continue;
            }
            
            $keyInput = array_search($input['id'],array_column($arrProp['parent']['inputs'],'id'));
            
            $input['value'] = $this->query->getInputValuesStoredToReceived($input);
            
            $valueStored = $this->bsform->{$input['input_type']}->getInputValue($input);
            $valueStored = Json::getFullArray($valueStored);
            
            if(is_array($valueStored)){
                $valueStored = $this->_removeTextKey($valueStored);
                $valueStored = json_encode($valueStored,256);
            }       
                  
            $keyInputValue = array_search($input['id'],array_column($arrProp['values'],'id'));
            $input['value'] = $arrProp['values'][$keyInputValue]['value'];
            
            $valueReceived = $this->bsform->{$input['input_type']}->getInputValue($input);
            $valueReceived = Json::getFullArray($valueReceived);
            
            if(is_array($valueReceived)){
                $valueReceived = $this->_removeTextKey($valueReceived);
                $valueReceived = json_encode($valueReceived,256);
            } 
              
            $flagHasDifference = FALSE;
            
            if($valueStored!=$valueReceived){
                
                if(method_exists($this->query->{$input['input_type']},'getCompareValues')){
                    $flagHasDifference = $this->query->{$input['input_type']}->getCompareValues($valueStored,$valueReceived);
                }
                else{
                    $flagHasDifference = TRUE;
                }
                
            }
            
            if($flagHasDifference===TRUE){
                $arrInputsReturn[] = $arrProp['values'][$keyInputValue];
            }
        }   
        return $arrInputsReturn;       
        
    }
    
    public function getFormHtml(){
        
        $arrProp = $this->prop;
        $arrProp['inputs'] = $this->inputs;
        
        $this->bsform->setNew($arrProp);
        
        return $this->bsform->getFormHtml();
    }
    
    public function getInput($inputId,$inputs=NULL,$parent='form'){
        
        if($inputs===NULL){
            $inputs = $this->inputs;
        }
        
        foreach($inputs as $input){
            if($input['id']==$inputId){
                $input['parent'] = $parent;
                return $input;
            }
            else if(array_key_exists('inputs',$input)){
                $inputChild = $this->getInput($inputId,$input['inputs'],$parent.'.'.$input['id']);
                if($inputChild!==FALSE){
                    return $inputChild;    
                }    
            }
        }
        
        return false;   
    }
    
    public function getInputs($arrProp = array()){
        
        return $this->inputs;
    }
    
    public function getInputsLog($arrProp = array()){
        
        $arrDataReturn = array();
        
        foreach($this->inputs as $input){
            if(!isset($input['no_form']) || !$input['no_form']){
                $arrDataReturn[] = array(
                    'label' =>  (isset($input['label']) ? $input['label'] : $input['id']),
                    'value' => isset($input['value']) ? $input['value'] : null,
                );
                
                if(isset($input['text'])){
                    $arrDataReturn[sizeof($arrDataReturn)-1]['text'] = $input['text'];
                }
            }
        }
        
        return $arrDataReturn;
        
    }
    public function getInputValue($arrInput = array()){
        
        if(!isset($arrInput['value'])){
            //BUSCAR VALUE NO FORM ARMAZENADO?!!?!
            return '';
        }
        
        return $this->bsform->{$arrInput['input_type']}->getInputValue($arrInput);
        
        
        
    }     
    public function getInputsProp($arrProp = array())
    {
        
        $arrReturn = array();    
        foreach($arrProp['inputs'] as $input){
            $arrReturn[sizeof($arrReturn)] = array(
                'id' => isset($input['id']) ? $input['id'] : random_string(),
            );
            
            if(isset($input[$arrProp['propertie']])){
                $arrReturn[(sizeof($arrReturn)-1)] = array(
                    $arrProp['propertie']  = $input[$arrProp['propertie']],     
                );
                
            }
            else if(isset($arrProp['supress_by'])){
                $arrReturn[(sizeof($arrReturn)-1)] = array(
                    $arrProp['propertie']  = $input[$arrProp['supress_by']],     
                );        
            }
            else{
                $arrReturn[(sizeof($arrReturn)-1)] = array(
                    $arrProp['propertie']  = null     
                );        
                
            }  
        }
        
        return $arrReturn;
    }
    
    public function getTableAlias(){

        return $this->prop['table_base_alias'] ?? 'TForm';
        
    }
    
    public function getValidation($arrProp = array()){
         
        $arrDataReturn = array();
        
        if(!($this->prop['validation'] ?? NULL)){
            return NULL;
        }
        
        foreach($this->prop['validation'] as $rule){
            
            $ruleName = $rule['rule'];
            
            $arrTempProp = array(
                'form'  =>  $this->prop
            );
            
            $arrTempProp['form']['inputs'] = $this->inputs;
            $arrTempProp['rule'] = $rule;
            $arrTempProp['data_select'] = $this->getQuerySelectData();
            
            if(!$this->CI->validation->{$ruleName}->run($arrTempProp)){
                $arrDataReturn[] = $rule;
            }
            
        }
        
        
        return $arrDataReturn;    
    }
    
    public function initializeForm(){
        
        foreach($this->inputs as &$input){
            if(isset($input['value']) AND $input['value']!==false){
                $input['value_by_default'] = true;
            }
            
            if(method_exists($this->query->{$input['input_type']},'initialize')){
                $arrParent = $this->prop;
                $arrParent['inputs'] = $this->inputs;
                $input = $this->query->{$input['input_type']}->initialize(
                    array(
                        'parent'=>  $arrParent,
                        'input' =>  $input,
                    )
                );
            }
            
            if(method_exists($this->bsform->{$input['input_type']},'initialize')){
                $arrParent = $this->prop;
                $arrParent['inputs'] = $this->inputs;
                $input = $this->bsform->{$input['input_type']}->initialize(
                    array(
                        'parent'=>  $arrParent,
                        'input' =>  $input,
                    )
                );
            }
            
            if(
                array_key_exists('db_schema',$this->prop)!==FALSE AND $this->prop['db_schema']!==NULL AND
                array_key_exists('db_schema',$input)===FALSE
            ){
                $input['db_schema'] = $this->prop['db_schema']; 
            }
        } 
        
        
        
        $this->initialized = true;      
        
    }
    
    public function setNew($arrProp = array()){
        
        unset($this->prop);
        unset($this->inputs);
               
        //set dos inputs 
        if(isset($this->CI->config->item('form','form')['inputs']['before_inputs'])){
            $arrProp['inputs'] = array_merge($this->CI->config->item('form','form')['inputs']['before_inputs'],$arrProp['inputs']);
        }
        
        if(isset($this->CI->config->item('form','form')['inputs']['after_inputs'])){
            $arrProp['inputs'] = array_merge($arrProp['inputs'],$this->CI->config->item('form','form')['inputs']['after_inputs']);
        }          
        
        $this->inputs = $arrProp['inputs'];    
        unset($arrProp['inputs']);
        
        $this->prop = $arrProp;
        
        if(!isset($this->prop['table_base_alias'])){
            $this->prop['table_base_alias'] = 'TForm';
        }
        
        
        $this->setDeafultValues();
        
        $this->initializeForm();
        
        $this->CI->data->setSystemData(
            array(
                'form'      =>  array(
                    'inputs'    =>  $this->inputs,
                    'prop'      =>  $this->prop
                )
            )
        );
    }
    
    public function setValues($arrValues = array()){
        
        if(!$arrValues){
            return FALSE;
        }

        foreach($this->inputs as &$input){
        
            $keyValue = array_search($input['id'],array_column($arrValues,'id'));
            
            if($keyValue!==false){
                
                $input['value'] = $this->bsform->{$input['input_type']}->getInputValue($arrValues[$keyValue]);
                
                
                if(isset($arrValues[$keyValue]['text'])){
                    $input['text'] = $arrValues[$keyValue]['text'];
                }
                
                if(isset($input['encrypt']) AND $input['encrypt']){
                    if(in_array($this->prop['method'],array('insert','update'))===false){
                        $input['value'] = $this->CI->encryption->encrypt($input['value']); 
                    }
                }
                
            }
            
            if($keyValue === false){ 
                if(array_key_exists($this->query->getColumnValueName($input),$arrValues)){
                    $input['value'] = $arrValues[$this->query->getColumnValueName($input)];
                    
                    if(isset($input['encrypt']) AND $input['encrypt']){
                        if(in_array($this->prop['method'],array('insert','update'))===true){
                            $input['value'] = $this->CI->encryption->decrypt($input['value']);   
                        }
                        else{
                            $input['value'] = $this->CI->encryption->encrypt($input['value']);      
                        }
                    }
                }  
            }   
            
            
            
        }
        
        $this->CI->data->setSystemData(
            array(
                'form'      =>  array(
                    'inputs'    =>  $this->inputs,
                    'prop'      =>  $this->prop
                )
            )
        );
       
    }
    
    /**
     * QUERIES DATA
     **/
    public function getQueryOrderColumn($arrProp = array()){
        
        if(!is_array($arrProp['input'])){
            $keyInput = array_search($arrProp['input'],array_column($arrProp['parent']['inputs'],'id'));
            
            if($keyInput===FALSE){
                return array();    
            }
            $arrProp['input'] = $arrProp['parent']['inputs'][$keyInput];
            
        }
        
        return $this->query->getQueryOrderColumn($arrProp);
        
    } 
    public function getQuerySetData($arrProp = array()){
                
        $arrProp = array_merge($this->prop,$arrProp);
        $arrProp['inputs'] = $this->inputs;
        
        
        return $this->query->getQuerySetData($arrProp);
    }
    
    public function getQuerySelectData($arrProp = array()){
        
        $arrProp = array_merge($arrProp,$this->prop);
        $arrProp['inputs'] = $this->inputs;
        
        return $this->query->getQuerySelectData($arrProp);
        
    }
    
    public function getQuerySelectOptionsData($arrInput = array()){
        
        return $this->query->getQuerySelectOptionsData($arrInput);    
    }
    
    
    /**
     * PRIVATES
     */
    private function _removeTextKey($arrValue){
        
        unset($arrValue['text']);
        
        foreach($arrValue as &$row){
            if(is_array($row)){
                $row = $this->_removeTextKey($row);
                
            }
        }
        
        return $arrValue;
         
    }
    private function getDecryptInputs($arrProp = array()){
        
        if(!isset($arrProp['parent'])){
            $arrProp['parent'] = $this->prop;
            $arrProp['parent']['inputs'] = $this->inputs;
        }
        
        foreach($arrProp['parent']['inputs'] as $input){
            
            $keyValue = array_search($input['id'],array_column($arrProp['values'],'id'));
            
            if($keyValue === false){
                continue;
            }
            
            if(!isset($arrProp['values'][$keyValue]['value']) || !$arrProp['values'][$keyValue]['value']){
                continue;
            }
            
            if(isset($input['encrypt']) AND $input['encrypt']){
                $arrProp['values'][$keyValue]['value'] = $this->CI->encryption->decrypt($arrProp['values'][$keyValue]['value']);
                
            }
            
        }
        
        return $arrProp['values'];
        
    }
    
    
    private function setDeafultValues(){
        
        foreach($this->inputs as &$input){
            
            if(array_key_exists('method',$this->prop)){
                $input['method'] = $this->prop['method'];
            }
            
            
            if(isset($input['value']) AND $input['value']){
                
                $input['value_by_default'] = true;
                $var = str_replace('{','',$input['value']);
                $var = str_replace('}','',$var);
                
                
                if($var=='random'){
                    $input['value'] = random_string();    
                }
                else if(!is_array($var)){
                    $varTmp = $this->CI->data->getSystemData($var);
                    $input['value'] = ($varTmp ? $varTmp : $input['value']);
                }
                
            }
            if(!isset($this->prop['method'])){
                return null;
            }
            if(isset($input['encrypt']) AND $input['encrypt']){
                if(in_array($this->prop['method'],array('insert','update'))===false){
                    $input['value'] = isset($input['value']) ? $this->CI->encryption->encrypt($input['value']) : '';    
                }
                  
            } 
        }
        
    }
    
    private function _setInputsFilters($arrProp = array())
    {
        
    }
}

?>