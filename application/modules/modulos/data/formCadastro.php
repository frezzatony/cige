<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
        
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->modulo->runActionUserPermissions(
                array(
                    'action'            =>  $this->modulo->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'token'         =>  $this->modulo->getToken(),
            'inputs'        =>  array(
                array(
                    'type'          =>  'textbox',
                    'label'         =>  $this->modulo->variables->get('id')->get('label'),
                    'value'         =>  $this->modulo->get('item.value'),
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
                    'label'         =>  'Descrição:',
                    'value'         =>  $this->modulo->variables->get('descricao')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'uri',
                    'label'         =>  'URI:',
                    'value'         =>  $this->modulo->variables->get('uri')->get('value'),
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