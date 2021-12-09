<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relational_1_n_Variables extends Variables_defaults{
    
    public $inputType = array('externallist');
    public $variables;
    
    function __construct($arrProp = array()){
        parent::__construct();
        
        $this->set($arrProp);
        
        if($this->get('from.module') AND $this->get('from.variables')){
            $this->setFromVariables();
        }
        
    }
    
    protected function formatValue($value){
        
        $value = strval(trim($value));
        
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
    
    private function setFromVariables(){
        
        $this->variables = new Variables;
        
        $className = $this->get('from.module');
        $module = new $className(
            array(
                'request'   =>  $this->get('from.request'),
            )
        );
        
        foreach($this->get('from.variables') as $variableId){
            
            $keyModuleVariable = array_search($variableId,array_column($module->get('data.variables'),'id'));
            
            if($keyModuleVariable === FALSE){
                continue;
            }
            
            $this->variables->set($module->get('data.variables.'.$keyModuleVariable));
            
        }
    }
    
     
}