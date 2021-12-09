<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cpf_validation extends Data{
    
    
    function __construct($arrProp = array()){
        
        $this->set($arrProp);  
                
    }
    
    public function validate($arrProp = array()){
        
        if($arrProp){
            $this->unset();
            $this->set($arrProp);    
        }
        
        if(!($this->get('value'))){
            return TRUE;
        }
        // Code ported from jsfromhell.com
        $c = preg_replace('/\D/', '', $this->get('value'));

        if (mb_strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }
}
