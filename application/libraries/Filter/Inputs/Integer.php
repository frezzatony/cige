<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Integer_filter extends Filter_inputs_defaults
{

    protected $CI;

    function __construct()
    {

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
            'data-input-type'   =>  'integer',
            'data-operators'    =>  'equal,between,greater,greater_or_equal,less,less_or_equal,not_between,not_equal,notnull',
        );
        
    }
      /**
     * PRIVATES
     */
}

?>