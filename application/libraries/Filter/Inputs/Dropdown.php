<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dropdown_filter extends Filter_inputs_defaults{

    protected $CI;

    function __construct(){

        parent::__construct();
        $this->CI = &get_instance();

    }
    
    public function getOptionsInput($variable = array()){
        
        $variable = parent::_initVariable($variable);
        $optionLabel = $variable->get('filter_configs.label') ?? $variable->get('label');
        
        return array(
            'value'             =>  $variable->get('id'),
            'text'              =>  $optionLabel ? $optionLabel : $variable->get('id'),
            'label'             =>  $optionLabel ? $optionLabel : $variable->get('id'),
            'data-input-id'     =>  $variable->get('id'),
            'data-input-type'   =>  'dropdown',
            'data-operators'    =>  'equal,not_equal,is_null,notnull',
            'data-input-id'     =>  $variable->get('id'),
        );
    }
    
    /**
     * PRIVATES
     */
}

?>