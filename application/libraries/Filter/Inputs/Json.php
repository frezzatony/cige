<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Json_filter extends Filter_inputs_defaults{

    function __construct(){

        parent::__construct();

    }
    
    public function getOptionsInput($variable = array()){
        
        $variable = parent::_initVariable($variable);
        $optionLabel = $variable->get('filter_configs.label') ?? $variable->get('label');
        
        return array(
            'value'             =>  $variable->get('id'),
            'text'              =>  $optionLabel ?? $variable->get('id'),
            'label'             =>  $optionLabel ?? $variable->get('id'),
            'data-input-id'     =>  $variable->get('id'),
            'data-input-type'   =>  'dropdown',
            'data-input-id'     =>  $variable->get('id'),
        );
    }
    
    /**
     * PRIVATES
     **/
}

?>