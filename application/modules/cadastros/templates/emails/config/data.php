<?php

/**
 * @author Tony Frezza
 */

 

return array(
    'schema'            =>  'cadastros',
    'table'             =>  'mails',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'id',
            'clause'    =>  'greater',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  57,
        'editItems'     =>  58,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
        
        array(
            'id'        =>  'login',
            'type'      =>  'character',
            'column'    =>  'login',
            'label'     =>  'Login',
        ),
        
        array(
            'id'        =>  'nome',
            'type'      =>  'character',
            'column'    =>  'nome',
            'label'     =>  'Nome',
        ),
                
        array(
            'id'        =>  'pass',
            'type'      =>  'character',
            'column'    =>  'pass',
        ),
        
        array(
            'id'        =>  'conta_criada',
            'type'      =>  'bool',
            'column'    =>  'conta_criada',
            'label'     =>  'Conta Criada',
        ),
        
        array(
            'id'        =>  'conta_acessada',
            'type'      =>  'bool',
            'column'    =>  'conta_acessada',
            'label'     =>  'Conta acessada',
        ),
        
    ),
    'rules'         =>  array(),
    'list_items'    =>  array(
        'columns'   =>  array(
            
            
            array(
                'id'    =>  'login',
                'text'  =>  'Login',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                    'md'        =>  4,
                )
            ),
            
            array(
                'id'    =>  'nome',
                'text'  =>  'Nome',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                    'md'        =>  6,
                )
            ),
            
            array(
                'id'    =>  'conta_criada',
                'text'  =>  'Conta criada',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                    'md'        =>  6,
                )
            ),
            
            array(
                'id'    =>  'conta_acessada',
                'text'  =>  'Conta acessada',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                    'md'        =>  6,
                )
            ),
            
            
        ),
    ),
);

?>