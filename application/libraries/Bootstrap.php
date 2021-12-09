<?php

/**
 * @author Tony Frezza

 */


class Bootstrap{
    
    private $loaded = [];
    private $nodes = [];
    
    function __call($name, $arguments){
        
        $this->loadLibrary('Component');
        
        if(array_key_exists($name,$this->loaded)===FALSE){
            $this->loadLibrary($name);
        }
        
        
        if(!$arguments[0]??NULL){
            $arguments[0]['id'] = random_string();
            $arguments[0]['random_id'] = TRUE;
        }
        $arguments[0]['id'] = $arguments[0]['id'] ?? random_string();
        $arguments[0]['tag'] = $arguments[0]['tag'] ?? $name;
        
        
        $this->nodes[] = [
            'type'  =>  $name,
            'node'  =>  $arguments[0]
        ];
        
        return $arguments[0]['id'];      
    }
    
    
    public function getHtml(){
        
        $html = new Html;
        
        foreach($this->nodes as $node){
            
            if(method_exists($this->{$node['type']},'getHtmlData')===FALSE){
                $html->add($node['node']);
            }
            else{
                $html->add($this->{$node['type']}->getHtmlData($node['node']));    
            }

        }
        
        return $html->getHtml();
    }
    
    public function getHtmlData(){
        
        $arrDataReturn = array();
        
        foreach($this->nodes as $node){
           if(method_exists($this->{$node['type']},'getHtmlData')===FALSE){
                $arrDataReturn[] = $node['node'];
            }
            else{
                $arrDataReturn[] = $this->{$node['type']}->getHtmlData($node['node']);    
            }
        }
        
        return $arrDataReturn;
        
    }
    public function reset(){
        unset($this->nodes); 
        $this->nodes = array();
    }
   /**
     * PRIVATES
     **/
    
    private function loadLibrary($name){
        
        $directory = dirname(__FILE__).'/Bootstrap/Components/';
        
        if(file_exists($directory.ucfirst($name).'.php')===FALSE){
            
            if(array_key_exists('html',$this->loaded)===FALSE){
                require_once($directory.ucfirst('html').'.php');
                $this->loaded[] = 'html';
            }
            
            $className = 'html_bootstrap';
        }
        else{
            require_once($directory.ucfirst($name).'.php');
            $this->loaded[] = $name;
            $className = $name.'_bootstrap';    
        }
        
        
        
        $this->{strtolower($name)} = new $className;

    } 
    
}

?>