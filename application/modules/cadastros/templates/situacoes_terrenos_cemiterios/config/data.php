<?php

/**
 * @author Tony Frezza
 */

 

return array(
    'schema'            =>  'listas',
    'table'             =>  'situacoes_terrenos_cemiterios',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'descricao',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  30,
        'editItems'     =>  43,
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
        'order'     =>  array(
            array(
                'id'    =>  'descricao',
                'dir'   =>  'ASC'
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
                    'lg'        =>  15,
                )
            ),
            
            array(
                'id'    =>  'situacao',
                'text'  =>  'Situação',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  7,
                )
            ),
            
            
        ),
    ),
);

?>