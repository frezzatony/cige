<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Date_bsform extends Bsform_defaults{

    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/jquery-datetimepicker/css/jquery.datetimepicker.css');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/jquery-datetimepicker/js/jquery.datetimepicker.full.js');
        

    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
        
        //add o INPUT
        $arrReturn['id'] = $this->getInputId($arrInput);
        $arrReturn['tag'] = 'input';
        $arrReturn['type'] = 'text';
        $arrReturn['data-mask'] = 'date';
        $arrReturn['placeholder'] = '__/__/____';
        $arrReturn['class'] = $this->CI->common->append($arrInput['class']??array(),array('form-control','date'));
        $arrReturn['value'] = $arrInput['value'] ?? NULL;
        $arrReturn['autocomplete'] = 'off';
        
        if (isset($arrInput['readonly']) AND $arrInput['readonly']!==FALSE){
            $arrReturn['readonly'] = true;
        }

        if (isset($arrInput['placeholder']) AND $arrInput['placeholder']){
            $arrReturn['placeholder'] = $arrInput['placeholder'];
        }

        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            $arrReturn = $this->getDefaultLayout(
                array(
                    'input' => $arrInput,
                    'children' => $arrReturn,
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