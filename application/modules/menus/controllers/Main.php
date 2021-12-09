<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{
    
    private $arrTemplate;
    
    function __construct(){
        
        parent::__construct();
        $this->arrTemplate = $this->common->getTemplate();
                
    }
    
    
    function index(){       
        
        $this->auth_model->login();
        
        echo 'menus module';   
    }
    
    public function show_all_items(){
        
        $this->auth_model->login();
        
        //item somente para administradores
        if(!$this->users->isAdmin($this->data->get('user.id'))){
            $this->main_model->erro();
        }
        
        //somente pode ser exibido se for requisitado por modal
        $arrTemplate = $this->common->getTemplate();
        if($arrTemplate['template']!='modal'){
            $this->main_model->erro();
        }
                
        include(dirname(__FILE__).'/../data/showAllItems/treeMenu_showAllItems.php');
        
        $htmlBody = new Html($getTreeMenuHtmlData());
        
        $viewData = array(
            'title'     =>  'Todos os itens de menus',
            'body'      =>  $htmlBody->getHtml(),
        );
        
        Common::printJson($viewData);
    }
   
    /** PRIVATES **/
    
    
}
