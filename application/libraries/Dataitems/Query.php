<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/PostgreSql/'.'Columns/Columns_postgreSql_defaults.php');

class Query extends Data{
    
    function __construct($arrProp = array()){
        parent::__construct();
                
        $this->scanDirectory(dirname(__FILE__).'/PostgreSql/Clauses/');
        $this->scanDirectory(dirname(__FILE__).'/PostgreSql/Columns/');
        
        if($arrProp){            
            $this->set($arrProp);
                
        }
    }
    
    public function getQueryDeleteData(){
        
        $arrDataReturn = $this->getQuerySelectData();
        
        foreach($arrDataReturn as $key => $val){
            
            if(!in_array($key,array('from','where','or_where','like','where_in'))){
                unset($arrDataReturn[$key]);
            }
            
        }
               
        return $arrDataReturn;
        
    }
    
    public function getQuerySelectData(){
        
        $schema = $this->get('data.schema');
        $tableBase = $this->get('data.table');
        $pkColumn = $this->get('data.pk_column') ? $this->get('data.pk_column') : 'id'; 
        
        $tableBaseAlias = $this->get('data.table').'_'.random_string();
        $this->set('data.table_alias',$tableBaseAlias);

        $arrDataReturn = array(
            'from'          =>  array(
                'db_schema'     =>  $schema,
                'table'         =>  $tableBase,
                'as'            =>  $tableBaseAlias
            ),
            'select'        =>  array(
                 array(
                    'table'     =>  $tableBaseAlias,
                    'column'    =>  $pkColumn,
                    'as'        =>  'pk'
                )
            ),
            'join'          =>  array(),
            'where_in'      =>  array(),
            'group_by'      =>  array(),
            'order_by'      =>  array(),
            'groups_where'  =>  array(),
            'limit'         =>  NULL,
            'with'          =>  array(),
            'where'         =>  array(),
        );
        
        $arrDataReturn = $this->_getMergeDataSelect($arrDataReturn,
            $this->get()
        );   
        
        
        $arrUsedColumns = array();        
        foreach($this->get('data.variables')??array() as $column){
                if(!($column['type']??NULL)){
                    continue;
                }
                $className = strtoMINusculo($column['type'].'_Columns');
                
                if(
                    isset($className)===FALSE OR
                    ($column['no_form']??NULL)
                    OR
                    (!($column['column'] ?? NULL) AND !($column['variables'] ?? NULL))
                ){
                    continue;
                }
                
                $arrTemp = array(
                    'parent'    =>  $this->get('data'),
                );             
                $arrTemp = array_merge($arrTemp,$column);
                $arrTemp['filters'] = array();
                
                foreach($this->get('filters') ?? array() as $key => $filter){
                    
                    $filter['id'] = explode('.',$filter['id'])[0];
                    
                    if($filter['id'] == $column['id']){
                        $arrTemp['filters'][] = $filter;                        
                    }
                    
                }
                          
                $className = $className.'_Postgresql';
                
                $tempPostgreSql = new $className($arrTemp);    
                
                $arrDataColumn = $tempPostgreSql->getSelectData();
                
                if(!$arrDataColumn){
                    continue;
                }
                
                if(is_array(($arrDataColumn['base_select']['where']??NULL)) AND sizeof($arrDataColumn['base_select']['where'])>1){
                    $arrDataColumn['base_select']['groups_where'] = array();
                    $arrGroupColumn = array(); 
                    foreach($arrDataColumn['base_select']['where'] as $key => $where){
                        $arrGroupColumn[] = $where;
                        
                        unset($arrDataColumn['base_select']['where'][$key]);
                    }
                    $arrDataColumn['base_select']['groups_where'][] = $arrGroupColumn;

                }
                
                
                if(($arrDataColumn['base_select']??NULL)){
                    $arrDataReturn = $this->_getMergeDataSelect($arrDataReturn,$arrDataColumn['base_select']);
                }
                if(($arrDataColumn['with']??NULL)){
                    $arrDataReturn['with'] = array_merge($arrDataReturn['with'],$arrDataColumn['with']);
                }
        }
        
        foreach($this->get('order') ?? array() as $order){
            
            if($order['table']??NULL == $tableBase){
                $order['table'] = $tableBaseAlias;
            }
            
            if($order['table'] ?? NULL){
                $order['column'] =  $order['table'].'.'.$order['column'];
            }
            
            $arrDataReturn['order_by'][] = $order;
        }
        
        
        if($this->get('group_by_id')){
            $arrDataReturn['group_by'] = array_merge(
                array($tableBaseAlias.'."id"'),
                $arrDataReturn['group_by']
            );    
        }
        
        return $arrDataReturn;
    }
    
    
    public function getQueryUpdateData($kk=NULL){
    
        $schema = $this->get('data.schema');
        $tableBase = $this->get('data.table');
        
        $arrDataReturn = array(
            'table'     =>  $schema.'.'.$tableBase,      
        );
        $arrDataReturn = $this->_getMergeDataUpdate($arrDataReturn);
        
        foreach($this->get('data.variables') as $column){
            
            $className = strtoMINusculo($this->CI->common->getDataFromArrayObject('type',$column).'_Columns_PostgreSql');
                
            if(
                class_exists($className)===FALSE OR $this->CI->common->getDataFromArrayObject('no_form',$column) OR
                $this->CI->common->getDataFromArrayObject('no_db',$column)
                ){
                continue;
            }
            
            $arrTemp = array(
                'parent'    =>  $this->get('data'),
                'filters'   =>  array()
            );    
                     
            $arrTemp = array_merge($arrTemp,$this->CI->common->getDataFromArrayObject(NULL,$column));
            
            if(is_array($this->get('filters'))){
                foreach($this->get('filters') as $filter){
                    if($filter['id']==$column['id']){
                         $arrTemp['filters'][] = $filter;  
                    }
                }
                
                //$filterKeys = array_keys(array_column($this->get('filters'),'id'),$this->CI->common->getDataFromArrayObject('id',$column));
                //$arrTemp['filters'] = array_intersect_key($this->get('filters'),$filterKeys);
            }
            
            $arrTemp['filters'] = array_merge(
                $arrTemp['filters'],
                ($column['filters']??array())
            );
            
            $tempPostgreSql = new $className($arrTemp);    
                
            $arrDataColumn = $tempPostgreSql->getUpdateData();
            
            if($arrDataColumn){
                $arrDataReturn = $this->_getMergeDataUpdate($arrDataReturn,$arrDataColumn);    
            }
            
        }
        
        return $arrDataReturn;
            
    }
    
    
    
