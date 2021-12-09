<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');



class Emails_cadastros_controller extends Data{
    
    private $cadastro;
    
    function __construct(Cadastros $cadastro){
        parent::__construct();
        
        $this->set('template',$this->CI->common->getTemplate());
        
        $this->cadastro = $cadastro;         
    }
    
    public function index(){
        
        return $this->default();
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
    
    public function arquivo(){
        
        
        
        $arrData = $this->cadastro->getItems(
            array(
                'order'             =>  array(
                    array(
                        'column'    =>  'login',
                        'dir'       =>  'ASC',
                    )
                ),
                'simple_get_items'  =>  TRUE
            )
        );
        
        
        foreach($arrData as $row){
            
            $pwd = $row['pass_value'];
        
            $ciphering = "AES-128-CTR";
            $decryption_iv = '1234567891011121';
            $options = 0;
            $decryption_key = "GeeksforGeeks";
              
            
            $pwd =openssl_decrypt ($pwd, $ciphering, 
                    $decryption_key, $options, $decryption_iv);
            
            
            echo '192.168.4.3;'.$row['login_value'].'@saobentodosul.sc.gov.br;'.$pwd.';192.168.4.254;'.$row['login_value'].'@saobentodosul.sc.gov.br;'.$pwd.';';
            echo "\n";
        }
        
        
    }    
            
}
