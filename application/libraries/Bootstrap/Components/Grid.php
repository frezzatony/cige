<?php

/**
 * @author Tony Frezza

 */


class Grid_Bootstrap extends Component_Bootstrap{
    
    public function __construct() {
        parent::__construct();
    }

    
    public function getHtmlData($node){
        
        $template = $node['template'] ?? 1;
        
        $directory = dirname(__FILE__).'/Grid/';
        require_once($directory.'/Template_'.$template.'.php');
        
        $className = 'Grid_Bootstrap_Template_'.$template;
        
        $template = new $className($node);
        
        $htmlData = $template->getHtmlData();
        
        return $htmlData;
        
    }
        
}

?>