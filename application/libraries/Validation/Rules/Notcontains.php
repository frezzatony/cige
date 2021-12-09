<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notcontains_validation extends Data{
    
    function __construct($arrProp = array()){
        
        $this->set($arrProp);  
                
    }

    public function validate($arrProp = array()){
        
        if($arrProp){
            $this->unset();
            $this->set($arrProp);    
        }
        
        $this->set('rule.compare',string_to_array($this->get('rule.compare')));
        
        
    }
}
