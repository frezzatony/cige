<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');



class Controle_revisoes_iptu_cadastros_controller extends Data{
    
    private $cadastro;
    
    function __construct(Cadastros $cadastro){
        parent::__construct();
        
        $this->set('template',$this->CI->common->getTemplate());
        
        $this->cadastro = $cadastro;         
    }
    
    public function index(){
        
        return $this->default();
    }
    
    public function afterUpdate(){
        
        $arrReturn = array(
            'data'  =>  array(
                'dt_abertura_controle'  =>  $this->cadastro->variables->get('dt_abertura_controle','read')->get('value')    
            ),
        );
                
        
        return $arrReturn;
            
    }
    
    public function beforeUpdate(){
        
        require_once(dirname(__FILE__).'/../models/Controle_revisoes_iptu_model.php');
        $Cadastro_Model = new Controle_revisoes_iptu_model;
        
        $Cadastro_Model->setVariables($this->cadastro);
        
        if(!$this->cadastro->get('item.value')){
            
        }
                
        
        $validationErrors = $Cadastro_Model->validate($this->cadastro);
        
        return array(
            'cadastro'      =>  $this->cadastro,
            'validation'    =>  $validationErrors,
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
        
        $htmlBody = new Html();
                
        $idPanelActionMenu = $htmlBody->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('card','col-md-24','padding-top-6','padding-bottom-6','margin-top-4','nopadding','cadastro-item-actionmenu'),
            )
        );
        
        $htmlBody->add(
            array(
                'text'      =>  $this->cadastro->getActionMenuController(
                     array(
                        'pk_controller' =>  $this->cadastro->get('id'),
                        'user_id'       =>  $this->CI->data->get('user.id'),
                        'entity_id'     =>  $this->CI->data->get('user.configs.entity'),
                        'menu'          =>  include(dirname(__FILE__).'/../data/actionMenuControllerItem.php'),
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
    /*
    public function getItemsGrid($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
            )
        )){
            
            $this->CI->main_model->erroPermissao();
        }
        
        $arrListItemsKeys = array_column($this->cadastro->get('data.list_items.columns'),'id');
        $arrConfig = $this->CI->data->get('post');
        
        $arrConfig['order'] =  $this->cadastro->getOrderBy();
        
               
        if($this->CI->data->get('post.order.column')!==''){
            $arrConfig['order'] =  $this->cadastro->getOrderBy(
                array(
                    array(
                        'id'        =>  $arrListItemsKeys[$this->CI->data->get('post.order.column')] ?? $this->cadastro->get('data.list_items.columns')[0]['id'],
                        'dir'       =>  in_array($this->CI->data->get('post.order.dir'),array('asc','desc')) ? $this->CI->data->get('post.order.dir') : 'asc',
                    )
                )   
            );    
        }
        
        $arrConfig = array_merge($arrConfig,$arrProp);
        
        $arrItems = $this->cadastro->getItems($arrConfig);
        
        $arrData = array();
        foreach($arrItems['items'] as $item){
            
            $this->cadastro->setItem($item);
            
            $arrRow = array(
                //'href'      =>  NULL,
            );
            
            foreach($arrListItemsKeys as $listKey){
                
                switch($listKey){
                    
                    case 'situacao':{
                        
                        switch((integer)$this->cadastro->variables->get('processo_situacao.value')){
                            
                            case 9:{
                                $classSpan = 'color-green';
                                break;
                            }
                            case 10:{
                                $classSpan = 'color-red';
                                break;
                            }
                            
                            default:{
                                $classSpan = 'color-yellow';    
                                break;
                            }
                        }
                        
                        
                        $columnValue='<span class="'.$classSpan.'">'.$this->cadastro->variables->get('processo_situacao.text').'</span>';
                        
                        break;
                    }
                    default:{
                        $columnValue = $this->cadastro->variables->get($listKey.'.text');
                        $columnValue = $columnValue ? $columnValue : $this->cadastro->variables->get($listKey.'.value');
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
                    ),TRUE),
                'pk_value'   =>  $item['id_value'],
            );  
        }
        
        $arrItems['items'] = $arrData;
        $arrItems['order'] = $arrConfig['order'];
        
        if(($arrProp['return']??NULL)){
            return $arrItems;
        }
        
        Common::printJson($arrItems);
        
        
    }
    */
    public function receberRevisao(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.editItems'),
            )
        )){
            
            $this->CI->main_model->erroPermissao();
        }
        
        $idResponsavel = $this->CI->encryption->decrypt($this->CI->data->get('post.id_responsavel'));
        
        if($idResponsavel != $this->CI->data->get('user.id') OR !$this->cadastro->get('item.value')){
            $this->CI->main_model->erro();
            exit;
        }
        else if($idResponsavel == $this->cadastro->variables->get('responsavel.value')){
            
            Common::printJson(
                array(
                    'status'    =>  'info',
                    'messages'  =>  array(
                        array(
                            'type'      =>  'info',
                            'message'   =>  'Você já é o responsável.',
                        )
                    ),
                )
            );
            exit;
        }
        
        require_once(dirname(__FILE__).'/../models/Controle_revisoes_iptu_model.php');
        $Cadastro_Model = new Controle_revisoes_iptu_model;
        
        $response = $Cadastro_Model->receberRevisao($this->cadastro,
            array(
                'idResponsavel'  =>  $idResponsavel
            )
        );
        
        
        Common::printJson(
            array(
                'status'            =>  'ok',
                'nome_responsavel'  =>  $this->CI->data->get('user.nome'), 
                'dt_atribuicao'     =>  $this->cadastro->variables->get('processo_dt_atribuicao_responsavel.value'), 
                'messages'          =>  array(
                    array(
                        'type'      =>  'success',
                        'message'   =>  'O processo foi atribuído a você.'
                    )
                ),
            )
        );
        
    }
            
}
