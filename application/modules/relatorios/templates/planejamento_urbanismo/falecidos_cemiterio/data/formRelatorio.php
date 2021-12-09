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
                    'type'          =>  'dropdown',
                    'id'            =>  'cemiterio',
                    'label'         =>  'Cemitério',
                    'grid-col'      =>  array(
                        'lg'        =>  24,  
                    ),
                    'class'         =>  array('chosen'),
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '19', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'nome'
                        ),
                        'hide_filters'  =>  array(
                            'id',
                        ),
                        'order'     =>  array(
                            array(
                                'id'        =>  'nome',
                                'dir'       =>  'ASC'
                            ),
                        )
                        
                    ),
                    'parent'        =>  array(
                        'module'    =>  'relatorios',
                        'request'   =>  $this->relatorio->get('id')
                    )
                ),
                                     
            ) 
        )   
    );
    
    return $bsForm->getHtmlData();
    
}   
    
?>