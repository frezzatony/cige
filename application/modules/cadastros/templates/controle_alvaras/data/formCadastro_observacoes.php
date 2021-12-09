<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro_observacoes = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->cadastro->runActionUserPermissions(
                array(
                    'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                    'user_id'           =>  $this->CI->data->get('user.id'),
                    'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
                array(
                    'type'          =>  'summernote',
                    'id'            =>  'observacoes',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  $this->cadastro->variables->get('observacoes')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('observacoes')->get('value'),
                    'data-height'   =>  228,
                ),
            
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>