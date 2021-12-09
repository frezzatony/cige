<?php

/**
 * @author Tony Frezza
 */


$getFormCadastroTipo_Controller = function(){
    
    $formClass = array('form-controller','tab-enter');
    
    if(!in_array($this->controller->variables->get('tipo')->get('value'),array(NULL,1,2,3))){
        append($formClass,array('softhide','no-save'));
    }
    
    $bsForm = new BsForm(
        array(
            'id'            =>  'formTipo_Controller',
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
                        'lg'        =>  8
                    ),
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'descricao_singular',
                    'label'         =>  'Descrição singular:',
                    'value'         =>  $this->controller->variables->get('descricao_singular')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'descricao_plural',
                    'label'         =>  'Descrição plural:',
                    'value'         =>  $this->controller->variables->get('descricao_plural')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'url',
                    'label'         =>  'Url:',
                    'value'         =>  $this->controller->variables->get('url')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'controller',
                    'label'         =>  'Nome arquivo Controller:',
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