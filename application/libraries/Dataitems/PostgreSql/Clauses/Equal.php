<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Equal_clauses_PostgreSql extends Data{
	
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
        
       if($this->get('case_sensitive')){
            return $this->_getQuerySelectStringCaseSensitive();
        }
        

        $strReturn = '( unaccent("'.$this->get('table').'"."'.$this->get('column').'"::CITEXT))::CITEXT LIKE ';
        $strReturn .= '( unaccent(\''.replace_db($this->get('value')).'\'::CITEXT))::CITEXT';
        
        if(
            replace_db($this->get('value')) == '' AND
            !in_array($this->get('type'),array('date','relational_1_n'))
            ){
            $strReturn .= ' OR ';
            $strReturn .= '"'.$this->get('table').'"."'.$this->get('column').'" IS NULL';
        }
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
    public function _getQuerySelectStringCaseSensitive(){
        
        $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'"::CITEXT = ';
        $strReturn .= '\''.replace_db($this->get('value')).'\'::CITEXT';
        
        if(replace_db($this->get('value')) == ''){
            $strReturn .= ' OR ';
            $strReturn .= '"'.$this->get('table').'"."'.$this->get('column').'" IS NULL';
        }
        return $strReturn;
    
    }
  }
?>