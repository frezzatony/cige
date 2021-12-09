<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Character_Columns_PostgreSql extends Columns_PostgreSql_defaults{
    
    protected $CI;
    protected $variable;
    
    function __construct($arrProp = array()){
        $this->CI = &get_instance();   
        $this->set($arrProp);
        
        $variableType = ($arrProp['variable_type'] ?? 'Character').'_Variables';
        $this->variable = new $variableType($arrProp);
        $this->variable->set('method','database');
        
    }
    
    
    public function getSelectData(){
        
        $strAs = $this->get('parent.column_alias') ? $this->get('parent.column_alias').'_' : '';
        $strAs .= $this->getColumnValueName($this->get());
        
        $arrDataReturn = array(
            'base_select' =>  array(
                'select'    =>  array(
                    array(
                            'table'     =>  $this->get('parent.table_alias'),
                            'column'    =>  $this->getColumnName($this->get()),
                            'as'        =>  $strAs,
                        ) 
                ),
                'where' =>  array(),
                'or_where'  =>  array(),
            ) 
        );
        
        if($this->get('filters')){
            foreach($this->get('filters') as $filter){
                
                $filter = array_merge(
                    $filter,
                    array(
                        'column'    =>  $this->getColumnName($this->get()),
                        'table'     =>  $this->get('parent.table_alias')
                    )
                );
                
                $clauseName = $filter['clause'].'_clauses_PostgreSql';       
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
        
        $this->variable->set('method','database');
        
        $value = $this->variable->getValue(); 
        
        if($this->get('mask')){
            $value = $this->CI->mask->unmask($value,$this->get('mask'));
        }
                  
        $arrDataReturn = array(
            'set'   =>  array(
                array(
                    'column'    =>  $this->getColumnName(),
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
                        'column'    =>  $this->getColumnName($this->get()),
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