<?php

/**
 * @author Tony Frezza
 */


if(
    
    ($this->cadastro->variables->get('processo_situacao.value')==9)
    AND
    !$this->cadastro->runActionUserPermissions(
        array(
            'action'            =>  113, //Alterar situação de Revisão de Iptu já encerrada
        )
    )
    
    
        
){
    return array(); 
}

return array(
    array(
        'action'    =>  105,
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
                'action'    =>  105,
                'atributos' =>  array(
                    'title'     =>  'Excluir',
                    'icon'      =>  'fa fa-trash',
                    'href'      =>  '/delete',
                    'class'     =>  array('cadastro-excluir-item','need-item'), 
                )
            ),
            array(
                'action'    =>  105,
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
                'action'    =>  105,
                'atributos' =>  array(
                    'title'     =>  'Ficha de abertura',
                    'icon'      =>  'la la-file-invoice size-12',
                    'href'      =>  '#', 
                    'class'     =>  array('btn-imprimir-ficha-abertura','need-item'),
                )
            ),
        )
    ),
);

?>