<?php

/**
 * @author Tony Frezza
 */


class Breadcrumb_Bootstrap extends Component_Bootstrap{
    
        
    public function getHtmlData($node){
        
        
        $breadClass = array();
        append($breadClass,$node['class']??array());
        
        
        $arrReturn = array(
            'tag'       =>  $node['tag_breadcrumb'] ?? 'ol',
            'class'     =>  $breadClass,
            'children'  =>  array(),
        );
        
        $arrReturn['children'][] = $this->getHomeNode($node);
               
        foreach($node['nodes']??array() as $breadNode){
            $arrReturn['children'][] = $this->getNode($breadNode);
        }
        
        return $arrReturn;
    }
    
    /**
     * PRIVATES
     **/
    
    private function getHomeNode($node){
        
        if(($node['include_home']??TRUE)){
            
            return $this->getNode(
                array(
                    'href'      =>  $node['home_href']??NULL,
                    'text'      =>  '<i class="fa fa-home"></i>'
                )
            );
        }        
    }
    
    private function getNode($arrNode){
        
        $arrNode['class']  = $arrNode['class'] ?? array();
        append($arrNode['class'],array('breadcrumb-item'));
        
        $arrReturn = array(
            'tag'       =>  'li',
            'class'     => $arrNode['class'],
        );
        
        if(!($arrNode['href']??NULL)){
            $arrReturn['children'] = array(
                array(
                    'tag'       =>  'span',
                    'text'      =>  $arrNode['text'] ?? NULL,
                    'children'  =>  $arrNode['children'] ?? NULL,
                )
            );
        }
        else{
            $arrReturn['children'] = array(
                array(
                    'tag'       =>  'a',
                    'href'      =>  $arrNode['href'],
                    'text'      =>  $arrNode['text'] ?? NULL,
                    'children'  =>  $arrNode['children'] ?? NULL,
                )
            );
        }
        
        return $arrReturn;
    }
}

?>