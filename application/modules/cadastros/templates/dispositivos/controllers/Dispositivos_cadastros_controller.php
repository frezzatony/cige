<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');



class Dispositivos_cadastros_controller extends Data{
    
    private $cadastro;
    private $arrIdsTemplates = array(
        1   =>  'smartphone',
    );
    
        
    function __construct(Cadastros $cadastro){
        parent::__construct();
        
        $this->set('template',$this->CI->common->getTemplate());
        
        $this->cadastro = $cadastro;         
    }
    
    public function index(){
        
        
        $tipoItem = $this->cadastro->variables->get('tipo.value') ? $this->cadastro->variables->get('tipo.value') : $this->CI->uri->get('tipo');
        
        
        if($tipoItem!==FALSE AND is_numeric($tipoItem)){
            
            switch($tipoItem){
                case 1:{
                    return $this->editTemplateSmartphone();
                    break;
                }
                default:{
                    return $this->editTemplateBlank();
                    break;
                }
            }
             
        }
        
        return $this->default();
    }
    
    
    public function beforeUpdate(){
        
        
        include(dirname(__FILE__).'/../models/Dispositivos_model.php');
        $dispositivosModel = new Disposivitos_model;
        
        
        //VALIDACAO DO TIPO DE DISPOSITIVO
        
        //não existe o tipo recebido, o form é inválido
        if(!$dispositivosModel->validateTipo($this->cadastro)){
            $this->CI->main_model->erro();
        }
        //FIM VALIDACAO DO TIPO DE DISPOSITIVO
        
        return array(
            'cadastro'      =>  $this->cadastro,
        );
        
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
        
        
        $arrDataView = array(
            'url_new_item'      =>  BASE_URL.$this->cadastro->get('configs.uri_segment').'/'.$this->cadastro->get('url').'/view', 
            'arrIdsTemplates'   =>  $this->arrIdsTemplates,
        );
        
        $htmlBody = new Html();
        $htmlBody->add(
            array(
                'text'  =>  $this->CI->template->load('blank','cadastros/templates/dispositivos','changeTemplate_view',$arrDataView,TRUE),
            )
        );
        
         
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-right',
            )
        );
        
        $buttonsHtmlData = $this->cadastro->getButtonsController(
            array(
                'menu'      =>  include(dirname(__FILE__).'/../data/changeTemplateFooterButtons.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        ); 
        
        return array(
            'title'         =>  'Cadastros | ' . $this->cadastro->get('descricao_singular') . '| Escolher template',
            'body'          =>  $htmlBody->getHtml(),
            'modal_size'    =>  'sm',
            'footer'        =>  $htmlFooter->getHtml(),
        );
        
    }
    
    public function getItemsGrid($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
            )
        )){
            $this->CI->main_model->erroPermissao();
        }
        
        $arrListItemsKeys = array_column($this->cadastro->get('data.list_items.columns'),'id');
        $arrProp = $this->CI->data->get('post');
        
        $arrProp['order'] =  $this->cadastro->getOrderBy();
        
        if($this->CI->data->get('post.order.column')!==''){
            $arrProp['order'] =  $this->cadastro->getOrderBy(
                array(
                    array(
                        'id'        =>  $arrListItemsKeys[$this->CI->data->get('post.order.column')] ?? $this->cadastro->get('data.list_items.columns')[0]['id'],
                        'dir'       =>  in_array($this->CI->data->get('post.order.dir'),array('asc','desc')) ? $this->CI->data->get('post.order.dir') : 'asc',
                    )
                )   
            );    
        }
         
        $arrItems = $this->cadastro->getItems($arrProp);
        
        $arrData = array();
        foreach($arrItems['items'] as $item){
            
            $this->cadastro->setItem($item);
            
            $arrRow = array();
            
            foreach($arrListItemsKeys as $listKey){
                
                $columnValue = $this->cadastro->variables->get($listKey.'.text');
                $columnValue = $columnValue ? $columnValue : $this->cadastro->variables->get($listKey.'.value');
                
                if($listKey == 'atributos'){
                    $columnValue = '';
                    foreach(($this->cadastro->variables->get('atributos.value')??array()) as $rowValue){
                        $columnValue .= $columnValue ? ' / ' : '';
                        
                        $columnValue .= ucfirst($rowValue[1]['value']).': ' . $rowValue[2]['value'];
                        
                    }
                }
                
                
                $arrRow[]= $columnValue;
            } 
            
            $arrData[] = array(
                'data'      =>  $arrRow,
                'href'      =>  $this->CI->parser->parse_string($this->cadastro->get('configs.url_view_element'), 
                    array(
                        'modulo'        =>  $this->cadastro->get('module'),
                        'url_cadastro'  =>  $this->cadastro->get('url'),
                        'id_element'    =>  $item['id_value'],
                    )
                ,TRUE).'/tipo/'.$this->cadastro->variables->get('tipo.value'),
                'pk_value'   =>  $item['id_value'],
            );  
        }
        
        $arrItems['items'] = $arrData;
        $arrItems['order'] = $arrProp['order'];
        
        Common::printJson($arrItems);
        
        
    }
    
    private function editTemplateBlank(){
        
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
        
        
        include(dirname(__FILE__).'/../data/functionGetActionMenuControllerItem.php');
        
        $htmlBody->add(
            array(
                'text'      =>  $this->cadastro->getActionMenuController(
                     array(
                        'pk_controller' =>  $this->cadastro->get('id'),
                        'user_id'       =>  $this->CI->data->get('user.id'),
                        'entity_id'     =>  $this->CI->data->get('user.configs.entity'),
                        'menu'          =>  $getActionMenuControllerItem(),
                    )
                ),
                'parent_id' =>  $idPanelActionMenu,
            )
        );
        
        include(dirname(__FILE__).'/../data/blank_template/paneCadastro.php');
        $paneCadastro = $getPaneCadastro();
        
        $htmlPaneCadastro = new Html;
        $htmlPaneCadastro->add(
            array(
                'children'  =>  $paneCadastro['html_data']
            )
        );
        
        if($paneCadastro['javascript']??NULL){
           $htmlPaneCadastro->add(
                array(
                    'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneCadastro['javascript']??NULL)),TRUE),
                )  
            ); 
        }
        
        
        $htmlPaneCadastro->add(
            array(
                'text'      =>  $this->CI->template->load('jquery','cadastros/templates/dispositivos','jsDispositivos',NULL,TRUE),
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
    
    private function editTemplateSmartphone(){
        
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
        
        
        include(dirname(__FILE__).'/../data/functionGetActionMenuControllerItem.php');        
        $htmlBody->add(
            array(
                'text'      =>  $this->cadastro->getActionMenuController(
                     array(
                        'pk_controller' =>  $this->cadastro->get('id'),
                        'user_id'       =>  $this->CI->data->get('user.id'),
                        'entity_id'     =>  $this->CI->data->get('user.configs.entity'),
                        'menu'          =>  $getActionMenuControllerItem(
                            array(
                                'tipo'      =>  1, //id do tipo Smartphone
                            )
                        ),
                    )
                ),
                'parent_id' =>  $idPanelActionMenu,
            )
        );
        
        include(dirname(__FILE__).'/../data/smartphone_template/paneCadastro.php');
        $paneCadastro = $getPaneCadastro();
        
        $htmlPaneCadastro = new Html;
        $htmlPaneCadastro->add(
            array(
                'children'  =>  $paneCadastro['html_data']
            )
        );
        
        if($paneCadastro['javascript']??NULL){
           $htmlPaneCadastro->add(
                array(
                    'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneCadastro['javascript']??NULL)),TRUE),
                )  
            ); 
        }
        
        
        $htmlPaneCadastro->add(
            array(
                'text'      =>  $this->CI->template->load('jquery','cadastros/templates/dispositivos','jsDispositivos',NULL,TRUE),
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
                'menu'      =>  include(dirname(__FILE__).'/../data/itemFooterButtons.php'),
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
    
    public function setValues($arrValues){
        
        //DESCRIPTOGRAFANDO TIPO DE DISPOSITIVO
        $keyTipo = array_search('tipo',array_column($arrValues,'id'));
        if($keyTipo===NULL){
            $this->CI->main_model->erro();
        }
        
        $tipo = (int) $this->CI->encryption->decrypt(($arrValues[$keyTipo]['value']??NULL));
        
        //não existe um tipo, o form foi violado
        if(!$tipo){
            $this->CI->main_model->erro();
        }
        
        $arrValues[$keyTipo]['value'] = $tipo;
        //FIM DESCRIPTOGRAFANDO TIPO DE DISPOSITIVO
        
        
        if($this->arrIdsTemplates[$tipo]??NULL){
            include(dirname(__FILE__).'/../data/'.$this->arrIdsTemplates[$tipo].'_template/setValues.php');
            $setValues(
                array(
                    'values'        =>  &$arrValues,
                )
            );
        }
        
        return $arrValues;
    }
            
}
