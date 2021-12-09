<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Main extends CI_Controller{
    
    private $relatorio;
    private $controller;
    private $arrTemplate;
    
    function __construct(){
         
        parent::__construct();
        
        $this->arrTemplate =  $this->common->getTemplate();
        
        $this->initSelf();
               
    }
    
    public function index(){ 
        
         
        if($this->input->get_post('validate')){
            
            $this->validate();
            return;
        }
        
        if($this->uri->getKey('method')!==FALSE){
            
            $this->getMethod();
            return;
        }
        
        $this->default();    
                     
    }
    
    
    /** NAO EXTERNOS **/
    private function validate(){
        
         
        if(method_exists($this->controller,'validate')){       
            $this->controller->validate($this->relatorio);
        }
        
        
        
    }
    
    public function default(){
           
        $htmlBody = new Html();
        $htmlBody->add($this->relatorios->getHtmlDataDefaultBody()); 
        
        $viewData = array(
            'body'      =>  $htmlBody->getHtml(),
            'footer'    =>  '',
        );  
        
        $controllerData = $this->controller->index();
        
        foreach($controllerData ?? array() as $key => $val){
            if($viewData[$key]??NULL){
               append($viewData[$key],$val); 
            }
            else{
                $viewData[$key] = $val;
            }
        }
        
        $htmlBody->resetHtml();
        $htmlBody->add(
            array(
                'tag'       =>  'script',
                'type'      =>  'text/javascript',
                'text'      =>  $this->template->load('blank','relatorios','jsDefaultItem',NULL,TRUE),
            )
        );
        $viewData['body'] .= "\n" . $htmlBody->getHtml();
        
        Common::printJson($viewData);
    }
     
     
    private function getMethod($method=NULL){
        
        $method = clearSpecialChars(trim($this->uri->get('method')));
        if(method_exists($this->controller,$method)){
            $this->controller->set('view_data',
                array(
                    'assinaturaUsuario' =>  $this->template->load('blank','relatorios','assinaturaUsuario_view',NULL,TRUE),
                    'carimboSistema_A4'    =>  $this->template->load('blank','relatorios','carimboSistema_A4_view',NULL,TRUE),
                )
            );
            $this->controller->{$method}();
            return;
        }
        
        $this->main_model->erro(); 
        
    }
    
    private function initSelf(){
        
        if($this->uri->getKey('relatorios') === FALSE OR !$this->uri->get('relatorios')){
            redirect(BASE_URL, 'refresh');
        }
        
        $this->arrDataToken = $this->json->getFullArray($this->encryption->decrypt($this->input->get_post('token')));
        
        $arrRelatorio = array(
            'module'        =>  clearSpecialChars($this->uri->get('relatorios')),
            'url'           =>  clearSpecialChars($this->uri->get($this->uri->get('relatorios'))),
            'request_id'    =>  is_numeric($this->arrDataToken['request_id']) ? $this->arrDataToken['request_id'] :NULL,
        );
        
        
        $this->relatorio = new Relatorios($arrRelatorio);
        
        //não há um relatorio para o modulo e url informados
        if(!$this->relatorio->get('id')){
            redirect(BASE_URL, 'refresh');
        }
        
        $controllerName = $this->relatorio->requireTemplateFile();

        if(!$controllerName){
            $this->main_model->erro();
        }
        
        $this->controller = new $controllerName($this->relatorio);
        
        $arrValues = $this->input->get_post('values');
        
        if(method_exists($this->controller,'setValues')){
            $arrValues = $this->controller->setValues($arrValues);
        }
        
        $this->relatorio->mergeValues(
            array(
                'values'        =>  $arrValues,
                'method'        =>  'database',
            )
        );  
        
        return $this;
    }
        
}
