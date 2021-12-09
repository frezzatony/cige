<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modulos_model extends CI_Model{
    
    private $cachePermissions = array();
    
    
    function __construct(){
        
        parent::__construct();
        
    }
    
    public function getModulos($arrProp = array()){
        
        $arrDataSelect = array(
            'from'      =>  'sistema.modulos',
            'where'     =>  $arrProp['where'] ?? NULL,
            'where_in'  =>  array(),
            'limit'     =>  $arrProp['limit'] ?? NULL,
            'order'     =>  $arrProp['order'] ?? array(
                array(
                    'column'    =>  'descricao',
                    'dir'       =>  'ASC'
                )
            )
        );
        
        if(isset($arrProp['modulos_id'])){
            $arrDataSelect['where_in'][] = array('column' => 'id', 'value' => $arrProp['modulos_id']);
        }
        
        return $this->database->getExecuteSelectQueryData($arrDataSelect);
        
    }
    
    public function getUserModulesByMainMenu($arrProp = array()){
        
                
        $query = '
            
            WITH RECURSIVE 
	
            	treeMenu AS (
            	    SELECT *, 1 as LVL,
            	    ARRAY [TMenus.id] AS ancestry
            		FROM sistema.menus_itens TMenus
            		WHERE TMenus.sistema_menus_id = 1 --{TIPO DE MENU}
            		UNION ALL
            		SELECT TMenus.*, treeMenu.LVL+1,
            		array_append(treeMenu.ancestry, TMenus.id) AS ancestry
            		FROM sistema.menus_itens TMenus
            		JOIN treeMenu ON treeMenu.id=TMenus.id_item_pai   
            	),
            	
            	actionsFamily AS(
            		SELECT TActions.id, NULL AS id_parent
            		FROM sistema.controllers_acoes TActions
            		UNION
            		SELECT TActionsFilhas.sistema_controllers_acoes_id_filha AS id, TActionsFilhas.sistema_controllers_acoes_id
            		FROM sistema.controllers_acoes_filhas TActionsFilhas
            		JOIN sistema.controllers_acoes TActions ON TActions.id = TActionsFilhas.sistema_controllers_acoes_id_filha
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
            				WHERE usuarios.id = '.$arrProp['user_id'].' ) --{USUARIO}
            		)
                 AND 
                    TActionPermissions.entidade_entidades_id = '.$arrProp['entity_id'].' --{ENTIDADE}
                 
            		UNION 
            		SELECT actionsFamily.*,
            		LVL+1,
            		array_append(actionsTree.ancestry, actionsFamily.id) AS ancestry
            		FROM actionsFamily
            		JOIN actionsTree ON actionsTree.id = actionsFamily.id_parent
            	),
            	
            	userActions AS (
            		SELECT array_agg(DISTINCT c) AS family
            		FROM (
            		  SELECT unnest(ancestry)
            		  FROM actionsTree
            		) AS dt(c)
                ),
                userAdminGroups AS (
                	SELECT (CASE WHEN count(TGrupos.id) > 0 THEN \'t\' ELSE \'f\' END) AS is_admin
    				FROM usuarios.usuarios
    				JOIN usuarios.usuarios_grupos ON usuarios_grupos.usuarios_usuarios_id = usuarios.id
    				JOIN usuarios.grupos TGrupos ON TGrupos.id = usuarios_grupos.usuarios_grupos_id
    				WHERE usuarios.id = '.$arrProp['user_id'].' --{USUARIO} 
    				AND TGrupos.administrador = \'t\'
                ),
                menuItems AS(
                	SELECT treeMenu.id, treeMenu.id_item_pai, treeMenu.ordem, treeMenu.atributos,
                	treeMenu.sistema_tipos_controllers_id, treeMenu.sistema_controllers_acoes_id,
                	treeMenu.sistema_modulos_id, TControllers.id as controller_id,
                	userActions.family, userAdminGroups.is_admin
                	FROM treeMenu
                	LEFT JOIN userActions ON treeMenu.sistema_controllers_acoes_id = ANY(userActions.family)
                    LEFT JOIN sistema.controllers_acoes TControllersAcoes ON TControllersAcoes.id = sistema_controllers_acoes_id
                    LEFT JOIN sistema.controllers TControllers ON TControllers.id = TControllersAcoes.sistema_controllers_id
                    --LEFT JOIN userAdminGroups ON treeMenu.admin_node = \'t\'
                    LEFT JOIN userAdminGroups ON userAdminGroups.is_admin = \'t\'
                	
                WHERE
                    	(
                    		treeMenu.sistema_controllers_acoes_id IS NOT NULL
                    		AND
                    		userActions.family IS NOT NULL
                            AND
                    		treeMenu.admin_node = \'f\'
                    	)
                    	/*
                        OR
                    	(
                    		treeMenu.sistema_controllers_acoes_id IS NULL
                            AND
                    		treeMenu.admin_node = \'f\'
                    	)
                        */
                        OR 
                    	(
                    		is_admin = \'t\'	
                    	)
            
                    
                ),
                modulos AS (
                	SELECT DISTINCT TModulos.id AS modulo_id, TModulos.descricao AS modulo_descricao
                	FROM menuItems
                	JOIN sistema.modulos TModulos ON TModulos.id = menuItems.sistema_modulos_id
                	WHERE TModulos.id <> 2
                	UNION 
                	SELECT id, descricao
                	FROM sistema.modulos TModulos
                	WHERE TModulos.id = 2

                )
            
            	SELECT *
            	FROM modulos
            	ORDER BY modulo_descricao
        
        ';
                
        $arrData = $this->database->getExecuteSelectQuery($query);
        
        
        return $arrData;      
        
    }
    
    /**
     * PRIVATES
     **/
    
}