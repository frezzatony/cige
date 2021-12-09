<?php

/**
 * @author Tony Frezza
 */
 
$getFormIntegrantes = function(){
    
    $bsForm = new BsForm(
        array(
            'id'            =>  'form_unidadesFamiliares_integrantes',
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
                    'type'      =>  'grid',
                    'id'        =>  'integrantes',
                    'label'     =>  'Integrantes da Unidade Familiar',
                    'body_style'=>  'height: 290px;',
                    'value'     =>  $this->cadastro->variables->get('integrantes.value'),
                    'inputs'    =>  array(
                        
                        array(
                            'type'          =>  'dropdown',
                            'id'            =>  'integrantes_grau_parentesco',
                            'label'         =>  'Grau de parentesco com o titular:',
                            'readonly_key'  =>  TRUE,
                            'hide_key'      =>  TRUE,
                            'grid-col'      =>  array(
                                'lg'    =>  7,  
                            ),
                            'class'         =>  array('uppercase'),
                            'from'          =>  $this->cadastro->variables->get('integrantes')->variables->get('integrantes_grau_parentesco.from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            )  
                        ),
                        array(
                            'type'          =>  'checkbox',
                            'id'            =>  'integrantes_responsavel_unidade_familiar',
                            'label'         =>  'Responsável pela Unidade Familiar',
                            'data-value'    =>  'SIM',
                            'grid-col'      =>  array(
                                'lg'        =>  17
                            ),
                            'formgroup-class'   =>  array('margin-top-14','margin-bottom-6')
                        ), 
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'integrantes_integrante_cpf_cnpj',
                            'label'         =>  'CPF:',
                            'readonly'      =>  TRUE,
                            'data-mask'     =>  'cpf_cnpj',
                            'grid-col'      =>  array(
                                'lg'    =>  4,  
                            ),
                        ),
                        array(
                            'type'          =>  'externallist',
                            'id'            =>  'integrantes_integrante',
                            'class'         =>  array('integrantes_integrante'),
                            'label'         =>  'Pessoa:',
                            'readonly_key'  =>  TRUE,
                            'hide_key'      =>  TRUE,
                            'grid-col'      =>  array(
                                'lg'    =>  12,  
                            ),
                            'from'          =>  $this->cadastro->variables->get('integrantes')->variables->get('integrantes_integrante.from'),
                            //'url'           =>  BASE_URL.'cadastros/'.$this->cadastro->get('url').'/method/externallist_integrantes',
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id'),
                                'url'       =>  $this->cadastro->get('url'),
                            )  
                        ),
                        
                                                                      
                    )
                ),
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/unidades_familiares','js_UnidadesFamiliares_Integrantes',NULL,TRUE));
    
    return $bsFormData;
    
    
}   
    
?>