<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Not_equal_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'not_equal',
            'text'  =>  'Diferente de'
        );
        
        return $arrDataReturn;
    }
    
   public function getQuerySelectString($arrProp = array()){
        
        
        if(array_key_exists('case_sensitive',$arrProp)===TRUE && $arrProp['case_sensitive']==='true'){
            
            return $this->_getQuerySelectStringCaseSensitive($arrProp);
            
        }
        $strReturn = '( unaccent("'.$this->get('table').'"."'.$this->get('column').'"::CITEXT))::CITEXT NOT LIKE ';
        $strReturn .= '( unaccent(\''.replace_db($this->get('value')).'\'::CITEXT))::CITEXT';
        

        if(replace_db($this->get('value')) == ''){
            $strReturn .= ' OR ';
            $strReturn .= '"'.$this->get('table').'"."'.$this->get('column').'" NOTNULL';
        }
        else{
            $strReturn .= ' OR ';
            $strReturn .= '"'.$this->get('table').'"."'.$this->get('column').'" IS NULL';
        }
        
        return '('.$strReturn.')';
                
    }
    /**
     * PRIVATES
     */
    public function _getQuerySelectStringCaseSensitive(){
        
        $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'"::CITEXT <> ';
        $strReturn .= '\''.replace_db($this->get('value')).'\'::CITEXT';
        
        if(replace_db($this->get('value')) == ''){
            $strReturn .= ' OR ';
            $strReturn .= '"'.$this->get('table').'"."'.$this->get('column').'" NOTNULL';
        }
        return $strReturn;
    
    }
    
  }
?>