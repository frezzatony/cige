<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->entidade->runActionUserPermissions(
                array(
                    'action'            =>  $this->entidade->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'token'         =>  $this->entidade->getToken(),
            'inputs'        =>  array(
                array(
                    'type'          =>  'textbox',
                    'label'         =>  $this->entidade->variables->get('id')->get('label'),
                    'value'         =>  $this->entidade->get('item.value'),
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
                    'type'          =>  'textbox',
                    'id'            =>  'descricao',
                    'label'         =>  $this->entidade->variables->get('descricao')->get('label').':',
                    'value'         =>  $this->entidade->variables->get('descricao')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>