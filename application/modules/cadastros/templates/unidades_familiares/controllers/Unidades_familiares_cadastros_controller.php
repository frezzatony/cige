<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Unidades_familiares_cadastros_controller extends Data{
    
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
            'messages'  =>  array(),
        );
        
        require_once(dirname(__FILE__).'/../models/Unidades_familiares_model.php');
        $UnidadesFamiliares_Model = new Unidades_familiares_model;
        
        //valida enderecos repetidos
        $dataEndereceosRepetidos = $UnidadesFamiliares_Model->getEnderecosRepetidos(
            array(
                'id_cadastro'   =>  $this->cadastro->get('item.value'),
            )
        );
        if($dataEndereceosRepetidos){
            $arrReturn['messages'][] = array(
                'type'      =>  'warning',
                'message'   =>  '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Há outra(s) unidade(s) familiare(s) com o mesmo endereço informado.',
            );
           
        }
        
        
        
        return $arrReturn;
        
    }
    
    public function beforeUpdate(){
        
        require_once(dirname(__FILE__).'/../models/Unidades_familiares_model.php');
        $UnidadesFamiliares_Model = new Unidades_familiares_model;
        
        $validationErrors = $UnidadesFamiliares_Model->validate($this->cadastro);
        
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
        
        include(dirname(__FILE__).'/../models/Unidades_familiares_model.php');
        $UnidadesFamiliares_Model = new Unidades_familiares_model;
        
        include(dirname(__FILE__).'/../data/function_getDataPontuacaoEmhab.php');
        $dataTblPontuacaoEmhab = $getDataPontuacaoEmhab($UnidadesFamiliares_Model->getPontuacaoEmhab($this->cadastro->variables->get('id.value')));
        
        include(dirname(__FILE__).'/../data/function_getDataPontuacaoSantaFe.php');
        $dataTblPontuacaoSantaFe = $getDataPontuacaoSantaFe($UnidadesFamiliares_Model->getPontuacaoLoteamentoSantaFe($this->cadastro->variables->get('id.value')));
        
        include(dirname(__FILE__).'/../data/paneCadastro.php');
        $paneCadastro = $getPaneCadastro(
            array(
                'data_tbl_pontuacao_emhab'      =>  $dataTblPontuacaoEmhab,
                'data_tbl_pontuacao_santa_fe'   =>  $dataTblPontuacaoSantaFe,
            )
        );
        
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
        
        
        include(dirname(__FILE__).'/../data/paneAcompanhamentoRetorno.php');
        $paneAcompanhamentoRetorno = $getPaneAcompanhamentoRetorno();
        
        $htmlAcompanhamentoRetorno = new Html;
        $htmlAcompanhamentoRetorno->add(
            array(
                'children'  =>  $paneAcompanhamentoRetorno['html_data']
            )
        );
        $htmlAcompanhamentoRetorno->add(
            array(
                'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneAcompanhamentoRetorno['javascript']??NULL)),TRUE),
            )  
        );
        
        $arrBootstrapTabs = array(
            'class'     =>  array('cadastro-item-content','bg-white'),
            'nodes'     =>  array(
                array(
                    'tab'   =>  array(
                        'text'      =>  '<i class="las la-grip-horizontal size-15"></i> &nbsp; Item',
                    ),
                    'pane'  =>  array(
                        'text'   =>  $htmlPaneCadastro->getHtml(),
                        'style'     =>  'height: 380px;',
                    )  
                ),
                array(
                    'tab'   =>  array(
                        'text'      =>  '<i class="la la-history size-15"></i> &nbsp; Acompanhamentos de retorno',
                    ),
                    'pane'  =>  array(
                        'text'   =>  $htmlAcompanhamentoRetorno->getHtml(),
                        'style'     =>  'height: 380px;',
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
                    'text'   =>  '<small>Em desenvolvimento...</small>',
                    'style'     =>  'height: 380px;',
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
   
    public function externalList_Integrantes_Data($arrProp = array()){
        
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
        
        include(dirname(__FILE__).'/../models/Unidades_familiares_model.php');
        $UnidadesFamiliares_Model = new Unidades_familiares_model;
        
         
        $arrProp['filters'] = $this->CI->data->get('post.filters');
        $arrProp['data'] = new Data($this->CI->data->get('post.post_data')??array());
        $arrProp['limit'] = $this->CI->data->get('post.limit');
        $arrProp['order'] = $this->CI->data->get('post.order');
        $dataExternalList = $UnidadesFamiliares_Model->getIntegrantesData($arrProp);
        
        $arrDataItems = array();
        
        foreach($dataExternalList as $row){
            $arrDataItems[] = array(
                'data'      =>  array(
                    array(
                        'text'  =>  $row['id']
                    ),
                    array(
                        'text'  =>  $row['nome']
                    ),
                    array(
                        'text'  =>  $this->CI->mask->mask($row['cpf_cnpj'],'cpf_cnpj'),
                    ),
                    array(
                        'text'  =>  $row['nis']
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
    
    public function getDataTblPontuacaoEmhab(){
        
        include(dirname(__FILE__).'/../models/Unidades_familiares_model.php');
        $UnidadesFamiliares_Model = new Unidades_familiares_model;
        
        include(dirname(__FILE__).'/../data/function_getDataPontuacaoEmhab.php');
        $dataPontuacao = $getDataPontuacaoEmhab($UnidadesFamiliares_Model->getPontuacaoEmhab($this->cadastro->get('item.value')));
        
        $arrGetItems = array(
            'items' =>  array()
        );
        
        foreach($dataPontuacao??array() as $row){
            
            $arrGetItems['items'][] = array(
                'data'  =>  array(),
            );
            $newRow = &$arrGetItems['items'][sizeof($arrGetItems['items'])-1]['data'];
            foreach($row as $column){
                $newRow[] = array(
                    'text'  =>  $column['text'],
                    'class' =>  string_to_array($column['class']??NULL),
                );
            }
            
        } 
                    
        Common::printJson($arrGetItems);
         
    }
    
    public function getDataTblPontuacaoSantaFe(){
        
        include(dirname(__FILE__).'/../models/Unidades_familiares_model.php');
        $UnidadesFamiliares_Model = new Unidades_familiares_model;
        
        include(dirname(__FILE__).'/../data/function_getDataPontuacaoSantaFe.php');
        $dataPontuacao = $getDataPontuacaoSantaFe($UnidadesFamiliares_Model->getPontuacaoLoteamentoSantaFe($this->cadastro->get('item.value')));
        
        $arrGetItems = array(
            'items' =>  array()
        );
        
        foreach($dataPontuacao??array() as $row){
            
            $arrGetItems['items'][] = array(
                'data'  =>  array(),
            );
            $newRow = &$arrGetItems['items'][sizeof($arrGetItems['items'])-1]['data'];
            foreach($row as $column){
                $newRow[] = array(
                    'text'  =>  $column['text'],
                    'class' =>  string_to_array($column['class']??NULL),
                );
            }
            
        } 
                    
        Common::printJson($arrGetItems);
         
    }
    
          
}
