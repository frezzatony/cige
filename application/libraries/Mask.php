<?php

/**
 * @author Tony Frezza
 */


require_once(APPPATH.'third_party/PhpMask/Clemdesign_Mask.php');

class Mask extends Data{

    
    function __construct($arrProp = array()){
        
        parent::__construct();
        $this->Clemdesign_Mask = new Clemdesign_Mask;
        
        
        $directory = dirname(__FILE__).'/Mask/';
        $this->_scanInputDirectory($directory.'Exceptions/');
               
    }
    
    public function mask($value,$mask){
        
        if(isset($this->{$mask})){
            return $this->{$mask}->mask($value);    
        }
        
        return $this->Clemdesign_Mask->apply($value,$mask);
    }
    
    public function unmask($value,$mask){
        
        if(isset($this->{$mask})){
            return $this->{$mask}->unmask($value);    
        }
        
        return preg_replace('/[\-\|\(\)\/\.\: ]/', '', $value);
        
    }
    
    private function _scanInputDirectory($directory){
        
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
       
        foreach($scanned_directory as $input_file){
            
            if(is_dir($input_file)){
                continue;
            }
            
            require_once($directory.$input_file);
            $objectName = preg_replace('/.php/', '', $input_file);
            $className = $objectName.'_exceptions_mask';
            
            $this->{strtoMINusculo($objectName)} = new $className;
            
        }   
    }
}