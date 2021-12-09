<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Checkbox_bsform extends Bsform_defaults
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
        
        
        
        //add os nodes do inputs (checkboxes)
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
                                        'type'  => 'checkbox',
                                        'name'  => $arrInput['id'],
                                        'id'    =>  $arrInput['id'],
                                        'value' => $option['value'],
                                        'class' => (isset($arrInput['class']) ? $arrInput['class'] . ' ' : '') .
                                            ' icheck',
                                        ), array(
                                        'tag' => 'span',
                                        'class' => 'size-13 weight-100',
                                        'text' => $option['text'], //strtoMAIsuculo($option['text']),
                                        ))), ))));

            foreach ($arrSizeColGrid as $keyCol => $sizeCol)
            {
                $arrReturn[$keyOption]['class'] = 'col-' . $keyCol . '-' . $sizeCol . ' ' . $arrReturn[$keyOption]['class'];
            }
            
            if (is_array($arrInput['value']) AND array_search($option['value'], $arrInput['value'])!==FALSE)
            {
                $arrReturn[$keyOption]['children'][0]['children'][0]['children'][0]['checked'] = 'checked';
            }

            if (isset($arrInput['readonly']) AND $arrInput['readonly'])
            {
                $arrReturn[$keyOption]['children'][0]['children'][0]['children'][0]['disabled'] =
                    'disabled';
            }


        }
        
        $rowClass = 'col-xs-24 col-md-24 col-sm-24 col-lg-24 bordered bg-white text-semi-black';
        
        if(array_key_exists('no_padding',$arrInput)!==TRUE || $arrInput['no_padding']!==TRUE){
            $rowClass .= ' padding-top-10 padding-bottom-10';    
        }
         
        $arrReturn = array(
            'tag'   => 'div',
            'class' =>  'row',
            'children'  =>  array(
                array(
                    'tag'       =>  'div',
                    'class'     => $rowClass,
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

    function getInputValue($arrInput = array()){   
        
        $form = new Form;
            
        $value = array();

        if(isset($arrInput['value']) AND !is_array($arrInput['value'])){
            $arrInput['value'] = Json::getFullArray($arrInput['value']);
            
        }
        
        if(isset($arrInput['value']) AND is_array($arrInput['value'])){
            $value = array_column($arrInput['value'],$form->query->checkbox->getColumnValueName($arrInput));
        }
        //tenta recuperar valor por outro método, recebendo do form
        if(sizeof($value)<=0 AND isset($arrInput['value']) AND is_array($arrInput['value'])){
            $value = array_column($arrInput['value'],'value');
        }
        
        if(is_array($value)){
            foreach($value as $key => $val){
                if($val==''){
                    unset($value[$key]);
                }
            }
        }
        
        $value = $this->CI->security->xss_clean($value);
        
        return ($value ? $value : array());

    }

    /**
     * PRIVATES
     */
}

?>