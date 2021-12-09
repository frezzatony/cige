<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bool_Variables extends Variables_defaults{
    
    public $inputType = 'bool';
    
    function __construct($arrProp = array()){
        parent::__construct();
        $this->set($arrProp);
        
    }
    
    protected function formatValue($value){
        
        
        if($this->get('method')=='database'){
            return $this->getDatabaseFormat($value);
        }
        
        if(!$value OR $value=='' OR $value===FALSE OR $value=='f' OR $value=='false' OR strtoMAIsuculo(convert_accented_characters($value)) == 'NAO' OR $value=='0'){
            return 'NÃO';
        }
        
        return 'SIM';
        
    }
    
    private function getDatabaseFormat($value){
        
        if(!$value OR $value=='' OR $value===FALSE OR $value=='f' OR $value=='false' OR strtoMAIsuculo(convert_accented_characters($value)) == 'NAO' OR $value=='0'){
            return 'f';
        }
       
        return 't';
    }

}