<?php

/**
 * @author Tony Frezza

 */

$variable_leis =  array(
    'id'            =>  'leis',
    'label'         =>  'Leis de divulgacao',
    'type'          =>  'relational_n_n',
    'schema'        =>  'cadastros',
    'table'         =>  'logradouros_leis',
    'pk_column'     =>  'cadastros_logradouros_id', 
    'variables'     =>  array(
              
        array(
            'id'        =>  'lei',
            'type'      =>  'character',
            'column'    =>  'lei',
            'label'     =>  'Lei',
        ),
        array(
            'id'        =>  'ano',
            'type'      =>  'integer',
            'column'    =>  'ano',
            'label'     =>  'Ano',
        ),
    )
    
);

?>