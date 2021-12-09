<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Logradouros_cadastros_controller extends Data{
    
    private $cadastro;
    private $idCidadeSBS = 4593;
    
    function __construct(Cadastros $cadastro){
        
        parent::__construct();
        
        $this->cadastro = $cadastro;         
    }
    
    public function index(){
        
        return $this->default();
    }
    
    public function beforeDelete($arrProp = array()){
        
        $cadastroLogradouro = new Cadastros(
            array(
                'requests_id'   =>  array(14)
            )
        );
        
        
        $arrDataItems = $cadastroLogradouro->getItems(
            array(
                'simple_get_items'  =>  TRUE,
                'filters'           =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'in_integer',
                        'value'     =>  $arrProp['pk'],
                    )
                )
            )
        );
        
        
        $arrReturn = array(
            'response'  =>  array(),
        );
        //VERIFICAR CIDADE PARA PODER EXCLUIR
        foreach($arrDataItems as $item){
            if($item['cidade_value']==$this->idCidadeSBS){
                if(!$this->cadastro->runActionUserPermissions(
                    array(
                        'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                        'user_id'           =>  $this->CI->data->get('user.id'),
                        'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
                    )
                )){
                    $arrReturn['response'][] = array(
                        'pk'        =>  $item['pk'],
                        'status'    =>  FALSE,
                        'error'     =>  array(
                            'code'  =>  'permission'
                        )
                    ); 
                    
                    
                    $keyPk = array_search($item['pk'],$arrProp['pk']);
                    unset($arrProp['pk'][$keyPk]);
                }
            }
        }
        
        $arrReturn['pk'] = $arrProp['pk'];
        
        return $arrReturn;
    }
    
    public function default(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $htmlBody = new Html();
                
        $idPanelActionMenu = $htmlBody->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('card','col-md-24','padding-top-6','padding-bottom-6','margin-top-4','nopadding','cadastro-item-actionmenu'),
            )
        );
        
        $arrActionMenu = include(dirname(__FILE__).'/../data/actionMenuControllerItem.php');
        
        $htmlBody->add(
            array(
                'text'      =>  $this->cadastro->getActionMenuController(
                     array(
                        'pk_controller' =>  $this->cadastro->get('id'),
                        'user_id'       =>  $this->CI->data->get('user.id'),
                        'entity_id'     =>  $this->CI->data->get('user.configs.entity'),
                        'menu'          =>  $arrActionMenu,
                    )
                ),
                'parent_id' =>  $idPanelActionMenu,
            )
        );
        
        include(dirname(__FILE__).'/../data/paneCadastro.php');
        $paneCadastro = $getPaneCadastro();
        
        $htmlPaneCadastro = new Html;
        $htmlPaneCadastro->add(
            array(
                'children'  =>  $paneCadastro['html_data']
            )
        );
        $htmlPaneCadastro->add(
            array(
                'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneCadastro['javascript']??NULL)),TRUE),
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
        if($this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
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
        
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
                
        $buttonsHtmlData = $this->cadastro->getButtonsController(
            array(
                'menu'      =>  include(dirname(__FILE__).'/../data/itemFooterButtons.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        );
        
        return array(
            'title'     =>  'Cadastros | ' . $this->cadastro->get('descricao_singular'),
            'body'      =>  $htmlBody->getHtml(),
            'footer'    =>  $htmlFooter->getHtml(),
        );
    }
    
    public function externallist_cidades_data($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        include(dirname(__FILE__).'/../models/Logradouros_model.php');
        $Logradouros_Model = new Logradouros_model($this->cadastro);
        
         
        $arrProp['filters'] = $this->CI->data->get('post.filters');
        $arrProp['data'] = new Data($this->CI->data->get('post.post_data')??array());
        $arrProp['limit'] = $this->CI->data->get('post.limit');
        $arrProp['order'] = $this->CI->data->get('post.order');
        $dataExternalList = $Logradouros_Model->getCidadesData($arrProp);
        
        $arrDataItems = array();
        
        foreach($dataExternalList as $row){
            $arrDataItems[] = array(
                'data'      =>  array(
                    array(
                        'text'  =>  $row['id']
                    ),
                    array(
                        'text'  =>  $row['cidade']
                    ),
                    array(
                        'text'  =>  $row['estado']
                    ),
                ),
                'pk_value'  =>  $row['id'],
            );
        }
        
        Common::printJson(
            array(
                'items' =>  $arrDataItems,
                'count' =>  $dataExternalList[0]['full_count'] ?? 0
            )
        );
        
    }
    
    public function save(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        
        $actionSave = 37;
        if($this->cadastro->variables->get('cidade.value') != $this->idCidadeSBS){
            $actionSave = 99;
        }
        
                
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $actionSave,
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
            )
        )){
            $this->CI->main_model->erroPermissao();
        }
        
        $arrValues = $this->CI->input->post('values');
        
        $this->cadastro->mergeValues(
            array(
                'values'        =>  $arrValues,
                'method'        =>  'database',
            )
        );        
        
        $arrDifferenceValues = $this->cadastro->getDifferenceValues(
            array(
                'method'    =>  'database'
            )
        );
        
        //Não há alterações feitas
        if(!$arrDifferenceValues AND $this->cadastro->get('item.value') != ''){
            Common::printJson(
                array(
                    'status'    =>  'info',
                    'id'        =>  $this->cadastro->get('item.value'),
                    'token'     =>  $this->cadastro->getToken(),
                    'console'   =>  array(
                        array(
                            'date_time' =>  date('d/m/Y|H:i:s'),
                            'message'   =>  '[Cadastro]['.$this->cadastro->get('descricao_singular').']['.$this->cadastro->get('item.value').']:Não há alterações para registrar',
                            'type'      =>  'success',
                        )
                    ),
                    'messages'   =>  array(
                        '<i class="fa fa-info-circle"></i>&nbsp;&nbsp;Não há alterações para registrar.'
                    )
                ),200,TRUE
            ); 
            return;
        }
        
           
        $validationErrors = $this->cadastro->variables->validate();
        
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
                    'messages'  =>  $arrConsole,
                    'errors'    =>  $validationErrors,
                    'console'   =>  $arrConsole,
                ),200,TRUE
            );
            
            return;       
        }
        
        
        
        $action = ($this->cadastro->get('item.value'))  ? 'UPDATE' : 'INSERT';        
        $responseUpdate = $this->cadastro->update();
        
        //LOG DE ATIVIDADE DO CADASTRO
        Logger::setLog(
            array(
                'schema'        =>  ($this->cadastro->get('data.schema') ?? $this->config->item('db_log_schema','cadastros')).'_'.$this->CI->config->item('db_log_sufix','cadastros'),
                'table_log'     =>  ($this->cadastro->get('data.schema') ?? $this->config->item('db_log_schema','cadastros')).'_'.$this->cadastro->get('data.table'),
                'item_id'       =>  $this->cadastro->get('item.value'),
                'action'        =>  $action,
                'user_id'       =>  $this->CI->data->get('user.id'),
                'data'          =>  array(
                    'inputs'        =>  $arrDifferenceValues
                )
            )
        );
        
        
        if(is_array($responseUpdate)){
            Common::printJson($responseUpdate,200,TRUE); 
            return;
        }

        $consoleResponse = '[Cadastro]['.$this->cadastro->get('descricao_singular').'][Código:' .$responseUpdate.']: Foi ';
        $consoleResponse .= ($action == 'UPDATE') ? 'atualizado.' : 'criado.';
             
        Common::printJson(
            array(
                'status'    =>  $responseUpdate ? 'ok' : 'error',
                'id'        =>  $responseUpdate,
                'token'     =>  $this->cadastro->getToken(),
                'console'   =>  array(
                    array(
                        'date_time' =>  date('d/m/Y|H:i:s'),
                        'message'   =>  $consoleResponse,
                        'type'      =>  'success',
                    )
                )
            ),200,TRUE
        ); 
    }
            
}
