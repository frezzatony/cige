<?php

/**
 * @author Tony Frezza
 */


class Controllers extends Cadastros{
    
    
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        require_once(dirname(__FILE__).'/Tipos_controllers.php');
        require_once(dirname(__FILE__).'/Acoes_controllers.php');
        require_once(dirname(__FILE__).'/Permissoes_acoes_controllers.php');
        
        parent::__construct(
            array(
                'module'            =>  'controllers',
                'uri_segment'       =>  'controllers',
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('controllers'),
                'data_file'         =>  'data_controllers',
                'item'              =>  $arrProp['item'] ?? NULL,
            )
        ); 
    }
    
    public function initModule(){
        
    }
    
    public function getControllers($arrProp = array()){
        
        $dataFile = APPPATH.'modules/'.$this->get('configs.module_path').'/config/data_controllers.php';'';
        
        $arrConfigs = array(
            'data'          =>  require $dataFile,
            'group_by_id'   =>  TRUE,
            'filters'       =>  $arrProp['filters'] ?? NULL,
            'order'         =>  $arrProp['order'] ?? array(
                array(
                    'column'    =>  'descricao_singular',
                    'dir'       =>  'ASC',
                )
            )
        );
        
        $dataitems = new DataItems($arrConfigs);
        
        $arrData = $dataitems->getItems();
        
        return $arrData;
        
    }
    
    public function getControllerActions($arrProp = array()){
        
        $dataFile = APPPATH.'modules/'.$this->get('configs.module_path').'/config/data_acoes_controllers.php';'';
        
        $arrConfigs = array(
            'data'          =>  require $dataFile,
            'group_by_id'   =>  TRUE,
            'filters'       =>  $arrProp['filters'] ?? NULL,
            'order'         =>  $arrProp['order'] ?? array(
                array(
                    'column'    =>  'descricao',
                    'dir'       =>  'ASC',
                )
            )
        );
        
        $dataitems = new DataItems($arrConfigs);
        
        $arrData = $dataitems->getItems();
        
        return $arrData;
        
    }
    
    //retorna um objeto do tipo do controller
    public function getControllerObject($arrProp = array()){
        
        //controller do tipo Gestao do Sistema
        if($this->variables->get('tipo.value')==3){
            
            $arrControllerName =  explode('/',$this->variables->get('controller.value'));
            $controllerName = end($arrControllerName);
            
            if(!$controllerName){
                $arrControllerName =  explode('/',$this->variables->get('url.value'));
                $controllerName = end($arrControllerName);
            }
            
            if(class_exists($controllerName)){
                return new $controllerName();
            }
            
                        
            exit;
            return FALSE;        
        }
        
        $tipoController = new Tipos_Controllers(
            array(
                'item'      =>  $this->variables->get('tipo.value'),
            )
        );
        
        $arrControllerName =  explode('/',$tipoController->variables->get('modulo_codigofonte.value'));
        $controllerName = end($arrControllerName);
        
        if(class_exists($controllerName)){
            
            return new $controllerName(
                array(
                    'request'   =>  $this->get('item.value'),
                )
            );
        }
        
        print_r('aqui:2'); exit;
        return FALSE;   
        
    }
    
    
    public function getTiposControllers($arrProp = array()){
        return $this->CI->controllers_model->getTiposControllers($arrProp);
    }
    
    
    
    /**
     * PRIVATES
     */
    
}

?>