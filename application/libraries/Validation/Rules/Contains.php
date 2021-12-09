<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'/third_party/autoload.php';
use Respect\Validation\Validator as v;

class Contains_validation extends Data{
    
    function __construct($arrProp = array()){
        
        $this->set($arrProp);  
                
    }

    public function validate($arrProp = array()){
        
        if($arrProp){
            $this->unset();
            $this->set($arrProp);    
        }
        
        return v::contains($this->get('value'))->validate($this->get('rule.compare'));
    }
}
