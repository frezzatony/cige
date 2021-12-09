<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dropdown_bsform extends Bsform_defaults{

    function __construct($arrProp = array()){

        parent::__construct($arrProp);
                        
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','required','update_on','ajax_options','readonly'));

    }
   
    
    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }             
        
        $arrReturn = array();
        
        $arrInput['options'] = $this->getInputOptions($arrInput);
        
        
        foreach($arrInput['options']??array() as $keyOption => $option){
            
            foreach($option['return_data']??array() as $extraData){
                
                $strName = $extraData['name'];
                foreach($extraData as $key => $val){
                    $arrInput['options'][$keyOption]['data-return-'.$strName.'-'.$key] = $val;    
                }  
            }
            
            foreach($option['data']??array() as $key => $attribute){
                
                foreach($attribute as $keyDataReturn => $valueDataReturn){
                    
                    if($keyDataReturn == 'name'){
                        continue;
                    }
                    
                    $arrInput['options'][$keyOption]['data-return-'.$attribute['name'].'-'.$keyDataReturn] = (is_array($valueDataReturn) ? implode(' ', $valueDataReturn) : $valueDataReturn);
                        
                }
                
            }
            
            
            unset($arrInput['options'][$keyOption]['return_data']);
            unset($arrInput['options'][$keyOption]['data']);
            
        }
        
        /*
        
        
        
        
        */
        
        
        //READONLY convertendo para Textbox
        if(($arrInput['readonly'] ?? FALSE) AND !($arrInput['dropdown']?? FALSE)){
            return $this->getHtmlDataReadOnly($arrInput);
        }
        else if ($arrInput['readonly'] ?? FALSE){
            $arrReturn['disabled'] = TRUE;
            unset($arrInput['readonly']);
        }
               
        //add o SELECT
        $arrReturn['id'] = $this->getInputId($arrInput);
        $arrReturn['tag'] = 'select';
        $arrReturn['value'] = $arrInput['value'] ?? NULL;
        $arrReturn['class'] = $this->CI->common->append($arrInput['input_class'] ?? array(),array('form-control','padding-3','size-11'));
        $arrReturn['class'] = $this->CI->common->append($arrReturn['class'], $arrInput['class'] ?? array());
        $arrReturn['children'] = array();
        
        
        
        foreach ($arrInput as $key => $attribute){
            if (!in_array($key, $this->arrNoAttribute)){
                $arrReturn[$key] = (is_array($attribute) ? implode(' ', $attribute) : $attribute);
            }
        }

        
        if(array_key_exists('options',$arrInput)!==FALSE AND $arrInput['options']){
            
            foreach ($arrInput['options'] as $data){
                $arrOption = array(
                    'tag'       => 'option',
                    'parent_id' => $arrReturn['id'],
                );
                
                $arrOption = array_merge($arrOption,$data);
                
                if(isset($data['value']) AND $arrReturn['value'] == $data['value']){
                    $arrOption['selected'] = 'selected';
                }
    
                $arrReturn['children'][] = $arrOption;
            }    
        }
        
        if(array_key_exists('first_null',$arrInput) AND $arrInput['first_null']===TRUE){
            $arrOption = array(
                'tag'       => 'option',
                'value'     =>  NULL,
                'text'      =>  NULL,
                'parent_id' => $arrReturn['id'],
            );
            
             array_unshift($arrReturn['children'],$arrOption);                
        }
        

        //add o GRID
        $arrReturn = $this->getDefaultLayout(
            array(
                'input'     =>  $arrInput,
                'children'  =>  $arrReturn,
            )
        );


        return $arrReturn;

    }

    function getHtmlDataReadOnly($arrInput = array()){
    
        $textbox = new Textbox_bsform($arrInput);
        
        if($textbox->get('value')){
            $keyValue = array_search($textbox->get('value'),array_column($textbox->get('options'),'value'));
            
            if($keyValue !== FALSE){
                $optionValue = $textbox->get('options.'.$keyValue);
                $textbox->set('value',$optionValue['text']);
            }
        }
        

        return $textbox->getHtmlData();

    }
    

    /**
     * PRIVATES
     */
}

?>