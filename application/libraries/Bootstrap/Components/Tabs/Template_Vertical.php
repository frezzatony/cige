<?php

/**
 * @author Tony Frezza
 */

class Tabs_Bootstrap_Template_Vertical extends Component_Bootstrap{
    
    public function getHtmlData($node){
        
        if(!($node['nodes']??NULL)){
            return NULL;
        }
        
        $arrDefaultListGroupCol = array(
            'lg'    =>  5,
            'md'    =>  5,
            'sm'    =>  12,
            'xs'    =>  12  
        );
        
        $keyActiveTab = array_search(TRUE,array_column($node,'active'));
        if($keyActiveTab===FALSE){
            $node[0]['active'] = TRUE;
        }
        
        $node['class'] = $node['class'] ?? array();
        
        $node['tabs_class'] = $node['tabs_class'] ?? array();       
        append($node['tabs_class'],
            array(
                'list-group','nav-tabs','border-bottom','padding-top-20','text-right',
                'col-lg-' . ($node['tab_group_col']['lg'] ?? $arrDefaultListGroupCol['lg']),
                'col-md-' . ($node['tab_group_col']['md'] ?? $arrDefaultListGroupCol['md']),
                'col-sm-' . ($node['tab_group_col']['sm'] ?? $arrDefaultListGroupCol['sm']),
                'col-xs-' . ($node['tab_group_col']['xs'] ?? $arrDefaultListGroupCol['xs']),
                'nomargin','nopadding',
            )
        );
        
        $node['tab_content_class'] = $node['tab_content_class'] ?? array();
        append($node['tab_content_class'],
            array(
                'tab-vertical-content',
                'col-lg-'. ($node['tab_content_col']['lg'] ?? (BOOTSTRAP_COLS-(($node['tab_group_col']['lg'] ?? $arrDefaultListGroupCol['lg'])))),
                'col-md-'. ($node['tab_content_col']['md'] ?? (BOOTSTRAP_COLS-(($node['tab_group_col']['md'] ?? $arrDefaultListGroupCol['md'])))),
                'col-sm-'. ($node['tab_content_col']['sm'] ?? (BOOTSTRAP_COLS-(($node['tab_group_col']['sm'] ?? $arrDefaultListGroupCol['sm'])))),
                'col-xs-'. ($node['tab_content_col']['xs'] ?? (BOOTSTRAP_COLS-(($node['tab_group_col']['xs'] ?? $arrDefaultListGroupCol['xs'])))),
                'nomargin','nopadding'
            )
        );
        
        $arrReturn = array(
            'tag'       =>  'div',
            'class'     =>  append($node['class'],array('tabs','col-lg-24','nopadding','nomargin')),
            'children'  =>  array(
                array(
                    'tag'       =>  'div',
                    'class'     =>  $node['tabs_class'],
                    'children'  =>  array()
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  $node['tab_content_class'],
                    'children'  =>  array()
                )
            )
        );
        
        $navTabs = &$arrReturn['children'][0]['children'];
        $navContents = &$arrReturn['children'][1]['children'];
        
        
        foreach($node['nodes'] as $key => $item){
            
            $navLink = $item['tab'];
            
            $navLink['data-pane'] = $navLink['data-pane'] ?? random_string();
            $navLink['class'] = $navLink['class'] ?? array();
            
            append($navLink['class'],
                array(
                    'list-group-item','size-11', (($item['active']??NULL) ? 'active' : '')   
                )
            );
            
            $navTabs[] = array(
                'tag'       =>  'div',
                'class'     =>  array('col-lg-24','nomargin','nopadding','nav-item',),
                'children'  =>  array(
                    array(
                        'tag'       =>  'a',
                        'class'     =>  $navLink['class'],
                        'data-pane' =>  $navLink['data-pane'],
                        'href'      =>  $navLink['href'] ?? NULL,
                        'text'      =>  $navLink['text'] ?? NULL,
                        'children'  =>  $navLink['children'] ?? NULL,   
                    )
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
            
            $navPane['style']  = $navPane['style'] ?? array();
            append($navPane['style'],' overflow-y: auto; scrollbar-width: thin;');
            
            
            $navContents[] = array(
                'tag'       =>  'div',
                'id'        =>  ($navPane['id']??NULL),
                'class'     =>  $navPane['class'],
                'data-pane' =>  $navLink['data-pane'],
                'text'      =>  $navPane['text'] ?? NULL,
                'style'     =>  $navPane['style'],
                'children'  =>  $navPane['children'] ?? NULL,
            );
        }
        
        return $arrReturn; 
        
    }
    
}

?>