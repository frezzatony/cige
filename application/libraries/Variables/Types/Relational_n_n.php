<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relational_n_n_Variables extends Variables_defaults{
    
    public $inputType = array('grid','group');
    public $variables;
    
    function __construct($arrProp = array()){
        
        parent::__construct();
        
        if($arrProp){
            
            $this->variables = new Variables;    
        
            $this->variables->set('id',
                array(
                    'type'      =>  ($arrProp['uuid']??NULL) ? 'uuid' : 'integer',
                    'no_filter' =>  TRUE,
                )
            );
            
            $this->variables->set($arrProp['variables'] ?? array());
            unset($arrProp['variables']);
            $this->set($arrProp);
        }
        
        
    }
    
    protected function formatValue($value){
        
        $value = Json::getFullArray($value);
        $arrReturn = array();
        
        if(is_Array($value) AND $value){
            
            
            foreach($value as $rowValue){
                
                $tempVariables = $this->variables;
                
                $tempRowValue = array();
                $tempVariables->set($rowValue);
                
                foreach($tempVariables->get() as $variable){
                    
                    $variable->set('method',$this->get('method'));
                    
                    if($variable->get('id') == 'id' AND $this->get('uuid') AND !$variable->get('value')){
                        $variable->set('value',$this->uuid->v4());
                        
                    }
                    
                    $tempRowValue[] = array(
                        'id'    =>  $variable->get('id'),
                        'value' =>  $variable->get('value'),
                        'text'  =>  $variable->get('text'),
                    );
                }
                
                $arrReturn[] = $tempRowValue;
            }
                
        }
        
        return $arrReturn;        
    }
    
   
}