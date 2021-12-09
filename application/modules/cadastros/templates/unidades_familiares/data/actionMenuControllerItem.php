<?php

/**
 * @author Tony Frezza
 */




return array(
    array(
        'action'    =>  77,
        'atributos' =>  array(
            'title'     =>  'Novo',
            'icon'      =>  'la la-file size-12',
            'href'      =>  '/view',
            'class'     =>  'cadastro-novo-item', 
        )
    ),
    
    array(
        'atributos' =>  array(
            'title'     =>  'Gerenciar', 
        ),
        'children'  =>  array(
            array(
                'action'    =>  77,
                'atributos' =>  array(
                    'title'     =>  'Excluir',
                    'icon'      =>  'fa fa-trash',
                    'href'      =>  '/delete',
                    'class'     =>  array('cadastro-excluir-item','need-item'), 
                )
            ),
            array(
                'action'    =>  77,
                'atributos' =>  array(
                    'title'     =>  'Gerar uma cópia',
                    'icon'      =>  'fa fa-copy',
                    'href'      =>  '/view',
                    'class'     =>  array('cadastro-clone-item','need-item'),
                )
            ),
        )
    ),
    array(
        'atributos' =>  array(
            'title'     =>  'Imprimir',
            'icon'      =>  'la la-print size-12', 
        ),
        'children'  =>  array(
            array(
                'action'    =>  77,
                'atributos' =>  array(
                    'title'     =>  'Ficha cadastral - Emhab',
                    'icon'      =>  'la la-file-invoice size-12',
                    'href'      =>  '#', 
                    'class'     =>  array('btn-ficha-cadastral-emhab')
                )
            ),
            array(
                'action'    =>  77,
                'atributos' =>  array(
                    'title'     =>  'Ficha cadastral - Lot. Santa Fé',
                    'icon'      =>  'la la-file-invoice size-12',
                    'href'      =>  '#', 
                    'class'     =>  array('btn-ficha-cadastral-santa-fe')
                )
            ),
        )
    ),
);

?>