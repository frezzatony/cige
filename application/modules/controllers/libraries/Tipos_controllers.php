<?php

/**
 * @author Tony Frezza

 */


class Tipos_Controllers extends Cadastros{
    
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        $this->CI->config->load('../modules/controllers/config/tipos_controllers',TRUE);
        $this->CI->load->model('../modules/controllers/models/tipos_controllers_model');
        
        parent::__construct(
            array(
                'module'            =>  'controllers',
                'uri_segment'       =>  'controllers/tipos-controllers',
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('tipos_controllers'),
                'data_file'         =>  'data_tipos_controllers',
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