<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relational_n_n_Columns_PostgreSql extends Columns_PostgreSql_defaults{
    
    protected $CI;
    
    function __construct($arrProp = array()){
        $this->CI = &get_instance();   
        $this->set($arrProp);
        
    }
    
    
    public function getSelectData(){
        
        $arrDataReturn = array();
        
        $strWithAlias = '_'.$this->get('table').'_'.random_string();
        $this->set('variables.id',
            array(
                'id'        =>  'id',
                'type'      =>  'integer',
                'column'    =>  'id'
            )
        );
        
        $withJoinType = 'LEFT';
        if($this->get('filters')){
            $withJoinType = 'INNER';
            $filters = $this->get('filters');
            
            foreach($filters as &$filter){
                $filter['input'] = explode('.',$filter['input']);
                unset($filter['input'][0]);
                $filter['input'] = implode('.',$filter['input']);
                $filter['id'] = $filter['input'];
            }
            
            $this->set('filters',$filters);
            
        }
        
        $dataitems = new DataItems(
            array(
                'data'      =>  $this->get(),
                'filters'   =>  ($this->get('filters') ?? NULL),
                'limit'     =>  ($this->get('limit') ??  NULL),
            )
        );
        
        $arrDataSelect = $dataitems->getDataSelect();
        
        foreach($arrDataSelect as $key => $dataProp){
            if(array_key_exists($key,$arrDataReturn)===FALSE){
                $arrDataReturn[$key] = $dataProp;
            }        
        }
        
        $arrDataSelect['order_by'] = array(
            array(
                'column'    =>  '"'.$arrDataSelect['from']['as'].'"."id"',
                'dir'       =>  'ASC'
            )
            
        );
                
        $arrDataSelect['group_by'] = NULL;
                
        $query = $this->CI->database->getCompiledSelectQuery($arrDataSelect);
        
        $arrDataReturn['with'][] = array(
            'alias'     =>  $strWithAlias,
            'query'     =>  $query 
        );
        
        
        $strSelect = '';
        $strName = '';
        $strColumn = '';
        
        foreach($arrDataReturn['select'] ?? array() as $select){
            
            if($strSelect){
                $strSelect .= ',\',\','."\n";
            }
            
            $strName = '\'"';
            $strName .= str_replace('"','',($select['as'] ?? $select['column']));
            $strName .= '"\'';
            
            $strColumn = '"'.$strWithAlias.'".';
            $strColumn .= '"'.str_replace('"','',($select['as'] ?? $select['column'])).'"';
            
            $strSelect .= $strName.',\':\','.'\'"\','.$strColumn.'::text,\'"\'';
            
        }
        
        $strSelect = 'ARRAY_TO_STRING(ARRAY[\'{\','.$strSelect.',\'}\'],\'\')';
        $strSelect = 'STRING_AGG('.$strSelect.',\',\')';
        $strSelect = 'ARRAY_TO_STRING(ARRAY[\'[\','.$strSelect.',\']\'],\'\')';
        
        $strSelect = '(
            CASE WHEN "'.$strWithAlias.'"."pk" NOTNULL
            THEN ' . $strSelect .' 
            ELSE \'[]\'
            END 
        )';
        
        
        $arrAggDataSelect = array(
                'from'  =>  array(
                    'table' => $strWithAlias
                ),
                'select'    =>  array(
                    'pk',
                    array(
                        'as'        =>  $this->getColumnValueName($this->get()),
                        'column'    =>  $strSelect,
                    )
                ),
                'group_by'  =>  array(
                    '"'.$strWithAlias.'".pk' 
                )
        
        );
        
        $query = $this->CI->database->getCompiledSelectQuery($arrAggDataSelect);
        
        $arrDataReturn['with'][] = array(
            'alias'     =>  $strWithAlias.'_agg',
            'query'     =>  $query 
        );
        
        
        $tableJoinOn = '"'.$this->get('parent.table_alias').'".'.($this->get('parent.pk_column') ?? 'id').' = "'.$strWithAlias.'_agg"."pk"';
        
        $arrDataReturn['base_select']['join'][] = array(
            'table'     =>  '"'.$strWithAlias.'_agg"',
            'on'        =>  $tableJoinOn ,
            'type'      =>  $withJoinType,
            'escape'    =>  FALSE
        );
        
        $arrDataReturn['base_select']['select'] = array(
            array(
                'as'        =>  $this->getColumnValueName($this->get()),
                'column'    =>  '"'.$strWithAlias.'_agg".'.$this->getColumnValueName($this->get()),
            )
        );
        
        
        
        $arrDataReturn['base_select']['group_by'] = array_merge(
            array('"'.$strWithAlias.'_agg".'.$this->getColumnValueName($this->get())),
            $arrDataReturn['base_select']['group_by'] ?? array()
        );
        
        
        return $arrDataReturn;
    }
    
    
    public function getUpdateData(){
              
        $oldValues = $this->get('old_value');
        
        $arrDataReturn = array(
            'batch'     =>  TRUE,
            'pk_column' =>  $this->get('pk_column'),
            'data'      =>  $this->getBatchData($this->get('value'),$oldValues),
        );
        
        if(!$this->isset('preserv_order') OR $this->get('preserv_order')==TRUE){ //EU NAO QUIS DEIXAR UM IF MUITO GRANDE, POR ISSO TEM DOIS!!!!
            if(is_array($oldValues) AND is_array($arrDataReturn['data']) AND sizeof($oldValues) > sizeof($arrDataReturn['data'])){
                $arrDataRemove = $this->getBatchData(array_diff_key($oldValues,$this->get('value') ?? array()),$oldValues,'delete');
                $arrDataReturn['data'] = array_merge($arrDataReturn['data'],$arrDataRemove);
            }
        }
        
        return $arrDataReturn;
    }

    
    /**
     * 
     * PRIVATES
     **/
    
    private function getBatchData($value,$oldValues,$method=NULL){
        
        if(!$this->isset('preserv_order') OR $this->get('preserv_order')==TRUE){
            return $this->getBatchDataPreservOrder($value,$oldValues,$method);
        }
        
        $arrReturn = array();
        $arrPkValues = array();
        
        //INSERT/UPDATE
        foreach($value ?? array() as $rowValue){
            $variables = new Variables($this->get('variables'));
            
            foreach($variables->get() as $variable){
                
                $keyVariable = array_search($variable->get('id'),array_column($rowValue,'id'));
                if($keyVariable !== FALSE){
                    $variables->set($variable->get('id'),$rowValue[$keyVariable]); 
                    if($variable->get('id')=='id'){
                        $arrPkValues[] = $variable->get('value');
                    }   
                }
                
            }
            
            $arrConfig = array(
                'data'      =>  $this->get(),
                'filters'   =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal',
                        'value'     =>  $variables->get('id')->get('value')
                    ),
                )
            );
            $arrConfig['filters'] = array_merge(
                $arrConfig['filters'],
                ($this->get('filters') ?? array())
            );
            
            
            $arrConfig['data']['variables'] = array();
            foreach($variables->get() as $variable){
                $arrConfig['data']['variables'][] = $variable->get();    
            }
            
            $query = new Query($arrConfig);
            $queryData = $query->getQueryUpdateData(true);
            
            $queryData['rule'] = 'insert';    
            if($oldValues){
                foreach($oldValues as $rowOldValue){
                    $keyOldInputId = array_search('id',array_column($rowOldValue,'id'));
                    if($keyOldInputId !== FALSE AND $rowOldValue[$keyOldInputId]['value']==$variables->get('id')->get('value')){
                        $queryData['rule'] = $method ?  $method : 'update';
                        
                        break;
                    }             
                }
            }
               
            $arrReturn[] = $queryData;
        }
        
        //DELETE
        if($method != 'delete'){
            foreach($oldValues as $key => $rowOldValue){
                $keyIdOldValue = array_search('id',array_column($rowOldValue,'id'));
                if($keyIdOldValue===FALSE){
                    continue;
                }
                
                if(in_array($rowOldValue[$keyIdOldValue]['value'],$arrPkValues)){
                    unset($oldValues[$key]);
                }
            }
            
            if($oldValues){
                $arrReturn = array_merge(
                    $arrReturn,
                    self::getBatchData($oldValues,$oldValues,'delete')
                );
            }
        }
        else{
            //print_R($arrConfig['filters']); exit;
        }        
        
        
        return $arrReturn;
        
    }
    
    private function getBatchDataPreservOrder($value,$oldValues,$method=NULL){
        
        $arrReturn = array();
        
        foreach($value ?? array() as $order => $rowValue){
            
            $variables = new Variables($this->get('variables'));
                        
            foreach($variables->get() as $variable){
                
                $keyVariable = array_search($variable->get('id'),array_column($rowValue,'id'));
                if($keyVariable !== FALSE){
                    $variables->set($variable->get('id'),$rowValue[$keyVariable]);    
                }
                
            }
            
            $variables->set('id',
                array(
                    'value'     =>  ($order+1)
                )
            );
                  
            $arrConfig = array(
                'data'      =>  $this->get(),
                'filters'   =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  $variables->get('id')->get('value')
                    ),
                )
            );
            
            $arrConfig['data']['variables'] = array();
            foreach($variables->get() as $variable){
                $arrConfig['data']['variables'][] = $variable->get();    
            }
            
            $query = new Query($arrConfig);
            $queryData = $query->getQueryUpdateData(true);
            
            $queryData['rule'] = $method ? $method : (($oldValues[$order] ?? FALSE) ? 'update' : 'insert');
                
            $arrReturn[] = $queryData;
        }
        
        return $arrReturn;
    }
    
}

?>