<?php

/**
 * @author Tony Frezza
 */


class Tabs_Bootstrap extends Component_Bootstrap{
    
    public function getHtmlData($node){
        
        
        $template = ucfirst($node['template'] ?? 'Horizontal');
        
        $directory = dirname(__FILE__).'/Tabs/';
        require_once($directory.'/Template_'.$template.'.php');
        
        $className = 'Tabs_Bootstrap_Template_'.$template;
        
        $template = new $className($node);
        
        $htmlData = $template->getHtmlData($node);
        
        return $htmlData;       
        
    }    
}

?>