<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relatorios_model extends CI_Model{
    
    private $data;
    
    function __construct(){
        $this->data = new Data;    
    }
    
     
    public function getRequests($arrProp = array()){
        
        $arrDataSelect = array(
            'select'    =>  array(
                'TRequest.id','TRequest.url','TRequest.ativo','TRequest.descricao_plural as descricao',
                'TRequest.atributos','TRequest.controller',
                array(
                    'column'    =>  'TRequest.sistema_tipos_controllers_id',
                    'as'        =>  'tipo_controller_id'
                ),
                array(
                    'column'    =>  'TRequest.sistema_modulos_id',
                    'as'        =>  'modulo_id'
                ),
                array(
                    'column'    =>  'TModulos.uri',
                    'as'        =>  'modulo_uri'
                ),

            ),
            'where'     =>  array(),
            'where_in'  =>  array(),
            'from'      =>  'sistema.controllers TRequest',
            'join'      =>  array(
                array(
                    'type'  =>  'LEFT',
                    'table' =>  'sistema.modulos TModulos',
                    'on'    =>  'TModulos.id = TRequest.sistema_modulos_id'
                )
            )  
        );
        
        
        if($arrProp['data_select'] ?? NULL ){
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
        
        if($arrProp['module'] ?? NULL){
            $arrProp['module'] = clearSpecialChars($arrProp['module']);
            $arrDataSelect['where'][] = array(
                'column'    =>  'TModulos.uri',
                'value'     =>  $arrProp['module'],
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
    
        
    /**
     * PRIVATES
     **/
     
        
}