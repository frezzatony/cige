<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Year_bsform extends Bsform_defaults
{

    protected $CI;

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
        $arrReturn['data-mask'] = '9999';
        $arrReturn['placeholder'] = '____';
        $arrReturn['class'] = $this->CI->common->append($arrInput['class']??array(),array('form-control','year'));
        append($arrReturn['class'],($arrInput['input_class']??NULL));
        
        $arrReturn['value'] = $arrInput['value'] ?? NULL;
        $arrReturn['value'] = $arrReturn['value'] ? $arrReturn['value'] : NULL;
        $arrReturn['autocomplete'] = 'off';

        if (isset($arrInput['readonly']) AND $arrInput['readonly'])
        {
            $arrReturn['readonly'] = true;
        }

        if (isset($arrInput['placeholder']) AND $arrInput['placeholder'])
        {
            $arrReturn['placeholder'] = $arrInput['placeholder'];
        }

        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            $arrReturn = $this->getDefaultLayout(array(
                'input' => $arrInput,
                'children' => $arrReturn,
                ));
        }

        return $arrReturn;

    }


    /**
     * PRIVATES
     */
}

?>