<?php

/**
 * @author Tony Frezza

 */


class Common{

    private $CI;
    private $arrFilters = array(
        'form'
    );
    
    function __construct()
    {

        $this->CI = &get_instance();
    }
    
    public function append($source,$append,$delimiter = ' '){
        
        
        if(is_null($source)){
            $source = '';
        }
        
        if(is_array($source)){
            if(is_array($append)){
                $source = array_merge($source,$append);    
            }
            else{
                
                $source[] = $append;
            }
            
        }
        else if(is_string($source) AND is_array($append)){
            $append = implode($delimiter,$append);
            
            $source .= $delimiter .$append;
                
        }
        else{
            
            $source .= $delimiter .$append;
        }
        
        return $source;
        
    }
    
    function getBuildTree(array &$elements, $parentId = NULL) {
        
        $tree = array();
    
        foreach ($elements as $key => $element) {
            if ($element['id_item_pai'] == $parentId){
                $children = self::getBuildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $tree[$element['id']] = $element;
                unset($elements[$key]);
            }
        }
        return $tree;
    }
    
       
    public function getDataFromArrayObject($key,$objArray){
        
        if(is_object($objArray)){
            return $objArray->get($key);    
        }
        else if($key !== NULL){
            return $objArray[$key] ?? NULL;    
        }
        
        return $objArray;
        
    }
    
    public function getDataFromMethod($arrProp = array()){
        
        $moduleName = explode('.',$arrProp['path'])[0];
        $objectName = $moduleName.'_get_data';
        
        $methodName = $this->CI->data->getRegiterData($arrProp['path'])['method'];
        
        $this->CI->load->library('../modules/'.$moduleName.'/libraries/Get_data_'.$moduleName,NULL,$objectName);
        
        return $this->CI->{$objectName}->{$methodName}($arrProp);
           
    }
    
    public function getJqueryJavascript($js){
        
        $javascript = "\n\t";
        $javascript .= 'jQuery(window).ready(function(){';
        $javascript .= "\n\t\t";
        $javascript .= $js;
        $javascript .= "\n\t";
        $javascript .= '});';
        
        
        return $javascript;
        
    }
    public function getTemplate($arrProp = array()){
        
        $path = '';
        
        $template = $arrProp['template'] ?? 'padrao';
        if($this->CI->data->get('get.from') OR $this->CI->data->get('post.from')){
            $template = 'ajax';
        }
        
        if($this->CI->data->get('get.modal') OR $this->CI->data->get('post.modal')){
            $template = 'modal';
        }
        
        $arrReturn = array(
            'template'  =>  $template,
            'path'      =>  $path,
            'view'      =>  'Main_view'  
        );
        
        return $arrReturn;
    }
    
    public function getUnbuildTree($arrTree = array(),$parentId = NULL){
        $arrReturn = array();
        
        foreach($arrTree as $key => $node){
            $node['parent_id'] = $parentId;
            $node['order'] = $key;
            $children = $node['children'] ?? NULL;
            unset($node['children']);
            
            $arrReturn[] = $node;
            if($children){
                $arrReturn = array_merge(
                    $arrReturn,
                    self::getUnbuildTree($children,($node['id'] ?? NULL))
                );
            }
        }
        
        return $arrReturn;
        
    }
    
    
    public function getUrlFromConfig($arrProp = array()){

        $url = $this->CI->config->item('url_'.$arrProp['url'], $arrProp['config']);

        return $this->CI->parser->parse_string($url, $arrProp,TRUE);

    }
    
   
    public static function printJson($response = array(),$status=200,$exit = FALSE){
        
        $output = new CI_Output;
        
        $output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();  
        
        if($exit){
            exit;    
        }        
        
       return; 
    }
    
    public static function requireController($arrProp = array()){
        
        $directory = APPPATH.'modules/'.($arrProp['module']).($arrProp['path_templates']).'/controllers';
        $controllerName = ($arrProp['controller']);
        
        $file =  ucfirst($controllerName).($arrProp['template_sufix']);
        
        if(file_exists($directory.'/'.$file.'.php')){
            require_once($directory.'/'.$file.'.php');
            return $file;    
        }
        
        echo 'CONTROLLER NAO LOCALIZADO: ' . $directory.'/'.$file.'.php'; exit;
        return FALSE;
        
    }
    
    /**
     * PRIVATES
     **/


}

?>