<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return  array(
    'id_controller' =>  2, //id na tabela sistema.controllers
    'schema'        =>  'usuarios',
    'table'         =>  'usuarios',
    'auto_load_items'   =>  TRUE,
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'actions'           =>  array(
        'viewItems'     =>  3,
        'deleteItems'   =>  4,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController_usuarios.php'),
    'variables'     =>  array(
        array(
            'type'                      =>  'integer',
            'id'                        =>  'id',
            'column'                    =>  'id',
            'label'                     =>  'Código',
            'pk'                        =>  TRUE,
            'nn'                        =>  TRUE,
            'not_compare_difference'    =>  TRUE,
        ),
        
        array(
            'type'                      =>  'date_time',
            'id'                        =>  'last_activity',
            'column'                    =>  NULL,
            'label'                     =>  'Última alteração',
            'not_compare_difference'    =>  TRUE,
            'no_db'                     =>  TRUE,
        ),
        array(
            'id'        =>  'situacao',
            'type'      =>  'bool',
            'column'    =>  'ativo',
            'label'     =>  'Ativo',
            
        ),
        array(
            'id'        =>  'nome',
            'type'      =>  'character',
            'column'    =>  'nome',
            'label'     =>  'Nome completo',
        ),
        array(
            'id'        =>  'login_user',
            'type'      =>  'character',
            'column'    =>  'usuario',
            'label'     =>  'Login',
        ),
        array(
            'id'        =>  'password_user',
            'type'      =>  'character',
            'column'    =>  'senha',
            'label'     =>  'Senha',
        ),
        array(
            'id'        =>  'email',
            'type'      =>  'character',
            'column'    =>  'email',
            'label'     =>  'E-mail',
        ),
        array(
            'id'            =>  'profiles',
            'label'         =>  'Perfis de acesso',
            'type'          =>  'relational_n_n',
            'schema'        =>  'usuarios',
            'table'         =>  'usuarios_grupos',
            'pk_column'     =>  'usuarios_usuarios_id', 
            'variables'     =>  array(        
                array(
                    'id'        =>  'user_profile',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'usuarios_grupos_id',
                    'label'     =>  'Perfil',
                    'from'          =>  array(
                        'module'    =>  'profiles_users',
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'nome'
                        ),
                        'hide_filters'  =>  array(      
                        ),
                        'filters'   =>  array(
                            array(
                                'id'        =>  'ativo',
                                'clause'    =>  'equal',
                                'value'     =>  'true', //ativo
                            ),
                        ),
                        'order'     =>  array(
                            array(
                                'id'        =>  'nome',
                                'dir'       =>  'ASC'
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
                                
                            ),
                        ),
                    ),
                ),
            )  
        ),
         array(
            'id'        =>  'configs',
            'type'      =>  'json',
            'column'    =>  'configs',
            'label'     =>  'Configurações',
            'no_filter' =>  TRUE,
        ),
    ),
    'rules'         =>  array(
    
        
        
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
                    'lg'        => 6,
                )
            ),
            array(
                'id'    =>  'login_user',
                'text'  =>  'Login',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'email',
                'text'  =>  'E-mail',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  4,
                )
            ),
            array(
                'id'    =>  'situacao',
                'text'  =>  'Ativo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  8,
                )
            ),
            
            
        ),
    ),
);


?>