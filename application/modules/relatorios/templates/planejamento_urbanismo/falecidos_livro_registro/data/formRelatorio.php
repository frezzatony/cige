<?php

/**
 * @author Tony Frezza
 */


$getFormRelatorio= function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'inputs'        =>  array(                    
                array(
                    'tag'       =>  'label',
                    'for'       =>  'data_inicio',
                    'class'     =>  array('col-lg-24','nopadding','nomargin','size-12'),
                    'style'     =>  'padding-left: 2px !important;',
                    'text'      =>  'Data de falecimento entre:',
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_inicio',
                    
                    'grid-col'      =>  array(
                        'lg'        =>  7,  
                    ),
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('nopadding','nomargin'),
                    'style'     =>  'float:left;',
                    'children'  =>  array(
                        array(
                            'tag'       =>  'label',
                            'for'       =>  'data_fim',
                            'class'     =>  array('nopadding','nomargin','size-12'),
                            'style'     =>  '',
                            'text'      =>  'e&nbsp;&nbsp;',
                        ),
                        
                    )
                ),
                
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_fim',
                    'grid-col'      =>  array(
                        'lg'        =>  7,  
                    ),
                ),
                                     
            ) 
        )   
    );
    
    return $bsForm->getHtmlData();
    
}   
    
?>