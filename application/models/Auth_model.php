<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{
       
    function __construct(){
        
        // Chamar o construtor do Model
        parent::__construct();        
                           
    }
    
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
    
    
       
}
