<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cpf_cnpj_exceptions_mask{

    protected $CI;

    function __construct(){
        //$this->CI = &get_instance();
    }
    
    
    
    function mask($value){
        
        $value = preg_replace('/[^0-9]/', '', $value);

        if (strlen($value) == 11){
            return $this->mask_cpf($value);
        }
        elseif (strlen($value) == 14){
            return $this->mask_cnpj($value);
        }
        
        return NULL;
    }
    
    private function mask_cpf($value){
        
       return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $value);  
       
    }
    
    private function mask_cnpj($value){
        
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $value);
        
    }
    
    
    
    
    function unmask($value){
        
        $value = preg_replace('/[^0-9]/', '', $value);

        if (strlen($value) == 11){
            return $this->unmask_cpf($value);
        }
        elseif (strlen($value) == 14){
            return $this->unmask_cnpj($value);
        }
        
        return NULL;
    }
    
    private function unmask_cpf($value){
        
       return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1\$2\$3\$4", $value);  
       
    }
    
    private function unmask_cnpj($value){
        
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1\$2\$3\$4\$5", $value);
        
    }
}