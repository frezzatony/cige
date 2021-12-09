<?php

/**
 * @author Tony Frezza

 */


class Entidades extends Cadastros{
    
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        parent::__construct(
            array(
                'module'            =>  'entidades',
                'uri_segment'       =>  $this->CI->config->item('uri_segment','entidades'),
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('entidades'),
                'data_file'         =>  'data_entidades',
                'item'              =>  $arrProp['item'] ?? NULL
            )
        ); 
        
        $this->set('id',$this->get('data.id_controller'));
    }
    
    public function initModule(){
        
    }
    
    /*
    public function setItem($arrProp = array()){
        
        $this->set($this->CI->entidades_model->getentidades($arrProp)[0]);

        return $this;
    }
    */
      
    /**
     * PRIVATES
     */


}

?>