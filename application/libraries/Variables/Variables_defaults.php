<?php

/**
 * @author Tony Frezza

 */


class Variables_defaults{
    
    protected $CI;
    protected $data;
    
    function __construct($arrProp=array()){
        
        $this->CI = &get_instance();
        $this->data = new Data();
        
        if($arrProp??NULL){
            $this->set($arrProp);
        }
    }
    
    public function append($name, $data){
            return $this->data->append($name,$data);
    } 
    public function get($data=NULL){
        
        if($data == 'value'){
            return $this->getValue();   
        }
        
        $dataReturn = $this->data->get($data);
        
        if(!$data AND is_array($dataReturn) AND array_key_exists('value',$dataReturn)===TRUE){
            
            $dataReturn['value'] = $this->getValue();
        }
        
        return $dataReturn;
    }
    
    public function isset($data=NULL){
        return $this->data->isset($data);
    }
    
    public function getDifferenceValues($arrProp = array()){
                
        if(!in_array($this->get('type'),$this->CI->config->item('with_child','config_variables'))){
            return $this->getDifferenceValueNoChildren($arrProp);
            
        }
        else{
            return $this->getDifferenceValueHasChildren($arrProp);
        }
        
    }
    
    
    public function getValue(){
        
        $values = $this->data->get('value');
        
        return $this->formatValue($values);
        
    }
    
    public function set($arrProp = array(),$arrData = array()){
        $this->data->set($arrProp,$arrData);
    }
    
    public function unset($name,$tag=NULL){
        $this->data->unset($name,$tag);
    }
    
    public function updateRelacionalValue($arrProp = array()){
        
        if(!$this->get('from')){
            return FALSE;
        }
        
        $className = $this->get('from.module');
        
        $module = new $className(
            array(
                'request'   =>  $this->get('from.request'),
            )
        );
        
        $module->setItem($this->get('value'));
        
        foreach($this->get('from.text') as $key => $val){
            $this->set('text',$module->variables->get($val.'.value'));
        }
        
    }
    
    /**
     * PRIVATEs
     **/
    private function getDifferenceValueNoChildren($arrProp = array()){
        
        
        if(!($this->isset('old_value'))){
            $this->set('old_value',NULL);
        }
        
        if($arrProp['method'] ?? NULL){
            $this->set('method',$arrProp['method']);
        }
        
        $arrValues = array(
            'old_value' =>  $this->formatValue($this->get('old_value')),
            'value'     =>  $this->getValue('value'), 
        );
        
        if($this->get('text')){
            $arrValues['old_text']  = $this->get('old_text');
            $arrValues['text'] = $this->get('text');
            
        }
        
        if($arrValues['old_value'] != $arrValues['value']){
            return $arrValues;    
        }
        
        return NULL;
        
    }
    
    
    private function getDifferenceValueHasChildren($arrProp = array()){
        
        $arrValues = array_values($this->get('value'));        
        $arrOldValues = array_values($this->get('old_value'));
        
        $arrReturn = array();
        
        $tempVariables = new Variables;
        foreach($this->variables->getData() as $variableData){
            foreach($variableData as $key => $data){
                if(in_array($key,array('value','old_value','text','old_text'))){
                    unset($variableData[$key]);
                }
            } 
            
            $tempVariables->set($variableData);
        }
        
        
        
        foreach($arrValues as $keyRowValue => $rowValue){
            
            if(($arrOldValues[$keyRowValue]??NULL)){
                foreach($arrOldValues[$keyRowValue] as $variableValue){
                   $variableValue['old_value'] = NULL;
                   $tempVariables->set($variableValue);
                }    
            }
            
            foreach($rowValue as $inputValue){
                
                $tmpInputValue = $inputValue;
                unset($tmpInputValue['id']);
                $tempVariables->set($inputValue['id'],$tmpInputValue);
            }
            
               
                         
            $arrDifferenceValues = $tempVariables->getDifferenceValues($arrProp);
                       
             
            if(sizeof($arrDifferenceValues)){
                
                foreach($arrDifferenceValues as $key => $variableDifference){
                    if($variableDifference['id']=='id'){
                        unset($arrDifferenceValues[$key]);
                    }
                }
                
                $arrReturn[] = array(
                    'old_value'     =>  $arrOldValues[$key] ?? NULL,
                    'value'         =>  $rowValue,
                );
            }
            
        }
        
        if(sizeof($arrOldValues) > sizeof($arrValues)){
            
            foreach($arrOldValues as $key => $rowOldValue){
                if(array_key_exists($key,$arrValues) === TRUE){
                    continue;
                }
                
                $arrReturn[] = array(
                    'old_value'     =>  $rowOldValue,
                    'value'         =>  NULL,
                );
                
            }
        }
        
        return $arrReturn; 
    }
    
}