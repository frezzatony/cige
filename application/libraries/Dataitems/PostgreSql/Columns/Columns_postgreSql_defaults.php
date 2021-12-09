<?php

/**
 * @author Tony Frezza

 */


class Columns_PostgreSql_defaults extends Data{
    
    function __construct(){
        parent::__construct();
    }
    
    public function getColumnBaseName($arrProp = array()){
        
        return (isset($arrProp['column']) ? $arrProp['column'] : $arrProp['id']);
        
    }
    
    
    public function getColumnName($arrInput = array()){
        
        if($arrInput){
            return $arrInput['column'] ?? $arrInput['id'];    
        }
        
        return $this->get('column') ? $this->get('column') : $this->get('id');
        
        
    }    
    
    public function getColumnTextName($arrInput = array()){
        
        return $arrInput['id'].'_text';
        
    }
    
    public function getColumnValueName($arrInput = array()){
        
        return $arrInput['id'].'_value';
        
    }
    
    public function getColumnVariableName($arrInput = array()){
        
        return $arrInput['id'].'_{variable}';
        
    }
    
    
    
    public function replaceColumnJson($column){
        
       $column = 'REPLACE('.$column.',\'\\\\\',\'\\\\\\\\\')'; 
       $column = 'REPLACE('.$column.',\'"\',\'\\\\"\')';
                        
        return $column;
        
    }
    
}

?>