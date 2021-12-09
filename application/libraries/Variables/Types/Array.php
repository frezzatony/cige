<?php

/**
 * @author Tony Frezza
 * @copyright 2020
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Array_Variables extends Variables_defaults{
    
    public $inputType = 'array';
    
    function __construct($arrProp = array()){
        parent::__construct();
        $this->set($arrProp);
        
    }
    
    protected function formatValue($value){
        
        if($this->get('method')=='database'){
            return $this->getDatabaseFormat($value);
        }
        
        $value = $this->getArrayValue($value);
        
        return $value;
       
    }
    
    private function getArrayValue($value){
        
        if(is_string($value)){
            $tmpValue = $value;
            if(strstr('[',$tmpValue)==0){
                $tmpValue = substr($tmpValue,1);
            }
            if(strstr(']',$tmpValue)==strlen($value)-1){
                $tmpValue = substr($tmpValue,0,strlen($tmpValue)-1);
            }
            
            $value = explode(',',$tmpValue);
        }
        
        return $value;
    }
    
    private function getDatabaseFormat($value){
        
        if(is_string($value)){
            $value = $this->getArrayValue($value);
        }
        
        $strReturn = '[';
        $strReturn .= implode(',',is_array($value) ? $value : array());
        $strReturn .= ']';
        
        return $strReturn;
    }

}