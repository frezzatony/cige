<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/Dataitems/'.'Query.php');

class DataItems extends Data{
        
    function __construct($arrProp = array()){
        
        parent::__construct($arrProp);
            
    }
    
    public function delete(){
        
        $arrErrors = array();
        
        $arrDataDeleteQuery = $this->getDataDelete();
        $query = $this->CI->database->getCompiledDeleteQuery($arrDataDeleteQuery);
        
        $db_debug = $this->CI->db->db_debug;
        $this->CI->db->db_debug = FALSE;
         
        $this->CI->db->trans_start();        
        $errorReporting = error_reporting();
        error_reporting(0);
        $execute = $this->CI->database->getExecuteQuery($query,TRUE);
        error_reporting($errorReporting);
        
        $this->CI->db->trans_complete();
        $this->CI->db->db_debug = $db_debug;
        
        if ($this->CI->db->trans_status() === FALSE OR !$execute){
            $this->CI->db->trans_rollback();
            
            return array(
                'status'    =>  FALSE,
                'error'     =>  $this->CI->db->error()
            );
            
        } 
        else{
            $this->CI->db->trans_commit();
        }
        
        return array(
            'status'    =>  TRUE,
            'error'     =>  NULL
        );
    }
    
    public function getDataDelete(){
        
        $query = new Query($this->get());
        return $query->getQueryDeleteData();  
        
    }
    
    public function getDataSelect(){
        
        $query = new Query($this->get());
        
        $arrReturn = $query->getQuerySelectData();
        
        return $arrReturn;
        
    }
    
    public function getCountTotalItems(){
        
        $arrDataQuerySelect = $this->getDataSelect();
        $arrDataQuerySelect['limit'] = NULL;
        $arrDataQuerySelect['order_by'] = NULL;
        $arrTempData = $arrDataQuerySelect;
        unset($arrTempData['with']);
        
        $arrDataQuerySelect['with'] = $arrDataQuerySelect['with'] ?? array();
        $arrDataQuerySelect['with'][] = array(
            'alias'     =>  '__temp',
            'query'     =>  $this->CI->database->getCompiledSelectQuery($arrTempData)
        );
        
        
        $arrCountData = array(
            'select'        =>  array(
                'COUNT(1) as count'
            ),
            'from'          =>  '__temp',
            'with'          =>  $arrDataQuerySelect['with']
        );
        
        $arrData = $this->CI->database->getExecuteSelectQueryData($arrCountData)[0]['count'];
        //$this->CI->db->insert('public.temp',array('valor'=>$this->CI->db->last_query()));         
        return $arrData;
        
    }
    
    public function getItems(){
        
        $arrDataQuerySelect = $this->getDataSelect();
        $arrDataQuerySelect['select'][] = array(
            'column'    =>  'count(*) OVER()',
            'as'        =>  '{data_items_full_count}',
        );
        
        
        return $this->CI->database->getExecuteSelectQueryData($arrDataQuerySelect);
        
    }
    
    public function updateItem(){
            
        $arrData = $this->get('data');    
        
        $arrDataQuery = array(
            'pk_column'     =>  $this->get('pk_column'),
            'pk_value'      =>  $this->get('pk_value'), 
            'data'          =>  $arrData,
            'filters'       =>  $this->get('filters'), 
        );
        
        $arrDataUpdate = $this->executeUpdate($arrDataQuery);
        
        if($arrDataUpdate === FALSE){
            return FALSE;
        }
                
        return $arrDataUpdate[0][$this->get('pk_column')];         
    }
    
    
    /**
     * PRIVATES
     **/
    
    private function executeUpdate($arrProp = array()){
        
        $query = new Query($arrProp);
        $dataQueryUpdate = $query->getQueryUpdateData();  
        $this->CI->db->from($dataQueryUpdate['table']); 
             
        foreach($dataQueryUpdate['set'] as $set){
            
            $this->CI->db->set($set['column'],$set['value'],($set['escape'] ?? FALSE));
        }
        foreach($dataQueryUpdate['where'] as $where){
            $this->CI->db->where($where['column']);
        }
        
        
        $this->CI->db->trans_start();
        $method = 'update';
        if($arrProp['pk_value']){
            $sql = $this->CI->db->get_compiled_update();
            $arrDataUpdate = array(
                array(
                    $arrProp['pk_column']  => $arrProp['pk_value'],
                )
            );
            
            $this->CI->database->getExecuteSelectQuery($sql);
            
        }
        else{
            $method = 'insert';
            $sql = $this->CI->db->get_compiled_insert();
            $sql .= ' RETURNING ' . $arrProp['pk_column'];
            
            $arrDataUpdate = $this->CI->database->getExecuteQuery($sql);
        } 
        
        
        if($dataQueryUpdate['batch'] ?? NULL){
            $this->executeBatchUpdate($arrProp,$dataQueryUpdate,$arrDataUpdate,$method);
        }
        
        $this->CI->db->trans_complete();
        
        if ($this->CI->db->trans_status() === FALSE){
            $this->CI->db->trans_rollback();
            return FALSE;
        } 
        else{
            $this->CI->db->trans_commit();
        }
        
        return $arrDataUpdate; 
        
    }
    
    private function executeBatchUpdate($arrProp,$dataQueryUpdate,$arrDataUpdate,$method){
        
        foreach($dataQueryUpdate['batch'] as $rowBatch){
            foreach($rowBatch['data'] as $queryData){
                $queryData['where'] = $queryData['where'] ?? array();
                
                $queryData['where'][] = array(
                    'column'    =>  $queryData['table'].'.'.$rowBatch['pk_column'],
                    'value'     =>  $arrDataUpdate[0][$arrProp['pk_column']]
                );
                
                $this->CI->db->flush_cache();
                $this->CI->db->reset_query();                
                $this->CI->db->from($queryData['table']); 
                
                foreach($queryData['set'] as $set){
                    
                    $this->CI->db->set($set['column'],$set['value'],($set['escape'] ?? FALSE));
                }
                foreach($queryData['where'] as $where){
                    $this->CI->db->where($where['column'],$where['value'] ?? NULL);
                }
                
                
                switch($queryData['rule']){
                    case 'update':{
                        
                        $this->CI->db->set(
                            $rowBatch['pk_column'],
                            $arrDataUpdate[0][$arrProp['pk_column']]
                        );
                        
                        $sql = $this->CI->db->get_compiled_update();
                        break;
                    }
                    case 'delete':{
                        $sql = $this->CI->db->get_compiled_delete();
                        break;
                    }
                    default:{
                        $this->CI->db->set(
                            $rowBatch['pk_column'],
                            $arrDataUpdate[0][$arrProp['pk_column']]
                        );
                        $sql = $this->CI->db->get_compiled_insert();
                        break;
                    }
                }
                
                //$this->CI->db->insert('temp',array('valor'=>$sql));
                $this->CI->database->getExecuteSelectQuery($sql);
            }   
        }
    }
    
}



?>