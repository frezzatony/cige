<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Main extends CI_Controller{
    
    private $user;
    
    function __construct(){
        
        parent::__construct();
        
        $this->make_bread->add('Usuários',FALSE,FALSE);
        
        //verifica se tem elemento informado
        $idItem = (integer) trim($this->data->get('post.pk_item'));        
        if(is_integer($idItem) OR (integer)$this->uri->get('id')){
            $idItem = $idItem ? $idItem : (integer) $this->uri->get('id');     
        }
        
        $this->user = new Users(
            array(
                'item'      =>  $idItem    
            )
        );
                                   
        //DEFINE DADOS E VALIDAÇÕES PARA UMA AÇÃO INFORMADA QUE PODERÁ SER EXECUTADA
        $arrToken = $this->json->getFullArray($this->encryption->decrypt($this->data->get('post.token')));
        
        if(is_array($arrToken)){
            
            $this->auth_model->login();
            $this->user->validateToken($arrToken);
            
            $this->user->set('token',$arrToken);
            if($arrToken['parent']){
                $arrToken['parent']['variable'] = $arrToken['variable'] ?? NULL;
                $this->user->setParent($arrToken['parent']);
            }
        }
        
        //CLONE DE ITEM
        if($this->data->get('post.clone')){
            $this->user->set('item',NULL);
        }
        
    }
    
    public function index(){ 
        
        $arrTemplate = $this->common->getTemplate();
        
        if($this->uri->getKey('view') !== FALSE){
            if($this->input->get_post('load')=='modal' AND !in_array($arrTemplate['template'],array('modal','ajax'))){
                $this->setJsModal();
            }
            else{
                $this->editItem();
                return;    
            }
            
        }
        else if($this->uri->getKey('getitems')!== FALSE){
            $this->getItemsGrid();
            return;
        }
        else if($this->uri->getKey('save')!== FALSE){
            $this->save();
            return;
        }
        else if($this->uri->getKey('delete')!== FALSE){
            $this->delete();
            return;
        }
               
        $this->listItems(array());
        
        return TRUE;
        
    }
    
    public function delete(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->user->runActionUserPermissions(
            array(
                'action'            =>  $this->user->get('configs.actions.editItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $arrPks = $this->input->post('pk') ?? NULL;
        if(!$arrPks){
            Common::printJson(
                array(
                    'messages'  =>  array(
                        array(
                            'type'      =>  'info',
                            'message'   =>  '<i class="fa fa-info-circle margin-right-10"></i>Não há itens selecionados.'
                        )
                    )
                )
            );
            return false;
        }
        
        
        $arrResponseDelete = $this->user->delete($arrPks);
        
        $arrMessages = array();
        $arrConsole = array();
        
        
        $flagAllDeleted = TRUE;
        $failItensCount = 0;        
        
        foreach($arrResponseDelete as $response){
            
            if(!$response['status']){
                
                $flagAllDeleted = FALSE;
                
                $failItensCount++;
                
                $message = '[Cadastro]['.$this->user->get('descricao_singular').'][Código:'.$response['pk'].']: Não pode ser excluído. ';
                $message .= $this->config->item($response['error']['code'],'db_errors');
                $arrConsole[] = array(
                    'date_time' =>  date('d/m/Y|H:i:s'),
                    'message'   =>  $message
                );
                
            }
            else{
                
                //LOG DE ATIVIDADE DO CADASTRO
                $this->logger->setLog(
                    array(
                        'schema'        =>  $this->user->get('data.schema').'_logs',
                        'table_log'     =>  $this->user->get('data.schema').'_'.$this->user->get('data.table'),
                        'item_id'       =>  $this->user->get('item.value'),
                        'user_id'       =>  $this->data->get('user.id'),
                        'action'        =>  'DELETE',
                    )
                );
                
                
                $arrConsole[] = array(
                    'date_time' =>  date('d/m/Y|H:i:s'),
                    'message'   =>  '[Cadastro]['.$this->user->get('descricao_singular').'][Código:'.$response['pk'].']: Foi excluído.'
                );   
            }
        }
        
        
        if($flagAllDeleted){
            $arrMessages = array(
                array(
                    'type'      =>  'success',
                    'message'   =>  sizeof($arrPks)==1 ? 'Item excluído.' : 'Itens excluídos',
                )
            );   
        }
        else if($failItensCount < sizeof($arrResponseDelete)){
            
            $arrMessages = array(
                array(
                    'type'      =>  'success',
                    'message'   =>  'Executada a exclusão de alguns itens.'
                ),
                array(
                    'type'      =>  'warning',
                    'message'   =>  '<i class="fa fa-exclamation-triangle margin-right-10"></i> Alguns itens não foram excluídos.<br />Consulte o Console para mais detalhes.'
                ),
            );  
        }
        else{
            $arrMessages = array(
                array(
                    'type'      =>  'error',
                    'message'   =>  '<i class="fa fa-exclamation-triangle margin-right-10"></i>A exclusão não foi executada.<br />Consulte o Console para mais detalhes.'
                ),
            );  
        }
        
        
        Common::printJson(
            array(
                'messages'  =>  $arrMessages,
                'console'   =>  $arrConsole
            )    
        );
    }
    
    public function editItem($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->user->runActionUserPermissions(
            array(
                'action'            =>  $this->user->get('configs.actions.viewItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $htmlBody = new Html();
        
        $htmlBody->add($this->user->getHtmlDataDefaultBody());
        
        $idPanelActionMenu = $htmlBody->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('card','col-md-24','padding-top-6','padding-bottom-6','margin-top-4','nopadding','cadastro-item-actionmenu'),
            )
        );
        
        $htmlBody->add(
            array(
                'text'      =>  $this->user->getActionMenuController(
                     array(
                        'pk_controller' =>  $this->user->get('id'),
                        'user_id'       =>  $this->data->get('user.id'),
                        'entity_id'     =>  $this->data->get('user.configs.entity'),
                        'menu'          =>  include(dirname(__FILE__).'/../data/actionMenuControllerItem_usuarios.php'),
                    )
                ),
                'parent_id' =>  $idPanelActionMenu,
            )
        );
        
        include(dirname(__FILE__).'/../data/paneCadastroUsuario.php');
        $paneCadastro = $getPaneCadastro();
        
        $htmlPaneCadastro = new Html;
        $htmlPaneCadastro->add(
            array(
                'children'  =>  $paneCadastro['html_data']
            )
        );
        $htmlPaneCadastro->add(
            array(
                'text'      =>  $this->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneCadastro['javascript']??NULL)),TRUE),
            )  
        );
        
        $arrBootstrapTabs = array(
            'class'     =>  array('cadastro-item-content'),
            'nodes'     =>  array(
                array(
                    'tab'   =>  array(
                        'text'      =>  '<i class="fa fa-th"></i> &nbsp; Item',
                    ),
                    'pane'  =>  array(
                        'text'   =>  $htmlPaneCadastro->getHtml()
                    )  
                ),
            )
        );
        
        //permissão para ver historico de alteracoes
        if($this->user->runActionUserPermissions(
            array(
                'action'            =>  $this->user->get('configs.actions.editItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            
            $arrBootstrapTabs['nodes'][] = array(
                'tab'   =>  array(
                    'text'      =>  '<i class="fa fa fa-list-alt"></i> &nbsp; Histórico de alterações',
                ),
                'pane'  =>  array(
                    'class' =>  array('bg-gray'),
                    'text'   =>  '<small>Em desenvolvimento...</small>'
                )  
            );
            
        }
        
        $bootstrap = new Bootstrap;        
        
        $bootstrap->tabs($arrBootstrapTabs);
        
        $htmlBody->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('container-fluid','nomargin','nopadding'),
                'children'  =>  $bootstrap->getHtmlData()
            )
        );
        
        $htmlBody->add(
                array(
                    'tag'       =>  'script',
                    'type'      =>  'text/javascript',
                    'text'      =>  $this->template->load('blank','cadastros','jsDefaultItem',NULL,TRUE),
                )
            );
        
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
                
        $buttonsHtmlData = $this->user->getButtonsController(
            array(
                'pk_controller' =>  $this->user->get('id'),
                'user_id'       =>  $this->data->get('user.id'),
                'entity_id'     =>  $this->data->get('user.configs.entity'),
                'menu'      =>  include(dirname(__FILE__).'/../data/itemFooterButtons_usuarios.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        );
        
        //JS DE CADASTROS
        $htmlBody->add(
            array(
                'tag'       =>  'script',
                'type'      =>  'text/javascript',
                'text'      =>  $this->template->load('blank','cadastros','jsDefaultItem',NULL,TRUE),
            )
        );
        
        Common::printJson(
            array(
                'title'     =>  'Controller',
                'body'      =>  $htmlBody->getHtml(),
                'footer'    =>  $htmlFooter->getHtml(),
            )
        );
        
    }
    
    public function getItemsGrid(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->user->runActionUserPermissions(
            array(
                'action'            =>  $this->user->get('configs.actions.viewItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
                
        $arrListItemsKeys = array_column($this->user->get('data.list_items.columns'),'id');
        $arrProp = $this->data->get('post');
        
        $arrProp['order'] =  $this->user->getOrderBy();
        
        if($this->data->get('post.order.column')!==''){
            $arrProp['order'] =  $this->user->getOrderBy(
                array(
                    array(
                        'id'        =>  $arrListItemsKeys[$this->data->get('post.order.column')] ?? $this->user->get('data.list_items.columns')[0]['id'],
                        'dir'       =>  in_array($this->data->get('post.order.dir'),array('asc','desc')) ? $this->data->get('post.order.dir') : 'asc',
                    )
                )   
            );    
        }
        
        $arrItems = $this->user->getItems($arrProp);
        $arrData = array();
        
        foreach($arrItems['items'] as $item){
            
            $this->user->setItem($item);
            
            $arrRow = array(
                'href'      =>  1,
            );
            
            foreach($arrListItemsKeys as $listKey){
                
                $columnValue = $this->user->variables->get($listKey)->get('text');
                $columnValue = $columnValue ? $columnValue : $this->user->variables->get($listKey)->get('value');
                
                $arrRow[]= $columnValue;
            }  
            
            $arrData[] = array(
                'data'      =>  $arrRow,
                'href'      =>  $this->parser->parse_string($this->user->get('configs.url_view_element'), 
                    array(
                        'url_cadastro'  =>  $this->user->get('url'),
                        'id_element'    =>  $item['id_value'],
                    )
                ,TRUE),
                'pk_value'   =>  $item['id_value'],
            );  
        }
        
        $arrItems['items'] = $arrData;
        $arrItems['order'] = $arrProp['order'];
        Common::printJson($arrItems);
        
    }
    
    public function listItems($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->user->runActionUserPermissions(
            array(
                'action'            =>  $this->user->get('configs.actions.viewItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        //CLOSE BUTTON
        $this->menus->addActionButtonsRightNode(
            array(
                'tag'       =>  'a',
                'class'     =>  'btn btn-primary-outline btn-sm load-page',
                'href'      =>   BASE_URL,
                'text'      =>  '<i class="fa fa-times"></i>'
            )
        );   
       
        $this->template->set('actionMenu',$this->user->getActionMenuController(
            array(
                'pk_controller' =>  $this->user->get('id'),
                'user_id'       =>  $this->data->get('user.id'),
                'entity_id'     =>  $this->data->get('user.configs.entity'),
            )
        ));    
        
        $arrHtmlDataListItems = $this->user->getHtmlDataListItems();    
        $this->template->append('javascript',$arrHtmlDataListItems['javascript']);
        unset($arrHtmlDataListItems['javascript']);
        $this->template->set($arrHtmlDataListItems);
                
        $this->setJsCadastros();
        
        $arrTemplate = $this->common->getTemplate($arrProp);
        
        $this->template->load($arrTemplate['template'],'controllers', $arrTemplate['view']);
        
    }
    
    public function save($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->user->runActionUserPermissions(
            array(
                'action'            =>  $this->user->get('configs.actions.editItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $arrValues = $this->input->post('values');
        
        $keyPassword = array_search('password_user',array_column($arrValues,'id'));
        if($arrValues[$keyPassword]['value']){
            $this->user->variables->addRule(
                array(
                    'id'        =>  'password_user',
                    'rule'      =>  'length',
                    'min'       =>  6,
                    'message'   =>  'Senha deve conter no mínimo 6 caracteres.'
                ) 
            );
        }
        else{
            unset($arrValues[$keyPassword]);
            $this->user->variables->unset('password_user');
        }
        
        $this->user->mergeValues(
            array(
                'values'        =>  $arrValues,
                'method'        =>  'database',
            )
        );        
        
        $arrDifferenceValues = $this->user->getDifferenceValues(
            array(
                'method'    =>  'database'
            )
        );
        
        //Não há alterações feitas
        if(!$arrDifferenceValues AND $this->user->get('item.value') != ''){
            Common::printJson(
                array(
                    'status'    =>  'info',
                    'id'        =>  $this->user->get('item.value'),
                    'token'     =>  $this->user->getToken(),
                    'console'   =>  array(
                        array(
                            'date_time' =>  date('d/m/Y|H:i:s'),
                            'message'   =>  '[Usuário]['.$this->user->get('item.value').']:Não há alterações para registrar',
                            'type'      =>  'success',
                        )
                    ),
                    'messages'   =>  array(
                        array(
                            'type'      =>  'info',
                            'message'   =>  '<i class="fa fa-info-circle"></i>&nbsp;&nbsp;Não há alterações para registrar.'
                        )
                        
                    )
                )
            );
            return; 
        }
            
        $validationErrors = $this->user->variables->validate();
        
        if($validationErrors){
            
            $errorMessages = array();
            foreach($validationErrors as $error){
                if(array_search($error['key'],array_column($errorMessages,'key')) === FALSE){
                    $errorMessages[] = $error;
                }
            }
            
            $arrConsole = array();
            foreach(array_column($errorMessages,'message') as $message){
                $arrConsole[] = array(
                    'date_time' =>  date('d/m/Y|H:i:s'),
                    'message'   =>  $message,
                    'type'      =>  'error', 
                );   
            }
            
            
            Common::printJson(
                array(
                    'status'    =>  'error',
                    'messages'  =>  array_column($errorMessages,'message'),
                    'errors'    =>  $validationErrors,
                    'console'   =>  $arrConsole,
                )
            ); 
            return;      
        }
        
        
        //HASH DO PASSWORD
        $newPassword = password_hash($this->user->variables->get('password_user.value'),PASSWORD_DEFAULT);
        $this->user->variables->set('password_user',array('value'=>$newPassword));
        
        $action = ($this->user->get('item.value'))  ? 'UPDATE' : 'INSERT';
        
        $responseUpdate = $this->user->update();
        
        //nao loggar senha de usuario
        $keyPasswordInput = array_search('password_user',array_column($arrDifferenceValues??array(),'id'));
        unset($arrDifferenceValues[$keyPasswordInput]);
        
        
        //LOG DE ATIVIDADE DO CADASTRO
        $this->logger->setLog(
            array(
                'schema'        =>  $this->user->get('data.schema').'_logs',
                'table_log'     =>  $this->user->get('data.schema').'_'.$this->user->get('data.table'),
                'item_id'       =>  $this->user->get('item.value'),
                'action'        =>  $action,
                'user_id'       =>  $this->data->get('user.id'),
                'data'          =>  array(
                    'inputs'        =>  $arrDifferenceValues
                )
            )
        );
        
        if(is_array($responseUpdate)){
            Common::printJson($responseUpdate); 
            return;
        }

        $consoleResponse = '[Usuário][' .$responseUpdate.']: Foi ';
        $consoleResponse .= ($action == 'UPDATE') ? 'atualizado.' : 'criado.';
             
        Common::printJson(
            array(
                'status'    =>  $responseUpdate ? 'ok' : 'error',
                'id'        =>  $responseUpdate,
                'token'     =>  $this->user->getToken(),
                'console'   =>  array(
                    array(
                        'date_time' =>  date('d/m/Y|H:i:s'),
                        'message'   =>  $consoleResponse,
                        'type'      =>  'success',
                    )
                )
            )
        ); 
        
        
    }
    
    /** NAO EXTERNOS **/
    
    private function setJsCadastros($arrProp = array()){
        
        $data = array(
            'item'  =>   $this->user->get('item'),
            'url'   =>  current_url(),
        );
        
        $jsCadastros = $this->template->load('blank','cadastros','jsCadastros_view',$data,TRUE);
        
        $this->template->append('javascript',$jsCadastros);
    }
    
    private function setJsModal($arrProp = array()){
        
        $data = array(
            'item'  =>   $this->user->get('item'),
            'url'   =>  current_url(),
        );
        
        $jsSetModal = $this->template->load('blank','cadastros','jsSetModal_view',$data,TRUE);
        
        $this->user->append('javascript',$jsSetModal);
        
        
    }  
}
