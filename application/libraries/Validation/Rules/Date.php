<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'/third_party/autoload.php';
use Respect\Validation\Validator as v;

class Date_validation extends Data{
        
    function __construct($arrProp = array()){
        
        $this->set($arrProp);  
                
    }
    
    public function validate($arrProp = array()){
        
        if($arrProp){
            $this->unset();
            $this->set($arrProp);    
        }
        
        if($this->get('rule.format')){
            return v::date($this->get('rule.format'))->validate($this->get('value'));
        }
        
        return v::date()->validate($this->get('value'));
    }
    
    
}