    /**
     * PRIVATES
     **/
    
    private function _getMergeDataSelect($arrDataSelect, $newDataSelect){
        
        if(array_key_exists('select',$arrDataSelect)===FALSE){
            $arrDataSelect['select'] = array();
        }
        if(array_key_exists('join',$arrDataSelect)===FALSE){
            $arrDataSelect['join'] = array();
        }
        if(array_key_exists('where',$arrDataSelect)===FALSE){
            $arrDataSelect['where'] = array();
        }
        if(array_key_exists('or_where',$arrDataSelect)===FALSE){
            $arrDataSelect['or_where'] = array();
        }
        if(array_key_exists('where_in',$arrDataSelect)===FALSE){
            $arrDataSelect['where_in'] = array();
        }
        if(array_key_exists('groups_where',$arrDataSelect)===FALSE){
            $arrDataSelect['groups_where'] = array();
        }        
        if(array_key_exists('like',$arrDataSelect)===FALSE){
            $arrDataSelect['like'] = array();
        }
        if(array_key_exists('order_by',$arrDataSelect)===FALSE){
            $arrDataSelect['order_by'] = array();
        }
        if(array_key_exists('group_by',$arrDataSelect)===FALSE){
            $arrDataSelect['group_by'] = array();
        }
        if(array_key_exists('limit',$arrDataSelect)===FALSE){
            $arrDataSelect['limit'] = array();
        }
        
        
        /**
         * MERGES
         **/
         
        if(($newDataSelect['select']??NULL)){
            foreach($newDataSelect['select'] as $select){
                
                if($select['column']??NULL){
                    $select['column'] = $this->CI->parser->parse_string($select['column'],
                        array(
                            'table_base_alias'  =>   '"'.$this->get('data.table_alias').'"',
                        ),TRUE
                    );
                }
                
                $arrDataSelect['select'][] = $select;  
            }
            
        }
        
        if(array_key_exists('join',$newDataSelect)!==FALSE){
            foreach($newDataSelect['join'] as $join){
                
                if($join['on']??NULL){
                    $join['on'] = $this->CI->parser->parse_string($join['on'],
                        array(
                            'table_base_alias'  =>   '"'.$this->get('data.table_alias').'"',
                        ),TRUE
                    );
                }
                
                $arrDataSelect['join'][] = $join;    
            }
            //$arrDataSelect['join'] = array_merge($arrDataSelect['join'],$newDataSelect['join']);
        }
        if(array_key_exists('where',$newDataSelect)!==FALSE){
            //temp($arrDataSelect['where']);
            $arrDataSelect['where'] = array_merge($arrDataSelect['where'],$newDataSelect['where']);
        }
        if(array_key_exists('or_where',$newDataSelect)!==FALSE){
            $arrDataSelect['or_where'] = array_merge($arrDataSelect['or_where'],$newDataSelect['or_where']);
        }
        if(array_key_exists('where_in',$newDataSelect)!==FALSE){
            $arrDataSelect['where_in'] = array_merge($arrDataSelect['where_in'],$newDataSelect['where_in']);
        }
        if(array_key_exists('groups_where',$newDataSelect)!==FALSE){
            $arrDataSelect['groups_where'] = array_merge($arrDataSelect['groups_where'],$newDataSelect['groups_where']);
        }
        if(array_key_exists('like',$newDataSelect)!==FALSE){
            $arrDataSelect['like'] = array_merge($arrDataSelect['like'],$newDataSelect['like']);
        }
        if(array_key_exists('order_by',$newDataSelect)!==FALSE){
            $arrDataSelect['order_by'] = array_merge($arrDataSelect['order_by'],$newDataSelect['order_by']);
        }
        if(array_key_exists('group_by',$newDataSelect)!==FALSE){
            $arrDataSelect['group_by'] = array_merge($arrDataSelect['group_by'],$newDataSelect['group_by']);
        }
        if(array_key_exists('limit',$newDataSelect)!==FALSE){
            $arrDataSelect['limit'] = $newDataSelect['limit'];
        }
        
        return $arrDataSelect;
        
    }
    
    
     private function _getMergeDataUpdate($arrDataUpdate=array(), $newDataUpdate=array()){
        
        if(array_key_exists('set',$arrDataUpdate)===FALSE){
            $arrDataUpdate['set'] = array();
        }
        if(array_key_exists('where',$arrDataUpdate)===FALSE){
            $arrDataUpdate['where'] = array();
        }
        if(array_key_exists('where_in',$arrDataUpdate)===FALSE){
            $arrDataUpdate['where_in'] = array();
        }
        if(array_key_exists('like',$arrDataUpdate)===FALSE){
            $arrDataUpdate['like'] = array();
        }
        if(array_key_exists('limit',$arrDataUpdate)===FALSE){
            $arrDataUpdate['limit'] = array();
        }
        
        if(array_key_exists('batch',$arrDataUpdate)===FALSE){
            $arrDataUpdate['batch'] = array();
        }
        
        /**
         * MERGES
         **/
        
        if($newDataUpdate['batch'] ?? FALSE){
            $arrDataUpdate['batch'][] = $newDataUpdate;
            return $arrDataUpdate; 
        }
        
        if(($newDataUpdate['set'] ?? NULL)){
            foreach($newDataUpdate['set'] as $set){
                $arrDataUpdate['set'][] = $set;  
            }
            
        }
        
        if(array_key_exists('where',$newDataUpdate)!==FALSE){
            $arrDataUpdate['where'] = array_merge($arrDataUpdate['where'],$newDataUpdate['where']);
        }
        if(array_key_exists('where_in',$newDataUpdate)!==FALSE){
            $arrDataUpdate['where_in'] = array_merge($arrDataUpdate['where_in'],$newDataUpdate['where_in']);
        }
        if(array_key_exists('like',$newDataUpdate)!==FALSE){
            $arrDataUpdate['like'] = array_merge($arrDataUpdate['like'],$newDataUpdate['like']);
        }
        
        if(array_key_exists('limit',$newDataUpdate)!==FALSE){
            $arrDataUpdate['limit'] = $newDataUpdate['limit'];
        }
        
        return $arrDataUpdate;
        
    }
  
    
    private function scanDirectory($directory){
        
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        
        $arrDirectory = explode('/',$directory);
        $lastPath = strtoMINusculo($arrDirectory[sizeof($arrDirectory)-2]);
        
        
        foreach($scanned_directory as $input_file){
            
            if(
                $input_file == 'Columns_postgreSql_defaults.php' OR
                is_dir($directory.$input_file)
            ){
                continue;
            }
                 
            require_once($directory.$input_file);
            
            $objName = strtoMINusculo(str_replace('.php','',$input_file).'_'.$lastPath);
            
            $className = $objName.'_PostgreSql';
            $this->{$objName} = new $className; 
                     
        }  
    }
}
?>