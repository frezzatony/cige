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
                    'label'         =>  'Código',
                    'value'         =>  $this->cadastro->get('item.value'),
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  3,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  24
                    ),
                    
                ),
                
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'em_uso',
                    'label'         =>  'Em uso',
                    'data-value'    =>  'SIM',
                    'value'         =>  $this->cadastro->variables->get('em_uso.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  14
                    ),
                    'formgroup-class'   =>  array('margin-top-14','margin-bottom-12')
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao',
                    'label'         =>  'Situação cadastro:',
                    'value'         =>  $this->cadastro->variables->get('situacao.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  12
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'orgao',
                    'label'         =>  'Órgão/Secretaria',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('orgao.value'),
                    'input_class'   =>  array('uppercase'),
                    'grid-col'     =>  array(
                        'lg'        =>  6
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'numero_linha',
                    'label'         =>  'Número Linha',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('numero_linha.value'),
                    'input_class'   =>  array(''),
                    'data-mask'     =>  $this->cadastro->variables->get('numero_linha.mask'),
                    'grid-col'     =>  array(
                        'lg'        =>  6
                    ),
                ), 
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'tipo_plano_telefonico',
                    'label'         =>  'Tipo Plano Telef.',
                    'value'         =>  $this->cadastro->variables->get('tipo_plano_telefonico.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  6,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('tipo_plano_telefonico.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'login_gestor',
                    'label'         =>  'Login gestor',
                    'value'         =>  $this->cadastro->variables->get('login_gestor.value'),
                    'input_class'   =>  array(''),
                    'grid-col'     =>  array(
                        'lg'        =>  6
                    ),
                ),
                array(
                    'type'          =>  'summernote',
                    'id'            =>  'observacoes',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  'Observações:',
                    'value'         =>  $this->cadastro->variables->get('observacoes.value'),
                    'data-height'   =>  160,
                ),                          
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>