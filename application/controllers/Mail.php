<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

    function __construct(){
        
        parent::__construct();
        
        $this->auth_model->login();
                
    }
    
    function index(){           
        /*
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => '192.168.4.3',
            'smtp_port' =>  25,
            'smtp_user' => 'tony@saobentodosul.sc.gov.br',
            'smtp_pass' => 'tf23a3',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        
                       
        $this->email->from('tony@saobentodosul.sc.gov.br', 'Your Name');
        $this->email->to('tony@saobentodosul.sc.gov.br');
        
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        
        $this->email->send();
        */
    }
    
    
    
}
