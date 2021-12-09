<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Date_Variables extends Variables_defaults{
    
    public $inputType = 'date';
    private $dateTime;
    
    function __construct($arrProp = array()){ 
        parent::__construct($arrProp);
    }
    
    
    protected function formatValue($value){
        
        
        if($value=='' OR is_null($value)){
            return NULL;
        }
        
        if(is_array($value)){
            foreach($value as &$val){
                
                if(isTimestamp(trim($val))){
                    $val = new DateTime('@' . trim($val));
                }
                else{
                    
                    if(Datetime::createFromFormat('Y-m-d', substr(trim($val),0,10)) !== FALSE){
                        $val = Datetime::createFromFormat('Y-m-d', substr(trim($val),0,10));
                    }
                    else{ 
                        $val = Datetime::createFromFormat('d/m/Y', substr(trim($val),0,10));
                    }
                }
            }
        }
        else{
            if(isTimestamp(trim($value))){
                $value = new DateTime('@' . trim($value));
            }
            else{
                
                if(Datetime::createFromFormat('Y-m-d', substr(trim($value),0,10)) !== FALSE){
                    $value = Datetime::createFromFormat('Y-m-d', substr(trim($value),0,10));
                }
                else{ 
                    $value = Datetime::createFromFormat('d/m/Y', substr(trim($value),0,10));
                }
            }
        }
        
                
                
        if($this->get('method')=='database'){
               
            if(is_array($value)){
                foreach($value as &$val){
                    $val = $this->getDatabaseFormat($val);
                }
            }
            else{
                $value = $this->getDatabaseFormat($value);
            }
            
            return $value;
        }
        
        return $this->getReadFormat($value);
    }
    
    private function getDatabaseFormat($value){
        
        return $value ? $value->format('Y-m-d') : '';
          
    }
    
    private function getReadFormat($value){
        
        return $value ? $value->format('d/m/Y') : '';    
    }
    
     
}