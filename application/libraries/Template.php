<?php 

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template extends Data{
        
    function __construct(){
        
        parent::__construct();
        
        $this->set('plugins',array());
        $this->set('css_paths',array());
        $this->set('css',array());
        $this->set('js_paths',array());
        $this->set('js',array());
    }
    
    
    function load($template = '', $module=NULL, $view = '', $view_data = array(), $return = FALSE){
        
        $this->set('breadcrumb',$this->CI->make_bread->output());
        $this->set('system_alias', $this->CI->config->item('alias','sistema'));
        $this->set('system_name', $this->CI->config->item('name','sistema'));
        $this->set('system_version', $this->CI->config->item('version','sistema'));
        
        $this->set('empresa', $this->CI->config->item('empresa','sistema'));
        
        $html = new Html();
        $html->add($this->CI->data->get('footerHtmlData'));
        $this->set('footerHtml',$html->getHtml());
        $this->set('footer',$this->CI->data->get('footer'));
        
        if($view_data){
            $this->set($view_data);
        }
        
        $this->set('contents', $this->CI->load->view($view, $this->get(), TRUE,$module));
        
        if($this->get('messages')){
            
            foreach(Json::getFullArray($this->get('messages')) as $message){
                
                $string = "\n\t\t\t\t";
                
                switch($message['type']){
                    case 'success':{
                        $type = 'success';
                        break;
                        
                    }
                    default:{
                        $type = 'error';
                        break;
                    }
                }
                
                $string .= '_'.$type.'Message(\''.$message['message'].'\');';
                
                
                $this->append('javascript',$string);
            }
        }
        
        if($return){
            return $this->CI->load->view('templates/' . $template . '/template', $this->get(), $return);    
        }
        
        $this->CI->load->view('templates/' . $template . '/template', $this->get(), $return);
         
    }
    
    function loadCss($cssPath){
        
        if($cssPath AND is_array($cssPath)==FALSE){
            $cssPath = array(
                'path'  =>   $cssPath
            );
        } 
        
        
        if(strtoMINusculo(substr($cssPath['path'],-4)) != '.css'){
            $cssPath['path'] .= '.css';
        }       
        
        if(in_array($cssPath['path'],array_column($this->get('css'),'path'))===FALSE){
            
            $css = $this->get('css');
            $css[] = $cssPath;
            $this->set(array('css'=>$css));

        }
    }
    
    function loadJs($jsPath){
        
        if($jsPath AND is_array($jsPath)==FALSE){
            $jsPath = array(
                'path'  =>   $jsPath
            );
        } 
        
        if(in_array($jsPath['path'],array_column($this->get('js'),'path'))===FALSE){
            $js = $this->get('js');
            $js[] = $jsPath;
            $this->set(array('js'=>$js));

        }
        
         
    }
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */
