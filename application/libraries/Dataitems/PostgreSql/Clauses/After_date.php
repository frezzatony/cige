<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class After_date_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'after_date',
            'text'  =>  'Depois de'
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString($arrProp = array()){
        
        $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'"::DATE > '.'\''.replace_db($this->get('value')).'\'::DATE) ';
        
        if(
            replace_db($this->get('value')) == '' AND
            !in_array($this->get('type'),array('relational_1_n'))
            ){
            
            $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'" NOTNULL) ';
        }
        
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
  }
?>