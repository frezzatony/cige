<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Password_bsform extends Bsform_defaults{

    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
   
        //add o INPUT
        $arrInput['id'] = $this->getInputId($arrInput);
        $arrReturn['id'] = $arrInput['id'];
        $arrReturn['tag'] = 'input';
        $arrReturn['type'] = 'password';
        $arrReturn['class'] = $this->CI->common->append($arrInput['class']??array(),array('form-control'));
        $arrReturn['class'] = $this->CI->common->append($arrReturn['class'],$arrInput['input_class']??array());
        $arrReturn['value'] = $arrInput['value'] ?? NULL;
        $arrReturn['autocomplete'] = 'off';
        
        if(array_key_exists('readonly',$arrInput) AND $arrInput['readonly']){
            $arrReturn['readonly'] = true;
        }
        
        if(array_key_exists('placeholder',$arrInput)){
            $arrReturn['placeholder'] = $arrInput['placeholder'];
        }
        
        if(array_key_exists('data-mask',$arrInput)){
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