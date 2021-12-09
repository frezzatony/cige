<?php

/**
 * @author Tony Frezza

 */

$variable_ceps =  array(
    'id'            =>  'ceps',
    'label'         =>  'CEPs',
    'type'          =>  'relational_n_n',
    'schema'        =>  'cadastros',
    'table'         =>  'logradouros_ceps',
    'pk_column'     =>  'cadastros_logradouros_id', 
    'variables'     =>  array(
              
        array(
            'id'        =>  'cep',
            'type'      =>  'character',
            'column'    =>  'cep',
            'label'     =>  'CEP',
        ),
        array(
            'id'        =>  'lado_logradouro',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_lados_logradouros_id',
            'label'     =>  'Lado do logradouro',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '18', //id do cadastro pertinente
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
                        'clause'    =>  'equal',
                        'value'     =>  '1', //Ativo
                    ),
                ),
            ),
        ),
        array(
            'id'        =>  'numero_inicio',
            'type'      =>  'character',
            'column'    =>  'numero_inicio',
            'label'     =>  'Número início',
        ),
        array(
            'id'        =>  'numero_fim',
            'type'      =>  'character',
            'column'    =>  'numero_fim',
            'label'     =>  'Número fim',
        ),
        
    )
    
);

?>