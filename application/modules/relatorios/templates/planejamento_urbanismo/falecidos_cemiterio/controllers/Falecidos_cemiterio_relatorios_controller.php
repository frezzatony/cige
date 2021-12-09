<?php

/**
 * @author Tony Frezza
 */


class Falecidos_cemiterio_relatorios_controller extends Data{
    
    private $relatorio;
    
    function __construct(Relatorios $relatorio){
        
        parent::__construct();
        $this->relatorio = $relatorio;
        
    }
    
    
    public function index(){
        
        return $this->default();
        
        
    }
    
    public function default(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->relatorio->runActionUserPermissions(
            array(
                'action'            =>  103,//id da ação pertinente
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $htmlBody = new Html();
        
        
        
        include(dirname(__FILE__).'/../data/formRelatorio.php');
        $formRelatorio = $getFormRelatorio();
        
        $htmlBody->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('padding-10'),
                'children'  =>  array(
                    $formRelatorio['form']
                ) 
            )
        );
        
        
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
                
        $buttonsHtmlData = $this->relatorio->getButtonsController(
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
            'title'         =>  'Relatório | Falecidos por cemitério',
            'body'          =>  $htmlBody->getHtml(),
            'footer'        =>  $htmlFooter->getHtml(),
            'modal_size'    =>  'sm'
        );
    }
    
    
    
    /**
     * PRIVATES
     **/
    
}

?>