<?php

/**
 * @author Tony Frezza
 */


class Logradouros_relatorios_controller extends Data{
    
    private $relatorio;
    
    function __construct(Relatorios $relatorio){
        
        parent::__construct();
        $this->relatorio = $relatorio;
        
    }
    
    
    public function index(){
        
        return $this->default();
        
    }
    
    public function default(){
        
        
        $this->CI->main_model->erroPermissao();
        
    }
    
    public function completo(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->relatorio->runActionUserPermissions(
            array(
                'action'            =>  115,//id da ação pertinente
            )
        )){            
            $this->CI->main_model->erroPermissao();
        }
        
        
                
    }
    
    
    /**
     * PRIVATES
     **/
    
}

?>