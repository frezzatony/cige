<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Datetime_bsform extends Bsform_defaults
{

    protected $CI;

    function __construct()
    {

        parent::__construct();
        $this->CI = &get_instance();

    }

    function getInputDataHtml($arrInput = array())
    {

        //add o INPUT
        $arrReturn['id'] = $this->getInputId($arrInput);
        $arrReturn['tag'] = 'input';
        $arrReturn['type'] = 'text';
        $arrReturn['class'] = (isset($arrInput['class']) ? $arrInput['class'] : '') .
            ' datepicker form-control ';
        $arrReturn['value'] = $this->getInputValue($arrInput);

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

    function getInputValue($arrInput = array())
    {

        if (isset($arrInput['value']) AND is_array($arrInput['value']))
        {
            $value = $arrInput['value'][0] ?? NULL;
        } else
        {
            $value = (isset($arrInput['value']) ? $arrInput['value'] : '');
        }

        $value = $this->CI->security->xss_clean(strip_tags($value));
        $value = formataDataHoraImprime(array('data' => $value));
        return $this->CI->main_model->getFromConfig($value);
    }

    /**
     * PRIVATES
     */
}

?>