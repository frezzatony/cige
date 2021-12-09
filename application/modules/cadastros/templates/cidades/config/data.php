<?php

/**
 * @author Tony Frezza
 */

 
return array(
    'schema'            =>  'cadastros',
    'table'             =>  'cidades',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  26,
        'editItems'     =>  39,
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
                        'clause'    =>  'equal_integer',
                        'value'     =>  '1',
                    ),
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '2',
                    ),
                ),
            ),
        ),
        
        array(
            'id'        =>  'nome',
            'type'      =>  'character',
            'column'    =>  'nome',
            'label'     =>  'Nome',
        ),
        array(
            'id'        =>  'estado',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_estados_id',
            'label'     =>  'Estado',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '17', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'hide_filters'  =>  array(
                    'id',
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'    =>  'nome',
                        'dir'   =>  'ASC'
                    )
                )
            ),
        ),
        
    ),
    'rules'         =>  array(),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id' =>  'nome',
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
                    'lg'        =>  10,
                )
            ),
            array(
                'id'    =>  'estado',
                'text'  =>  'Estado',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  8,
                )
            ),
            array(
                'id'    =>  'situacao',
                'text'  =>  'Situação',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            
        ),
    ),
);

?>