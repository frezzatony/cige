<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return array(
    'id_controller' =>  5, //id na tabela sistema.controllers
    'schema'        =>  'sistema',
    'table'         =>  'controllers_permissoes_acoes',
    'auto_load_items'   =>  TRUE,
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'id',
            'clause'    =>  'not_equal',
            //'value'     =>  ''
        ),
        
    ),
    'actions'           =>  array(
        'viewItems'     =>  9,
        'deleteItems'   =>  10,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/permissoes_acoes_controllers/actionMenuController_permissoes_acoes_controllers.php'),
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
            'id'        =>  'entidade',
            'type'      =>  'relational_1_n',
            'column'    =>  'entidade_entidades_id',
            'label'     =>  'Entidade',
            'from'      =>  array(
                'module'    =>  'entidades',
                'value'     =>  array(
                    'id'
                ) ,
                'text'      =>  array(
                    'descricao'
                )
            ),
        ),
        array(
            'id'        =>  'controller_acao',
            'type'      =>  'relational_1_n',
            'column'    =>  'sistema_controllers_acoes_id',
            'label'     =>  'Ação',
            'from'      =>  array(
                'module'    =>  'acoes_controllers',
                'value'     =>  array(
                    'id'
                ) ,
                'text'      =>  array(
                    'descricao'
                ),
                'variables' =>  array(
                    'controller'
                )
            ),
        ),
        array(
            'id'        =>  'perfil_usuarios',
            'type'      =>  'relational_1_n',
            'column'    =>  'usuarios_grupos_id',
            'label'     =>  'Perfil de usuários',
            'from'      =>  array(
                'module'    =>  'profiles_users',
                'value'     =>  array(
                    'id'
                ) ,
                'text'      =>  array(
                    'nome'
                )
            ),
        ),
        
             
    ),
    'rules'         =>  array(
        
    ),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id'        =>  'id',
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
                'id'    =>  'controller_acao.variables.controller.variables.tipo',
                'text'  =>  'Tipo de controller',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'controller_acao.variables.controller',
                'text'  =>  'Controller',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'controller_acao',
                'text'  =>  'Ação',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  6,
                )
            ),
            array(
                'id'    =>  'perfil_usuarios',
                'text'  =>  'Perfil de usuários',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'entidade',
                'text'  =>  'Entidade',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
        ),
    ),
);


?>