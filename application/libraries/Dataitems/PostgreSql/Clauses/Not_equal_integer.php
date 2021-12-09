<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Not_equal_integer_clauses_PostgreSql extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'equal',
            'text'  =>  'Igual a'
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString(){
    
        $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'"::INT) ';
        
        $intValue = (int)replace_db($this->get('value'));
        
        if($intValue){
            $strReturn .= ' <> \''.$intValue.'\'::INT';    
        }
        else{
            $strReturn .= ' IS NULL';
        }
        
        
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
    
  }
?>