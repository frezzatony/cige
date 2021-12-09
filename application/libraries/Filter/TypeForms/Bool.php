<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bool_typeform_filter extends Filter_typeforms_defaults
{

    protected $CI;

    function __construct($arrProp = array())
    {

        parent::__construct();
        $this->set($arrProp);
        //$this->CI = &get_instance();

    }
    
    public function getFormHtmlData(){
        
        $bsForm = new BsForm($this->getFormData());
        
        return $bsForm->getHtmlData();
        
        $arrReturn = array(
            'form'  =>  $bsForm->getHtmlData()['form']
        );             
        
        return $arrReturn;
        
        
    }
    public function getFormData(){
        
        $arrReturn = array(
            'template'      =>  1,
            'no_panel'      =>  TRUE,
            'inputs'        =>  array(
                array(
                    'type'          =>  'dropdown',
                    'grid_class'    =>  'filter-input-type-bool-model',
                    'no_label'      =>  TRUE,
                    'no_fieldset'   =>  TRUE,
                    'grid_lg'       =>  24,
                    'input_lg'      =>  24,
                    'class'         =>  array('padding-3','size-11','height-24','filter-input-value'),
                    'options'       =>  array(
                        array(
                            'text'      =>  'Sim',
                            'value'     =>  't'
                        ),
                        array(
                            'text'      =>  'Não',
                            'value'     =>  'f'
                        )
                    )
                ),               
            )   
        );
        
        
        return $arrReturn;
    }
      /**
     * PRIVATES
     */
}

?>