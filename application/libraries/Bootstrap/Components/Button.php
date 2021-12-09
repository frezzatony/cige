<?php

/**
 * @author Tony Frezza
 */


class Button_Bootstrap extends Component_Bootstrap{
    
        
    public function getHtmlData($node){
        
        $class = array(
            'btn',
            ($node['size']??NULL) ? 'btn-'.$node['size'] : NULL,
            'btn-'.($node['color'] ?? 'default'),
        );
        $node['class'] = $node['class']??array();
        append($node['class'],$class);
        
        
        $arrReturn = array(
            'parent_id'     =>  $node['parent_id'] ?? NULL,
            'tag'           =>  $node['tag'] ?? 'button',
            'class'         =>  $node['class'],
            'children'      =>  array(
                array(
                    'tag'       =>  'i',
                    'class'     =>  array(
                        ($node['icon_left'] ?? NULL),
                        (($node['icon_left_size']??NULL) ? 'size-'.$node['icon_left_size'] : NULL),
                    )
                ),
                array(
                    'text'  =>  ($node['text'] ?? NULL),   
                ),
                array(
                    'tag'       =>  'i',
                    'class'     =>  array(
                        ($node['icon_right'] ?? NULL),
                        (($node['icon_right_size']??NULL) ? 'size-'.$node['icon_right_size'] : NULL),
                    )
                ),
            ),
            
        );
        
        if($node['disabled'] ?? NULL){
            $arrReturn['disabled'] = 'disabled';
        }
        
        $this->getId($node,$arrReturn);
        
        
        $arrUsedTags = array(
            'id','parent_id','tag','class','size','color','icon_left','text','icon_right','disabled'
        );
        
        
        
        foreach($node as $key=>$val){
            if(in_array($key,$arrUsedTags)===FALSE){
                $arrReturn[$key] = $val;
            }
        }
        
        
        return $arrReturn;
    }
    
}

?>