<?php

/**
 * @author Tony Frezza
 */

 

return array(
    array(
        'action'    =>  array(37,99),
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
                'action'    =>  array(37,99),
                'atributos' =>  array(
                    'title'     =>  'Excluir',
                    'icon'      =>  'fa fa-trash',
                    'href'      =>  '/delete',
                    'class'     =>  array('cadastro-excluir-item','need-item'), 
                )
            ),
            array(
                'action'    =>  array(37,99),
                'atributos' =>  array(
                    'title'     =>  'Gerar uma cópia',
                    'icon'      =>  'fa fa-copy',
                    'href'      =>  '/view',
                    'class'     =>  array('cadastro-clone-item','need-item'), 
                )
            ),
        )
    ),
);

?>