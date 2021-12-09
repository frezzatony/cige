<?php

/**
 * @author Tony Frezza
  */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Entidades_model extends CI_Model
{

    private $cacheTree = array();

    function __construct()
    {

        parent::__construct();

    }

    public function getEntities($arrProp = array()){

        $arrData = array();
        $arrData['from'] = 'entidade.entidades TEntidade';
        $arrData['where'] = array();
        

        if(isset($arrProp['entities_id'])){
            $arrData['where_in'][] = array('column' => 'id', 'value' => $arrProp['entities_id']);
        }


        if (isset($arrProp['where'])){
            $arrData['where'] = array_merge($arrData['where'], $arrProp['where']);
        }
        
        if (isset($arrProp['data']))
        {
            $arrData = array_merge($arrData, $arrProp['data']);
        }
        
        $arrData['limit'] = (isset($arrProp['limit']) ? $arrProp['limit'] : null);
        

        $arrDataReturn = $this->database->getExecuteSelectQueryData($arrData);
        
        if(array_key_exists('build_tree',$arrProp) AND $arrProp['build_tree']){
            $arrDataReturn = $this->arrays->buildTree($arrDataReturn,FALSE,array(
                'child_parent'  =>  'entidade_entidades_id'  
            ));                
        }
        
        return $this->json->getFullArray($arrDataReturn);
    }
   
    public function getEntityTreeParent($arrProp = array()){

        if (isset($this->cacheTree[$arrProp['pk_value']])){
            return $this->cacheTree[$arrProp['pk_value']];
        }
        
        $arrProp['pk_value'] = $arrProp['pk_value'] ? $arrProp['pk_value'] : 1; //PRIMEIRA ENTIDADE 
        $arrDataReturn = array();

        $arrDataReturn = $this->database->getTreeParents(array(
            'select' => array(
                'id',
                'descricao',
                'abreviatura'
            ),
            'table'         =>  'entidade.entidades',
            'pk_column'     =>  'id',
            'pk_value'      =>  $arrProp['pk_value'],
            'column_parent' =>  'entidade_entidades_id',
        ));

        $this->cacheTree[$arrProp['pk_value']] = $arrDataReturn;

        return $this->json->getFullArray($arrDataReturn);
    }
    
    public function getUserEntities($arrProp = array()){
        
        $user = new Users();
        $user->setItem($arrProp['user_id']);
        $arrUserGroups = $user->getUserGroups();
        
        //nao está em nenhum grupo
        if(!$arrUserGroups){
            return NULL;
        }
        
        $strGroupIn = implode(',',array_column($arrUserGroups,'id'));
        
        $arrData = array(
            'distinct'  =>  TRUE,
            'select'    =>  array(
                'TEntidade.*'
            ),
            'join'      =>  array(
                array(
                    'table' =>  'sistema.controllers_permissoes_acoes TControllersPermAcoes',
                    'on'    =>  'TControllersPermAcoes.entidade_entidades_id = TEntidade.id AND TControllersPermAcoes.usuarios_grupos_id IN('.$strGroupIn.')',
                    'type'  =>  'left'
                    
                ),   
            ),
            'where'     =>  array(
                array(
                    'column'    =>  'TControllersPermAcoes.sistema_controllers_acoes_id IS NOT NULL'
                ),
            ),
        );   
          
 
        $arrData = self::getEntities(
            array(
                'data'          =>  $arrData,
                'build_tree'    =>  $arrProp['build_tree'] ?? FALSE,
            )
        );
        
        if(!$arrData){
            $arrData = self::getEntities(
                array(
                    'entities_id'   =>  1,
                    'build_tree'    =>  $arrProp['build_tree'] ?? FALSE,
                )
            );
            
        }
        //echo $this->db->last_query(); exit;
        return $arrData;   
             
    }
    
    
    public function updateUserEntity($arrProp = array()){
        
        $this->data->set('user.configs.entity',$arrProp['entity_id']);
        
        return $this->users->update(
            array(
                'id'    =>  $arrProp['user_id'],
                'data'  =>  array(
                    'configs'   =>  array(
                        'entity'    =>  $arrProp['entity_id']
                    )
                ),
            )
        );        
       
        
    }
    /**
     * PRIVATES & PROTECTEDS
     */


}
