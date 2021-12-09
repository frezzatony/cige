<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Cpf.php');
class Cpf_cnpj_validation extends Data{
    
    
    function __construct($arrProp = array()){
        $this->cpf = new Cpf_validation();
        $this->cnpj = new Cnpj_validation();
        $this->set($arrProp);  
    }
    
    public function validate($arrProp = array()){
        
        if($arrProp){
            $this->unset();
            $this->set($arrProp);    
        }
        
        if(strlen($this->get('value'))==0){
            return TRUE;
        }
        
        if($this->cpf->validate($this->get())){
            return TRUE;
        }
        
        return $this->cnpj->validate($this->get());
    }
    
}
