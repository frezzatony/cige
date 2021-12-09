<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return array(
    'id_controller' =>  11, //id na tabela sistema.controllers
    'schema'        =>  'sistema',
    'table'         =>  'modulos',
    'auto_load_items'   =>  TRUE,
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'descricao',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'actions'           =>  array(
        'viewItems'     =>  20,
        'deleteItems'   =>  21,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController_modulos.php'),
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
            'id'        =>  'descricao',
            'type'      =>  'character',
            'column'    =>  'descricao',
            'label'     =>  'Descrição',
        ),
        
        array(
            'id'        =>  'uri',
            'type'      =>  'character',
            'column'    =>  'uri',
            'label'     =>  'Uri',
        ),
        
    ),
    'rules'         =>  array(
        
    ),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id'        =>  'descricao',
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
                'id'    =>  'descricao',
                'text'  =>  'Descrição',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        => 22,
                )
            ),
        ),
    ),
);


?>