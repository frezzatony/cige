<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Begins_with_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'begins_with',
            'text'  =>  'Inicia com'
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString($arrProp = array()){
        
        if(array_key_exists('case_sensitive',$arrProp)===TRUE && $arrProp['case_sensitive']==='true'){
            
            return $this->_getQuerySelectStringCaseSensitive($arrProp);
            
        }
        
        if(replace_db($this->get('value')) == ''){
           return NULL;
        }
        else{
            $strReturn = '(unaccent("'.$this->get('table').'"."'.$this->get('column').'"::CITEXT))::CITEXT ';
            $strReturn .= ' LIKE ( unaccent(\''.replace_db($this->get('value')).'%\'::CITEXT))::CITEXT';    
        }
        
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
    public function _getQuerySelectStringCaseSensitive($arrProp = array()){
        
        $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'"::CITEXT ';
        $strReturn .= 'LIKE(\''.replace_db($this->get('value')).'%\'::CITEXT)';
        return $strReturn;
    
    }

  }
?>
