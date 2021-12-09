<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model{
       
    function __construct(){
        
        // Chamar o construtor do Model
        parent::__construct();
        
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
                
        $this->emAtualizacao();
        
        $this->preLoad();
                
        $this->data->set(
            array(
                'from'      =>  $_GET['from'] ?? str_replace('192.168.4.14','cige.saobentodosul.sc.gov.br',base_url(uri_string())),
                'get'       =>  $_GET,
                'post'      =>  $this->json->getFullArray($_POST),
                'messages'  =>  $this->input->get_post('messages'), 
                'ajax'      =>  $this->input->get_post('ajax') ? $this->input->get_post('ajax') : $this->uri->get('ajax'),
                'view'      =>  $this->input->get_post('view') ? $this->input->get_post('view') : $this->uri->get('view'),
                'method'    =>  $this->input->get_post('method') ? $this->input->get_post('method') : $this->uri->get('method'),

            )
        );
        
        if($this->session->flashdata('messages')){ 
            $this->data->append('messages',$this->session->flashdata('messages'));
        }
                
        //valida se está logado
        if(strtoMAIsuculo($this->router->class) != 'LOGIN' AND $this->auth->logged_in()){
            $this->setDefaultLoggedIn();  
        }
        
        $this->initView();
        $this->initModules();
        
                           
    }
    
    /* 
    public function login(){
        
        //fazendo login
        if($this->input->post('dologin') AND $this->input->post('dologin')=='dologin' AND !$this->auth->logged_in()){
            
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            if(!$this->auth->login($username,$password)){ //se o login falhar      
                redirect(BASE_URL.'login/erro?from='.$this->data->get('from'), 'refresh');
                return;
            }
            else{  
                redirect(BASE_URL,'header'); //$this->data->get('from')
                return;
            }
        }
        
        //valida se está logado
        else if(strtoMAIsuculo($this->router->class) != 'LOGIN' AND !$this->auth->logged_in()){
            redirect(BASE_URL.'login?from='.$this->data->get('from'),'refresh');
            return;    
        } 
    }
    */
    
    public function erro($arrProp = array()){
        
        $this->auth->logout();
        
        if(isset($arrProp['redirect']) AND $arrProp['redirect'] == false){
            return;
        }
        
        $arrTemplate = $this->common->getTemplate();
        
        if(in_array($arrTemplate['template'],array('padrao','default'))){
            redirect(BASE_URL.'login?error='.($arrProp['error_id']??NULL), 'refresh');
            return;  
        }
        
        Common::printJson(
            array(
                'status'    =>  'error_secutiry',
                'url'       =>  BASE_URL.'login?error='.($arrProp['error_id']??NULL),
            )
        );
        
           
    }
    
    public function erroPermissao($arrProp = array()){
        
        $messages = array(
            'status'    =>  'error',
            'messages'  =>  array(
                array(
                    'message'   =>  $arrProp['message'] ?? 'Você não possui privilégios mínimos <br />para esta operação.',
                    'type'      =>  'error',
                )
            )
        );
        
        if($this->data->get('ajax')){
            Common::printJson($messages);
            return;
        }
        
        $this->session->set_flashdata('messages',$messages['messages']);
        
        redirect(BASE_URL);
        return;

    }
    
    function getMemUsed($size=null){
        
        if(!$size){
            $size = memory_get_usage(true);
        }
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.strtoupper($unit[$i]);
    }
         
    public function setDefaultLoggedIn(){
        
        $this->data->set('user',$this->json->getFullArray($this->auth->user()));
        $this->template->set('arrUser',$this->data->get('user'));
        
        //usuario sem Entidade configurada
        if(!$this->data->get('user.configs.entity')){
            $this->data->set('user.configs.entity',1); //PRIMEIRA ENTIDADE CADASTRADA
            
            
            $this->users->update(
                array(
                    'id'    =>  $this->data->get('user.id'),
                    'data'  =>  array(
                        'configs'   =>  array(
                            'entity'            =>  $this->data->get('user.configs.entity'),
                        )
                    ),
                )
            );
        }
        
                    
        //usuario sem Modulo configurado
        if(!$this->data->get('user.configs.modulo')){
            
            $this->data->set('user.configs.modulo',2); //ACESSO PÙBLICO
            
            $this->modules->initialize(
                array(
                    'initialize'    =>  FALSE,
                    'modules'       =>  array(
                        'modulos'
                    )
                )
            );
            
            $modulo = new Modulos(
                array(
                    'requests_id'       =>  array(2)   
                )
            );
            
            $this->users->update(
                array(
                    'id'    =>  $this->data->get('user.id'),
                    'data'  =>  array(
                        'configs'   =>  array(
                            'modulo'            =>  $modulo->get('item.value'),
                            'modulo_descricao'  =>  $modulo->variables->get('descricao.value'),
                        )
                    ),
                )
            );
            
            $this->data->set('user',$this->json->getFullArray($this->auth->user($this->data->get('user.id'))));
            $modulo->initModule();
        }
        
        
        
        if($this->data->get('messages')){
            
            foreach($this->data->get('messages') as $message){
                
                $string = "\n\t\t\t\t";
                
                switch($message['type']){
                    case 'success':{
                        $type = 'success';
                        break;
                        
                    }
                    default:{
                        $type = 'error';
                        break;
                    }
                }
                
                $string .= '_'.$type.'Message(\''.$message['message'].'\');';
                
                $this->template->append('javascript',$string);
            }
        }
    }
    
    public function initView(){
        //fontAwesome
        
        $this->template->loadCss(BASE_URL.'assets/plugins/font-awesome/4.7.0/css/font-awesome.min.css');
        $this->template->loadCss(BASE_URL.'assets/plugins/line-awesome/1.3.0/css/line-awesome.min.css');
        $this->template->loadJs(BASE_URL.'assets/plugins/jquery.address/jquery.address-1.5.js?tracker=track');
        //bootstrapGrid
        $this->template->loadCss(BASE_URL.'assets/plugins/bsgrid/css/bsgrid.css');
        $this->template->loadJs(BASE_URL.'assets/plugins/bsgrid/js/bsgrid.js');
        
        //contextMenu
        $this->template->loadCss(BASE_URL.'assets/plugins/jquery-contextmenu/jquery.contextMenu.css');
        $this->template->loadJs(BASE_URL.'assets/plugins/jquery-contextmenu/jquery.contextMenu.js');
        $this->template->loadJs(BASE_URL.'assets/plugins/jquery-contextmenu/jquery.ui.position.js');
        
        //jqueryConfirm
        $this->template->loadCss(BASE_URL.'assets/plugins/jquery-confirm/jquery-confirm.min.css');
        $this->template->loadJs(BASE_URL.'assets/plugins/jquery-confirm/jquery-confirm.min.js');
        //boostrapTabs
        $this->template->loadJs(BASE_URL.'assets/plugins/tabs/tabs.js');
        $this->template->loadJs(BASE_URL.'assets/plugins/accordion/cige_accordion.js');
        $this->template->loadJs(BASE_URL.'assets/plugins/price/jquery.priceformat.js');
        $this->template->loadJs(BASE_URL.'assets/plugins/jquery.scrollTo/jquery.scrollTo.js');
        
        //resizableTableColumn
        $this->template->loadJs(BASE_URL.'assets/plugins/colresizable/colResizable-1.6.min.js');
               
    }
    
    
    public function setOnLogon($arrProp = array()){
        
        $arrDataUser = $this->json->getFullArray($this->auth->user()->row());
        unset($arrDataUser['password']);
        $this->data->set('user',$arrDataUser);
        $this->session->set_userdata(
            array(
                'user'  =>  $arrDataUser
            )
        );
        
        $arrSetUser = array(
            'set'       =>  FALSE,
            'configs'   =>  array()
        );
        
        if(!$this->data->get('user.configs.entity')){
            
            $userEntities = $this->permissions_model->getUserEntities(
                array(
                    'user_id'   =>  $this->data->get('user.id'),     
                )
            );
            
            //nao possui nenhuma entidade com permissao 
            if(!$userEntities){
                $this->erro();
            }
            
            $entity = $userEntities[key($userEntities)];
                      
            $arrSetUser['set']  = TRUE;
            $arrSetUser['configs']['entity'] = (int)$entity['id'];
        }
        
        if(!$this->data->get('user.configs.modulo')){
            
            $dataModules = $this->modulos_model->getUserModulesByMainMenu(
                array(
                    'user_id'   =>  $arrProp['user_data']['id'],
                    'entity_id' =>  $arrSetUser['configs']['entity'] ? $arrSetUser['configs']['entity'] : $this->data->get('user.configs.entity'),
                    'limit'     =>  1
                )
            );
            
            if(!$dataModules){
                $this->erro();
            }
            
            $arrSetUser['set']  = TRUE;
            $arrSetUser['configs']['modulo'] = (int)$dataModules[0]['modulo_id'];
            $arrSetUser['configs']['modulo_descricao'] = $dataModules[0]['modulo_descricao'];
              
        }
            
        if($arrSetUser['set']){
            $this->users->update(
                array(
                    'id'    =>  $this->data->get('user.id'),
                    'data'  =>  $arrSetUser,
                )
            );
            
            $this->data->set('user',$this->json->getFullArray($this->auth->user()->row()));
        }
        
        $this->load->library('user_agent');        
        $this->logger->setLog(
            array(
                'schema'        =>  'sistema_logs',
                'table_log'     =>  'login_logs',
                'item_id'       =>  $this->data->get('user.id'),
                'data'          =>  array(
                    'HTTP_USER_AGENT'       =>  $_SERVER['HTTP_USER_AGENT'],
                    'agent'                 =>  $this->agent->browser().' '.$this->agent->version(),
                    'is_robot'              =>  $this->agent->is_robot(),
                    'is_mobile'             =>  $this->agent->mobile() ? TRUE : FALSE,
                    'plataform'             =>  $this->agent->platform(),
                    'HTTP_X_FORWARDED_FOR'  =>  $_SERVER['HTTP_X_FORWARDED_FOR'] ?? NULL,
                    'HTTP_CLIENT_IP'        =>  $_SERVER['HTTP_CLIENT_IP'] ?? NULL,
                    'REMOTE_ADDR'           =>  $_SERVER['REMOTE_ADDR'] ?? NULL,
                    'user'                  =>  array(
                        'id'        =>  $this->data->get('user.id'),
                        'username'               =>  $this->data->get('user.username'),
                        'configs'                =>  $this->data->get('user.configs'),       
                    ),
                   
                )
            )
        );
    }
    
    public function validaAjaxFrom(){
        
        if($this->data->get('from')){
           return;
        }
        
        $return = array(
            'status'    =>  'error',
            'from'      =>  $this->data->get('from'),
            'to'        =>  BASE_URL
        );
        
        $this->erro(
            array(
                'redirect'  =>  FALSE
            )
        );
        
        Common::printJson($return);
        return;
        
        /*
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($return, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();  
                
        return; 
        */
    }
    
    /**
     *PRIVATES
     **/
     
    private function emAtualizacao(){
        
        if(
            !$this->config->item('em_atualizacao')
            ||
            in_array($_SERVER['REMOTE_ADDR'],$this->config->item('ips_atutorizados_em_atualizacao'))
            ){ 
            return TRUE;
        } 
        
        echo 'Sistema em atualização...'; exit;
        
        
    }
    
    private function initModules(){
        
        $this->modules->initialize();
        $this->modules->initializeAfterAllModules();
        
        
    }
    private function preLoad(){
                
        $this->load->library('data');   
        
        
        $this->data->set('footerHtmlData',
            array(
                'children'  =>  array()
            )
        );
        
        $this->data->set('footer',
            array(
                'nodes' =>  array(
                    array(
                        'text'      =>  $this->config->item('alias','sistema') . ' - ' . $this->config->item('name','sistema')
                    ),
                    array(
                        'text'      =>  'Versão: ' . $this->config->item('version','sistema')
                    )
                )
            )
        );  
       
        $arrLibraries = array(
            'template',
            'make_bread',
            'html',
            'session',
            'auth',
            'json',
            'common',
            'modules',
            'arrays',
            'database',
            'UUID',
            'variables',
            'session',
            'encryption',
            'parser',
            'mask',
            'bootstrap',
            'bsform',
            'dataitems',
            'filter',
            'validation',
            'CILogViewer',
            //'email',
            //'PHPExcel',
            //'Pdf'
            
        );
                
        foreach($arrLibraries as $library){
            $this->load->library($library);    
        }
        
        
        $arrModules = array(
            'console',
            'users',
        );
        
        $this->modules->initialize(
            array(
                'modules'       =>  $arrModules
            )
        ); 
                
    }
   
}
