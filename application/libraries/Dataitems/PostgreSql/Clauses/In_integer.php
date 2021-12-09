<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class In_integer_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value'                 =>  'in_integer',
            'text'                  =>  'Está em',
            'data-num-cols-input'   =>  0
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString($arrProp = array()){
        
        
        $value = $this->get('value');
        
        if(is_array($value)){
            $value = implode(',',$value);
        }
        
        $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'"::INT) IN('.$value.')';
        
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
  }
?>