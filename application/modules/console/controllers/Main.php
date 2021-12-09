<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
    private $arrTemplate;
    
    function __construct(){
        
        parent::__construct();
        $this->arrTemplate = $this->common->getTemplate();
                
    }
    
    function change_user_entity(){
        $this->auth_model->login();
        
        $arrEntites = $this->entities_model->getEntities(
            array(
            'build_tree'    =>  TRUE
            )
        );
        
        $arrUserEntities = $this->permissions_model->getUserEntities(
            array(
                'user_id'   =>  $this->data->get('user.id')
            )
        );
            
        $html = new Html;
        
        $idTree = $html->add(
            array(
                'tag'       =>  'div',
                'id'        =>  'entities_tree',
                'class'     =>  'fancytree',
                'children'  =>  array($this->getNodesTree(
                    array(
                        'entities'      =>  $arrEntites,
                        'user_entities' =>  $arrUserEntities,
                        'entity_active' =>  $this->data->get('user.configs.entity'),
                    )
                ))
            )
        );
        
        $this->template->set('entitiesTree',$html->getHtml());
        
        
        $this->template->load($this->arrTemplate['template'],'entities','TreeEntities_view');
        
    }
    
    function set_user_entity(){
        
        $this->auth_model->login();
        
        $arrUserEntities = $this->permissions_model->getUserEntities(
            array(
                'user_id'   =>  $this->data->get('user.id')
            )
        );
        
        
        $idEntity = (int) $this->data->get('post.entity');
        
        //nao possui permissao
        if(array_search($idEntity,array_column($arrUserEntities,'id'))===FALSE){
            Common::printJson(
               array(
                    'status'    =>  'error',
                    'message'   =>  'Não há permissões para selecionar esta entidade.',
                )
            
            );
            return;
        }
        
        //nao altera, pois é a mesma
        if((int)$this->data->get('user.configs.entity') == $idEntity){
            Common::printJson(
               array(
                    'status'    =>  'none',
                    'message'   =>  'Esta é a entidade atual e não foi alterada.'  
                )
            );
            return;
        }
        
        
        //altera
        $flag = $this->entities_model->updateUserEntity(
            array(
                'user_id'   => $this->data->get('user.id'), 
                'entity_id' =>  $idEntity,
            ) 
        );
        
        //houve erro de banco
        if(!$flag){
            Common::printJson(
               array(
                    'status'    =>  'error',
                )
            );
            return;    
        }
        
        Common::printJson(
            array(
                'status'    =>  'ok',
            )
        );
        
       
    }
    function index(){       
        
        $this->auth_model->login();
        
        
        
        //$this->template->load($this->arrTemplate['template'],NULL,NULL);
    }
    
    /** PRIVATES **/
    
    private function getNodesTree($arrProp = array()){
     
        $arrReturn = array(
            'tag'       =>  'ul',
            'children'  =>  array()
        );   
        
        foreach($arrProp['entities'] as $entity){
                        
            $arrNode = array(
                'tag'           =>  'li',
                'class'         =>  array(
                    'folder'
                ),
                'text'          =>  $entity['descricao'],
                'data-entity'   =>  $entity['id'],
                'data-active'   =>  FALSE,
            );
            
            if(array_search($entity['id'],array_column($arrProp['user_entities'],'id'))!==FALSE){
                $arrNode['data-active'] = TRUE;
                $arrNode['class'][] =  'can-active';
                $arrNode['text'] .= ' <i class="fa fa-check"></i>'; 
            }
            else{
                $arrNode['text'] .= ' <i class="fa fa-lock"></i>';
            }
            
            
            if(array_key_exists('children',$entity) AND $entity['children']){
                $arrNode['children'][] = self::getNodesTree(
                    array(
                        'entities'      =>  $entity['children'],
                        'user_entities' =>  $arrProp['user_entities'],
                        'entity_active' =>  $arrProp['entity_active'],
                    )
                );
                $arrNode['class'][] = 'folder';
            }
            $arrReturn['children'][] = $arrNode;
            
        }  
        
        
              
        
        
        
        return $arrReturn;
        
    }
    
}
