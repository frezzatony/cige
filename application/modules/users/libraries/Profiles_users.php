<?php

/**
 * @author Tony Frezza

 */


class Profiles_Users extends Cadastros{
    
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        $this->CI->config->load('../modules/users/config/profiles_users',TRUE);
        
        parent::__construct(
            array(
                'module'            =>  'users',
                'uri_segment'       =>  $this->CI->config->item('uri_segment','profiles_users'),
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('profiles_users'),
                'data_file'         =>  'data_profiles_users',
                'item'              =>  $arrProp['item']?? NULL,
            )
        ); 
        
    }
    
    public function initModule(){
        
    }
     
    /**
     * PRIVATES
     */
    
}

?>