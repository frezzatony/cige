<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Textbox_bsform extends Bsform_defaults{

    

    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','required','readonly'));
        
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
   
        //add o INPUT
        $arrInput['id'] = $this->getInputId($arrInput);
        $arrReturn['id'] = $arrInput['id'];
        $arrReturn['tag'] = 'input';
        $arrReturn['type'] = 'text';
        $arrReturn['class'] = $this->CI->common->append($arrInput['class']??array(),array('form-control'));
        $arrReturn['class'] = $this->CI->common->append($arrReturn['class'],$arrInput['input_class']??array());
        $arrReturn['value'] = $arrInput['value'] ?? NULL;
        $arrReturn['autocomplete'] = 'off';
        

        foreach ($arrInput as $key => $attribute){
            if (!in_array($key, $this->arrNoAttribute)){
                $arrReturn[$key] = (is_array($attribute) ? implode(' ', $attribute) : $attribute);
            }
        }
        
        
        if($arrInput['readonly'] ?? FALSE){
            $arrReturn['readonly'] = true;
        }
        
        if($arrInput['placeholder'] ?? FALSE){
            $arrReturn['placeholder'] = $arrInput['placeholder'];
        }
        
        if($arrInput['data-mask'] ?? FALSE){
            $arrReturn['data-mask'] = $arrInput['data-mask'];
        }
        
        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            
            $arrReturn = $this->getDefaultLayout(
                array(
                    'input'     => $arrInput,
                    'children'  => $arrReturn,
                )
            );
        }
        
        return $arrReturn;

    }
    
    /**
     * PRIVATES
     */
}

?>