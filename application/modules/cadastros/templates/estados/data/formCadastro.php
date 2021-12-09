<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
    
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
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  $this->cadastro->variables->get('id')->get('label'),
                    'value'         =>  $this->cadastro->get('item.value'),
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
                    'label'         =>  $this->cadastro->variables->get('situacao')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('situacao')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome',
                    'label'         =>  $this->cadastro->variables->get('nome')->get('label'),
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('nome')->get('value'),
                    'input_class'   =>  array('uppercase'),
                    'grid-col'      =>  array(
                        'lg'        =>  24
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'abreviatura',
                    'label'         =>  $this->cadastro->variables->get('abreviatura')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('abreviatura')->get('value'),
                    'input_class'   =>  array('uppercase'),
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'pais',
                    'label'         =>  $this->cadastro->variables->get('pais')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('pais')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'from'          =>  $this->cadastro->variables->get('pais')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>