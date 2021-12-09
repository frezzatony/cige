<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__).'/../../cadastros/controllers/Main_cadastros.php';

class Main extends Main_cadastros{    
    
    function __construct(){
        
        parent::__construct();
        
        //verifica se tem elemento informado
        $idItem = trim($this->data->get('post.pk_item'));        
        if(is_integer($idItem) OR (integer)$this->uri->get('id')){
            $idItem = $idItem ? $idItem : (integer) $this->uri->get('id');     
        }
        
        $this->cadastro = new Scheduler(
            array(
                'item'      =>  $idItem,
            )
        );
        
        $this->make_bread->add('Tarefas agendadas', BASE_URL.'scheduler',FALSE);

        parent::initDefaults();
        
    }
    
    protected function editItem($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $htmlBody = new Html;
        
        
        $idPanelActionMenu = $htmlBody->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('card','col-md-24','padding-top-2','padding-bottom-2','margin-top-4','nopadding','cadastro-item-actionmenu'),
            )
        );
        
        $htmlBody->add(
            array(
                'text'      =>  $this->cadastro->getActionMenuController(
                     array(
                        'pk_controller' =>  $this->cadastro->get('id'),
                        'user_id'       =>  $this->data->get('user.id'),
                        'entity_id'     =>  $this->data->get('user.configs.entity'),
                        'menu'          =>  include(dirname(__FILE__).'/../data/actionMenuControllerItem_Scheduler.php'),
                    )
                ),
                'parent_id' =>  $idPanelActionMenu,
            )
        );
        
        
        
        include(dirname(__FILE__).'/../data/tabCadastro.php');
        $htmlBody->add(
            array(
                'children'  =>  $getHtmlDataTabCadastro()
            )
        );
        
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
                
        $buttonsHtmlData = $this->cadastro->getButtonsController(
            array(
                'menu'      =>  include(dirname(__FILE__).'/../data/itemFooterButtons_Scheduler.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        );
        
        parent::editItem(
            array(
                'view_data' =>  array(
                    'title'     =>  'Tarefa agendada',
                    'body'      =>  $htmlBody->getHtml(),
                    'footer'    =>  $htmlFooter->getHtml(),  
                )
            )
        );    
    }
    
    public function afterDelete($arrProp = array()){
        
        foreach($arrProp['response_delete'] as $response){
            $this->cadastro->removeJob($response['pk']);            
        }
        
        return TRUE;
        
    }
    public function afterUpdate(){
        
        $idJob = $this->cadastro->get('item.value');
        
        
        if(!boolValue($this->cadastro->variables->get('ativo.value'))){
            $this->afterDelete(
                array(
                    'response_delete'   =>  array(
                        array(
                            'pk'    =>  $idJob
                        )
                    )
                )
            );
            
            return TRUE;
        }
        
        
        $periodicidade = $this->cadastro->variables->get('periodicidade.value');
        $action = 'php '.BASEPATH.'../index.php scheduler run ';
        
        
        $arrParametros = array(
            'module'    =>  $this->cadastro->variables->get('modulo.value'),
            'action'    =>  $this->cadastro->variables->get('metodo.value'),
        ); 
        
        $action .= '\''.json_encode($arrParametros,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'\'';
        
        $this->cadastro->setJob($periodicidade,$action,$idJob);
        
        return TRUE;
    }
    
    
            
}
