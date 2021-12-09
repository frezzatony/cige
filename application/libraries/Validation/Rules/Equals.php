<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Equals_validation extends Data{
    
    function __construct($arrProp = array()){
        
        $this->set($arrProp);  
                
    }

    public function validate($arrProp = array()){
        
        if($arrProp){
            $this->unset();
            $this->set($arrProp);    
        }
        
        return $this->get('value') === $this->get('rule.compare');
    }
}
