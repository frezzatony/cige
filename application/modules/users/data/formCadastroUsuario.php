<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->user->runActionUserPermissions(
                array(
                    'action'            =>  $this->user->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
                array(
                    'type'          =>  'hidden',
                    'id'            =>  'pk_id',
                    'value'         =>  $this->user->get('item.value'),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  $this->user->variables->get('id')->get('label'),
                    'value'         =>  $this->user->get('item.value'),
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao',
                    'label'         =>  'Situação',
                    'value'         =>  $this->user->get('item.value') ? $this->user->variables->get('situacao')->get('value')  : 'SIM',
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'options'   =>  array(
                        array(
                            'text'      =>  'ATIVO',
                            'value'     =>  'SIM',
                        ),
                        array(
                            'text'      =>  'INATIVO',
                            'value'     =>  'NÃO'
                        )
                    ),
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'login_user',
                    'label'         =>  $this->user->variables->get('login_user')->get('label'),
                    'required'      =>  TRUE,
                    'value'         =>  $this->user->variables->get('login_user')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome',
                    'label'         =>  $this->user->variables->get('nome')->get('label'),
                    'required'      =>  TRUE,
                    'value'         =>  $this->user->variables->get('nome')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  24
                    ),
                ), 
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'email',
                    'label'         =>  $this->user->variables->get('email')->get('label'),
                    'required'      =>  TRUE,
                    'value'         =>  $this->user->variables->get('email')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  24
                    ),
                ),  
                array(
                    'type'          =>  'password',
                    'id'            =>  'password_user',
                    'label'         =>  $this->user->variables->get('password_user')->get('label'),
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                ),                   
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>