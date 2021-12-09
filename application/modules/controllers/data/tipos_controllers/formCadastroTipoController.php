<?php

/**
 * @author Tony Frezza
 */


$getFormCadastroTipoController = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->tipoController->runActionUserPermissions(
                array(
                    'action'            =>  $this->tipoController->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  $this->tipoController->variables->get('id')->get('label'),
                    'value'         =>  $this->tipoController->get('item.value'),
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
                    'label'         =>  $this->tipoController->variables->get('descricao')->get('label').':',
                    'value'         =>  $this->tipoController->variables->get('descricao')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'modulo_codigofonte',
                    'label'         =>  'Módulo no Código Fonte:',
                    'value'         =>  $this->tipoController->variables->get('modulo_codigofonte.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'uri',
                    'label'         =>  'Uri (url):',
                    'value'         =>  $this->tipoController->variables->get('uri.value'),
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