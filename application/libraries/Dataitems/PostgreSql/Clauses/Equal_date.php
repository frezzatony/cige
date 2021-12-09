<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Equal_date_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'equal_date',
            'text'  =>  'Igual a',
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString(){
        
        
        if(replace_db($this->get('value')) == ''){
            $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'" IS NULL)';
        }
        else{
            $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'"::DATE = '.'\''.replace_db($this->get('value')).'\'::DATE) ';
        }
        
        return '('.$strReturn.')';
                
    }
    /**
     * PRIVATES
     */
  }
?>