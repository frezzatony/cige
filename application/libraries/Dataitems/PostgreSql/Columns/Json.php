<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Json_Columns_PostgreSql extends Columns_PostgreSql_defaults{
    
    protected $CI;
    protected $variable;
    
    function __construct($arrProp = array()){
        $this->CI = &get_instance();   
        $this->set($arrProp);
        
        
        $this->variable = new Json_Variables($arrProp);
        $this->variable->set('method','database');
        
    }
    
    
    public function getSelectData(){
        
        $strAs = $this->get('parent.column_alias') ? $this->get('parent.column_alias').'_' : '';
        $strAs .= $this->getColumnValueName($this->get());
        
        $column = $this->getColumnName($this->get());
        
        if($this->variable->isset('key')){
            
            $column = $this->getSelectKey($column);
        }
        
        $arrDataReturn = array(
            'base_select' =>  array(
                'select'    =>  array(
                    array(
                        'table'     =>  $this->get('parent.table_alias'),
                        'column'    =>  $column,
                        'as'        =>  $strAs,
                        'escape'    =>  TRUE,
                    ),
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
        
        $value = $this->variable->getValue(); 
        
        if($value AND $this->variable->get('key')){
            $value = $this->getUpdateKeyValue($value);
        }
        
        if($value AND $this->variable->get('append')){
            $value = $this->getUpdateAppendValue($value);
        }
                     
        $arrDataReturn = array(
            'set'   =>  array(
                array(
                    'column'    =>  $this->getColumnName(),
                    'value'     =>  ($value ? '\''.$value.'\'' : 'DEFAULT'),
                    'escape'   =>   NULL
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

    /**
     * PRIVATES
     **/
     
     private function getSelectKey($column){
        
        $column = '("'.$this->get('parent.table_alias').'".'.$column.')->>'.$this->variable->get('key');
        
        return $column;
     }
     
     private function getUpdateAppendValue($value){
        
        $value = $this->getColumnName() .' || \'' .$value.'\'';
        return $value;
     }
     
     
     private function getUpdateKeyValue($value){
        
        $key = $this->variable->get('key');
        
        if(substr($key,0,1)!='{'){
            $key = '{'.$key;
        }
        if(substr($key,strlen($key)-1,1)!='}'){
            $key .= '}';
        }
        
        $key = str_replace('\'','"',$key);
        
        
        $value = 'jsonb_set('.$this->getColumnName().',\''.$key.'\',\''.$value.'\')';
        
        return $value;
        
     }    
}

?>