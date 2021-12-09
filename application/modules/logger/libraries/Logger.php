<?php

/**
 * @author Tony Frezza
 * @copyright 2017
 */


class Logger{
    
    private $CI;
    
    function __construct(){
        $this->CI = &get_instance();
        $this->CI->load->dbforge();
    }
    
    public function initDatabaseLog($arrProp = array()){
        
        //nao existe o schema de logs, será criado
        if(!$this->CI->logger_model->getSchemaLogExists($arrProp)){
            $this->CI->logger_model->createLogSchema($arrProp);
        }
        
        //nao existe a tabela de log, será crida
        if(!$this->CI->logger_model->getTableLogExistis($arrProp) AND substr($arrProp['table_log'],0,1)!='_'){
            $this->CI->logger_model->createLogTable($arrProp);
        }  
        
        
    }
    
    public function getLastActivitySelectData($arrProp = array()){
             
        
        $tableLogAs = 'last_activity_'.random_string();
        $arrReturn = array(
            'join'      =>  array(
                array(
                    'table'     =>  $arrProp['data']['schema'].'_logs.'.$arrProp['data']['schema'].'_'.$arrProp['data']['table'].' AS '.$tableLogAs,
                    'on'        =>  $tableLogAs.'.item_id = {table_base_alias}."id"',
                    'type'      =>  'LEFT',
                )    
            ),
            'select'    =>  array(
                array(
                    'column'    =>  'DATE_TRUNC(\'second\',"'.$tableLogAs.'"."last_update")',
                    'as'        =>  'last_activity_value',
                    'escape'    =>  FALSE,
                )
            ),
            'group_by'      =>  array(
                $tableLogAs.'.last_update'
            ),
            'log_table'     =>   $tableLogAs,
            'log_column'    =>   'last_update',   
        );
        
        
        return $arrReturn;
            
    }
    
    public function getLogItemData($arrProp = array()){
        return $this->CI->logger_model->getLogItemData($arrProp);
    }
    
    public static function setLog($arrProp = array()){
        
        $loggerModel = new Logger_model;
        
        return $loggerModel->setLog($arrProp);        
        
    }
    
        
}

?>