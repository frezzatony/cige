<?php

/**
 * @author Tony Frezza
 */


$getFormCadastroPermissaoAcaoController = function(){
    
    $bsForm = new BsForm(
        array(
            'id'            =>  'ajG6OB4lf9Ek',
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->permissaoAcaoController->runActionUserPermissions(
                array(
                    'action'            =>  $this->permissaoAcaoController->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'inputs'    =>  array(
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  $this->permissaoAcaoController->variables->get('id')->get('label'),
                    'value'         =>  $this->permissaoAcaoController->get('item.value'),
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  24,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  3
                    ), 
                ),
                array(
                    'type'          =>  'dropdown',//externallist
                    'id'            =>  'entidade',
                    'label'         =>  $this->permissaoAcaoController->variables->get('entidade')->get('label').':',
                    'value'         =>  $this->permissaoAcaoController->variables->get('entidade')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),                        
                    'from'          =>  $this->permissaoAcaoController->variables->get('entidade')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'permissoes',
                    )
                ),
                array(
                    'type'          =>  'dropdown',
                    'label'         =>  'Perfil de usuários:',
                    'id'            =>  'perfil_usuarios',
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'value'         =>  $this->permissaoAcaoController->variables->get('perfil_usuarios')->get('value'),
                    'from'      =>  array(
                        'module'        =>  'profiles_users',
                        'filters'       =>  array(
                            array(
                                'id'        =>  'controller',
                                'clause'    =>  'equal',
                                'value'     =>  '{this.inputs.#controller.value}'   
                            )
                        ),
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'nome'
                        ),
                        'order'         =>  array(
                            array(
                                'id'        =>  'nome'
                            )
                        )
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'label'         =>  'Tipo de controller:',
                    'id'            =>  'tipo_controller',
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'value'         =>  $this->permissaoAcaoController->variables->get('controller_acao')->variables->get('controller')->variables->get('tipo')->get('value'),
                    'from'      =>  array(
                        'module'        =>  'tipos_controllers',
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao'
                        )
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'label'         =>  'Controller:',
                    'id'            =>  'controller',
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'value'         =>  $this->permissaoAcaoController->variables->get('controller_acao')->variables->get('controller')->get('value'),
                    'first_null'    =>  TRUE,
                    'from'      =>  array(
                        'module'        =>  'controllers',
                        'filters'       =>  array(
                            array(
                                'id'        =>  'tipo',
                                'clause'    =>  'equal',
                                'value'     =>  '{this.inputs.#tipo_controller.value}'   
                            )
                        ),
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao_plural'
                        ),
                        'order'         =>  array(
                            array(
                                'id'        =>  'descricao_plural'
                            )
                        )
                    ),
                    'update_on'     =>  array(
                        array(
                            'selector'      =>  'form.#tipo_controller',
                            'bind'          =>  'change',    
                        )
                    ),
                    
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'label'         =>  'Ação:',
                    'id'            =>  'controller_acao',
                    'grid-col'      =>  array(
                        'lg'    =>  16,  
                    ),
                    'value'         =>  $this->permissaoAcaoController->variables->get('controller_acao')->get('value'),
                    'first_null'    =>  TRUE,
                    'from'      =>  array(
                        'module'        =>  'acoes_controllers',
                        'filters'       =>  array(
                            array(
                                'id'        =>  'controller',
                                'clause'    =>  'equal',
                                'value'     =>  '{this.inputs.#controller.value}'   
                            )
                        ),
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao'
                        ),
                    ),
                    'update_on'     =>  array(
                        array(
                            'selector'      =>  'form.select#controller',
                            'bind'          =>  'change',    
                        ),
                    ),
                ),                    
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>