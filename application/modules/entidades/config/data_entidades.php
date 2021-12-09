<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return array(
    'id_controller' =>  8, //id na tabela sistema.controllers
    'schema'        =>  'entidade',
    'table'         =>  'entidades',
    'auto_load_items'   =>  TRUE,
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'descricao',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'actions'           =>  array(
        'viewItems'     =>  14,
        'deleteItems'   =>  15,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController_entidades.php'),
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
        ),
       
        array(
            'id'        =>  'descricao',
            'type'      =>  'character',
            'column'    =>  'descricao',
            'label'     =>  'Descrição',
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
                    'lg'        => 2,
                ),
                //'head-width'    =>  50,
            ),
            array(
                'id'    =>  'descricao',
                'text'  =>  'Descrição',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        => 22,
                ),
                //'head-width'    =>  50,
            ),
        ),
    ),
);


?>