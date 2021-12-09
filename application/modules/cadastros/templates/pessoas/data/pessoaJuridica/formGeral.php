<?php

/**
 * @author Tony Frezza
 */

$getFormGeral = function(){
    
    $formReadOnly = !$this->cadastro->runActionUserPermissions(
        array(
            'action'            =>  $this->cadastro->get('configs.actions.editItems'),
            'user_id'           =>  $this->CI->data->get('user.id'),
            'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
        )
    );
        
    
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'readonly'      =>  $formReadOnly,
            'inputs'        =>  array(
            
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'entidade_publica',
                    'label'         =>  'Entidade pública',
                    'value'         =>  $this->cadastro->variables->get('entidade_publica.value'),
                    'data-value'    =>  'SIM',
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                    'formgroup-class'   =>  array('margin-top-10')
                    
                ),
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'inativo_receita_federal',
                    'label'         =>  'Inativo na Receita Federal',
                    'value'         =>  $this->cadastro->variables->get('inativo_receita_federal.value'),
                    'data-value'    =>  'SIM',
                    'grid-col'      =>  array(
                        'lg'        =>  16
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  10
                    ),
                    'formgroup-class'   =>  array('margin-top-10','margin-bottom-10')
                    
                ), 
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'esfera',
                    'label'         =>  'Esfera:',
                    'value'         =>  $this->cadastro->variables->get('esfera.value'),
                    'grid-col'     =>  array(
                        'lg'        =>  7,
                    ),
                    'first_null'    =>  TRUE,
                    'from'          =>  $this->cadastro->variables->get('esfera.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'unidade_gestora',
                    'label'         =>  'Tipo Unidade Gestora:',
                    'value'         =>  $this->cadastro->variables->get('unidade_gestora.value'),
                    'grid-col'     =>  array(
                        'lg'        =>  8,
                    ),
                    'first_null'    =>  TRUE,
                    'from'          =>  $this->cadastro->variables->get('unidade_gestora.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ), 
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'codigo_unidade_gestora',
                    'label'         =>  'Código Unidade Gestora:',
                    'readonly'      =>  $this->cadastro->variables->get('unidade_gestora.value') ? FALSE : TRUE,
                    'value'         =>  $this->cadastro->variables->get('codigo_unidade_gestora.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                ), 
                
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'mei',
                    'label'         =>  'Microempreendedor Individual',
                    'value'         =>  $this->cadastro->variables->get('mei.value'),
                    'data-value'    =>  'SIM',
                    'grid-col'      =>  array(
                        'lg'        =>  8
                    ),
                    'formgroup-class'   =>  array('margin-top-20')
                ),
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'responsavel_mei',
                    'label'         =>  'Responsável MEI:',
                    'value'         =>  $this->cadastro->variables->get('responsavel_mei.value'),
                    'readonly'      =>  !boolValue($this->cadastro->variables->get('mei.value')),
                    'readonly_key'  =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'    =>  16,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('responsavel_mei.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id'),
                        'url'       =>  $this->cadastro->get('url'),
                    ),
                    'formgroup-class'   =>  array('margin-top-6') 
                ),
                             
            )
        )    
    );
    
    $arrReturn = $bsForm->getHtmlData(); 
    append($arrReturn['javascript'],"\n");
    append($arrReturn['javascript'],$this->CI->template->load('blank','cadastros/templates/pessoas','pessoaJuridica/js_FormGeral',NULL,TRUE));
    return $arrReturn;
    
}

?>