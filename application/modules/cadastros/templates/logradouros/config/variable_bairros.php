<?php

/**
 * @author Tony Frezza
 */

$variable_bairros =  array(
    'id'            =>  'bairros',
    'label'         =>  'Bairros',
    'type'          =>  'relational_n_n',
    'schema'        =>  'cadastros',
    'table'         =>  'logradouros_bairros',
    'pk_column'     =>  'cadastros_logradouros_id', 
    'variables'     =>  array(
        
        array(
            'id'        =>  'inicio',
            'type'      =>  'bool',
            'column'    =>  'inicio',
            'label'     =>  'Início',
        ),        
        array(
            'id'        =>  'bairro_localidade',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_bairros_id',
            'label'     =>  'Bairro / Localidade',
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
                    'situacao',
                    'cidade'
                                        
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '1', //ativo
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
                                'lg'        =>  12,
                            )
                        ),
                        
                        array(
                            'id'    =>  'cidade',
                            'text'  =>  'Cidade',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  10,
                            )
                        ),
                    ),
                ),
            ),
        ),
    )
    
);

?>