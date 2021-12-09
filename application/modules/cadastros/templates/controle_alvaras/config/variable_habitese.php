<?php

/**
 * @author Tony Frezza

 */


$variable_habitese =  array(
    'id'            =>  'habitese',
    'label'         =>  'Habite-se',
    'type'          =>  'relational_n_n',
    'schema'        =>  'cadastros',
    'table'         =>  'controle_alvaras_habitese',
    'pk_column'     =>  'cadastros_controle_alvaras_id',
    'variables'     =>  array(
        array(
            'id'        =>  'numero_habitese',
            'type'      =>  'character',
            'column'    =>  'numero_habitese',
            'label'     =>  'Número habite-se',
        ),
        array(
            'id'        =>  'data_habitese',
            'type'      =>  'date',
            'column'    =>  'data_habitese',
            'label'     =>  'Data habite-se',
        ),  
        array(
            'id'        =>  'area_habitese',
            'type'      =>  'number',
            'column'    =>  'area',
            'label'     =>  'Área (m²)',
        ),  
        array(
            'id'        =>  'observacoes_habitese',
            'type'      =>  'character',
            'column'    =>  'observacoes',
            'label'     =>  'Observações',
        ),        
    )
    
);

?>