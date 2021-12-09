<?php

/**
 * @author Tony Frezza
 */


class Accordion_Bootstrap extends Component_Bootstrap{
    
    public function getHtmlData($node){
        
        
        $this->init($node);
        $arrReturn = array(
            'tag'       =>  'div',
            'class'     =>  $node['class'],
            'children'  =>  array()  
        );
        
        
        
        
        foreach($node['nodes']??array() as $key => $childNode){
            
            $arrReturn['children'][] = array(
                'tag'       =>  'div',
                'class'     =>  $childNode['header']['class'],
                'text'      =>  $childNode['header']['title']??NULL,
            );
            
            $arrReturn['children'][] = array(
                'tag'       =>  'div',
                'class'     =>  $childNode['content']['class'],
                'text'      =>  $childNode['content']['text']??NULL,
            );
        }
        
        return $arrReturn;
        
    }  
    
    /**
     * PRIVATEs
     **/
    
    private function init(&$node){
        
        $node['class'] = $node['class'] ?? array();
        append($node['class'],array('card','col-lg-24','accordion','nopadding','nomargin'));
        
        if($node['multiple']??NULL){
            append($node['class'],array('accordion-multiple'));
            
        }
        
        if($node['nodes']??NULL){
            
            foreach($node['nodes'] as &$childNode){
                $childNode['header'] = $childNode['header'] ?? array();
                $childNode['header']['class'] = $childNode['header']['class'] ?? array();
                
                append($childNode['header']['class'],array('card-header','col-lg-24','nopadding','nomargin','nav-link'));
                
                $childNode['content'] = $childNode['content'] ?? array();
                $childNode['content']['class'] = $childNode['content']['class'] ?? NULL;
                
                append($childNode['content']['class'],array('card-header','col-lg-24','nopadding','nomargin','content'));
                
                if(!($childNode['content']['active']??NULL)){
                    append($childNode['content']['class'],array('softhide'));
                }
                
                if(($childNode['header']['active']??NULL)==TRUE){
                    append($childNode['header']['class'],array('active'));
                }
                
                       
            }
        }
        
        return $this;
    }  
}

?>