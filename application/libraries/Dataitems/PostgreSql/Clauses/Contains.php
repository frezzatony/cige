<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contains_clauses_PostgreSql extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value' =>  'contains',
            'text'  =>  'Contém',
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString(){
        
        if($this->get('case_sensitive')){
            return $this->_getQuerySelectStringCaseSensitive();
        }
        
        if(replace_db($this->get('value')) == ''){
           return NULL;
        }
        else{
            
             $strReturn = '(unaccent("'.$this->get('table').'"."'.$this->get('column').'"::CITEXT))::CITEXT ';
             $strReturn .= 'LIKE ALL (
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
        $strReturn .= 'LIKE(\'%'.replace_db($this->get('value')).'%\'::CITEXT)';
        return $strReturn;
    
    }
  }
?>