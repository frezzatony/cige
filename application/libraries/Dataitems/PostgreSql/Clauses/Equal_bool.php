<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Equal_bool_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'equal_bool',
            'text'  =>  'Igual a',
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString(){
        
        
        if(in_array(replace_db($this->get('value')),array('','f','NÃO'))){
            $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'" = \'false\'::bool';
            $strReturn .= ' OR "'.$this->get('table').'"."'.$this->get('column').'" IS NULL';
        }
        else{
            $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'" = \'true\'::bool';
        }
        
                
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
  }
?>