<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');



class Pessoas_cadastros_controller extends Data{
    
    private $cadastro;
    
    function __construct(Cadastros $cadastro){
        parent::__construct();
        
        $this->set('template',$this->CI->common->getTemplate());
        
        $this->cadastro = $cadastro;         
    }
    
   public function index(){
        
        switch((int)$this->CI->uri->get('tipo')){
            
            case 1:{
                return $this->editPessoaFisica();
                break;
            }
            case 2:{
                return $this->editPessoaJuridica();
                break;
            }
            
            default: {
                $this->CI->main_model->erro();
            }
        }
    }
    
    public function beforeUpdate(){
        
        include(dirname(__FILE__).'/../models/Pessoas_model.php');
        $pessoasModel = new Pessoas_model;
        
        
        //VALIDACAO DO TIPO DE PESSOA
        
        //não existe o tipo recebido, o form é inválido
        if(!$pessoasModel->validateTipoPessoa($this->cadastro)){
            $this->CI->main_model->erro();
        }
        //FIM VALIDACAO DO TIPO DE PESSOA
        
        
        //VALIDACAO POR TIPO DE PESSOA
        switch((int) $this->cadastro->variables->get('tipo')->get('value')){
            case 1: { //Pessoa Física
                $validationErrors = $pessoasModel->validatePessoaFisica($this->cadastro);
                break;
            }
            case 2: { //Pessoa Jurídica
                $validationErrors = $pessoasModel->validatePessoaJuridica($this->cadastro);
                break;
            }
        }
        
        return array(
            'cadastro'      =>  $this->cadastro,
            'validation'    =>  $validationErrors??array(),
        );
        
    }
    
    public function getItemsGrid(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
                'permission'        =>  'view',
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
        //temp($this->CI->db->last_query());
        $arrData = array();
        foreach($arrItems['items'] as $item){
            
            $this->cadastro->setItem($item);
            
            $arrRow = array();
            
            foreach($arrListItemsKeys as $listKey){
                
                $columnValue = $this->cadastro->variables->get($listKey.'.text');
                $columnValue = $columnValue ? $columnValue : $this->cadastro->variables->get($listKey.'.value');
                
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
        
        Common::printJson($arrItems,200,TRUE);
        
    }
    
    public function editPessoaFisica(){
        
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
                'class'     =>  array('card','col-md-24','padding-top-2','padding-bottom-2','margin-top-4','nopadding','cadastro-item-actionmenu'),
            )
        );
        
        $htmlBody->add(
            array(
                'text'      =>  $this->cadastro->getActionMenuController(
                     array(
                        'pk_controller' =>  $this->cadastro->get('id'),
                        'user_id'       =>  $this->CI->data->get('user.id'),
                        'entity_id'     =>  $this->CI->data->get('user.configs.entity'),
                        'menu'          =>  include(dirname(__FILE__).'/../data/actionMenuControllerItem_PessoasFisicas.php'),
                    )
                ),
                'parent_id' =>  $idPanelActionMenu,
            )
        );
        
                
        $arrPaneChildren = array();
        
        include(dirname(__FILE__).'/../data/pessoaFisica/formPessoaFisica.php');
        $bsFormPessoaFisicaData = $getFormPessoaFisica();
        append($arrPaneChildren,array($bsFormPessoaFisicaData['form']));
        
        append($arrPaneChildren,
            array(
                array(
                    'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($bsFormPessoaFisicaData['javascript']??NULL)),TRUE),
                ) 
            )
        );
        
        $bootstrap = new Bootstrap;
        
        $bootstrap->tabs(
            include(dirname(__FILE__).'/../data/pessoaFisica/tabPessoaFisica.php')
        );
        
        append($arrPaneChildren,
            array(
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('container-fluid','bg-gray','nomargin','','col-lg-24','padding-top-4'),
                    'children'  =>  $bootstrap->getHtmlData()
                )
            )
        );
                
