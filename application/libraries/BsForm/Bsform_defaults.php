<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Bsform_defaults extends Data{
    
    protected $CI; 
    protected $arrNoAttribute = array(
        'tag','type','autocomplete','value',
        'options','mask','from','input_class','grid-col','label','variable','db_column','no_label','no_fieldset',
        'grid_class','grid_lg','grid_md','grid_sm','grid_xs','input_lg','input_md','input_sm','input_xs',
        'parent','input-col'
    );
    
    
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        if($arrProp){
            $this->set($arrProp);
        }
    }
    
    protected function getInputId($arrInput = array()){
        
        if(!isset($arrInput['id']) || !$arrInput['id']){
            $arrInput['id'] = random_string();
        }
        
        return $arrInput['id'];
            
    }
    
    protected function getDefaultLayout($arrProp = array()){
        
        $arrFormGroup   = $this->getFormGroup($arrProp['input']);
        
        $arrFormGroup['children'] = array(
            $this->getInputLabel($arrProp['input']),
        );
        
        $arrTempChildren = array();
        
        foreach($arrProp['children'] as $key=>$val){
            if(is_numeric($key)){
                $arrTempChildren[] = $val;
                unset($arrProp['children'][$key]);    
            } 
        }
        
        $arrFormGroup['children'][] = $arrProp['children'];
        
        
        foreach($arrTempChildren as $children){
            
            $arrFormGroup['children'][] = $children;    
        }
        
        $arrGrid = $this->getGrid($arrProp['input']);
        
        $arrGrid['children'][0] = $arrFormGroup;
        return $arrGrid;
    }
     
    protected function getFormGroup($arrInput = array(),$idParent = null){
        
        if(isset($arrInput['no_fieldset']) AND $arrInput['no_fieldset']){
            return NULL;
        }
        
        $arrClass = array('xs','md','sm','lg');
        $formGroupClass = array(
            'form-group','nopadding',
        );
        
        $formGroupClass = array_merge(string_to_array($arrInput['formgroup-class'] ?? array()) ,$formGroupClass);
        
        if(array_key_exists('input-col',$arrInput) AND is_array($arrInput['input-col'])){
             foreach($arrInput['input-col'] as $key => $val){
                unset($arrClass[array_search($key,$arrClass)]);
                $formGroupClass[] = 'col-'.$key.'-'.$val;
             }
        }
        
        foreach($arrClass as $key){
            $formGroupClass[] = 'col-'.$key.'-24';
        }
        
        return array(
            'tag'       =>  'div',
            'class'     =>  $formGroupClass,
        );
    }
    
    protected function getGrid($arrInput = array()){
        
        if(isset($arrInput['no_grid']) AND $arrInput['no_grid']){
            return array();
        }
                 
        $arrClass = array('xs','md','sm','lg');
        $gridClass = array(
            'bsform-input','nopadding '.'padding-left-2','padding-right-6',
        );
        
        if(isset($arrInput['grid_class'])){
            if(is_array($arrInput['grid_class'])){
                if(array_search('child',$arrInput['grid_class']) === FALSE){
                    $arrInput[] = 'bsform-parent';
                }
                
                $gridClass = array_merge($gridClass,$arrInput['grid_class']);
            }
            else{
                $gridClass[] = $arrInput['grid_class'];
            }
        }
        
        if(array_search('child',$gridClass)===FALSE){
            $gridClass[] = 'bsform-parent';
        }        
        
        if(array_key_exists('grid-col',$arrInput) AND is_array($arrInput['grid-col'])){
             foreach($arrInput['grid-col'] as $key => $val){
                unset($arrClass[array_search($key,$arrClass)]);
                $gridClass[] = 'col-'.$key.'-'.$val;
             }
        }
        
        
        foreach($arrClass as $key){
            $gridClass[] = 'col-'.$key.'-24';
        }
        
        
        if(isset($arrInput['input_type']) AND $arrInput['input_type'] == 'hidden'){
            $gridClass[] = 'hidden-xs hidden-sm hidden-md hidden-lg';    
        }
        
        return array(
            'tag'           => 'div',
            'class'         => $gridClass,
            'data-input'    => (isset($arrInput['type']) ?  $arrInput['type'] : null),
        );
        
    }
    
    protected function getInputMaskValue($arrInput = array()){
        
        if(!isset($arrInput['value']) || !$arrInput['value']){
            return null;
        }
        
        if(isset($arrInput['mask_value']) AND is_array($arrInput['mask_value'])){
            
            foreach($arrInput['mask_value'] as $mask){
                
                $mask['value'] = $arrInput['value'];
                $arrInput['value'] = call_user_func('mask_'.$mask['mask'],$mask);   
                
            }
        }
        
        return $arrInput['value'];
    }
    
    
    public function getInputOptions($arrInput = array()){
        
        $data = new Data($arrInput);
        
        $arrReturn = array();
        
        if($data->get('options') AND is_array($data->get('options'))){
            $arrReturn = array_merge($arrReturn,$data->get('options'));
        }
        
        else if($data->get('from') AND $data->get('from.module') ){
            
            $arrReturn = array_merge($arrReturn,$this->getOptionsFromModule($data));
        }
        
        return $arrReturn;
    }
    
    /**
     * PRIVATES & PROTECTEDS
     */
    
    private function getOptionsFromModule($data){
       
        $arrReturn = array();
        
        $className = $data->get('from.module');
        $library = new $className(
            array(
                'requests_id'   =>  array($data->get('from.request'))
            )
        );
        
        $arrProp = array(
            'simple_get_items'   =>  TRUE,
            'filters'       =>  ($data->get('from.filters') ?? NULL),
            'order'         =>  NULL,
            'limit'         =>  ($data->get('from.limit') ??  NULL),
        );
        
        if($data->get('from.order')){
            $arrProp['order'] = $library->getOrderBy(
                $data->get('from.order')
            );
        }
        
        $method = $data->get('from.method') ? $data->get('from.method') : 'getItems';
        
        $arrDataItems = $library->{$method}($arrProp);
        
        foreach($arrDataItems as $row){
            $optionValue = '';
            $optionText = '';
            $returnData = array();
            
            //OPTION VALUE
            foreach($data->get('from.value') as $fromValue){
                if(is_array($fromValue)){
                    continue;    
                }
                
                if(array_key_exists($fromValue.'_value',$row)){
                    $optionValue .= $row[$fromValue.'_value'];
                    
                }
                
            }
            //FIM OPTION VALUE
            
            //OPTION VALUE
            foreach($data->get('from.text') as $fromText){
                if(is_array($fromText)){
                    continue;    
                }
                
                if(array_key_exists($fromText.'_text',$row)){
                    $optionText .= $row[$fromText.'_text'];
                    
                }
                else if(array_key_exists($fromText.'_value',$row)){
                    $optionText .= $row[$fromText.'_value'];
                    
                }
                
            }
            //FIM OPTION VALUE
            
            //EXTRA DATA
            $extraData = array();
            foreach($data->get('from.return_data')??array() as $returnData){
                
                $mask = $library->variables->get($returnData['id'].'.mask');
                
                $extraData[] = array(
                    'name'          =>  $returnData['name']??$returnData['id'],
                    'value'         =>  ($row[$returnData['id'].'_value']??NULL),
                    'text'          =>  ($row[$returnData['id'].'_text']??NULL),
                    'mask'          =>  $mask,
                    'value-masked'  =>  $this->CI->mask->mask(($row[$returnData['id'].'_value']??NULL),$mask),
                    'text-masked'   =>  $this->CI->mask->mask(($row[$returnData['id'].'_text']??NULL),$mask),
                );
                
            }
            //FIM EXTRA DATA
            
            $arrReturn[] = array(
                'value'     =>  ($data->get('cryptographic_value') ? $this->CI->encryption->encrypt($optionValue) : $optionValue),
                'text'      =>  $optionText,
                'data'      =>  $extraData,   
            );
        }
        
        return $arrReturn;
    }   
    protected function getInputLabel(&$arrInput = array(),$idParent = null){
        
        if(!isset($arrInput['label']) || (isset($arrInput['no_label']) AND $arrInput['no_label'])){
            return array();
        }
        
        $labelText = $arrInput['label'];
        if(isset($arrInput['validate']) AND $arrInput['validate']){
            $labelText .= '&nbsp;<i class="fa fa-shield" title="Este campo possui regras de validação"></i>';
            
        }
        
        if(isset($arrInput['from_list']) AND $arrInput['from_list']){
            $labelText .= '&nbsp;<i class="fa fa-list-alt" title="Valores fornecidos por uma lista"></i>';
            
        }
        
        if(isset($arrInput['from_rest']) AND $arrInput['from_rest']){
            $labelText .= '&nbsp;<i class="fa fa-database" title="Valores fornecidos por um servidor externo"></i>';
            
        }
        
        
        if(isset($arrInput['required']) AND $arrInput['required']){
            $labelText .= ' <span class="required" title="Campo obrigatório">*</span>';
            
        }
        
        return array(
            'tag'       => 'label',
            'class'     => $this->CI->common->append(array('control-label','block'),($arrInput['label_class']??array())) ,
            'for'       => (isset($arrInput['id']) ? $arrInput['id'] : ''),
            'parent_id' => $idParent,
            'text'      => $labelText,
            
        );
          
    }
    
    
    protected function getSizeColGrid($arrInput = array(), $return = false){
                
        return array(
            'xs'    => (isset($arrInput['grid_xs']) ? $arrInput['grid_xs'] : 24),
            'sm'    => (isset($arrInput['grid_sm']) ? $arrInput['grid_sm'] : 24),
            'md'    => (isset($arrInput['grid_md']) ? $arrInput['grid_md'] : 24),
            'lg'    => (isset($arrInput['grid_lg']) ? $arrInput['grid_lg'] : 24),
        );
        
        
    }
    
    protected function getSizeColInput($arrInput = array()){
        
        $arrGrid =  array(
            'xs'    => (isset($arrInput['input_xs']) ? $arrInput['input_xs'] : 24),
            'sm'    => (isset($arrInput['input_sm']) ? $arrInput['input_sm'] : 24),
            'md'    => (isset($arrInput['input_md']) ? $arrInput['input_md'] : 24),
            'lg'    => (isset($arrInput['input_lg']) ? $arrInput['input_lg'] : 24),
        );  
        
        return $arrGrid;
    }
    
    protected function getTextClasss($arrInput = array()){
        
        $class = '';
        if(isset($arrInput['text_class']) AND $arrInput['text_class']){
            if(is_array($arrInput['text_class'])){
                foreach($arrInput['text_class'] as $rowClass){
                    if($class){
                        $class.= ' ';
                    }
                    
                    $class .= $rowClass;
                }
            }
            else{
                $class = $arrInput['text_class'];
            }
            
            $class = trim($class);
            $class = ' '.$class;
        }
        
        return $class;
        
     }
     
}
?>