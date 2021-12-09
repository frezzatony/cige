<?php

/**
 * @author Tony Frezza
 */

 

return array(
    array(
        'action'    =>  21,
        'atributos' =>  array(
            'title'     =>  'Novo',
            'icon'      =>  'la la-file size-12',
            'href'      =>  '/view',
            'class'     =>  'editar-cadastro', 
        )
    ),
    array(
        'atributos' =>  array(
            'title'     =>  'Gerenciar',
            'class'     =>  'need_selected_items', 
        ),
        'children'  =>  array(
            array(
                'action'    =>  21,
                'atributos' =>  array(
                    'title'     =>  'Excluir',
                    'icon'      =>  'fa fa-trash',
                    'href'      =>  '/delete',
                    'class'     =>  'need_selected_items excluir-cadastro', 
                )
            ),
            array(
                'action'    =>  21,
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
        'action'    =>  21,
        'atributos' =>  array(
            'title'     =>  'Histórico de alterações',
            'icon'      =>  'fa fa-list-alt',
            'href'      =>  '/log',
            'class'     =>  'need_selected_items unique_selected_item log-cadastro', 
        )
    ),
);

?>