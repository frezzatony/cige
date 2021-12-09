<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Controllers_model extends CI_Model{
    
    private $cachePermissions = array();
    
    
    function __construct(){
        
        parent::__construct();
        
    }
    
    public function getControllerActionsByUser($arrProp = array()){
        
        if(
            !($arrProp['pk_controller']??NULL)
        ){
          return NULL;  
        }
        
        if($arrProp['entity_id'] ?? NULL){
            $strWhereEntity = 'AND TActionPermissions.entidade_entidades_id ='.$arrProp['entity_id'];
        }

        $query = '
            
            WITH RECURSIVE
	           
                controllers AS(
					SELECT *
					FROM sistema.controllers c
					WHERE c.id::int = \''.$arrProp['pk_controller'].'\'::int --{CONTROLLER}
				),
                
            	actionsFamily AS(
            		SELECT TActions.id, NULL AS id_parent
            		FROM sistema.controllers_acoes TActions
            		JOIN controllers ON controllers.id = TActions.sistema_controllers_id
            		UNION
            		SELECT TActionsFilhas.sistema_controllers_acoes_id_filha AS id, TActionsFilhas.sistema_controllers_acoes_id
            		FROM sistema.controllers_acoes_filhas TActionsFilhas
            		JOIN sistema.controllers_acoes TActions ON TActions.id = TActionsFilhas.sistema_controllers_acoes_id_filha
            		JOIN controllers ON controllers.id = TActions.sistema_controllers_id
            		ORDER BY id ASC
            	),
                userAdminGroups AS (
                	SELECT (CASE WHEN count(TGrupos.id) > 0 THEN \'t\' ELSE \'f\' END) AS is_admin
    				FROM usuarios.usuarios
    				JOIN usuarios.usuarios_grupos ON usuarios_grupos.usuarios_usuarios_id = usuarios.id
    				JOIN usuarios.grupos TGrupos ON TGrupos.id = usuarios_grupos.usuarios_grupos_id
    				WHERE usuarios.id::int = \''.$arrProp['user_id'].'\'::int --{USUARIO} 
    				AND TGrupos.administrador = \'t\'
                ),
            	actionsTree AS(
            		SELECT actionsFamily.*,
            		1 AS LVL, userAdminGroups.is_admin,
            		ARRAY [actionsFamily.id] AS ancestry
            		FROM actionsFamily
            		JOIN sistema.controllers_permissoes_acoes TActionPermissions ON 
                        TActionPermissions.sistema_controllers_acoes_id = actionsFamily.id
                        OR
                        TActionPermissions.sistema_controllers_acoes_id = actionsFamily.id_parent
                    LEFT JOIN userAdminGroups ON userAdminGroups.is_admin = \'t\'
            		WHERE 
                    
                		(
                			TActionPermissions.usuarios_grupos_id IN (
                				SELECT grupos.id
                				FROM usuarios.usuarios
                				JOIN usuarios.usuarios_grupos ON usuarios_grupos.usuarios_usuarios_id = usuarios.id
                				JOIN usuarios.grupos ON grupos.id = usuarios_grupos.usuarios_grupos_id
                				WHERE usuarios.id::int = \''.$arrProp['user_id'].'\'::int) --{USUARIO} 
                		)
                    
                    OR
                		(
                			is_admin = \'t\'
                		)
                    
                    
                    '.$strWhereEntity.'
            		UNION 
            		SELECT actionsFamily.*,
            		LVL+1, NULL AS is_admin,
            		array_append(actionsTree.ancestry, actionsFamily.id) AS ancestry
            		FROM actionsFamily
            		JOIN actionsTree ON actionsTree.id = actionsFamily.id_parent
            	)
            	
            	SELECT DISTINCT id
            	FROM actionsTree
        
        ';
        
        $arrData = $this->database->getExecuteSelectQuery($query);
        
        return $arrData;
        
    }
    public function getControllerPermissionsByUser($arrProp = array()){
        
        $arrProp['schema'] = 'sistema';
        
        $strWhereEntity = '';
        
        if($arrProp['entity_id'] ?? NULL){
            $strWhereEntity = 'AND TActionPermissions.entidade_entidades_id ='.$arrProp['entity_id'];
        }
        
        $query = '
                
        
            WITH RECURSIVE
	           
                controllers AS(
					SELECT *
					FROM sistema.controllers c
					WHERE c.id = '.$arrProp['controller_id'].' --{CONTROLLER}
				),
                
            	actionsFamily AS(
            		SELECT TActions.id, NULL AS id_parent
            		FROM sistema.controllers_acoes TActions
            		JOIN controllers ON controllers.id = TActions.sistema_controllers_id
            		UNION
            		SELECT TActionsFilhas.sistema_controllers_acoes_id_filha AS id, TActionsFilhas.sistema_controllers_acoes_id
            		FROM sistema.controllers_acoes_filhas TActionsFilhas
            		JOIN sistema.controllers_acoes TActions ON TActions.id = TActionsFilhas.sistema_controllers_acoes_id_filha
            		JOIN controllers ON controllers.id = TActions.sistema_controllers_id
            		ORDER BY id ASC
            	),
            
            	actionsTree AS(
            		SELECT actionsFamily.*,
            		1 AS LVL,
            		ARRAY [actionsFamily.id] AS ancestry
            		FROM actionsFamily
            		JOIN sistema.controllers_permissoes_acoes TActionPermissions ON 
                        TActionPermissions.sistema_controllers_acoes_id = actionsFamily.id
                        OR
                        TActionPermissions.sistema_controllers_acoes_id = actionsFamily.id_parent
                     
            		WHERE 
                    
            		(
            			TActionPermissions.usuarios_grupos_id IN (
            				SELECT grupos.id
            				FROM usuarios.usuarios
            				JOIN usuarios.usuarios_grupos ON usuarios_grupos.usuarios_usuarios_id = usuarios.id
            				JOIN usuarios.grupos ON grupos.id = usuarios_grupos.usuarios_grupos_id
            				WHERE usuarios.id = '.$arrProp['user_id'].') --{USUARIO} 
            		)
                    
                    '.$strWhereEntity.'
            		UNION 
            		SELECT actionsFamily.*,
            		LVL+1,
            		array_append(actionsTree.ancestry, actionsFamily.id) AS ancestry
            		FROM actionsFamily
            		JOIN actionsTree ON actionsTree.id = actionsFamily.id_parent
            	)
                
           	    SELECT  jsonb_agg(DISTINCT id) AS ids
            FROM actionsTree
        ';
        
        $arrData = $this->database->getExecuteSelectQuery($query);
        
        if($arrData[0]??NULL){
            $arrData = $this->json->getFullArray($arrData[0]);
        }
        
        return $arrData['ids']??array();
        
    }
    
    public function getTiposControllers($arrProp = array()){
        
        $arrDataSelect = array(
            'from'      =>  'sistema.tipos_controllers',
            'order_by'  =>  $arrProp['order_by'] ?? array(
                array(
                    'column'        =>  'descricao',
                    'dir'           =>  'ASC'
                )
            )
        );
        
        $arrData = $this->database->getExecuteSelectQueryData($arrDataSelect);
        return $arrData;
        
    }   
    /**
     * PRIVATES
     **/
    
}