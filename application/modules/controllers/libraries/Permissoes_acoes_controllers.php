<?php

/**
 * @author Tony Frezza
 */


class Permissoes_Acoes_Controllers extends Cadastros{
       
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        $this->CI->config->load('../modules/controllers/config/permissoes_acoes_controllers',TRUE);
        
        parent::__construct(
            array(
                'module'            =>  'controllers',
                'uri_segment'       =>  $this->CI->config->item('uri_segment','permissoes_acoes_controllers'),
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('permissoes_acoes_controllers'),
                'data_file'         =>  'data_permissoes_acoes_controllers',
                'item'              =>  $arrProp['item'] ?? NULL,
            )
        ); 
    }
    
    
    /**
     * PRIVATES
     **/
    
    
}

?>