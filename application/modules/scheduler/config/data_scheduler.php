<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return array(
    'id_controller' =>  8, //id na tabela sistema.controllers
    'schema'        =>  'sistema',
    'table'         =>  'tarefas_agendadas',
    'auto_load_items'   =>  TRUE,
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'descricao',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'actions'           =>  array(
        'viewItems'     =>  73,
        'editItems'     =>  74,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController_scheduler.php'),
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
        ),
        array(
            'id'        =>  'descricao',
            'type'      =>  'character',
            'column'    =>  'descricao',
            'label'     =>  'Descrição',
        ),
        array(
            'id'        =>  'periodicidade',
            'type'      =>  'character',
            'column'    =>  'periodicidade',
            'label'     =>  'Periodicidade',
        ),
        array(
            'id'        =>  'modulo',
            'type'      =>  'character',
            'column'    =>  'modulo',
            'label'     =>  'Módulo',
        ),
        array(
            'id'        =>  'metodo',
            'type'      =>  'character',
            'column'    =>  'metodo',
            'label'     =>  'Método',
        ),
        array(
            'id'        =>  'dias_logs',
            'type'      =>  'integer',
            'column'    =>  'dias_logs',
            'label'     =>  'Nº dias para armazenar logs',
        ),
        array(
            'id'        =>  'observacoes',
            'type'      =>  'character',
            'column'    =>  'observacoes',
            'label'     =>  'Observações',
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