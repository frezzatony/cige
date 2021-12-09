<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return array(
    'id_controller' =>  4, //id na tabela sistema.controllers
    'schema'        =>  'sistema',
    'table'         =>  'controllers_acoes',
    'auto_load_items'   =>  TRUE,
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'descricao',
            'clause'    =>  'contains',
            //'value'     =>  ''
        ),
        
    ),
    'actions'           =>  array(
        'viewItems'     =>  7,
        'deleteItems'   =>  8,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/acoes_controllers/actionMenuController_acoes_controllers.php'),
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
            'id'        =>  'controller',
            'type'      =>  'relational_1_n',
            'column'    =>  'sistema_controllers_id',
            'label'     =>  'Controller',
            'from'          =>  array(
                'module'    =>  'controllers',
                'value'         =>  array(
                    'id',
                ),
                'text'          =>  array(
                    'descricao_plural',
                ),
                'variables'     =>  array(
                    'tipo'
                ),
                'order' =>  array(
                    array(
                        'id'    =>  'descricao_plural',
                    )
                )
            ),
            
        ),
        array(
            'id'        =>  'descricao',
            'type'      =>  'character',
            'column'    =>  'descricao',
            'label'     =>  'Descrição',
        ),
        array(
            'id'            =>  'acoes_filhas',
            'label'         =>  'Contempla outras ações',
            'type'          =>  'relational_n_n',
            'schema'        =>  'sistema',
            'table'         =>  'controllers_acoes_filhas',
            'pk_column'     =>  'sistema_controllers_acoes_id', 
            'variables'     =>  array(        
                array(
                    'id'        =>  'acao_filha',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'sistema_controllers_acoes_id_filha',
                    'label'     =>  'Ação',
                    'from'          =>  array(
                        'module'    =>  'acoes_controllers',
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao'
                        ),
                    ),
                ),
            )
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
                    'lg'        => 6,
                )
            ),
            array(
                'id'    =>  'controller',
                'text'  =>  'Controller',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        => 6,
                )
            ),
            
            array(
                'id'    =>  'controller.variables.tipo',
                'text'  =>  'Tipo de Controller',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        => 4,
                )
            ),
            
        ),
    ),
);


?>