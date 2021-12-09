<?php

/**
 * @author Tony Frezza
 */


class Users extends Cadastros{
    
    public $CI; 
     
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        require_once(dirname(__FILE__).'/Profiles_users.php');
        
        parent::__construct(
            array(
                'module'            =>  'users',
                'uri_segment'       =>  $this->CI->config->item('uri_segment','users'),
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('users'),
                'data_file'         =>  'data_users',
                'item'              =>  $arrProp['item'] ?? NULL,
            )
        );   
    }
    
    public function change_password($newPassword){
        
        if(!$this->get('item.value')){
            return FALSE;
        }
        
        $newPassword = password_hash($newPassword,PASSWORD_DEFAULT);
        return $this->update(
            array(
                'id'        =>  $this->get('item.value'),
                'data'      =>  array(
                    'senha' =>  $newPassword
                )
            )
        );
    }
    
    
    public function getUserGroups(){
        
        $arrFilters = array();
        
        foreach($this->variables->get('profiles')->get('value') as $rowValue){
            
            $keyProfile = array_search('user_profile',array_column($rowValue,'id'));
            
            if($keyProfile===FALSE){
                continue;
            }
            
            $arrFilters[] = array(
                'id'        =>  'id',
                'clause'    =>  'equal_integer',
                'value'     =>  (int) $rowValue[$keyProfile]['value']
            );
            
        }
        
        
        $arrReturn = array();
        
        if(!$arrFilters){
            return $arrReturn;
        }
        
        $profileUser = new Profiles_Users();
        
        $dataProfiles = $profileUser->getItems(
            array(
                'simple_get_items'   =>  TRUE,
                'filters'           =>  $arrFilters,
            )
        );
        
        
        
        foreach($dataProfiles as $profile){
            $arrReturn[] = array(
                'id'            =>  $profile['id_value'],
                'ativo'         =>  $profile['ativo_value'],
                'nome'          =>  $profile['nome_value'],
                'descricao'     =>  $profile['descricao_value'],
                'administrador' =>  $profile['administrador_value'] 
            );
        }
        
        return $arrReturn;
    }
    
    
    public function isAdmin($idUser=NULL){
        
        if($idUser){
            $user = new Users();
            $user->setItem($idUser);    
        }
        else{
            $user = $this;
        }
        
        $userGroups = $user->getUserGroups();   
        
        return in_array('t',array_column($userGroups,'administrador'));
        
    }
    
    
    public function update($arrProp = array()){
        
        $return = NULL;
        if(!($arrProp['data']??NULL)){
            $return =  parent::update($arrProp);   
        }
        else{
            $return =  $this->CI->users_model->update($arrProp);    
        }
        
        return $return;
        
    }
    /**
     * PRIVATES
     */


}

?>