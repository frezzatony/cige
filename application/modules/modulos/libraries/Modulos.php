<?php

/**
 * @author Tony Frezza
 */


class Modulos extends Cadastros{
    
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        $this->CI->config->load('../modules/modulos/config/modulos',TRUE);
        
        parent::__construct(
            array(
                'module'            =>  'modulos',
                'uri_segment'       =>  $this->CI->config->item('uri_segment','modulos'),
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('modulos'),
                'data_file'         =>  'data_modulos',
                'item'              =>  $arrProp['requests_id'][0] ?? NULL,
            )
        ); 
    }
    
    public function initModule(){
        
        $arrTemplate = $this->CI->common->getTemplate();
        
        if(
            !$this->CI->auth->logged_in() OR //Somente válido se estiver loggado
            $arrTemplate['template'] != 'padrao'){
            return FALSE;    
        }
        
        $this->setModulosHtml();       
        
    }
    
    public function getUserModulos($arrProp = array()){
        
        return $this->CI->modulos_model->getUserModulesByMainMenu($arrProp);
        
    }
    
    
    /**
     * PRIVATES
     */
    
    private function setModulosHtml(){
        
        //adiciona o botão ao Footer
        $this->CI->data->prepend('footer.nodes',
            array(
                'children'      =>  array(
                    
                    array(
                        'tag'       =>  'button',
                        'class'     =>  array('btn','btn-sm','btn-default','btn-modulo','nopadding','nomargin','margin-bottom-4','padding-left-6','padding-right-6'),
                        'children'  =>  array(
                            array(
                                'tag'       =>  'span',
                                'class'     =>  array('size-11'),
                                'text'      =>  'Módulo: ' . $this->CI->data->get('user.configs.modulo_descricao')
                            )
                        )
                    )  
                )
            )
        );
        
        $this->CI->template->loadJs(BASE_URL.'assets/modules/modulos/modulos.js?v='.random_string('alnum',12)); 
        
    }

}

?>