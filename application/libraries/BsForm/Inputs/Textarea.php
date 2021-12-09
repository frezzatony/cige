<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Textarea_bsform extends Bsform_defaults{

    

    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','data-height','text'));
        
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
        
        
        //add o INPUT
        $arrInput['id'] = $this->getInputId($arrInput);
        $arrReturn['id'] = $arrInput['id'];
        $arrReturn['tag'] = 'textarea';
        $arrReturn['class'] = array_merge(
            ($arrInput['class'] ?? array()),
            array('form-control')
        );
        
        $arrReturn['text'] = $arrInput['value'] ?? NULL;
        $arrReturn['autocomplete'] = 'off';
        $arrReturn['style'] = '
            resize: vertical;
            min-height: 32px;
        ';
        
        foreach ($arrInput as $key => $attribute){
            if (!in_array($key, $this->arrNoAttribute)){
                $arrReturn[$key] = (is_array($attribute) ? implode(' ', $attribute) : $attribute);
            }
            else if($key == 'data-height'){
                $arrReturn['style'] .= ' height: '.$attribute.'px;';
            }
        }
        
        
        if($arrInput['readonly'] ?? FALSE){
            $arrReturn['readonly'] = true;
        }
        
        if($arrInput['placeholder'] ?? FALSE){
            $arrReturn['placeholder'] = $arrInput['placeholder'];
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