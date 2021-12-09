<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Json_Variables extends Variables_defaults{
    
    public $inputType = 'json';
    
    function __construct($arrProp = array()){
        parent::__construct();
        
        if($arrProp){
            
            if($arrProp['variables']??NULL){
                $this->variables = new Variables;
                $this->variables->set($arrProp['variables'] ?? array());  
            }
              
            $this->set($arrProp);
        }
        
    }
    
    protected function formatValue($value){
        
        if(is_string($value)){
            $value = trim($value);        
        }
        
        
        if(!is_null($value) AND $this->get('variables')){
            $value = $this->getVariablesValue($value);
        }
        
        if(is_null($value)){
            $value = '{}';
        }
        
        
        if($this->get('method')=='database'){
                
            return $this->formatDatabase($value);
             
        }
        
        return Json::getFullArray($value);
    }
    
    private function formatDatabase($value){
        
        $arrValue = Json::getFullArray($value,FALSE);
        if(is_string($arrValue)){
            $arrValue = json_encode($arrValue,true);
        }
        
        
        $strJson = json_encode($arrValue,JSON_UNESCAPED_UNICODE);
        if($strJson == '[]'){
            $strJson = '{}';
        }
        return $strJson;

    }
    
    private function getVariablesValue($value){
        
        $value = array_map(function($rowValue){
            
            $variables = new Variables(
                $this->get('variables')
            );
            
            $newRowValue = array();
            foreach($variables->get() as $variable){
                $keyVariable = array_search($variable->get('id'),array_column($rowValue,'id'));
                
                $variable->set('method',$this->get('method'));
                
                if($keyVariable!==FALSE){
                    $variable->set(
                        array(
                            'value'     =>  $rowValue[$keyVariable]['value']??NULL,
                        )
                    );
                    
                }
                
                $newRowValue[] = array(
                    'id'    =>  $variable->get('id'),
                    'value' =>  $variable->get('value'),
                );
            }
            
            
            return $newRowValue;
        },Json::getFullArray($value,FALSE));
       
       
       return $value;
        
    }
    
    
}