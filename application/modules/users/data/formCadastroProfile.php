<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->profileUser->runActionUserPermissions(
                array(
                    'action'            =>  $this->profileUser->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
                array(
                    'type'          =>  'hidden',
                    'id'            =>  'pk_id',
                    'value'         =>  $this->profileUser->get('item.value'),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  $this->profileUser->variables->get('id')->get('label').':',
                    'value'         =>  $this->profileUser->get('item.value'),
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
                    'id'            =>  'ativo',
                    'label'         =>  $this->profileUser->variables->get('ativo.label').':',
                    'value'         =>  $this->profileUser->variables->get('ativo.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'options'       =>  $this->profileUser->variables->get('ativo.options')
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome',
                    'label'         =>  $this->profileUser->variables->get('nome')->get('label').':',
                    'value'         =>  $this->profileUser->variables->get('nome')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'descricao',
                    'label'         =>  $this->profileUser->variables->get('descricao')->get('label').':',
                    'value'         =>  $this->profileUser->variables->get('descricao')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'administrador',
                    'label'         =>  $this->profileUser->variables->get('administrador.label').':',
                    'value'         =>  $this->profileUser->variables->get('administrador.value'),
                    'readonly'      =>  ($this->profileUser->get('item.value')==1 ? TRUE : FALSE), //Default: readonly para Profile Administradores
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  10
                    ),
                    'options'   =>  array(
                        array(
                            'text'      =>  'NÃO',
                            'value'     =>  'NÃO',
                        ),
                        array(
                            'text'      =>  'SIM',
                            'value'     =>  'SIM'
                        )
                    ),
                    
                ),
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>