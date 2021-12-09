<?php

/**
 * @author Tony Frezza

 * @classe Logger
 * @descricao Classe para Logs
 */

if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Logger_model extends CI_Model{
 
    function __construct(){
        
        parent::__construct();
        
    }
    

    public function getLogItemData($arrProp = array()){
        
        $arrDataReturn = array();
        
        //nao existe a tabela de log
        if(!$this->getTableLogExistis($arrProp)){
           return array(
                'total'     =>  0,
                'filtered'  =>  0,
                'items'     =>  array(), 
            );     
        } 
        
        $arrDataSelect['query'] = '
            WITH temp_log AS(
            	SELECT log, jsonb_array_elements(log) arr_log
            	FROM '.($arrProp['schema_log'] ?? $arrProp['schema']).'.'.$arrProp['table_log'].' 
            	WHERE item_id = '.$arrProp['item_id'].'
            )
            
            
            SELECT log, CONCAT(\'{\',STRING_AGG(DISTINCT CONCAT(\'"\',TUsers.id,\'":\',\'"\',TUsers.first_name,\'"\'),\',\'),\'}\') as users
            FROM temp_log
            JOIN '.$this->config->item('tables','ion_auth')['users'].' TUsers ON TUsers.id::CHARACTER VARYING = temp_log.arr_log->>\'user_id\'
            GROUP BY log
        ';

        $arrDataLog = $this->database->getExecuteSelectQueryData($arrDataSelect);
        
        
        //nao existe a tabela de log
        if(!$arrDataLog){
           return array(
                'total'     =>  0,
                'filtered'  =>  0,
                'items'     =>  array(), 
            );     
        } 
        
        
        $arrDataLog = $this->json->getFullArray($arrDataLog[0],true);
       
        return array(
            'total'     =>  (is_array($arrDataLog['log']) ? sizeof($arrDataLog['log']) : 0),
            'items'     =>  $arrDataLog['log'],
            'users'     =>  $arrDataLog['users'], 
        ); 
        
    }
    public function setLog($arrProp = array()){
        
        //nao existe o schema de log, será criado
        //nao existe a tabela de log, será crida
        if(!$this->getSchemaLogExists($arrProp)){
            $this->createLogSchema($arrProp);
        } 
        
        //nao existe a tabela de log, será crida
        if(!$this->getTableLogExistis($arrProp)){
            $this->createLogTable($arrProp);
        }    
        
        $arrDataLog = array();
        $arrDataLog['timestamp'] = time();
        
        if($arrProp['action']??NULL){
            $arrDataLog['action'] = $arrProp['action'];
        }
        
        if($arrProp['user_id']??NULL){
            $arrDataLog['user_id'] = $arrProp['user_id'];
        }
        

        if($arrProp['data']??NULL){
            foreach($arrProp['data'] as $keyData => &$data){
                
                $data = $this->json->getFullArray($data,true);
                $arrDataLog[$keyData] = $data;    
            }    
        }
        
         
        
        $jsonLog = json_encode($arrDataLog,JSON_HEX_QUOT|JSON_HEX_APOS|256);
        //UPSERT
        $query = '
        
            WITH new_values (n_pk, n_log, n_last_update) as (
              values 
                 (
                    '.$arrProp['item_id'].',
                    \'['.$jsonLog.']\'::jsonb,
                    NOW()
              )
            
            ),
            upsert as
            ( 
                UPDATE '.($arrProp['schema_log'] ?? $arrProp['schema']).'.'.$arrProp['table_log'].' m 
                    set 
                    '.($arrProp['column_pk']??'item_id').' = '.$arrProp['item_id'].',
                    log = log || \'['.$jsonLog.']\'::jsonb,
                    last_update = NOW()
                FROM new_values nv
                WHERE m.'.($arrProp['column_pk']??'item_id').' = nv.n_pk
                RETURNING m.*
            )
        
            
            INSERT INTO '.($arrProp['schema_log'] ?? $arrProp['schema']).'.'.$arrProp['table_log'].' ('.($arrProp['column_pk']??'item_id').', log, last_update)
            SELECT n_pk, n_log,n_last_update
            FROM new_values
            WHERE NOT EXISTS (SELECT 1 
                              FROM upsert up 
                              WHERE up.'.($arrProp['column_pk']??'item_id').' = new_values.n_pk)

        
        ';
        
        
        
        $this->database->getExecuteQuery($query);
       
        return $this->db->last_query();       
        
    }
    
    public function getSchemaLogExists($arrProp = array()){
        
        $schemaName = '';
        
        $arrData['query'] = '
            SELECT EXISTS(
            	SELECT schema_name FROM information_schema.schemata WHERE schema_name = \''.($arrProp['schema_log'] ?? $arrProp['schema']).'\'
            )
        
        ';
        
        $arrData = $this->database->getExecuteSelectQueryData($arrData);
        $arrData =$arrData[0];
        
        return $arrData['exists']=='t';
        
    }  
    public function getTableLogExistis($arrProp = array()){
        
        $arrData = array();
        $arrData['query'] = '
            SELECT EXISTS (
               SELECT 1
               FROM   information_schema.tables 
               WHERE  table_schema = \''.($arrProp['schema_log'] ?? $arrProp['schema']).'\'
               AND    table_name = \''.$arrProp['table_log'].'\'
               );
        ';
        $arrData = $this->database->getExecuteSelectQueryData($arrData);
        $arrData =$arrData[0];
        
        return $arrData['exists']=='t';
    }
    
    public function createLogSchema($arrProp = array()){
        
        $query = 'CREATE SCHEMA '.($arrProp['schema_log'] ?? $arrProp['schema']).' AUTHORIZATION postgres';
        
        return $this->db->query($query);
    }
    
    public function createLogTable($arrProp = array()){
        
        
        
        $query = '
            CREATE TABLE '.($arrProp['schema_log'] ?? $arrProp['schema']).'.'.$arrProp['table_log'].'
            (
              id serial NOT NULL,
              item_id integer NOT NULL,
              last_update timestamp,
              log jsonb,
              CONSTRAINT pk_log_'.$arrProp['table_log'].'_id PRIMARY KEY (id, item_id)
            )
            WITH (
              OIDS=FALSE
            );
            ALTER TABLE '.($arrProp['schema_log'] ?? $arrProp['schema']).'.'.$arrProp['table_log'].'
              OWNER TO postgres;
              
            ALTER TABLE '.($arrProp['schema_log'] ?? $arrProp['schema']).'.'.$arrProp['table_log'].'
            ADD CONSTRAINT '.$arrProp['table_log'].'_fk_'.$arrProp['table_log'].' 
            FOREIGN KEY (item_id) 
            REFERENCES '.$arrProp['schema'].'.'.$arrProp['table'].'(id) ON UPDATE CASCADE;
    
        ';
        
        return $this->db->query($query);
        
    }   
    
}
?>