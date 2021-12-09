<?php

/**
 * @author Tony Frezza
 */

 
return array(
    'schema'            =>  'cadastros',
    'table'             =>  'paises',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  52,
        'editItems'     =>  51,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
                
        array(
            'id'        =>  'nome',
            'type'      =>  'character',
            'column'    =>  'nome',
            'label'     =>  'Nome',
        ),
        array(
            'id'        =>  'abreviatura',
            'type'      =>  'character',
            'column'    =>  'abreviatura',
            'label'     =>  'Arbeviatura',
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
                'id'    =>  'abreviatura',
                'text'  =>  'Abreviatura',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
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
        ),
    ),
);

?>