<?php

/**
 * @author Tony Frezza

 */


class Button_dropdown_Bootstrap extends Component_Bootstrap{
    
    
    function __construct(){
        parent::__construct();
    }
    public function getHtmlData($node){
        
        
        $arrReturn = array(
            'tag'       =>  'div',
            'class'     =>  array('btn-group'),
            'children'  =>  array(
                $this->getButtonParent($node),
                $this->getMenu($node)
            ),
            'parent_id' =>  $node['parent_id']??NULL
        );
        $this->getId($node,$arrReturn);
               
        
        return $arrReturn;
        
    }
    
    /**
     * PRIVATES
     **/
     
    private function getButtonParent($node){
        
        $node['class'] = $node['class'] ?? array();
        append($node['class'],
            array(
                'btn',
                'btn-'.($node['color'] ?? 'default'),
                (($node['size'] ?? NULL) ? 'btn-'.$node['size'] : ''),
                'dropdown-toggle',  
                
            )
        );
        
        $arrReturn = array(
            'tag'           =>  'button',
            'data-toggle'   =>  'dropdown',
            'aria-expanded' =>  $node['expanded'] ?? 'false',
            'class'         =>  $node['class'],
            'title'         =>  ($node['title']??NULL),
            'children'      =>  array()
        );
        
        if(($node['disabled']??NULL)){
            $arrReturn['disabled'] = 'disabled';
        }
        
        if(($node['icon_left']?? NULL)){
            
            append($arrReturn['children'],
                array(
                    array(
                        'tag'       =>  'i',
                        'class'     =>  array(
                            ($node['icon_left'] ?? NULL),
                            (($node['icon_left_size']??NULL) ? 'size-'.$node['icon_left_size'] : NULL),
                        )
                    )
                )
            );
        }
        
        if(($node['text']??NULL)){
           append($arrReturn['children'],
                array(
                    array(
                        'text'  =>  $node['text'],
                    )
                )
            ); 
        }
        
        
        if(($node['icon_right']?? NULL)){
            
            append($arrReturn['children'],
                array(
                    array(
                        'tag'       =>  'i',
                        'class'     =>  array(
                            ($node['icon_right'] ?? NULL),
                            (($node['icon_right']??NULL) ? 'size-'.$node['icon_right'] : NULL),
                        )
                    )
                )
            );
        }
        
        if(($node['children']??NULL)){
            
            append($arrReturn['children'],$node['children']);
        }
        
        append($arrReturn['children'],
            array(
                array(
                    'text'  =>  '&nbsp;<span class="caret"></span>',
                )
            )
        );
        
        
        
        foreach($node as $key => $val){
            if(!in_array($key,array_merge(array_keys($arrReturn),array('disabled','size','color','text','menu_position','nodes','id','icon_left','icon_left_size','icon_right','icon_right_size','parent_id')))){
                $arrReturn[$key] = $val;
            }
        }
        
        return $arrReturn;
    }  
    
    private function getMenu($node){
        
        $menuClass = array('dropdown-menu');
        
        if(($node['menu_position']??NULL)){
            switch($node['menu_position']){
                case 'right':{
                    append($menuClass,array('dropdown-menu-right'));
                    break;
                }
                
            }
        }
        
        $arrDataChildren = array();
        
        foreach($node['nodes'] as $nodeChild){
            
            if(($nodeChild['divider']??NULL)){
                
                $arrDataChildren[] = array(
                    'tag'       =>  'li',
                    'class'     =>  array('dropdown-divider'),
                );
                
                continue;
            }
            
            
            $nodeChild['class'] = $nodeChild['class'] ?? array();
            append($nodeChild['class'],
                array(
                    'dropdown-item',
                    'size-11'
                )
            );
            
            $arrDataChild = array(
                'tag'       =>  'button',
                'class'     =>  $nodeChild['class'],
                'children'  =>  array(
                    array(
                        'tag'       =>  'i',
                        'class'     =>  array(
                            ($nodeChild['icon_left'] ?? NULL),
                            (isset($nodeChild['icon_left_size']) ? 'size-'.$nodeChild['icon_left_size'] : NULL),
                            'icon_left',
                        )
                    ),
                    
                )   
            );
            
            if(($nodeChild['disabled']??NULL)){
                $arrDataChild['disabled'] = 'disabled';
            }
            
            if(($nodeChild['text']??NULL)){
                append($arrDataChild['children'],
                    array(
                       array(
                            'tag'       =>  'span',
                            'class'     =>  'xn-text',
                            'text'      =>  $nodeChild['text'] ?? NULL,
                        ), 
                    )
                );
            }
            
            if(($nodeChild['icon_right']??NULL)){
                
                append($arrDataChild['children'],
                    array(
                        array(
                            'tag'       =>  'i',
                            'class'     =>  array(
                                $nodeChild['icon_right'] ?? NULL,
                                (isset($nodeChild['icon_right_size']) ? 'size-'.$nodeChild['icon_right_size'] : NULL),
                                'icon_right'
                            ),
                        )
                    )
                );
            }
            
            foreach($nodeChild as $key => $val){
                if(!in_array($key,array_merge(array_keys($arrDataChild),array('disabled','size','icon_left','icon_left_size','icon_right','icon_right_size','menu_position','text','nodes','parent_id')))){
                    $arrDataChild[$key] = $val;
                }
            }
            
            $arrDataChild = array(
                'tag'       =>  'li',
                'class'     =>  array(),
                'children'  =>  array(
                    $arrDataChild
                )
            );
            
            if(($nodeChild['nodes']??NULL)){
                append($arrDataChild['class'],array('dropdown-submenu'));
                
                append($arrDataChild['children'],
                    array(
                        $this->getMenu($nodeChild)
                    )
                );
                
            }
            
            $arrDataChildren[] = $arrDataChild;
        }
        
                
        $arrReturn = array(
            'tag'       =>  'ul',
            'class'     =>  $menuClass,
            'children'  =>  $arrDataChildren,
        );
        
        return $arrReturn;
    }
}

?>