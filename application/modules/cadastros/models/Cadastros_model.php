<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cadastros_model extends CI_Model{
    
    private $data;
    private $cadastro;
    
    function __construct(){
        parent::__construct();
        
        $this->data = new Data;    
    }
    
     
    public function getItems($arrProp = array()){
        
        $data = $this->cadastro->get('data');
        
        
        if(!($data['table'] ?? NULL)){
            return array();
        }
        
        if(!($data['schema'] ?? NULL)){
            $data['schema'] = 'cadastros';
        }
        
        $arrProp['filters'] = array_merge(($arrProp['filters'] ?? array()),$this->cadastro->get('data.filters') ?? array());
        $arrProp['filters'] = array_merge(($arrProp['filters'] ?? array()),$this->cadastro->get('filters') ?? array());
        
          
        $arrProp['filter_groups'] = array_merge(($arrProp['filter_groups'] ?? array()),$this->cadastro->get('data.filter_groups') ?? array());
                
        $data['variables'] = $this->cadastro->variables->getData();
        
        $arrConfigs = array(
            'data'          =>  $data,
            'filters'       =>  ($arrProp['filters'] ?? NULL),
            'filter_groups' =>  ($arrProp['filter_groups'] ?? NULL),
            'order'         =>  ($arrProp['order'] ??  NULL),
            'limit'         =>  ($arrProp['limit'] ??  NULL),
            'group_by_id'   =>  TRUE,
        );
        
        $arrLastActivityProp = $arrProp;
        $arrLastActivityProp['data'] = $data;
        $arrSelectLastActivityLog = $this->logger->getLastActivitySelectData($arrLastActivityProp);
        
        $arrConfigs = array_merge(
            $arrConfigs,
            $arrSelectLastActivityLog 
        );
        
        
         
        if(($arrConfigs['filters']??NULL)){
            //Filtro para alteracoes    
            $keyFilter = array_search('last_activity',array_column($arrConfigs['filters'],'id'));
            
            if($keyFilter !== FALSE){
                
                $variableDate = new Date_Variables(
                    array(
                        'value'     => ($arrConfigs['filters'][$keyFilter]['value']??NULL),
                        'method'    =>  'database',
                        'table'     =>  $arrSelectLastActivityLog['log_table'],
                        'column'    =>  $arrSelectLastActivityLog['log_column'],
                    )
                );
                
                $className = $arrConfigs['filters'][$keyFilter]['clause'];
                $className = $className.'_Clauses_Postgresql';
                
                $tempPostgreSql = new $className($variableDate->get());    
                
                $strWhereColumn = $tempPostgreSql->getQuerySelectString();
                
                $arrConfigs['where'] = array(
                    array(
                        'column'    =>  $strWhereColumn,
                        'escape'    =>  FALSE,
                    )    
                ); 
                           
            }
            
        }
        
        
        $dataitems = new DataItems($arrConfigs);
        
        if($arrProp['simple_get_items'] ?? NULL){   
            $arrData = $dataitems->getItems();
            return $arrData;
        }
        
        $arrData = $dataitems->getItems();
        $countTotal = $arrData[0]['{data_items_full_count}'] ?? 0;
        
        return array(
            'count'     =>  $countTotal,//$dataitems->getCountTotalItems(),
            'items'     =>  $dataitems->getItems(),  
        );
    }
     
    public function getRequests($arrProp = array()){
        
        $arrDataSelect = array(
            'where'     =>  array(),
            'where_in'  =>  array(),
            'from'      =>  $this->config->item('table_control','cadastros').' TRequest',  
        );
        
        
        if($arrProp['data_select'] ?? NULL){
            $arrDataSelect = array_merge($arrProp['data_select'],$arrDataSelect);
        }
        if($arrProp['requests_id'] ?? NULL){
            $arrDataSelect['where_in'][] = array(
                'column'    =>  'TRequest.id',
                'value'     =>  $arrProp['requests_id'],
            );
        }
        
        if($arrProp['url'] ?? NULL){
            $arrProp['url'] = clearSpecialChars($arrProp['url']);
            $arrDataSelect['where'][] = array(
                'column'    =>  'TRequest.url',
                'value'     =>  $arrProp['url'],
            );
        }
        
        $arrDataReturn = $this->database->getExecuteSelectQueryData($arrDataSelect);
        
        return $this->json->getFullArray($arrDataReturn);
    }
    
    public function getRequestActions($arrProp = array()){
        
        $arrDataSelect = array(
            'where'     =>  array(),
            'where_in'  =>  array(),
            'from'      =>  'sistema.cadastros_acoes TActions',  
        );
        
        if(array_key_exists('requests_id',$arrProp) AND $arrProp['requests_id']){
            $arrDataSelect['where_in'][] = array(
                'column'    =>  'TActions.sistema_cadastros_id',
                'value'     =>  $arrProp['requests_id'],
            );
        }
        
        $arrDataReturn = $this->database->getExecuteSelectQueryData($arrDataSelect);
                
        return $this->json->getFullArray($arrDataReturn);
    }
        
    public function getRequestPermissionsByUser($arrProp = array()){
        
        $query = '
            WITH RECURSIVE getTree as(
                SELECT 
					TCadastros.id as cadastro_id,
					TCadastrosAcoesFilhas.sistema_cadastros_acoes_id,
					TCadastrosAcoesFilhas.sistema_cadastros_acoes_id_filha,
					TCadastrosAcaoFilha.sistema_permissoes_id,
                    TCadastrosPermAcoes.entidade_entidades_id,
					1 as LVL
                FROM sistema.cadastros_acoes_filhas TCadastrosAcoesFilhas
				JOIN sistema.cadastros_acoes TCadastrosAcoes ON TCadastrosAcoes.id = TCadastrosAcoesFilhas.sistema_cadastros_acoes_id
                JOIN sistema.cadastros_acoes TCadastrosAcaoFilha ON TCadastrosAcaoFilha.id = TCadastrosAcoesFilhas.sistema_cadastros_acoes_id_filha
				JOIN sistema.cadastros TCadastros ON TCadastros.id = TCadastrosAcoes.sistema_cadastros_id
                
				JOIN sistema.cadastros_permissoes_acoes TCadastrosPermAcoes ON 
					TCadastrosPermAcoes.sistema_cadastros_acoes_id = TCadastrosAcoes.id 
						OR 
					TCadastrosPermAcoes.sistema_cadastros_acoes_id = TCadastrosAcoesFilhas.sistema_cadastros_acoes_id_filha
				WHERE 
				(
					TCadastrosPermAcoes.usuarios_grupos_id IN (
						SELECT grupos.id
						FROM usuarios.usuarios
						JOIN usuarios.usuarios_grupos ON usuarios_grupos.user_id = usuarios.id
						JOIN usuarios.grupos ON grupos.id = usuarios_grupos.group_id
						WHERE usuarios.id = '.$arrProp['user_id'].') 
				)
                UNION ALL
                SELECT 
				    TCadastros.id as cadastro_id,
					TCadastrosAcoesFilhas.sistema_cadastros_acoes_id,
					TCadastrosAcoesFilhas.sistema_cadastros_acoes_id_filha,
					TCadastrosAcaoFilha.sistema_permissoes_id,
                    TCadastrosPermAcoes.entidade_entidades_id,
					getTree.LVL+1
                FROM sistema.cadastros_acoes_filhas TCadastrosAcoesFilhas
				JOIN sistema.cadastros_acoes TCadastrosAcoes ON TCadastrosAcoes.id = TCadastrosAcoesFilhas.sistema_cadastros_acoes_id
				JOIN sistema.cadastros TCadastros ON TCadastros.id = TCadastrosAcoes.sistema_cadastros_id
                JOIN sistema.cadastros_acoes TCadastrosAcaoFilha ON TCadastrosAcaoFilha.id = TCadastrosAcoesFilhas.sistema_cadastros_acoes_id_filha
				JOIN sistema.cadastros_permissoes_acoes TCadastrosPermAcoes ON 
					TCadastrosPermAcoes.sistema_cadastros_acoes_id = TCadastrosAcoes.id 
						OR 
					TCadastrosPermAcoes.sistema_cadastros_acoes_id = TCadastrosAcoesFilhas.sistema_cadastros_acoes_id_filha
                JOIN getTree ON getTree.sistema_cadastros_acoes_id_filha=TCadastrosAcoesFilhas.sistema_cadastros_acoes_id 
				WHERE 
				(
					TCadastrosPermAcoes.usuarios_grupos_id IN (
						SELECT grupos.id
						FROM usuarios.usuarios
						JOIN usuarios.usuarios_grupos ON usuarios_grupos.user_id = usuarios.id
						JOIN usuarios.grupos ON grupos.id = usuarios_grupos.group_id
						WHERE usuarios.id = '.$arrProp['user_id'].') 
				)
            )
            SELECT 
                DISTINCT sistema_cadastros_acoes_id_filha as acao_id,
                entidade_entidades_id as entidade_id,
                sistema_permissoes_id
			FROM getTree
			WHERE getTree.cadastro_id = '.$arrProp['request']['id'].'
			UNION 
			SELECT 
                DISTINCT TCadastrosAcoes.id,
                TCadastrosPermAcoes.entidade_entidades_id,
                TCadastrosAcoes.sistema_permissoes_id
			FROM sistema.cadastros TCadastros
			JOIN sistema.cadastros_acoes TCadastrosAcoes ON TCadastrosAcoes.sistema_cadastros_id = TCadastros.id
			JOIN sistema.cadastros_permissoes_acoes TCadastrosPermAcoes ON 
				TCadastrosPermAcoes.sistema_cadastros_acoes_id = TCadastrosAcoes.id 
			WHERE TCadastros.id = '.$arrProp['request']['id'].'
			AND
			(
				TCadastrosPermAcoes.usuarios_grupos_id IN (
					SELECT grupos.id
					FROM usuarios.usuarios
					JOIN usuarios.usuarios_grupos ON usuarios_grupos.user_id = usuarios.id
					JOIN usuarios.grupos ON grupos.id = usuarios_grupos.group_id
					WHERE usuarios.id = '.$arrProp['user_id'].') 
			)
			ORDER BY acao_id ASC
        ';
        
        $arrPermissions = $this->database->getExecuteSelectQuery($query);
        //echo $this->db->last_query(); exit;
        //$arrPermissions = $this->json->getFullArray($arrPermissions);
        
        return $arrPermissions;
        
    }
    
    public function setController(Cadastros $cadastro){
        
        $this->cadastro = $cadastro;
    }
        
    /**
     * PRIVATES
     **/
     
        
}