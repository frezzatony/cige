<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/Grid/'.'Grid_bsForm_defaults.php');

class Grid_bsform extends Grid_bsForm_defaults{

    
    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array());

    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
        
        $template = $arrInput['template'] ?? '1';
        
        $directory = dirname(__FILE__).'/Grid/';
        require_once($directory.'Templates/'.$template.'.php');
        
        $className = 'Grid_BsFormTemplate_'.$template;
        
        $template = new $className($arrInput);
        
        $htmlData = $template->getHtmlData();
        
        return $htmlData;
    }
    
    /**
     * PRIVATES
     */
}

?>