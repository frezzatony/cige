<?php

/**
 * @author Tony Frezza
 */


class Tabs_Bootstrap_Template_Horizontal extends Component_Bootstrap{
    
    public function getHtmlData($node){
        
        if(!($node['nodes']??NULL)){
            return NULL;
        }
        
        $node['class'] = $node['class'] ?? array();
        
        $tabContentClass = array('tab-content');
        $arrReturn = array(
            'tag'       =>  'div',
            'class'     =>  append($node['class'],array('bordered_tabs','tabs','col-lg-24')),
            'children'  =>  array(
                array(
                    'tag'       =>  'ul',
                    'class'     =>  array('nav','nav-tabs'),
                    'children'  =>  array()
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  append($tabContentClass,$node['tab_content_class']??NULL),
                    'children'  =>  array()
                )
            )
        );
        
        $navTabs = &$arrReturn['children'][0]['children'];
        $navContents = &$arrReturn['children'][1]['children'];
        
        
        foreach($node['nodes'] as $key => $item){
            
            $navLink = $item['tab'];
            
            $navLink['data-pane'] = ($item['tab']['data-pane'] ?? random_string());
            $navLink['class'] = $navLink['class'] ?? array();
            append($navLink['class'],array('nav-item','inline',(($item['active']??NULL) ? 'active' : '')));
            
            
            $navTabs[] = array(
                'tag'       => 'li',
                'class'     =>  $navLink['class'],
                'children'  =>  array(
                    array(
                        'tag'       =>  'a',
                        'class'     =>  array('nav-link',),
                        'data-pane' =>  $navLink['data-pane'],
                        'href'      =>  $navLink['href'] ?? NULL,
                        'text'      =>  $navLink['text'] ?? NULL,
                    ),
                ) 
            );
            
            $navPane = $item['pane'];
            $navPane['class'] = $navPane['class'] ?? array(); 
            append($navPane['class'],
                array(
                    'tab-pane','nopadding','nomargin','container-fluid',
                    (($item['active']??NULL) ? '' : 'softhide')
                )
            );
            
            $navContents[] = array(
                'tag'       =>  'div',
                'id'        =>  ($navPane['id']??NULL),
                'class'     =>  $navPane['class'],
                'data-pane' =>  $navLink['data-pane'],
                'text'      =>  $navPane['text'] ?? NULL,
                'style'     =>  $navPane['style'] ?? NULL,
                'children'  =>  $navPane['children'] ?? NULL,
            );
        }
        
        return $arrReturn;        
    }    
}

?>