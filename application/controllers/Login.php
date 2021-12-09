<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        
    }
    
    public function index(){ //verifica se existe um metodo com o parametro solicitado
    	    
        if (method_exists(get_class($this), $this->router->class)) {
            $this->{$this->router->class}();
        } else {
            $this->padrao();
        }
    }
    
    private function padrao(){
        
        if($this->auth->logged_in()){
            redirect(BASE_URL, 'refresh');    
        }
        else{
            $this->template->load('login',NULL,'login/Login_view');   
        } 
    }
    
    
    public function erro(){
        
        $this->template->set('erro',true);
        $this->template->load('login',NULL,'login/Login_view');  
    }
    
    public function logout(){
                
        $this->auth->logout();
        
        $this->session->sess_destroy();
                            
        redirect(BASE_URL.'login', 'refresh');
    
    }
   
    
    private function esqueci_a_senha(){
        
        echo 'senha'; exit;
        
        
    }
    
}
