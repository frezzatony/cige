<?php

/**
 * @author Tony Frezza

 */


class Bsform_javascript extends Data{
    
    
    function __construct($arrProp = array()){
        
        parent::__construct($arrProp);
    
    }
    
    public function getJsOnUpdate($arrInput){
        
        $inputJs = '';
        foreach($arrInput['update_on'] as $action){
            $arrSelectors = explode('.',$action['selector']);
            
            $jsCall = "\t".$this->getStrInputSelector($arrInput);
            foreach($arrSelectors as $selector){
                
                if($jsCall){
                    $jsCall .= '.';
                }
                
                switch($selector){
                    case 'form':{
                        $jsCall .= $this->getStrSelectorForm();
                        break;
                    }
                    case 'body':{
                        $jsCall .= $this->getStrSelectorBody();
                        break;
                    }
                    default:{
                        $jsCall .= $this->getStrSelectorElement($selector);
                        break;
                    }
                }        
            }
            
            $jsCall .= '.bind(\''.$action['bind'].'\',function(e){';
            $jsCall .= "\n\t\t";
            $jsCall .= $this->getStrInputSelector($arrInput).'.'.$this->getStrSelectorForm().'.bsform({
                \'method\'      :   \'ajaxUpdateOptions\',
                \'input_id\'    :   \''.$arrInput['id'].'\',
                \'token\'        :   \''.$arrInput['data-token'].'\'
            });';
            $jsCall .= "\n\t";
            $jsCall .= '});';
            $inputJs .= "\n".$jsCall;
        }
        
        return $inputJs;
            
    }
    
    /**
     * PRIVATES
     **/
     private function getStrInputSelector($arrInput){
        
        return '$(\'#'.$this->get('id').'\').find(\'#'.$arrInput['id'].'\')' ;
     }
     private function getStrSelectorBody(){
        return 'closest(\'div.bsform-body\')';
     }
     private function getStrSelectorElement($selector){
        return 'find(\''.$selector.'\')';
     }
     private function getStrSelectorForm(){
        return 'closest(\'div.bsform\')';
     }
    
    
    
    
}

?>