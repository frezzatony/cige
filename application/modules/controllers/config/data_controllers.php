<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return array(
    'id_controller' =>  1, //id na tabela sistema.controllers
    'schema'        =>  'sistema',
    'table'         =>  'controllers',
    'auto_load_items'   =>  TRUE,
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'descricao_plural',
            'clause'    =>  'contains',
            //'value'     =>  ''
        ),
        
    ),
    'actions'           =>  array(
        'viewItems'     =>  2,
        'deleteItems'   =>  1,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/controllers/actionMenuController_controllers.php'),
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
            'label'     =>  'Ativo',
            'options'   =>  array(
                array(
                    'text'      =>  'ATIVO',
                    'value'     =>  'true',
                ),
                array(
                    'text'      =>  'INATIVO',
                    'value'     =>  'false'
                )
            ),
        ),
        
        array(
            'id'        =>  'tipo',
            'type'      =>  'relational_1_n',
            'column'    =>  'sistema_tipos_controllers_id',
            'label'     =>  'Tipo',
            'from'          =>  array(
                'module'    =>  'tipos_controllers',
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
            ),
        ),
        
        array(
            'id'        =>  'modulo',
            'type'      =>  'relational_1_n',
            'column'    =>  'sistema_modulos_id',
            'label'     =>  'Módulo',
            'from'          =>  array(
                'module'    =>  'modulos',
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
            ),
        ),
        
        array(
            'id'        =>  'descricao_singular',
            'type'      =>  'character',
            'column'    =>  'descricao_singular',
            'label'     =>  'Descrição singular',
        ),
        array(
            'id'        =>  'descricao_plural',
            'type'      =>  'character',
            'column'    =>  'descricao_plural',
            'label'     =>  'Descrição plural',
        ),
        array(
            'id'        =>  'url',
            'type'      =>  'character',
            'column'    =>  'url',
            'label'     =>  'URL',
        ),
        array(
            'id'        =>  'controller',
            'type'      =>  'character',
            'column'    =>  'controller',
            'label'     =>  'Nome do arquivo Controller',
        ),
        array(
            'id'        =>  'atributos',
            'type'      =>  'json',
            'column'    =>  'atributos',
            'no_filter' =>  TRUE,
        ),
    ),
    'rules'         =>  array(
        
    ),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id'        =>  'descricao_singular',
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
                'id'    =>  'descricao_plural',
                'text'  =>  'Descrição plural',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  8,
                )
            ),
            array(
                'id'    =>  'tipo',
                'text'  =>  'Tipo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'modulo',
                'text'  =>  'Módulo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'last_activity',
                'text'  =>  'Última alteração',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'ativo',
                'text'  =>  'Ativo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            
            
        ),
    ),
);


?>