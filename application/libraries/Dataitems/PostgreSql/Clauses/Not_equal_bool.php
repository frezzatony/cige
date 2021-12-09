<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Not_equal_bool_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'not_equal_bool',
            'text'  =>  'Diferente de',
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString(){
        
        
        if(in_array(replace_db($this->get('value')),array('','f','NÃO'))){
            $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'" <> \'false\'::bool';
        }
        else{
            $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'" <> \'true\'::bool';
        }
        
        $strReturn .= ' OR "'.$this->get('table').'"."'.$this->get('column').'" IS NULL';
        
                
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
  }
?>