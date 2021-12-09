<?php

/**
 * @author Tony Frezza
 */


class Modules extends Data{
    
    function __construct(){
        
        parent::__construct();
        $this->CI->config->load('modules');
        
        $this->CI->data->set('modules',array());
        
    }
    
    public function getVariables($arrProp = array()){
        
        $className = strtoMINusculo($arrProp['module']);
        
        if(!in_array($className,$this->CI->data->get('modules'))){
            $this->CI->main_model->erro();
        }
        
        $module = new $className($arrProp);
        
        $variables = $module->variables;
        
        if(($arrProp['variables']??NULL) && is_array($arrProp['variables'])){
            
            foreach($variables->get() as $tempVariable){
                if(!in_array($tempVariable->get('id'),$arrProp['variables'])){
                    $variables->unset($tempVariable->get('id'));
                }
            }
        }
        
        
        
        return $variables;
        
    }
        
    public function initialize($arrProp = array()){
        
        if(!($arrProp['modules'] ?? NULL)){
            $arrProp['modules'] = $this->CI->config->item('modules');
        }
        
        foreach($arrProp['modules'] as $module){
            
            if(is_array($module) AND array_key_exists('path',$module)==TRUE){
                $modulePath = $module['path'];
            }
            else{
                $modulePath = '/../modules/'.$module.'/';
            }
            
            $moduleRename = $moduleName = $module;
            if(is_array($module)){
                
                if(array_key_exists('name',$module)===TRUE){
                    $moduleName = $module['name'];    
                }
                
                if(array_key_exists('rename',$module)===TRUE){
                    $moduleRename = $module['rename'];
                }
                
            }
            
            if(in_array(strtoMINusculo($moduleName),$this->CI->data->get('modules')) OR !is_dir(dirname(__FILE__).$modulePath)){
               continue; 
            }
            
            $this->CI->data->set(
                array(
                    'modules'   =>  $this->CI->common->append($this->CI->data->get('modules'),$moduleName)
                )
            );
             
            if($this->CI->config->item('modules_depends',$moduleName)){
                $this->initialize($this->CI->config->item('modules_depends',$moduleName));    
            }
             
            if(file_exists(dirname(__FILE__).$modulePath . 'config/'.$moduleName.'.php')){
                $this->CI->config->load($modulePath.'config/'.$moduleName, true); 
                   
                //$this->CI->config->set_item($moduleRename,$this->CI->config->item($modulePath.'config/'.$moduleName));
//                $this->CI->config->set_item($modulePath.'config/'.$moduleName,NULL);
                
                if($this->CI->config->item('modules_depends',$moduleName)){
                    
                    $this->initialize(
                        array(
                            'modules'   =>  $this->CI->config->item('modules_depends',$moduleName),
                        )
                    );    
                }
            }
            

            if(file_exists(dirname(__FILE__).$modulePath . 'models/'.ucfirst($moduleName).'_model'.'.php')){
                $this->CI->load->model($modulePath . 'models/'.$moduleName.'_model',$moduleRename.'_model');
            }
            
            
            if(file_exists(dirname(__FILE__).$modulePath . 'libraries/'.ucfirst($moduleName).'.php')){
                $this->CI->load->library($modulePath.'libraries/'.$moduleName,NULL,$moduleRename);
                
                if(method_exists($this->CI->{$moduleName},'initModule') AND ($arrProp['initialize']??NULL !== FALSE)){
                    $this->CI->{$moduleName}->initModule();
                }    
            }
            
        }
         
    }
    
    public function initializeAfterAllModules(){
        foreach($this->CI->data->get('modules') as $key => $moduleName){
            if(($this->CI->{$moduleName}??NULL) AND method_exists($this->CI->{$moduleName},'initAfterModule')){
                $this->CI->{$moduleName}->initAfterModule();
            }
        }
    }
    
    /**
     * PRIVATES
     */

    
}

?>