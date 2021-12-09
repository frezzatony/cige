<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Number_Variables extends Variables_defaults{
    
    public $inputType = 'number';
    
    function __construct($arrProp = array()){
        parent::__construct(); 
        $this->set($arrProp);
    }
    
    protected function formatValue($value){
        
        $value = trim($value);
        
        
        $maxLenth =  $this->get('max_lenth') ? $this->get('max_lenth') : NULL;
        
        if($this->get('mask')){
            if($this->get('method')=='database'){
                $value = $this->CI->mask->unmask($value,$this->get('mask'));    
            }
            else{
                $value = $this->CI->mask->mask($value,$this->get('mask'));
            }
            
            
            
        }
        else if($this->get('method')=='database'){
            $value = formataFLOAT(substr($value,$maxLenth));    
        }
        else{
            
            $value = formataFLOATImprime(substr($value,$maxLenth));
        }
        
        
        return $value;
    }
    
     
}