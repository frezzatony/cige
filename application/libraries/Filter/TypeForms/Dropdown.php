<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dropdown_typeform_filter extends Filter_typeforms_defaults
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
            'data-input-id' =>  $this->get('id'),
            'inputs'        =>  array(
                array(
                    'type'          =>  'dropdown',
                    'data-input-id' =>  $this->get('id'),
                    'grid_class'    =>  'filter-input-type-dropdown-model',
                    'no_label'      =>  TRUE,
                    'no_fieldset'   =>  TRUE,
                    'grid_lg'       =>  24,
                    'input_lg'      =>  24,
                    'class'         =>  array('padding-3','size-11','height-24','filter-input-value'),
                    'options'       =>  $this->get('options'),
                    'first_null'    =>  $this->get('first_null'),
                    'from'          =>  $this->get('from'),
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