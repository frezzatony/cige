<?php

/**
 * @author Tony Frezza
 */


class Relatorios extends Cadastros{
    
    protected $CI;
    
    function __construct($arrProp = array()){
        
        parent::__construct();
        
        $this->CI->template->loadJs(BASE_URL.'/assets/modules/relatorios/relatorios.js');
        
        if($arrProp){
            
            $this->set($arrProp);
            
            $this->setRequest();
        }
        
    }
    
    public function getHtmlDataDefaultBody($arrprop = array()){
        $arrReturn = array(
            'children'      =>  array()
        );
        
        
        
        $arrReturn['children'][] = array(
            'tag'       =>  'input',
            'type'      =>  'hidden',
            'class'     =>  'container-relatorio',
            'value'     =>  random_string(),
        );
        
        return $arrReturn; 
    }
    
    public function getButtonsController($arrProp = array()){
        
        if(!$this->get('actions_user')){
            $this->set('actions_user',$this->CI->controllers_model->getControllerActionsByUser($arrProp));            
        }
        
        $arrProp['menu'] = $this->clearMenuItens(
            array(
                'menu'          =>  $arrProp['menu'],
                'user_actions'  =>  $this->get('actions_user'),
                'is_admin'      =>  $this->CI->users->isAdmin($this->CI->data->get('user.id'))
            )
        );
        
        if(!$arrProp['menu']){
            return NULL;
        }
        
        $bootstrap = new Bootstrap;
        
        foreach($arrProp['menu'] as $node){
            
            $type = $node['type'] ?? 'button';
            unset($node['type']);
            
            $bootstrap->$type($node);
        }
        
        return array(
            'html'      =>  $bootstrap->getHtmlData()  
        );
       
        
    }
    
    public function printHtml($arrProp = array()){
        
        require(__DIR__.'/Html.php');
        
        $html = new Html_Relatorios($this->get());
        if($arrProp){
            $html->set($arrProp);
        }
        
        $html->print();
    }
    
    public function printPdf($arrProp = array()){
        
        require(__DIR__.'/Pdf.php');
        
        $pdf = new PDF_Relatorios($this->get());
        if($arrProp){
            $pdf->set($arrProp);
        }
        
        $pdf->print();
    }
    
    public function printXls($arrProp = array()){
        
        require(__DIR__.'/Xls.php');
        
        $xls = new XLS_Relatorios($this->get());
        if($arrProp){
            $xls->set($arrProp);
        }
        
        $xls->print();
    }
    
    public function requireTemplateFile($arrProp = array()){
        
        return Common::requireController(
            array(
                'module'            =>  'relatorios',
                'path_templates'    =>  '/templates/'.$this->get('modulo_uri').'/'.$this->get('controller'),
                'controller'        =>  $this->get('controller'),
                'template_sufix'    =>  '_relatorios_controller',
            )
        );
    }
    
    public function runActionUserPermissions($arrProp = array()){
        
        $arrProp['user_id'] = $arrProp['user_id']?? $this->CI->data->get('user.id');
        $arrProp['entity_id'] = $arrProp['entity_id'] ?? $this->CI->data->get('user.configs.entity');
        
        if($this->CI->users->isAdmin($arrProp['user_id']??NULL)){
            return TRUE;
        }
        
        
        if(!$this->get('actions_user')){
            $arrProp['controller_id'] = $this->get('id');
            $this->set('actions_user',$this->CI->controllers_model->getControllerPermissionsByUser($arrProp));
        }
        
        return in_array($arrProp['action'],$this->get('actions_user'));
        
    }
    
    public function setRequest(){
        
        if($this->get('module')=='default' AND is_numeric($this->get('request_id'))){
            $dataRequest = $this->CI->relatorios_model->getRequests(
                array(
                    'requests_id'   =>  $this->get('request_id')
                )
            ); 
            
            if(!$dataRequest){
                return FALSE;
            }
            $controllerName = $this->get('url');
            
            $this->set($dataRequest[0]);
            
            $this->set('controller',$controllerName);
            $this->set('modulo_uri',$this->get('module'));
            
                    
        }
        else{
            $dataRequest = $this->CI->relatorios_model->getRequests($this->get());
            
            if(!$dataRequest){
                return FALSE;
            }
            
            $this->set($dataRequest[0]);     
        }
                
        
        $dataFile = 'modules/relatorios/templates/'.clearSpecialChars($this->get('module')).'/'.clearSpecialChars($this->get('url')).'/config/data.php';
        
        if(file_exists(APPPATH.$dataFile)==TRUE){
            $arrData = require APPPATH.$dataFile;
            
            foreach($arrData as $key => $val){
                
                
                if(is_array($val)){
                    $this->set('data.'.$key,
                        array_merge(
                            ($this->get('data.'.$key) ?? array()),
                            $val
                        )
                    );   
                }
                else{
                    $this->set('data.'.$key,$val);
                }
            } 
        }
        
        if(is_array($this->get('data'))){
            $arrProp = array(
                'variables' =>  $this->get('data.variables'),
                'rules'     =>  $this->get('data.rules'), 
            );
            $this->variables->set($arrProp); 
        }
         
    }
    
    
    
    /**
     * PRIVATES
     */
    
    private function clearMenuItens($arrProp = array()){
        
        if(!$arrProp['user_actions'] AND !($arrProp['is_admin']??NULL)){
            return NULL;
        }
        
        foreach($arrProp['menu'] as $key => $node){
            if($node['children']??NULL){
                $node['children'] = self::clearMenuItens(
                    array(
                        'menu'          =>  $node['children'],
                        'user_actions'  =>  $arrProp['user_actions'],
                        'is_admin'      =>  $arrProp['is_admin'] ?? NULL
                    )
                );
            }
            
            //para nao ficar um if com muitas verificacoes dentro, dividi em varios ifs
            if(!($node['action']??NULL) AND !($node['children']??NULL)){
                unset($arrProp['menu'][$key]);
            }
            
            if(is_array($node['action']??NULL) AND (!($arrProp['is_admin']??NULL))){
                $flagRemove = TRUE;
                foreach($node['action'] as $action){
                    if(in_array($action,$arrProp['user_actions'])){
                        $flagRemove = FALSE;
                    }
                }
                
                if($flagRemove){
                    unset($arrProp['menu'][$key]);
                }
                
            }
            
            else if(($node['action']??NULL) AND (!($arrProp['is_admin']??NULL) AND !is_array($node['action']??NULL) AND !in_array($node['action']??NULL,$arrProp['user_actions']))){
                unset($arrProp['menu'][$key]);
            }
            
            
            
        }
        
        return $arrProp['menu'];    
    } 
    
}

?>