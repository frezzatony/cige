<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return  array(
    'id_controller' =>  3, //id na tabela sistema.controllers
    'schema'        =>  'usuarios',
    'table'         =>  'grupos',
    'auto_load_items'   =>  TRUE,
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'actions'           =>  array(
        'viewItems'     =>  5,
        'deleteItems'   =>  6,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController_perfis_usuarios.php'),
    'variables'     =>  array(
        array(
            'type'                      =>  'integer',
            'id'                        =>  'id',
            'column'                    =>  'id',
            'label'                     =>  'Código',
            'pk'                        =>  TRUE,
            'nn'                        =>  TRUE,
            'not_compare_difference'    =>  TRUE,
        ),
        
        array(
            'type'                      =>  'date_time',
            'id'                        =>  'last_activity',
            'column'                    =>  NULL,
            'label'                     =>  'Última alteração',
            'not_compare_difference'    =>  TRUE,
            'no_db'                     =>  TRUE,
        ),
        array(
            'id'        =>  'ativo',
            'type'      =>  'bool',
            'column'    =>  'ativo',
            'label'     =>  'Situação',
            'options'   =>  array(
                array(
                    'text'      =>  'ATIVO',
                    'value'     =>  'SIM',
                ),
                array(
                    'text'      =>  'INATIVO',
                    'value'     =>  'NÃO'
                )
            ),
        ),
        array(
            'id'        =>  'nome',
            'type'      =>  'character',
            'column'    =>  'nome',
            'label'     =>  'Nome',
        ),
        array(
            'id'        =>  'descricao',
            'type'      =>  'character',
            'column'    =>  'descricao',
            'label'     =>  'Descrição',
        ),
        array(
            'id'        =>  'administrador',
            'type'      =>  'bool',
            'column'    =>  'administrador',
            'label'     =>  'Administrador do sistema',
        ),
    ),
    'rules'         =>  array(
        
    ),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id'        =>  'nome',
                'dir'       =>  'ASC'
            ),
        ),
        'columns'   =>  array(
            array(
                'id'    =>  'id',
                'text'  =>  'Código',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'nome',
                'text'  =>  'Nome',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        => 10,
                )
            ),
            array(
                'id'    =>  'administrador',
                'text'  =>  'Administrador do sistema',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        => 6,
                )
            ),
            array(
                'id'    =>  'ativo',
                'text'  =>  'Ativo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        => 6,
                )
            ),
            
            
        ),
    ),
);


?>