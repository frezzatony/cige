<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Main extends CI_Controller{
    
    private $arrTemplate;
    private $controller;
    
    function __construct(){
         
        parent::__construct();
        
        $this->arrTemplate =  $this->common->getTemplate();
        
        $this->initSelf();          
    }
    
    public function index(){ 
        
        if($this->uri->getKey('grid')!==FALSE){
            $this->viewConsulta();
            return;
        }
        
        if($this->uri->getKey('printgrid')!==FALSE){
            $this->printConsulta();
            return;
        }
        
        if($this->uri->getKey('method')!==FALSE){
            $this->getMethod();
            return;
        }
        
        $this->default();    
                     
    }
    
    
    
    /**
     * PRIVATES
     **/
    
    public function viewConsulta(){
        
        $this->setController();
        
        $htmlBody = new Html;
        
        $colunasRelatorio = Json::getFullArray($this->input->get_post('columns'));
        $bsgridId = $this->input->get_post('bsgrid');
        
        if(!$colunasRelatorio OR !$bsgridId){
            $this->main_model->erro();
        } 
        
        
        $arrColunas = array();                      
        foreach($colunasRelatorio as $keyColuna => $valColuna){
            
            $keyColunaListItem = array_search($valColuna['id'],array_column($this->controller->get('data.list_items.columns'),'id'));
            
            if($keyColunaListItem !== FALSE){
                $arrColunas[] = $this->controller->get('data.list_items.columns.'.$keyColunaListItem) ?? NULL;
                
                $arrColunas[(sizeof($arrColunas)-1)]['width'] = $valColuna['width'] ?? NULL;
            }        
            
        }
        
        $htmlBody->add(
            array(
                'text'  =>  $this->template->load('blank','relatorios','formPrintConsulta',
                    array(
                        'token'         =>  $this->input->get_post('token'),
                        'titulo'        =>  $this->controllerTitulo,
                        'controller'    =>  $this->controller,
                        'colunas'       =>  $arrColunas,
                        'bsgrid'        =>  $bsgridId,
                    )
                ,TRUE),
            )
        );
        
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
                
        $buttonsHtmlData = $this->controller->getButtonsController(
            array(
                'menu'      =>  include(dirname(__FILE__).'/../data/printFooterButtons.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        );
        
        
        $arrData = array(
            'title'         =>  'Imprimir/Exportar consulta',
            'modal_size'    =>  'md',
            'body'          =>  $htmlBody->getHtml(),
            'footer'        =>  $htmlFooter->getHtml(),
            
        );
        
        Common::printJson($arrData);
    }
    
    
    private function initSelf(){
        
        
                
    }
    
    private function printConsulta(){
        
        if(!$_POST){
            redirect(BASE_URL);
            exit();
        }
        
        $this->setController();
        
        print_R($_POST); 
        
    }
    
    private function setController(){
        
        if(!$this->input->get_post('token')){
            $this->main_model->erro();
        }
        
        $this->arrDataToken = $this->json->getFullArray($this->encryption->decrypt($this->input->get_post('token')));
        
        
        if(!is_numeric($this->arrDataToken['request_id'])){
            $this->main_model->erro();
        }
        
        $this->controller = new Controllers(
            array(
                'item'       =>  $this->arrDataToken['request_id']
            )
        );
        $this->controllerTitulo = $this->controller->variables->get('descricao_plural.value');
        
                
        $this->controller = $this->controller->getControllerObject();
                
        if(!$this->controller){
            $this->main_model->erro();
        }
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->controller->runActionUserPermissions(
            array(
                'action'            =>  $this->controller->get('configs.actions.viewItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        
        
        return TRUE;
         
    }
        
}
