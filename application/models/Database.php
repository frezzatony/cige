<?php

/**
 * @author Tony Frezza

 * @classe Database_model
 * @descricao Model para execuções de bancos de dados
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Database extends CI_Model{
    
    private $loaded;
        
    function __construct(){
                
        parent::__construct();        
    }
    
    public function getCompiledDeleteQuery($arrData = array(),$escape = TRUE){
         
         $this->db->reset_query();
         
          if(is_array($arrData['from'])){
            
            $strFrom = '';
            
            if(isset($arrData['from']['db_schema'])){
                $strFrom = $arrData['from']['db_schema'].'.';
            }
            $strFrom .= $arrData['from']['table'];
            
            if(isset($arrData['from']['as'])){
                $strFrom .= ' "'.$arrData['from']['as'].'"';
            }
        }else{
            $strFrom = $arrData['from'];
        }
        
        $this->db->from($strFrom);
        
        if(isset($arrData['where']) AND $arrData['where']){
            foreach($arrData['where'] as $where){

                $this->db->where(
                    $where['column'],
                    ($where['value'] ??  NULL),
                    ($where['escape'] ?? NULL)
                );
            }
        }
        
         if(isset($arrData['or_where']) AND $arrData['where']){
            foreach($arrData['or_where'] as $orWhere){

                $this->db->or_where(
                    $orWhere['column'],
                    (isset($orWhere['value']) ? $orWhere['value'] : NULL),
                    (isset($orWhere['escape']) ? $orWhere['escape'] : NULL)
                );
            }
        }
        
        if(isset($arrData['where_in']) AND $arrData['where_in']){
            foreach($arrData['where_in'] as $where_in){
                $this->db->where_in(
                    $where_in['column'],
                    $where_in['value']
                );
            }
        }
        if(isset($arrData['like']) AND $arrData['like']){
            foreach($arrData['like'] as $like){
                $this->db->like(
                    $like['column'],
                    $like['value']
                );
            }
        }
        
        $query =  $this->db->get_compiled_delete();
        
        return $query;
            
    }
    
    public function getCompiledUpdateQuery($arrData = array(),$escape = TRUE){
        
         
    }
    
    public function getCompiledSelectQuery($arrData = array(),$escape = TRUE){
        
        $this->db->reset_query();
        if(is_array($arrData['from'])){
            $strFrom = '';
            
            if(isset($arrData['from']['db_schema'])){
                $strFrom = $arrData['from']['db_schema'].'.';
            }
            $strFrom .= $arrData['from']['table'];
            
            if(isset($arrData['from']['as'])){
                $strFrom .= ' "'.$arrData['from']['as'].'"';
            }
        }else{
            $strFrom = $arrData['from'];
        }
        $this->db->from($strFrom);
        
        if(isset($arrData['select']) AND $arrData['select']){
            
            foreach($arrData['select'] as $select){
                if(is_array($select)){
                    $this->db->select($this->getSelectStr($select),$select['escape']??$escape);          
                }
                else{
                    $this->db->select($select,$escape);   
                }             
            }
            
        }
        
        if(isset($arrData['join']) AND $arrData['join']){
            foreach($arrData['join'] as $join){
                $this->db->join(
                    $join['table'],
                    (isset($join['on']) ? $join['on'] : NULL),
                    (isset($join['type']) ? $join['type'] : ''),
                    (isset($join['escape']) ? $join['escape'] : NULL)    
                );
            }
        }
        
        
        if(isset($arrData['groups_where']) AND $arrData['groups_where']){
            foreach($arrData['groups_where'] as $group){
                $this->db->group_start(); 
                foreach($group as $where){
                    
                    if($where['and']??NULL){
                        $this->db->where(
                            $where['column'],
                            (isset($where['value']) ? $where['value'] : NULL),
                            (isset($where['escape']) ? $where['escape'] : NULL)
                        );   
                    }
                    else{
                        $this->db->or_where(
                            $where['column'],
                            (isset($where['value']) ? $where['value'] : NULL),
                            (isset($where['escape']) ? $where['escape'] : NULL)
                        );   
                        
                    }
                    
                }
                $this->db->group_end();
            }
        }
        
        
        if(isset($arrData['where']) AND $arrData['where']){
            foreach($arrData['where'] as $where){

                $this->db->where(
                    $where['column'],
                    (isset($where['value']) ? $where['value'] : NULL),
                    (isset($where['escape']) ? $where['escape'] : NULL)
                );
            }
        }
        
         if(isset($arrData['or_where']) AND $arrData['where']){
            foreach($arrData['or_where'] as $orWhere){

                $this->db->or_where(
                    $orWhere['column'],
                    (isset($orWhere['value']) ? $orWhere['value'] : NULL),
                    (isset($orWhere['escape']) ? $orWhere['escape'] : NULL)
                );
            }
        }
        
        if(isset($arrData['where_in']) AND $arrData['where_in']){
            foreach($arrData['where_in'] as $where_in){
                $this->db->where_in(
                    $where_in['column'],
                    $where_in['value']
                );
            }
        }
        if(isset($arrData['like']) AND $arrData['like']){
            foreach($arrData['like'] as $like){
                $this->db->like(
                    $like['column'],
                    $like['value']
                );
            }
        }
        
        if(isset($arrData['limit']) AND $arrData['limit']){
            
            $length = (isset($arrData['limit']['length']) ?  $arrData['limit']['length'] : $arrData['limit']);
            $start = (isset($arrData['limit']['start']) ?  $arrData['limit']['start'] : 0);
                        
            $this->db->limit(
                $length,
                $start   
            );
        }
        
        if(isset($arrData['group_by'])){
            $this->db->group_by($arrData['group_by']);
        }
        
        if(isset($arrData['order_by'])){
            foreach($arrData['order_by'] as $orderby){
                $orderby['dir'] .= (strtoMINusculo($orderby['dir'])==strtoMINusculo('asc') ? ' NULLS FIRST' : ' NULLS LAST');
                
                $this->db->order_by(
                    $orderby['column'],
                    $orderby['dir'],
                    (isset($orderby['escape']) ? $orderby['escape'] : NULL)
                );
            }
        }
        
        
        if(isset($arrData['distinct']) AND $arrData['distinct']){
            $this->db->distinct();
        }
        $SqlSelect =  $this->db->get_compiled_select();
        
        if(($arrData['with']??NULL)){
            $SqlWith = '';
            foreach($arrData['with'] as $with){
                if($SqlWith){
                    $SqlWith .= ",\n";
                }
                
                $SqlWith .= '"'.str_replace('"','',$with['alias']) . '" AS (';
                $SqlWith .= "\n\t";
                $SqlWith .= str_replace("\n","\n\t",$with['query']);
                $SqlWith .= "\n".')';
            }
            
            
            
            if($arrData['with_recursive']??NULL){
                $SqlWith = 'WITH RECURSIVE ' . "\n".$SqlWith;
            }
            else{
               $SqlWith = 'WITH ' . "\n".$SqlWith; 
            }
            
            $SqlSelect = $SqlWith . "\n" . $SqlSelect;
        } 
        
        if($arrData['remove_slashes']??NULL){
            return str_replace('"','',$SqlSelect);
        }
        return $SqlSelect;   
    }
    public function getExecuteSelectQueryData($arrData = array(),$escape=TRUE,$showErrors = TRUE){
        
        if(array_key_exists('query',$arrData) AND $arrData['query']!=''){
            return $this->getExecuteSelectQuery($arrData['query']);
        }
        
        $SqlSelect = $this->getCompiledSelectQuery($arrData); 
        
        $this->db->trans_start();
        
        $query = $this->db->query($SqlSelect,FALSE,NULL,$showErrors);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            if(method_exists($query,'result_array')){
                return $query->result_array();    
            }
            return true;
               
        }   
    }
    
    public function getSelectStr($arrSelect = array()){
        
        if(!is_array($arrSelect)){
            return $arrSelect;
        }
        
        $strSelect  = '';
        if(array_key_exists('table',$arrSelect) AND $arrSelect['table']){
            $strSelect .= '"'.$arrSelect['table'].'".';
        }
        
        
        if(array_key_exists('table',$arrSelect) AND $arrSelect['table']!==NULL AND (!($arrSelect['escape']??NULL)) ){
            $strSelect .= '"'.$arrSelect['column'].'"';
        }
        else{
            $strSelect = $arrSelect['column'];
        }
        
        if(array_key_exists('as',$arrSelect) AND $arrSelect['as']){
            $strSelect .= ' as "'.$arrSelect['as'].'"';
        }
        
        return $strSelect;
        
    }
    public function getTreeParents($arrProp = array()){
        
        $sqlSelect = '';
        
        foreach($arrProp['select'] as $select){
            if($sqlSelect){
                $sqlSelect .=',';
            }
            
            $sqlSelect .= $select;
        }

        /**
         * POSTGRE
         **/
        $Sql = '
            WITH RECURSIVE getTree as(
                SELECT *, 1 as LVL
                FROM '.$arrProp['table'].'
                WHERE '.$arrProp['pk_column'].'='.$arrProp['pk_value'].'
                UNION ALL
                SELECT '.$arrProp['table'].'.*, getTree.LVL+1
                FROM '.$arrProp['table'].'
                JOIN getTree ON getTree.'.$arrProp['column_parent'].'='.$arrProp['table'].'.'.$arrProp['pk_column'].' 
            )
            SELECT '.$sqlSelect.' 
            FROM getTree
            ORDER BY LVL DESC
            ';
        
        $query = $this->db->query($Sql);
        
        return $query->result_array();
        
        
        
    }
   
   
    public function getExecuteQuery($query,$returnBoolean = FALSE){
        
       
        if(!$returnBoolean){
            
            $execute = $this->db->query($query);
            if(method_exists($execute,'result_array')){
                return $execute->result_array();    
            }
            
            return $execute;  
        }
        
        
        return $this->db->query($query); 
        
        
    }
   
     
    public function getExecuteSelectQuery($query,$showErrors = TRUE){
        
        $execute = $this->db->query($query,FALSE,NULL,$showErrors);
        
        if(method_exists($execute,'result_array')){
            return $execute->result_array();    
        }
        
        return $execute;   
    }
    
    
    /**
     * PRIVATES
     **/
    
    private function loadLibrary($name){
        
        $directory = dirname(__FILE__).'/Database/';
        
        if(file_exists($directory.ucfirst($name).'.php')===TRUE){
            
            require_once($directory.ucfirst($name).'.php');
            $this->loaded[] = $name;
            $className = $name.'_database'; 
           
        }
        else{
               
        }

        $this->{strtolower($name)} = new $className;

    } 
}
