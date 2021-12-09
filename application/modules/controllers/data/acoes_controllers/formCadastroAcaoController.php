<?php

/**
 * @author Tony Frezza
 */


$getFormCadastroAcaoController = function(){
    
    $bsForm = new BsForm(
        array(
            'id'            =>  'bDiABEWmQcwh',
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->acaoController->runActionUserPermissions(
                array(
                    'action'            =>  $this->acaoController->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
               array(
                    'type'          =>  'hidden',
                    'id'            =>  'pk_id',
                    'value'         =>  $this->acaoController->get('item.value'),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  $this->acaoController->variables->get('id')->get('label'),
                    'value'         =>  $this->acaoController->get('item.value'),
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
                    'label'         =>  $this->acaoController->variables->get('descricao')->get('label').':',
                    'value'         =>  $this->acaoController->variables->get('descricao')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'label'         =>  'Tipo de controller:',
                    'id'            =>  'tipo_controller',
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'value'         =>  $this->acaoController->variables->get('controller')->variables->get('tipo')->get('value'),
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
                    'label'         =>  $this->acaoController->variables->get('controller')->get('label').':',
                    'id'            =>  'controller',
                    'value'         =>  $this->acaoController->variables->get('controller')->get('value'),
                    'first_null'    =>  TRUE,
                    'from'      =>  array(
                        'module'        =>  $this->acaoController->variables->get('controller')->get('from.module'),
                        'filters'       =>  array(
                            array(
                                'id'        =>  'tipo',
                                'clause'    =>  'equal',
                                'value'     =>  '{this.inputs.#tipo_controller.value}'   
                            )
                        ),
                        'order'         =>  array(
                            array(
                                'id'        =>  'descricao_plural',
                                'dir'       =>  'ASC',
                            )
                        ),
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao_plural'
                        ),
                    ),
                    'update_on'     =>  array(
                        array(
                            'selector'      =>  'form.#tipo_controller',
                            'bind'          =>  'change',    
                        )
                    ),
                    
                ),
               
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>