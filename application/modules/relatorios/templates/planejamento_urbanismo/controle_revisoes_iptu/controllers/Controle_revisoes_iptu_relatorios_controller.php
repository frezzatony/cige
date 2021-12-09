<?php

/**
 * @author Tony Frezza
 */


class Controle_revisoes_iptu_relatorios_controller extends Data{
    
    private $relatorio;
    
    function __construct(Relatorios $relatorio){
        
        parent::__construct();
        $this->relatorio = $relatorio;
        
    }
    
    
    public function index(){
        
        return $this->default();
        
    }
    
    public function default(){
        
        
        $this->main_model->erroPermissao();
        
    }
    
    public function ficha_abertura(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->relatorio->runActionUserPermissions(
            array(
                'action'            =>  114,//id da ação pertinente
            )
        )){            
            $this->CI->main_model->erroPermissao();
        }
        
        if(!(int) $this->CI->input->get_post('id')){
            $this->CI->main_model->erro();
        }
        
        $idCadastro = (int) $this->CI->input->get_post('id');
        
        $cadasro = new Cadastros(
            array(
                'request'   =>  62,
                'item'      =>  $idCadastro,
            )
        );
        
        $viewData = array_merge(
            $this->get('view_data'),
            array(
                'cadastro'  =>  $cadasro,
            )
        );
              
        $viewHtml =  $this->CI->template->load('relatorios','relatorios/templates/planejamento_urbanismo/controle_revisoes_iptu','FichaAbertura_view',$viewData??NULL,TRUE);
               
        
        
        echo $viewHtml; 
                
    }
    
    
    /**
     * PRIVATES
     **/
    
}

?>