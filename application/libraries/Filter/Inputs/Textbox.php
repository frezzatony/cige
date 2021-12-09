<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Textbox_filter extends Filter_inputs_defaults{

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
            'data-input-type'   =>  'textbox',
            'data-input-text'   =>  '1',
            'data-operators'    =>  'begins_with,ends_with,equal,not_equal,contains,not_contains,not_begins_with,not_ends_with,is_null,notnull',
        );
    }
    
    /**
     * PRIVATES
     */
}

?>