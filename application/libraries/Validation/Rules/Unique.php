<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');



class Unique_validation extends Data{
        
    function __construct($arrProp = array()){
        parent::__construct();
        $this->set($arrProp);  
                
    }
    
    public function validate($arrProp = array()){
        
        if($arrProp){
            $this->unset();
            $this->set($arrProp);    
        }
        
        return ($this->CI->database->getExecuteQuery($this->get('rule.query'))) ? FALSE : TRUE;
    }
    
    
}