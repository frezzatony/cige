<?php

/**
 * @author Tony Frezza
 */

 

return array(
    'schema'            =>  'cadastros',
    'table'             =>  'sim_cards',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'orgao',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
        array(
            'id'        =>  'situacao',
            'clause'    =>  'equal',
            'value'     =>  1
        ),
        
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  119,
        'editItems'     =>  118,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
        
        array(
            'id'        =>  'situacao',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_situacoes_cadastros_id',
            'label'     =>  'Situação cadastro',
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
            'id'        =>  'numero_linha',
            'type'      =>  'character',
            'column'    =>  'numero_linha',
            'label'     =>  'Número linha',
            'mask'      =>  '(99) 9 9999 9999',
        ),
        array(
            'id'        =>  'orgao',
            'type'      =>  'character',
            'column'    =>  'orgao',
            'label'     =>  'Órgão/Secretaria',
        ),
        array(
            'id'        =>  'tipo_plano_telefonico',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_planos_telefonicos_id',
            'label'     =>  'Tipo plano telefônico',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '69', //id do cadastro pertinente
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
                        'id'        =>  'situacao',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '1',
                    ),
                ),
            ),
        ),
        array(
            'id'        =>  'login_gestor',
            'type'      =>  'character',
            'column'    =>  'login_gestor',
            'label'     =>  'Login gestor',
        ),
        array(
            'id'        =>  'em_uso',
            'type'      =>  'bool',
            'column'    =>  'em_uso',
            'label'     =>  'Em uso',
        ),
    ),
    'rules'         =>  array(),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id'    =>  'orgao'
            )
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
                'id'    =>  'orgao',
                'text'  =>  'Órgão/Secretaria',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'numero_linha',
                'text'  =>  'Número linha',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'em_uso',
                'text'  =>  'Em uso',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'tipo_plano_telefonico',
                'text'  =>  'Tipo de plano',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'login_gestor',
                'text'  =>  'Login gestor',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'situacao',
                'text'  =>  'Sit. cadastro',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            
        ),
    ),
);

?>