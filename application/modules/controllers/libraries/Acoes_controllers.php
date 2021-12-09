<?php

/**
 * @author Tony Frezza
 */


class Acoes_Controllers extends Cadastros{
    
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        $this->CI->config->load('../modules/controllers/config/acoes_controllers',TRUE);
        
        parent::__construct(
            array(
                'module'            =>  'controllers',
                'uri_segment'       =>  $this->CI->config->item('uri_segment','acoes_controllers'),
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('acoes_controllers'),
                'data_file'         =>  'data_acoes_controllers',
                'item'              =>  $arrProp['item'] ?? NULL,
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