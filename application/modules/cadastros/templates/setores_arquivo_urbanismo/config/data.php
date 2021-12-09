<?php

/**
 * @author Tony Frezza
 */


return array(
    'schema'            =>  'listas',
    'table'             =>  'setores_arquivo_urbanismo',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'id',
            'clause'    =>  'greater',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  33,
        'editItems'     =>  46,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
        array(
            'id'        =>  'situacao',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_situacoes_cadastros_id',
            'label'     =>  'Situação',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '12', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'hide_filters'  =>  array(
                    'id',
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal',
                        'value'     =>  '2',
                    ),
                ),
            ),
        ),
        array(
            'id'        =>  'descricao',
            'type'      =>  'character',
            'column'    =>  'descricao',
            'label'     =>  'Descrição',
        ),
        array(
            'id'        =>  'observacoes',
            'type'      =>  'character',
            'column'    =>  'observacoes',
            'label'     =>  'Observações',
        ),
    ),
    'rules'         =>  array(),
    'list_items'    =>  array(
        'columns'   =>  array(
            array(
                'id'    =>  'id',
                'text'  =>  'Código',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  5,
                )
            ),
            array(
                'id'    =>  'descricao',
                'text'  =>  'Descrição',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  10,
                )
            ),
            array(
                'id'    =>  'situacao',
                'text'  =>  'Situação',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  9,
                )
            ),
        ),
    ),
);

?>