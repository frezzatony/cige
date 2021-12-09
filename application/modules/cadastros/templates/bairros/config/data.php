<?php

/**
 * @author Tony Frezza
 */

 
return array(
    'schema'            =>  'cadastros',
    'table'             =>  'bairros',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  25,
        'editItems'     =>  38,
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
            'id'        =>  'cidade',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_cidades_id',
            'label'     =>  'Cidade',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '16', //id do cadastro pertinente
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
            ),
            'filter_configs' =>  array(
                'input_type'    =>  'externallist',
                'from'      =>  array(
                    'search'    =>  'text',
                )
            ),
        ),
        
        array(
            'id'        =>  'localidade',
            'type'      =>  'bool',
            'column'    =>  'localidade',
            'label'     =>  'É localidade',
        ),
        
    ),
    'rules'         =>  array(
        array(
            'id'        =>  'nome',
            'rule'      =>  'notnull',
            'message'   =>  'Nome deve conter um valor.'
        ),
         array(
            'id'        =>  'cidade',
            'rule'      =>  'notnull',
            'message'   =>  'Cidade deve conter um valor.'
        ),
    ),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id'        =>  'nome',
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
                    'lg'        =>  8,
                )
            ),
            array(
                'id'    =>  'localidade',
                'text'  =>  'Localidade',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'cidade',
                'text'  =>  'Cidade',
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