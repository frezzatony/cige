<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
    
    $bsForm = new BsForm(
        array(
            'id'            =>  'form_unidadesFamiliares_cadastro',
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
                    'label'         =>  $this->cadastro->variables->get('id.label'),
                    'value'         =>  $this->cadastro->get('item.value'),
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'label'         =>  'Última edição:',
                    'input_class'   =>  'text-right',
                    'readonly'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('last_activity.value').'h',
                    'grid-col'      =>  array(
                        'lg'    =>  5,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cadunico',
                    'label'         =>  'CadÚnico:',
                    'input_class'   =>  'text-right',
                    'value'         =>  $this->cadastro->variables->get('cadunico.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  15,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  5
                    )
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cpf_titular',
                    'label'         =>  'CPF:',
                    'readonly'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('titular')->variables->get('cpf_cnpj.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nis_titular',
                    'label'         =>  'NIS:',
                    'readonly'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('titular')->variables->get('nis.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                ),
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'titular',
                    'label'         =>  'Titular:',
                    'grid-col'      =>  array(
                        'lg'        =>  16
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  16 
                    ),
                    'readonly_key'  =>  TRUE,
                    'hide_key'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('titular.value'),
                    'from'          =>  $this->cadastro->variables->get('titular.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id'),
                        'url'       =>  $this->cadastro->get('url'),
                    )
                ),
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'titular_responsavel',
                    'label'         =>  'Titular é responsável pela Unidade Familiar',
                    'data-value'    =>  'SIM',
                    'value'         =>  ($this->cadastro->get('item.value') ? $this->cadastro->variables->get('titular_responsavel.value') : 'SIM'),
                    'grid-col'      =>  array(
                        'lg'    =>  24,  
                    ),
                    'formgroup-class'   =>   array('margin-top-6','margin-bottom-6')
                ),
                
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_inicio_residencia',
                    'label'         =>  'Reside no local desde:',
                    'class'         =>  array('text-right'),
                    'value'         =>  $this->cadastro->variables->get('data_inicio_residencia.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                ), 
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'vinculo_moradia',
                    'label'         =>  'Vínculo moradia:',
                    'value'         =>  $this->cadastro->variables->get('vinculo_moradia.value'),
                    'first_null'    =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                    'class'         =>  array('uppercase'),
                    'from'          =>  $this->cadastro->variables->get('vinculo_moradia.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'tipo_moradia',
                    'label'         =>  'Tipo de moradia:',
                    'class'         =>  array('uppercase'),
                    'value'         =>  $this->cadastro->variables->get('tipo_moradia.value'),
                    'first_null'    =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('tipo_moradia.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'sistema_construtivo_moradia',
                    'label'         =>  'Material moradia:',
                    'class'         =>  array('uppercase'),
                    'value'         =>  $this->cadastro->variables->get('sistema_construtivo_moradia.value'),
                    'first_null'    =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('sistema_construtivo_moradia.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )  
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao_moradia',
                    'label'         =>  'Situação da moradia:',
                    'class'         =>  array('uppercase'),
                    'value'         =>  $this->cadastro->variables->get('situacao_moradia.value'),
                    'first_null'    =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao_moradia.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )  
                ),
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/unidades_familiares','js_UnidadesFamiliares',NULL,TRUE));
    
    return $bsFormData;
}   
    
?>