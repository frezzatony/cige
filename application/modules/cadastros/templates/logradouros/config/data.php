<?php

/**
 * @author Tony Frezza
 */

 
require(dirname(__FILE__).'/variables.php');
 

return array(

    'table'             =>  'logradouros',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'denominacao',
            'clause'    =>  'contains',
            'value'     =>  ''
        ),
        array(
            'id'        =>  'cidade',
            'clause'    =>  'equal',
            'value'     =>  'SÃO BENTO DO SUL'
        ),
        
    ),
    'auto_load_items'   =>  FALSE,
    'actions'           =>  array(
        'viewItems'     =>  24,
        'editItems'     =>  37,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  $variables,
    'rules'         =>  array(
        array(
            'id'        =>  'tipo_logradouro',
            'rule'      =>  'notnull',
            'message'   =>  'Tipo de logradouro deve conter um valor.'
        ),
        array(
            'id'        =>  'estado',
            'rule'      =>  'notnull',
            'message'   =>  'Estado deve conter um valor.'
        ),
        array(
            'id'        =>  'cidade',
            'rule'      =>  'notnull',
            'message'   =>  'Cidade deve conter um valor.'
        ),
        array(
            'id'        =>  'denominacao',
            'rule'      =>  'notnull',
            'message'   =>  'Denominação deve conter um valor.'
        ),
        array(
            'id'        =>  'bairros.bairro_localidade',
            'rule'      =>  'notnull',
            'message'   =>  'Bairro/localidade deve conter um valor.'
        ),
        
    ),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id' =>  'denominacao', //nome_razaosocial
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
                'id'    =>  'tipo_logradouro',
                'text'  =>  'Tipo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'denominacao',
                'text'  =>  'Denominação',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  7,
                )
            ),
            
            array(
                'id'    =>  'cidade',
                'text'  =>  'Cidade',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'coordenadas_mapa',
                'text'  =>  'Coordenadas Mapa',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  5,
                )
            ),
            array(
                'id'    =>  'situacao',
                'text'  =>  'Situação',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
        )
    ),
);

?>