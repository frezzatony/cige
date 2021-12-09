<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/Variables/'.'Variables_defaults.php');
 
class Variables extends Data{
    
    private $rules;
    private $keys;
    
    
    function __construct($arrData = array()){
        
        parent::__construct($arrData);
        
        $this->CI->config->load('config_variables',TRUE);
                   
        $this->scanVariablesDirectory(dirname(__FILE__).'/Variables/Types/');
        $this->keys = array();        
    }
    
    public function addRule($newRule){
        
        if(!is_array($this->rules)){
            $this->rules = array();
        }
        
        $this->rules[] = $newRule;
    } 
    
    public function get($idVariable = NULL,$method=NULL){
        
        if($method){
            $this->set($idVariable,array('method'=>$method));
        }
        
        if(sizeof(explode('.',$idVariable))==1){
            return parent::get($idVariable);
        }
        else{
            $return = NULL;
            
            foreach(explode('.',$idVariable) as $key => $val){
                if($val == 'variables'){
                    $return = $return->variables;
                }
                else if(!$return){
                    $return = parent::get($val);
                }
                else{
                    $return = $return->get($val);
                }
            }
            
            return $return;
        }
        
    }
    
    public function getData($variables = NULL){
        
        if(!$variables){
            $variables = $this->get();
        }
        
        $arrDataReturn = array();
        
        foreach($variables as $variable){
            $arrDataReturn[] = $variable->get();
            
            
            if(isset($variable->variables)){
                $arrDataReturn[sizeof($arrDataReturn)-1]['variables'] = self::getData($variable->variables->get());
            }
        }
        
        return $arrDataReturn;
        
        
    }
    
    public function getDifferenceValues($arrProp = array()){
        
        $arrReturn = array();
        
        foreach($this->get() as $variable){
            if($variable->get('not_compare_difference')){
                continue;
            }
            
            
            $arrDiffValues = $variable->getDifferenceValues($arrProp);
            
            if($arrDiffValues){
                $arrReturn[] = 
                    array_merge(
                        array(
                            'id'        =>  $variable->get('id'),  
                        ),
                        $arrDiffValues
                    );
            }
        }
        
        return $arrReturn;
         
    }
    
   
    public function set($arrProp = array(),$arrData = array()){
        
        if(!$arrProp){
            return;
        }
        
        if($arrProp['rules'] ?? NULL){
            $this->setRules($arrProp['rules']);
            unset($arrProp['rules']);
        }
        if(is_string($arrProp)){
            $arrProp = array_merge(
                array('id'=>$arrProp),
                $arrData
            );
        }
        
        if($arrProp['id'] ?? NULL){
            $arrProp['variables'] = array($arrProp);
        }
        if($arrProp['variables'] ?? NULL){
            $arrProp = $arrProp['variables'];
        }
        
        foreach($arrProp as $variable){
            
            if(!($variable['id']??NULL)){
                continue;
            }
            
            $replaceVariable = $this->get($variable['id']);
             
            if(!$replaceVariable){
                
                $this->keys[] = $variable['id'];
                
                $variable['method'] = $variable['method'] ?? NULL;
                
                $className = ($variable['type'] ?? 'Character').'_Variables';
                
                if(($variable['value']??NULL) AND is_array($variable['value'])){
                    $className = 'Relational_n_n_Variables';
                }
                parent::set($variable['id'],new $className($variable)); 
            }
            else{
                foreach($variable as $key => $val){
                    if(in_array($key,array('id'))){
                        continue;
                    }
                    
                    if(is_string($key)){
                        
                        if($key=='variables' AND $replaceVariable->variables){
                            foreach($val as $childVariable){
                                $replaceVariable->variables->set($childVariable);    
                            }
                        }
                        
                        $replaceVariable->set('old_'.$key,$replaceVariable->get($key));
                        $replaceVariable->set($key,$val);
                    }
                    
                }
                
                parent::set($variable['id'],$replaceVariable);
            }
        }
        
    }
    
    public function setRules($rules){
        $this->rules = $rules;
    }
    public function update($arrProp = array()){
        
        if($this->get($arrProp['id'].'.id')){
            $this->set($arrProp);
        }
    }
    
    public function validate($variable = array()){
        
        $validation = new Validation(
            array(
                'variables' =>  $this,
                'rules'     =>  $this->rules
            )
        );
                
        return $validation->run();
        
    }
    
     
    
    /**
     * PRIVATES
     **/
     
    private function scanVariablesDirectory($directory){
        
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        
        foreach($scanned_directory as $input_file){
            
            if($input_file == 'Variables_defaults.php'){
                continue;
            }
            
            require_once($directory.$input_file);
            
            $objectName = preg_replace('/.php/', '', $input_file);
            $className = $objectName.'_variables';
            
            $this->{strtolower($objectName)} = new $className;
            
        }  
    }  
}

?>