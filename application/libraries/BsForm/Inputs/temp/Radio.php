<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Radio_bsform extends Bsform_defaults
{

    protected $CI;

    function __construct()
    {

        parent::__construct();
        $this->CI = &get_instance();

    }

    function getInputDataHtml($arrInput = array())
    {

        $arrReturn = array();

        $arrInput['id'] = $this->getInputId($arrInput);

        //monta e adicina os OPTIONS
        $arrInput['options'] = $this->getInputOptions($arrInput);
        $arrInput['value'] = $this->getInputValue($arrInput);

        $arrSizeColGrid = $this->getSizeColInput($arrInput);

        //add os nodes do inputs (radios)
        foreach ($arrInput['options'] as $keyOption => $option)
        {
           
            $arrReturn[$keyOption] = array(
                'tag' => 'div',
                'class' => 'nomargin nopadding ',
                'children' => array(array(
                        'tag' => 'div',
                        'class' => 'nopadding nomargin',
                        'children' => array(array('tag' => 'label', 'children' => array(array(
                                        'tag'   => 'input',
                                        'type'  => 'radio',
                                        'id'    =>  $arrInput['id'],
                                        'name'    =>  $arrInput['id'],
                                        'value' => $option['value'],
                                        'class' => (isset($arrInput['class']) ? $arrInput['class'] . ' ' : '') .
                                            ' icheck',
                                        ), array(
                                        'tag' => 'span',
                                        'class' => 'size-13' . $this->getTextClasss($arrInput),
                                        'text' => strtoMAIsuculo($option['text']),
                                        ))), ))));
            foreach ($arrSizeColGrid as $keyCol => $sizeCol)
            {
                $arrReturn[$keyOption]['class'] = 'col-' . $keyCol . '-' . $sizeCol . ' ' . $arrReturn[$keyOption]['class'];
            }

            if ($option['value'] == $arrInput['value'])
            {
                $arrReturn[$keyOption]['children'][0]['children'][0]['children'][0]['checked'] =
                    'checked';
            }

            if (isset($arrInput['readonly']) AND $arrInput['readonly'])
            {
                $arrReturn[$keyOption]['children'][0]['children'][0]['children'][0]['disabled'] =
                    'disabled';
            }


        }

        $arrReturn = array(
            'tag'   => 'div',
            'class' =>  'row',
            'children'  =>  array(
                array(
                    'tag'       =>  'div',
                    'class'     => 'col-xs-24 col-md-24 col-sm-24 col-lg-24 padding-top-10 padding-bottom-10 bordered bg-white text-semi-black',
                    'children'  => $arrReturn
                )
            )
        );

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

    function getInputHtmlReadOnlyArray($arrInput = array())
    {

        $arrReturn = array();

        //add o GRID
        $arrInput['input_type'] = 'hidden';
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            $arrReturn['children'][] = $this->CI->bsform->hidden->getInputDataHtml($arrInput);
        }

        if (isset($arrInput['value']) AND $arrInput['value'])
        {
            foreach ($arrInput['options'] as $data)
            {
                if ($arrInput['value'] == $data['value'])
                {
                    $arrInput['value'] = $data['text'];
                    break;
                }
            }
        }

        //add o GRID
        $arrInput['input_type'] = 'textboxt';
        $arrInput['id'] = 'noform_' . $arrInput['id'];
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            $arrReturn['children'][] = $this->CI->bsform->textbox->getInputDataHtml($arrInput);
        }

        return $arrReturn;

    }
    function getInputValue($arrInput = array())
    {

        $value = '';

        if (isset($arrInput['value']) AND is_array($arrInput['value']))
        {
            $value = $arrInput['value'][0] ?? NULL;
        } else
            if (isset($arrInput['value']))
            {
                $value = $arrInput['value'];
            } else
                if (isset($arrInput['options']) AND isset($arrInput['options'][0]['value']))
                {
                    //$value = $arrInput['options'][0]['value'];
                }

        $value = $this->CI->security->xss_clean(strip_tags($value));
        return $this->CI->main_model->getFromConfig($value);
    }

    /**
     * PRIVATES
     */

}

?>