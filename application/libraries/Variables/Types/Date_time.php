<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Date_time_Variables extends Variables_defaults{
    
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
                     if(Datetime::createFromFormat('Y-m-d H:i:s', trim($val)) !== FALSE){
                        $val = Datetime::createFromFormat('Y-m-d H:i:s', trim($val));
                    }
                    else{ 
                        $val = Datetime::createFromFormat('d/m/Y H:i:s', trim($val));
                    }
                    
                }
            }
        }
        else{
             if(isTimestamp(trim($value))){
                $value = new DateTime('@' . trim($value));
            }
            else{
                
                if(Datetime::createFromFormat('Y-m-d H:i:s', trim($value)) !== FALSE){
                    $value = Datetime::createFromFormat('Y-m-d H:i:s', trim($value));
                }
                else{ 
                    $value = Datetime::createFromFormat('d/m/Y H:i:s', trim($value));
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
        
        return $value ? $value->format('Y-m-d H:i:s') : '';
          
    }
    
    private function getReadFormat($value){
        
        return $value ? $value->format('d/m/Y H:i:s') : '';    
    }
    
     
}