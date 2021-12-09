<?php

/**
 * @author Tony Frezza
 */


$getFormCadastroTipo_Relatorio= function(){
    
    $formClass = array('form-controller','tab-enter');
    
    if(!in_array($this->controller->variables->get('tipo')->get('value'),array(4))){
        append($formClass,array('softhide','no-save'));
    }
    
    $bsForm = new BsForm(
        array(
            'id'            =>  'formTipo_Relatorio',
            'class'         =>  $formClass,
            'readonly'      =>  !$this->controller->runActionUserPermissions(
                array(
                    'action'            =>  $this->controller->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'token'         =>  $this->controller->getToken(),
            'inputs'        =>  array(
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  'Código:',
                    'value'         =>  $this->controller->get('item.value'),
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
                    'label'         =>  'Situação:',
                    'value'         =>  $this->controller->variables->get('ativo.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'options'       =>  $this->controller->variables->get('ativo.options')
                    
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'tipo',
                    'label'         =>  'Tipo:',
                    'value'         =>  $this->controller->variables->get('tipo')->get('value'),
                    'from'          =>  $this->controller->variables->get('tipo')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  $this->controller->variables->get('tipo')->get('from.module'),
                        'request'   =>  $this->controller->get('id')
                    ),
                    'grid-col'      =>  array(
                        'lg'    =>  24,  
                    ),
                    'input-col'     =>  array(
                        'lg'    =>  8
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'modulo',
                    'label'         =>  'Módulo:',
                    'first_null'    =>  TRUE,
                    'value'         =>  $this->controller->variables->get('modulo')->get('value'),
                    'from'          =>  $this->controller->variables->get('modulo')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  $this->controller->variables->get('modulo')->get('from.module'),
                        'request'   =>  $this->controller->get('id')
                    ),
                    'grid-col'      =>  array(
                        'lg'    =>  8,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'descricao_plural',
                    'label'         =>  'Descrição:',
                    'value'         =>  $this->controller->variables->get('descricao_plural')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'url',
                    'label'         =>  $this->controller->variables->get('url')->get('label').':',
                    'value'         =>  $this->controller->variables->get('url')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'controller',
                    'label'         =>  $this->controller->variables->get('controller')->get('label').':',
                    'value'         =>  $this->controller->variables->get('controller')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
            )
        )   
    );
    
    $arrDataReturn = $bsForm->getHtmlData();
    
    return $arrDataReturn;
    
    
}   
    
?>