<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Integer_Variables extends Variables_defaults{
    
    public $inputType = 'integer';
    
    function __construct($arrProp = array()){
        parent::__construct(); 
        $this->set($arrProp);
    }
    
    protected function formatValue($value){
        
        $value = trim($value);
        
        settype($value,'integer');
        $maxLenth =  $this->get('max_lenth') ? $this->get('max_lenth') : NULL;
        
        if($this->get('mask')){
            if($this->get('method')=='database'){
                $value = $this->CI->mask->unmask($value,$this->get('mask'));    
            }
            else{
                $value = $this->CI->mask->mask($value,$this->get('mask'));
            }
        }
        
        
        return substr($value,$maxLenth);
    }
    
     
}