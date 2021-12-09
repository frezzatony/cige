<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menus_model extends CI_Model{
 
    function __construct(){
        
        parent::__construct();
        
    }   
        
    public function getMainMenuData($arrProp = array()){
        
        $strWhereActionsTree = '';
        if(
            ($arrProp['user_id']??NULL) OR ($arrProp['entity_id']??NULL)
        ){
            
            if($arrProp['user_id']??NULL){
                $strWhereActionsTree = '
                    (
            			TActionPermissions.usuarios_grupos_id IN (
            				SELECT grupos.id
            				FROM usuarios.usuarios
            				JOIN usuarios.usuarios_grupos ON usuarios_grupos.usuarios_usuarios_id = usuarios.id
            				JOIN usuarios.grupos ON grupos.id = usuarios_grupos.usuarios_grupos_id
            				WHERE usuarios.id = '.$arrProp['user_id'].' ) --{USUARIO}
            		)
                '; 
                   
            }
            
            if($arrProp['entity_id']??NULL){
                
                $strWhereActionsTree = $strWhereActionsTree ? $strWhereActionsTree.' AND ' : '';
                
                $strWhereActionsTree .= '
                    TActionPermissions.entidade_entidades_id = '.$arrProp['entity_id'].' --{ENTIDADE}
                ';    
            }
            
            
            $strWhereActionsTree = $strWhereActionsTree ? 'WHERE '.$strWhereActionsTree : ''; 
        }
        
        if(!($arrProp['all_items']??NULL)){
            $strWhereByUser = '
                WHERE
                    	(
                    		treeMenu.sistema_controllers_acoes_id IS NOT NULL
                    		AND
                    		userActions.family IS NOT NULL
                            AND
                    		treeMenu.admin_node = \'f\'
                    	)
                    	OR
                    	(
                    		treeMenu.sistema_controllers_acoes_id IS NULL
                            AND
                    		treeMenu.admin_node = \'f\'
                    	)
                        OR 
                    	(
                    		is_admin = \'t\'	
                    	)
            ';
        }
        $strWhereModulo = '';
        if(($arrProp['modulo_id']??NULL)){
            $strWhereModulo = 'AND TMenus.sistema_modulos_id = '.$arrProp['modulo_id'].' --{MODULO}';
        }
        
        switch($arrProp['order_by']??NULL){
            case 'modulos':{
                $strOrder = 'TModulos.descricao ASC';
                break;
            }
            default:{
                $strOrder = 'menuItems.ordem ASC';
                break;
            }
        }
        $query = '
         
            WITH RECURSIVE 
	
            	treeMenu AS (
            	    SELECT *, 1 as LVL,
            	    ARRAY [TMenus.id] AS ancestry
            		FROM sistema.menus_itens TMenus
            		WHERE TMenus.sistema_menus_id = 1 --{TIPO DE MENU}
            		'.$strWhereModulo.'
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
            		 
            		'.($strWhereActionsTree??NULL).' 
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
                	userActions.family, userAdminGroups.is_admin,
                    TModulos.descricao
                	FROM treeMenu
                	LEFT JOIN userActions ON treeMenu.sistema_controllers_acoes_id = ANY(userActions.family)
                    LEFT JOIN sistema.controllers_acoes TControllersAcoes ON TControllersAcoes.id = sistema_controllers_acoes_id
                    LEFT JOIN sistema.controllers TControllers ON TControllers.id = TControllersAcoes.sistema_controllers_id
                    LEFT JOIN userAdminGroups ON userAdminGroups.is_admin = \'t\'
                    JOIN sistema.modulos TModulos ON TModulos.id = treeMenu.sistema_modulos_id
                	'.($strWhereByUser??NULL).'
                    
                )
                
                SELECT DISTINCT menuItems.*, tc.descricao AS tipo_controller
            	FROM menuItems
            	LEFT JOIN sistema.tipos_controllers tc ON tc.id = menuItems.sistema_tipos_controllers_id
                ORDER BY '.$strOrder.'
            	
        ';
        
        $arrMenu = $this->database->getExecuteQuery($query);
        
        $arrMenu = $this->json->getFullArray($arrMenu);
        //$arrMenu = $this->filterNodes($arrMenu);
        $arrMenu = $this->common->getBuildTree($arrMenu);
        //print_R($arrMenu); exit;
        return $arrMenu;
        
    }
    
    public function getTreeMainMenuData($arrProp = array()){
        
        $query = '
             
             WITH RECURSIVE 
	
            	treeMenu AS (
            	    SELECT *, 1 as LVL,
            	    ARRAY [id] AS ancestry
            		FROM sistema.menus_itens TMenus
            		WHERE TMenus.sistema_menus_id = 1 --{TIPO DE MENU}
            		AND TMenus.sistema_modulos_id = '.$arrProp['modulo_id'].' --{MODULO}
            		UNION ALL
            		SELECT TMenus.*, treeMenu.LVL+1,
            		array_append(treeMenu.ancestry, TMenus.id) AS ancestry
            		FROM sistema.menus_itens TMenus
            		JOIN treeMenu ON treeMenu.id=TMenus.id_item_pai   
            	)
            	
            SELECT DISTINCT id, id_item_pai, ordem, atributos, sistema_tipos_controllers_id, 
            sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id,
            admin_node,can_edit,can_delete
            FROM treeMenu
            ORDER BY ordem
            
        
        ';
        
        $arrMenu = $this->database->getExecuteQuery($query);
        $arrMenu = $this->json->getFullArray($arrMenu,TRUE);
        $arrMenu = $this->common->getBuildTree($arrMenu);
        //print_R($arrMenu); exit;
        return $arrMenu;
    }

    private function filterNodes($arrMenu){
        $nodesIds = array();
        foreach($arrMenu as $keyNode => &$node){
            if(!$node['permissao']){
                continue;
            }
            
            if(in_array($node['id'],$nodesIds)){
               unset($arrMenu[$keyNode]);
               continue; 
            }
                        
            $permKey =array_search($node['permissao'],array_column($this->session->userdata('permissions'),'id'));
            
            if($permKey===FALSE OR array_key_exists($permKey,$this->session->userdata('permissions'))===FALSE){
                unset($arrMenu[$keyNode]);
                continue;
            }
            
            $permNode =$this->session->userdata('permissions')[$permKey];
            
            if(in_array($node['permissao'],$permNode['children']) == FALSE){
                unset($arrMenu[$keyNode]);
                continue;  
            }
            
            $nodesIds[] = $node['id'];
                  
        }
        return $arrMenu;   
    }
    
}
?>