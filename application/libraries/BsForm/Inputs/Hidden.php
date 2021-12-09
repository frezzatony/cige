<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hidden_bsform extends Bsform_defaults{

    function __construct($arrProp = array()){

        parent::__construct($arrProp);

    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }

        $arrReturn = array();

        //add o INPUT
        $arrReturn['id'] = $this->getInputId($arrInput);
        $arrReturn['tag'] = 'input';
        $arrReturn['type'] = 'hidden';
        $arrReturn['class'] = $this->CI->common->append($arrInput['class']??array(),array('form-control'));
        $arrReturn['value'] = $arrInput['value'] ?? NULL;
        $arrReturn['autocomplete'] = 'off';

        //add o GRID
        if(!($arrInput['no_grid']??NULL)){
            $arrInput['grid_class'] = $arrInput['grid_class'] ?? array();
            append($arrInput['grid_class'],array('softhide'));
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