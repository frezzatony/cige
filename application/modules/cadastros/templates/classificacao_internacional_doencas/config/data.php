<?php

/**
 * @author Tony Frezza
 */
 

return array(
    'schema'            =>  'listas',
    'table'             =>  'classificacao_internacional_doencas',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nomenclatura',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  93,
        'editItems'     =>  94,
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
                    )
                ),
            ),
        ),
        array(
            'id'        =>  'nomenclatura',
            'type'      =>  'character',
            'column'    =>  'nomenclatura',
            'label'     =>  'Nomenclatura',
        ),
        array(
            'id'        =>  'cid_10',
            'type'      =>  'character',
            'column'    =>  'cid_10',
            'label'     =>  'CID 10',
            'mask'      =>  'A99.9999',
        ),
        array(
            'id'        =>  'doenca_cronica',
            'type'      =>  'bool',
            'column'    =>  'doenca_cronica',
            'label'     =>  'Doença Crônica',
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
                'id'        =>  'nomenclatura'
            )
        ),
        'columns'   =>  array(
            array(
                'id'    =>  'id',
                'text'  =>  'Código',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                    'md'        =>  2,
                )
            ),
            
            array(
                'id'    =>  'cid_10',
                'text'  =>  'CID 10',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
                    'md'        =>  3,
                )
            ),
            
            array(
                'id'    =>  'nomenclatura',
                'text'  =>  'Nomenclatura',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  10,
                    'md'        =>  10,
                )
            ),
            array(
                'id'            =>  'doenca_cronica',
                'text'          =>  ' Crônica',
                'list-class'    =>  'text-centered',
                'head-col'      =>  array(
                    'lg'        =>  4,
                    'md'        =>  4,
                )
            ),
            array(
                'id'            =>  'situacao',
                'text'          =>  'Situação',
                //'list-class'    =>  'text-centered',
                'head-col'      =>  array(
                    'lg'        =>  5,
                    'md'        =>  5,
                )
            ),
            
        ),
    ),
);

?>