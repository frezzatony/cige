<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cnpj_validation extends Data{
    
    
    function __construct($arrProp = array()){
        
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
        else if (!is_scalar($this->get('value'))) {
            return false;
        }

        // Code ported from jsfromhell.com
        $cleanInput = preg_replace('/\D/', '', $this->get('value'));
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if ($cleanInput < 1) {
            return false;
        }

        if (mb_strlen($cleanInput) != 14) {
            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $cleanInput[$i] * $b[++$i]);

        if ($cleanInput[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $cleanInput[$i] * $b[$i++]);

        if ($cleanInput[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }
}
