<?php

/**
 * @author Tony Frezza
 */

 

return array(
    'schema'            =>  'cadastros',
    'table'             =>  'produtos',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'id',
            'clause'    =>  'greater',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        
        //almox Cosip:
        1     =>  array(
            'viewItems'     =>  129,
            'editItems'     =>  128,
        ),
        
        //almox Depto TI:
        2     =>  array(
            'viewItems'     =>  130,
            'editItems'     =>  131,
        ),

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
            'id'        =>  'descricao',
            'type'      =>  'character',
            'column'    =>  'descricao',
            'label'     =>  'Descrição',
        ),
        
        array(
            'id'            =>  'atributos',
            'label'         =>  'Atributos',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'produtos_atributos',
            'pk_column'     =>  'cadastros_produtos_id', 
            'variables'     =>  array(     
                array(
                    'id'        =>  'nome',
                    'type'      =>  'character',
                    'column'    =>  'nome',
                    'label'     =>  'Nome atributo',
                ),
                array(
                    'id'        =>  'valor',
                    'type'      =>  'character',
                    'column'    =>  'valor',
                    'label'     =>  'Valor atributo',
                ),
                
            )
            
        )
        
    ),
    'rules'         =>  array(),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id'    =>  'id',
                'dir'   =>  'DESC'
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
                'id'    =>  'descricao',
                'text'  =>  'Descrição',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  6,
                )
            ),
            array(
                'id'    =>  'estoque',
                'text'  =>  'Estoque',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'atributos',
                'text'  =>  'Atributos',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  11,
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