<?php

/**
 * @author Tony Frezza

 */


class Table_Bootstrap extends Component_Bootstrap{
    
        
    public function getHtmlData($node){
                
        $arrReturn = array(
            'tag'       =>  'table',
            'class'     =>  $node['class'] ?? NULL,
            'children'  =>  array(),
        );
        
        foreach($node as $tag => $value){
            if(!in_array($tag,array('class','thead','tbody','tfoot'))){
                $arrReturn[$tag] = $value;
            }
        }
        
        /*THEAD*/
        $arrThead = array();
        foreach(($node['thead'] ?? array()) as $key => $thead){
            $arrThead[] = array(
                'tag'       =>  'th'
            );
            
            $arrThead[sizeof($arrThead)-1] = array_merge($arrThead[sizeof($arrThead)-1],$thead);
        }
        
        if(sizeof($arrThead)){
            
            $arrThead = array(
                'tag'       =>  'thead',
                'children'  =>  array(
                    array(
                        'tag'       =>  'tr',
                        'children'  =>  $arrThead
                    ),
                )
            );
            $arrReturn['children'][] = $arrThead;
        }
        /*FIM THEAD*/
        
        
        /*TBODY*/
        $arrBody = array();
        $arrRow = array();
        $arrColumn = array();
        
        foreach(($node['tbody'] ?? array()) as $key => $row){
            $arrRow = array(
                'tag'       =>  'tr',
                'children'  =>  array()
            );
            
            
            foreach($row as $key => $column){
                $arrColumn = array(
                    'tag'       =>  'td',
                );
                
                if(is_array($column)===FALSE){
                    $column = array(
                        'text'  =>  $column
                    );
                }
                                
                $arrColumn = array_merge($arrColumn,$column);
                $arrRow['children'][] = $arrColumn;    
            }
            $arrBody[] = $arrRow;
            
        }
        
        $arrBody = array(
            'tag'       =>  'tbody',
            'children'  =>  $arrBody
        );
        $arrReturn['children'][] = $arrBody;
        

        /*FIM TBODY*/
        
        
        
        /*TFOOT*/
        $arrTFoot = array();
        foreach(($node['tfoot'] ?? array()) as $key => $tfoot){
            $arrTFoot[] = array(
                'tag'       =>  'th'
            );
            
            $arrTFoot[sizeof($arrTFoot)-1] = array_merge($arrTFoot[sizeof($arrTFoot)-1],$tfoot);
        }
        
        if(sizeof($arrTFoot)){
            
            $arrTFoot = array(
                'tag'       =>  'tfoot',
                'children'  =>  array(
                    array(
                        'tag'       =>  'tr',
                        'children'  =>  $arrTFoot
                    ),
                )
            );
            $arrReturn['children'][] = $arrTFoot;
        }
        /*FIM TFOOT*/
        
        return $arrReturn;
        
        
    }    
}

?>