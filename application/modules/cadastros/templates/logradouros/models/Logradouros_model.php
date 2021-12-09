<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logradouros_model extends CI_Model{
         
    public function __construct(Cadastros $cadastro) {
        parent::__construct();
        
        $this->cadastro = $cadastro;
    }
    
    public function getCidadesData($arrProp = array()){
        
        
        $arrFilters = $this->getFilterSearchCidade($arrProp);
        
        $sqlLimit = 'LIMIT 10';
        if($arrProp['limit']??NULL){
            $sqlLimit = 'LIMIT '.$arrProp['limit']['length'];
            $sqlLimit .= ' OFFSET '.$arrProp['limit']['start'];
        }
        
        $sqlOrderBy = 'ORDER BY '.$arrFilters['table_as'].'.nome ASC';
        if(($arrProp['order']['column']??NULL) != NULL){
           
            $sqlOrderBy = 'ORDER BY ';
           
            $arrColumns = array(
                $arrFilters['table_as'].'.id',
                $arrFilters['table_as'].'.nome',
                'TEstados.nome',
            );
            
            $sqlOrderBy .= $arrColumns[$arrProp['order']['column']];
            $sqlOrderBy .= ' '.($arrProp['order']['dir']??NULL);
        }
        
        if($arrFilters['where']??NULL){
            $sqlWhere = 'WHERE ' . $arrFilters['where'];
        }
        
        $this->cadastro->set('parent',NULL);
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            //exclui Sao Bento do Sul
            $sqlWhere.= ' AND '.$arrFilters['table_as'].'.id <> 4593';  
        }
        
        
        
        $query = '
            SELECT DISTINCT count(*) OVER() AS full_count,'.$arrFilters['table_as'].'.id, 
            '.$arrFilters['table_as'].'.nome as cidade, TEstados.nome as estado
            FROM cadastros.cidades '.$arrFilters['table_as'].'
            JOIN cadastros.estados TEstados ON TEstados.id = '.$arrFilters['table_as'].'.cadastros_estados_id
            '.($sqlWhere??NULL).' 
            '.($sqlOrderBy).'
            '.($sqlLimit??NULL).'
        ';
        
        
        
        $arrData = $this->database->getExecuteQuery($query);
        
        return $arrData;
    }
    
    /**
     * PRIVATES
     **/
     
     
    private function getFilterSearchCidade($arrProp = array()){
        
        $cadastroCidades = new Cadastros(
            array(
                'requests_id'   =>  array(16)
            )
        );
        $dataItemsCidades = new DataItems($cadastroCidades->get());
        $dataItemsCidades->set('filters',($arrProp['filters']??array()));
        $dataItemsCidades->set('limit',10);
        $dataItemsCidades->set('group_by_id',TRUE);
        
        $arrDataSelect = $dataItemsCidades->getDataSelect();
        
        
        $arrReturn = array();
        
        $arrReturn['table_as'] = '"'.$arrDataSelect['from']['as'].'"';
        
        $arrReturn['where'] = '';
        
        foreach($arrDataSelect['where']??array() as $where){
            $arrReturn['where'] .= $arrReturn['where'] ? ' AND ' : '';
            $arrReturn['where'].=  $where['column'];
        }
        
        
        return $arrReturn;
    }
}

?>