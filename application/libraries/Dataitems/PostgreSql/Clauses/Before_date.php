<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Before_date_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'before_date',
            'text'  =>  'Antes de'
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString($arrProp = array()){
        
        $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'"::DATE < '.'\''.replace_db($this->get('value')).'\'::DATE) ';
        $strReturn .= ' OR ';
        $strReturn .= '"'.$this->get('table').'"."'.$this->get('column').'" IS NULL';
        
        return '('.$strReturn.')';
                
    }
    /**
     * PRIVATES
     */
  }
?>