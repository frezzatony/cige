<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Date_columns_PostgreSql extends Columns_PostgreSql_defaults{
    
    protected $CI;
    private $date;
    function __construct($arrProp = array()){
        $this->CI = &get_instance();   
        $this->set($arrProp);
        $this->date = new Date_Variables($arrProp);
    }
    
    
    public function getSelectData(){
        
        $strAs = $this->get('parent.column_alias') ? $this->get('parent.column_alias').'_' : '';
        $strAs .= $this->getcolumnValueName($this->get());
        
        $arrDataReturn = array(
            'base_select'   =>  array(
                'select'    =>  array(
                     array(
                        'table'     =>  $this->get('parent.table_alias'),
                        'column'    =>  $this->getcolumnName($this->get()),
                        'as'        =>  $strAs,
                    )
                ),
                'where'     =>  array(),
                'or_where'  =>  array(),
            ) 
        );
        
        
        if($this->get('filters')){
            
            foreach($this->get('filters') as $filter){
                $filter['method'] = 'database';
                $filter['type'] = 'date';
                
                $variableDate = new Date_Variables($filter);
                
                $filter['value'] = $variableDate->getValue(); 
                              
                $clauseName = $filter['clause'].'_clauses_PostgreSql';
                               
                
                $filter = array_merge(
                    $filter,
                    array(
                        'column'    =>  $this->getcolumnName($this->get()),
                        'table'     =>  $this->get('parent.table_alias')
                    )
                );
                         
                $tempFilter = new $clauseName($filter); 
                
                $strWhere = $tempFilter->getQuerySelectString();
                if($strWhere){
                    $arrDataReturn['base_select']['where'][] = array(
                        'column'    =>  $strWhere
                    );    
                }                   
                
                
            }
        }
        
        return $arrDataReturn;
            
    }
    
    
    public function getUpdateData(){
        $this->date->set('method','database');
        $value = $this->date->getValue();              
        $arrDataReturn = array(
            'set'   =>  array(
                array(
                    'column'    =>  $this->getcolumnName(),
                    'value'     =>  ($value ? $value : 'DEFAULT'),
                    'escape'   =>   ($value ? TRUE : NULL)
                )
            ),
            'where' =>  array(), 
        );
        
        if($this->get('filters')){
            
            foreach($this->get('filters') as $filter){
                                    
                $clauseName = $filter['clause'].'_clauses_PostgreSql';
                
                $filter = array_merge(
                    $filter,
                    array(
                        'column'    =>  $this->getcolumnName($this->get()),
                        'table'     =>  ($this->get('parent.table_alias') ? $this->get('parent.table_alias') : $this->get('parent.table'))
                    )
                );
                         
                $tempFilter = new $clauseName($filter);                    
                $arrDataReturn['where'][] = array(
                    'column'    =>  $tempFilter->getQuerySelectString()
                );
                
            }
        }
        
        return $arrDataReturn; 
    }

    
}

?>