<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validation extends Data{
        
    
    public function __construct($arrProp = array()){
        
        parent::__construct($arrProp);
        
        
        $directory = dirname(__FILE__).'/Validation/';
        $ruledDirectory = $directory .'Rules/';
        
        $this->scanRulesDirectory($ruledDirectory);
        
        
    }
    
    public function run(){
        
        $arrErrors = array();
        
        $groupRules = $this->getGroupRulesById();
        
        foreach($groupRules as $inputRules){
            
            $variableId = explode('.',$inputRules['id']);
            $variable =  $this->get('variables')->get($variableId[0]);
            
            if(!$variable){
                continue;
            }
            
            //if($variable->get('variables') AND is_array(Json::getFullArray($variable->get('value')))){
            if(in_array($variable->get('type'),$this->CI->config->item('with_child','config_variables'))){
                $arrErrors = array_merge(
                    $arrErrors,
                    $this->runMultipleValues($variable,$inputRules)
                ); 
            }
            else{
                
                $arrErrors = array_merge(
                    $arrErrors,
                    $this->runSimpleValue(
                        array(
                            'variable'      =>  $variable,
                            'input_rules'   =>  $inputRules,
                            'parent_id'     =>  $this->get('parent_id'),
                            'row'           =>  $this->get('row') ?? 0,
                        )
                    )
                );
            }    
        }
        
        return $arrErrors;    
    }
    
    /**
     * PRIVATES
     **/
    
    private function runMultipleValues($variable,$inputRules,$parentId=''){
        
        $arrErrors = array();
        
        foreach(($inputRules['rules'] ?? array()) as $key=> $rule){
            $rule['id'] = explode('.',$rule['id']);
            
            if($key==0){
                if($parentId){
                    $parentId .= '.';
                }
                $parentId .= $rule['id'][0];
            }
            unset($rule['id'][0]);
            $inputRules['rules'][$key]['id'] = implode('.',$rule['id']);
            
            
        }
        
        foreach(Json::getFullArray($variable->get('value'))??array() as $keyRow => $rowValue){
            
            foreach($variable->variables->get() as $variableChild){
                $variable->variables->set($variableChild->get('id'),array('method'=>'database'));
            }
            
            $variable->variables->set($rowValue);
            
            $validation = new Validation(
                array(
                    'variables'     =>  $variable->variables,
                    'rules'         =>  $inputRules['rules'],
                    'row'           =>  $keyRow,
                    'parent_id'     =>  $parentId,
                )
            );
            
            $inputErrors = $validation->run();
            
            $arrErrors = array_merge(
                $arrErrors,
                $inputErrors
            );
                
        }
        
        return $arrErrors;   
    }
    
    private function runSimpleValue($arrProp = array()){
        
        $arrErrors = array();
        
        foreach($arrProp['input_rules']['rules']??array() as $rule){
            
            $className = $rule['rule'];
            
            $arrParam = array(
                'input'     =>  $arrProp['variable']->get(),
                'value'     =>  $arrProp['variable']->get('value')??NULL,
                'rule'      =>  $rule,
            );
            
            if($this->{$className}->validate($arrParam)===FALSE){
                
                if($arrProp['parent_id']){
                    $rule['id'] = $arrProp['parent_id'].'.'.$rule['id'];
                }
                $rule['row'] = $arrProp['row'] ?? 0;
                $arrErrors[] = $rule;
            }  
        }
        
            
       return $arrErrors;     
    }
    
    private function getGroupRulesById(){
        
        $arrReturn = array();
        
        foreach(($this->get('rules') ?? array()) as $rule){
            $rule['key'] = $rule['key'] ?? random_string();
            
            $keyId = array_search($rule['id'],array_column($arrReturn,'id'));
            
            if($keyId===FALSE){
                $arrReturn[] = array(
                    'id'        =>  $rule['id'],
                    'rules'     =>  array()
                );
                
                $keyId = array_search($rule['id'],array_column($arrReturn,'id'));
            }
            
            $arrReturn[$keyId]['rules'][] = $rule;
        }
        
        return $arrReturn;
        
    }
    
    private function scanRulesDirectory($directory){
        
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
                
        foreach($scanned_directory as $input_file){
            if(is_dir($directory.$input_file)){
                continue;
                  
            }  
            
            require_once($directory.$input_file);
            
            $objectName = preg_replace('/.php/', '', $input_file);
            $className = $objectName.'_validation';
            
            $this->{strtolower($objectName)} = new $className;
            
        }
        
        
    }
}
?>