        $arrBootstrapTabs = array(
            'class'     =>  array('cadastro-item-content',),
            'tab_content_class' =>  array('padding-top-2'),
            'nodes'     =>  array(
                array(
                    'tab'   =>  array(
                        'text'      =>  '<i class="fa fa-th"></i> &nbsp; Item',
                    ),
                    'pane'  =>  array(
                        'children'  => $arrPaneChildren
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
                'menu'      =>  include(dirname(__FILE__).'/../data/itemFooterButtons_PessoasFisicas.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        );
        
        return array(
            'title'         =>  'Cadastros | Pessoa Física',
            'body'          =>  $htmlBody->getHtml(),
            'body_height'   =>  '560',
            'footer'        =>  $htmlFooter->getHtml(),
        );
    }
    
    public function editPessoaJuridica(){
        
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
                'class'     =>  array('card','col-md-24','padding-top-2','padding-bottom-2','margin-top-4','nopadding','cadastro-item-actionmenu'),
            )
        );
        
        $htmlBody->add(
            array(
                'text'      =>  $this->cadastro->getActionMenuController(
                     array(
                        'pk_controller' =>  $this->cadastro->get('id'),
                        'user_id'       =>  $this->CI->data->get('user.id'),
                        'entity_id'     =>  $this->CI->data->get('user.configs.entity'),
                        'menu'          =>  include(dirname(__FILE__).'/../data/actionMenuControllerItem_PessoasJuridicas.php'),
                    )
                ),
                'parent_id' =>  $idPanelActionMenu,
            )
        );
        
        $arrPaneChildren = array();

        include(dirname(__FILE__).'/../data/pessoaJuridica/formPessoaJuridica.php');
        $bsFormPessoaJuridicaData = $getFormPessoaJuridica();
        append($arrPaneChildren,array($bsFormPessoaJuridicaData['form']));
        
        append($arrPaneChildren,
            array(
                array(
                    'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($bsFormPessoaJuridicaData['javascript']??NULL)),TRUE),
                ) 
            )
        );
        
        $bootstrap = new Bootstrap;
        
        $bootstrap->tabs(
            include(dirname(__FILE__).'/../data/pessoaJuridica/tabPessoaJuridica.php')
        );
        
        append($arrPaneChildren,
            array(
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('container-fluid','bg-gray','nomargin','','col-lg-24','padding-top-4'),
                    'children'  =>  $bootstrap->getHtmlData()
                )
            )
        );
        
        $arrBootstrapTabs = array(
            'class'     =>  array('cadastro-item-content',),
            'tab_content_class' =>  array('padding-top-2'),
            'nodes'     =>  array(
                array(
                    'tab'   =>  array(
                        'text'      =>  '<i class="fa fa-th"></i> &nbsp; Item',
                    ),
                    'pane'  =>  array(
                        'children'  => $arrPaneChildren
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
                'menu'      =>  include(dirname(__FILE__).'/../data/itemFooterButtons_PessoasJuridicas.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        );
        
        
        return array(
            'title'         =>  'Cadastros | Pessoa Jurídica',
            'body'          =>  $htmlBody->getHtml(),
            'body_height'   =>  '560',
            'footer'        =>  $htmlFooter->getHtml(),
        );
        
    }
    
    public function setValues($arrValues){
        
        //DESCRIPTOGRAFANDO TIPO DE PESSOA
        $keyTipoPessoa = array_search('tipo',array_column($arrValues,'id'));
        if($keyTipoPessoa===NULL){
            $this->CI->main_model->erro();
        }
        
        $tipo = (int) $this->CI->encryption->decrypt(($arrValues[$keyTipoPessoa]['value']??NULL));
        
        //não existe um tipo, o form foi violado
        if(!$tipo){
            $this->CI->main_model->erro();
        }
        
        $arrValues[$keyTipoPessoa]['value'] = $tipo;
        //FIM DESCRIPTOGRAFANDO TIPO DE PESSOA
        
        return $arrValues;
    }
            
}
