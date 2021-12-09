<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Less_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'less',
            'text'  =>  'Menor que'
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString(){
       

        $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'"::REAL) < ';
        $strReturn .= '(\''.replace_db($this->get('value')).'\'::REAL)';
        
        if(
            replace_db($this->get('value')) == '' AND
            !in_array($this->get('type'),array('date','relational_1_n'))
            ){
            
            $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'" IS NULL';
        }
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
  }
?>