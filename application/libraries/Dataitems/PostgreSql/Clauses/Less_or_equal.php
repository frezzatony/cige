<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Less_or_equal_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'less_or_equal',
            'text'  =>  'Menor ou igual a'
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString(){
       

        $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'"::REAL) <= ';
        $strReturn .= '(\''.(real)replace_db($this->get('value')).'\'::REAL)';
        
        if(
            (real)replace_db($this->get('value')) == '' AND
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