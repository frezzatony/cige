<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Between_dates_clauses_PostgreSql extends Data{
	
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
    }
    
    public function getOptionsInput(){
        $arrDataReturn = array(
            'value'                 =>  'between_dates',
            'text'                  =>  'Entre',
            'data-num-cols-input'   =>  2
        );
        
        return $arrDataReturn;
    }
    
    public function getQuerySelectString(){
        
        $strReturn  = '';
        
        if($this->get('value.1')){
            $strReturn .= '"'.$this->get('table').'"."'.$this->get('column').'" <= '.'\''.$this->get('value.1').'\'';
            
            if($this->get('value.0')==''){
                $strReturn .= ' OR "'.$this->get('table').'"."'.$this->get('column').'" IS NULL';   
            }
            
            $strReturn = '('.$strReturn.')';
                
        }
        
        if($this->get('value.0')){
            
            if($strReturn){
                $strReturn .= ' AND ';
            }
            
            $strReturn .= '("'.$this->get('table').'"."'.$this->get('column').'" >= '.'\''.$this->get('value.0').'\')';    
        }
        
        if($strReturn){
            $strReturn = '('.$strReturn.')';
        }
        
        
        return $strReturn;
                
    }
    /**
     * PRIVATES
     */
  }
?>