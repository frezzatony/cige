<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Is_null_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value'                 =>  'is_null',
            'text'                  =>  'É nulo/vazio',
            'data-num-cols-input'   =>  0
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString($arrProp = array())
    {
        
        $strReturn = '("'.$this->get('table').'"."'.$this->get('column').'"::CITEXT) = \'\'';
        $strReturn .= ' OR "'.$this->get('table').'"."'.$this->get('column').'" IS NULL';
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
  }
?>