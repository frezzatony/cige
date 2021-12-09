<?php

/**
 * @author Tony Frezza
 */

 

return array(
    array(
        'atributos'     =>  array(
            'title'     =>  'Novo',
            'icon'      =>  'la la-file size-12',
        ),
        'externallist'  =>  TRUE,
        'children'      =>  array(
            array(
                'action'        =>  68,
                'externallist'  =>  TRUE,
                'atributos'     =>  array(
                    'title'     =>  'Pessoa Física',
                    'icon'      =>  'fa fa-list-alt size-13',
                    'href'      =>  '/view/tipo/1',
                    'class'     =>  'editar-cadastro',
                )
            ),
            array(
                'action'        =>  68,
                'externallist'  =>  TRUE,
                'atributos'     =>  array(
                    'title'     =>  'Pessoa Jurídica',
                    'icon'      =>  'fa fa-list-alt size-13',
                    'href'      =>  '/view/tipo/2',
                    'class'     =>  'editar-cadastro',
                )
            ),
        )
    ),
    array(
        'atributos' =>  array(
            'title'     =>  'Gerenciar',
            'class'     =>  'need_selected_items', 
        ),
        'children'  =>  array(
            array(
                'action'    =>  68,
                'atributos' =>  array(
                    'title'     =>  'Excluir',
                    'icon'      =>  'fa fa-trash',
                    'href'      =>  '/delete',
                    'class'     =>  'need_selected_items excluir-cadastro', 
                )
            ),
            array(
                'action'    =>  68,
                'atributos' =>  array(
                    'title'     =>  'Gerar uma cópia',
                    'icon'      =>  'fa fa-copy',
                    'href'      =>  '/clone',
                    'class'     =>  array('need_selected_items','unique_selected_item','clone-cadastro'), 
                )
            ),
        )
    ),
    array(
        'action'    =>  68,
        'atributos' =>  array(
            'title'     =>  'Histórico de alterações',
            'icon'      =>  'fa fa-list-alt',
            'href'      =>  '/log',
            'class'     =>  'need_selected_items unique_selected_item log-cadastro', 
        )
    ),
);

?>