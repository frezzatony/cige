<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Data{
    
    private $user;
    
    function __construct(){
        
        parent::__construct();
    }
    
    public function logged_in(){
        
        $logged = $this->loggedInSession();
        
        return $logged;
    }
    
    public function login($user,$password){
       
        if(!$this->setUser(NULL,$user)){
            return FALSE;
        }
        $this->user->variables->get('situacao')->set('method','database');
        if(!boolValue($this->user->variables->get('situacao')->get('value'))){
            return FALSE;
        }
        if(!$this->user->variables->get('password_user')->get('value')){
            return FALSE;
        }
        
        if(!password_verify($password,$this->user->variables->get('password_user')->get('value'))){
            return FALSE;
        }
        
        $this->setData();
        $this->setLog();
        
        return TRUE;
    }
    
    public function logout(){
        
        $this->user();
                
        $this->setLog(
            array(
                'action'    =>  'logout',
            )
        );
        
        // Destroy the session
		$this->CI->session->sess_destroy();
                
        
		// Recreate the session
		session_start();
		$this->CI->session->sess_regenerate(TRUE);
        
    }
    
    public function user($id=NULL){
                
        $dataSession = $this->CI->session->userdata('user');
        
        $id = $id ? $id : ($dataSession['id']??NULL);
        
        if($id){
            $this->setUser($id);
            $this->setData();
        }
        
        
        return $dataSession;
    }
        
    /**
     * PRIVATES
     **/
     
    private function loggedInCookie(){
        
        return FALSE;
    }
    
    private function loggedInSession(){
        
        $userData = self::user();
        return is_array($userData) AND sizeof($userData) > 0;        
    }
    
    private function setUser($id = NULL,$login = NULL){
        
        $arrFilers = array();
        
        if($id OR ($this->CI->session->userdata('user')['id']??NULL)){
            $arrFilers[] = array(
                'id'        =>  'id',
                'clause'    =>  'equal_integer',
                'value'     => (int) ($id ? $id : $this->CI->session->userdata('user')['id']),
            );
        }
        else if($login){
            $arrFilers[] = array(
                'id'        =>  'login_user',
                'clause'    =>  'equal',
                'value'     =>  $login
            );
        }
        
        if(!sizeof($arrFilers)){
            return FALSE;
        }
        
        $this->user = new Users();
        $arrData = $this->user->getItems(
            array(
                'simple_get_items'   =>  TRUE,
                'filters'           =>  $arrFilers
            )
        );
        if(!sizeof($arrData)){
            return FALSE;
        }
        
        $this->user->setItem($arrData[0]);
        
        return TRUE;
    }
    
    private function setData(){
        
        $arrData = array(
            'id'        =>  $this->user->variables->get('id')->get('value'),
            'username'  =>  $this->user->variables->get('login_user')->get('value'),
            'nome'      =>  $this->user->variables->get('nome')->get('value'),
            'configs'   =>  $this->user->variables->get('configs')->get('value'),
        );
        
        $this->CI->session->set_userdata('user',$arrData);
        $this->set($arrData);
        
        return TRUE;
    }
    
    private function setLog($arrProp = array()){
        
        return $this->CI->logger->setLog(
            array(
                'schema'        =>  'sistema_logs',
                'table_log'     =>  'sistema_logins',
                'column_pk'     =>  'usuarios_usuarios_id',
                'action'        =>  $arrProp['action'] ?? 'login',
                'item_id'       =>  $this->CI->auth->get('id'),
                'data'          =>  array(
                    'ip'            =>  $_SERVER['REMOTE_ADDR'] ?? NULL,
                ),
            )
        );
             
            
    }
    
    
    private function smtpAuth(){
        
        
    }
    
}

?>