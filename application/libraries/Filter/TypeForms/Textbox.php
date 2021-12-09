<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Textbox_typeform_filter extends Filter_typeforms_defaults
{

    protected $CI;

    function __construct()
    {

        parent::__construct();
        //$this->CI = &get_instance();

    }
    
    public function getFormHtmlData(){
        
        $bsForm = new BsForm($this->getFormData());
        
        return $bsForm->getHtmlData();
        
        
    }
    public function getFormData(){

        $arrReturn = array(
            'template'      =>  1,
            'no_panel'      =>  TRUE,
            'inputs'        =>  array(
                array(
                    'type'          =>  'textbox',
                    'grid_class'    =>  'filter-input-type-textbox-model',
                    'no_label'      =>  TRUE,
                    'no_fieldset'   =>  TRUE,
                    'grid_lg'       =>  24,
                    'input_lg'      =>  24,
                    'class'         =>  array('padding-3','size-11','height-24','filter-input-value'),
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