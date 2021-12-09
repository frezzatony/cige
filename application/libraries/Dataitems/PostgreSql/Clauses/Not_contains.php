<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Not_contains_clauses_PostgreSql  extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput()
    {
        $arrDataReturn = array(
            'value' =>  'not_contains',
            'text'  =>  'Não contém'
        );
        
        return $arrDataReturn;
    }
    
    
    public function getQuerySelectString($arrProp = array()){
        
        if($this->get('case_sensitive')){
            return $this->_getQuerySelectStringCaseSensitive();
        }
        
        if(replace_db($this->get('value')) == ''){
           return NULL;
        }
        else{
            
             $strReturn = '(unaccent("'.$this->get('table').'"."'.$this->get('column').'"::CITEXT))::CITEXT ';
             $strReturn .= 'NOT LIKE ALL (
                                string_to_array(
                                    \'%\' ||
                                    regexp_replace(
                                        (unaccent(\''.replace_db($this->get('value')).'\'::CITEXT))::CITEXT
                                    ,
                                     \'\s+\', \'% %\', \'g\')
                                    || \'%\', \' \'
                                )
                            )';  
        }
        
        return '('.$strReturn.')';
                
    }
    /**
     * PRIVATES
     */
    public function _getQuerySelectStringCaseSensitive(){
        
        $strReturn = '"'.$this->get('table').'"."'.$this->get('column').'"::CITEXT ';
        $strReturn .= 'NOT LIKE(\'%'.replace_db($this->get('value')).'%\'::CITEXT)';
        
        if(replace_db($this->get('value')) == ''){
            $strReturn .= ' OR ';
            $strReturn .= '"'.$this->get('table').'"."'.$this->get('column').'"  NOTNULL';
        }
        
        return '('.$strReturn.')';
    
    }
  }
?>