<?php

/**
 * @author Tony Frezza
 */

 

return array(
    'schema'            =>  'cadastros',
    'table'             =>  'cemiterios',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  29,
        'editItems'     =>  42,
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
            'id'        =>  'nome',
            'type'      =>  'character',
            'column'    =>  'nome',
            'label'     =>  'Nome',
        ),
        array(
            'id'        =>  'bairro',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_bairros_id',
            'label'     =>  'Bairro',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '15', //id do cadastro pertinente
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
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                    array(
                        'id'        =>  'cidade',
                        'clause'    =>  'equal',
                        'value'     =>  'sao bento do sul',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'    =>  'nome',
                        'dir'   =>  'ASC',
                    )
                )
            ),
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
                'id'    =>  'bairro',
                'text'  =>  'Bairro',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  7,
                )
            ),
            array(
                'id'    =>  'situacao',
                'text'  =>  'Situação',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  5,
                )
            ),
            
            
        ),
    ),
);

?>