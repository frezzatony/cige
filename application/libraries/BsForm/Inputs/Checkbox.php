<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Checkbox_bsform extends Bsform_defaults{
    
    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/checkbox-radio/css/checkbox_radio_img_sprite.css');
        
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','required'));
        
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
   
        
        //add o INPUT
        $arrInput['id'] = $this->getInputId($arrInput);
        $arrReturn['id'] = $arrInput['id'];
        $arrReturn['tag'] = 'input';
        $arrReturn['type'] = 'checkbox';
        $arrReturn['data-value'] = $arrInput['data-value'] ?? NULL;
        $arrReturn['value'] = $arrInput['value'] ?? NULL;
        $arrReturn['autocomplete'] = 'off';
        $arrReturn['class'] = array_merge(
            ($arrInput['class'] ?? array()),
            array('form-control')
        );
        
        if($arrReturn['value'] AND $arrReturn['data-value'] == $arrReturn['value']){
            $arrReturn['checked'] = 'checked';
        }

        foreach ($arrInput as $key => $attribute){
            if (!in_array($key, $this->arrNoAttribute)){
                $arrReturn[$key] = (is_array($attribute) ? implode(' ', $attribute) : $attribute);
            }
        }
        
        
        if(($arrInput['disabled'] ?? FALSE) OR ($arrInput['readonly'] ?? FALSE)){
            $arrReturn['disabled'] = true;
        }
        
        
        $arrReturn = array(
            'tag'       =>  'div',
            'class'     =>  array('checkbox checkbox-xs'),
            'children'  =>  array(
                array(
                    'tag'       =>  'label',
                    'children'  =>  array(
                        $arrReturn,
                        array(
                            'tag'       =>  'i',
                            'class'     =>  'fa fa-lg icon-checkbox',
                        ),
                        array(
                            'text'  =>  $arrInput['label'] ?? NULL
                        )
                    ),
                )
            )
        );
        
        $arrInput['no_label'] = TRUE;
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