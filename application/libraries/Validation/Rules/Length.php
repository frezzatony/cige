<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Length_validation extends Data{
        
    function __construct($arrProp = array()){
        
        $this->set($arrProp); 
        $this->set($arrProp['rule']??array());  
                
    }
    
    public function validate($arrProp = array()){
        
        if($arrProp){
            $this->unset();
            $this->set($arrProp); 
            $this->set($arrProp['rule']??array());   
        }
        
        
        $length = $this->extractLength($this->get('value'));
        
        return $this->validateMin($length) AND $this->validateMax($length);
    }

    protected function extractLength($input)
    {
        if (is_string($input)) {
            return mb_strlen($input, mb_detect_encoding($input));
        }

        if (is_array($input) || $input instanceof \Countable) {
            return count($input);
        }

        if (is_object($input)) {
            return count(get_object_vars($input));
        }

        if (is_int($input)) {
            return mb_strlen((string) $input);
        }

        return false;
    }

    protected function validateMin($length)
    {
        if (is_null($this->get('min'))) {
            return true;
        }
        
        
        return $length >= $this->get('min');
    }

    protected function validateMax($length)
    {
        if (is_null($this->get('max'))) {
            return true;
        }

        return $length <= $this->get('max');
    }
    
    
}