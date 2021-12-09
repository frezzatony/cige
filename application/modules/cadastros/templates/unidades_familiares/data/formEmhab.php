<?php

/**
 * @author Tony Frezza
 */


$getFormEmhab = function($arrProp = array()){
    
    if($this->cadastro->variables->get('last_activity.value')){
        
        $dtUltimaAlteracao = DateTime::createFromFormat('d/m/Y H:i:s', $this->cadastro->variables->get('last_activity.value'));
        $dtNow = new DateTime('now');
        
        $diff = $dtNow->diff($dtUltimaAlteracao);
        $totalMesesAtualizacaoCadastro = (($diff->format('%y') * 12) + $diff->format('%m'));
        
        
        $inputStatusClass = array(
            'bold'
        );
        
        if($totalMesesAtualizacaoCadastro > 24){
            $statusCadastro = 'Desatualizado';
            $inputStatusClass[] = 'color-red';
        }
        else{
            $statusCadastro = 'Atualizado';
            $inputStatusClass[] = 'color-green';
        }
          
    }
    
      
    $bsForm = new BsForm(
        array(
            'id'            =>  'form_unidadesFamiliares_emhab',
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
                    'label'         =>  'Status do cadastro:',
                    'input_class'   =>  $inputStatusClass ?? NULL,
                    'readonly'      =>  TRUE,
                    'value'         =>  $statusCadastro ?? NULL,
                    'grid-col'      =>  array(
                        'lg'    =>  17,  
                    ),
                    'input-col'      =>  array(
                        'lg'    =>  6,  
                    ),
                ),           
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'programas_sociais_emhab',
                    'label'         =>  'Programa de interesse:',
                    'first_null'    =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('programas_sociais_emhab.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                    'class'         =>  array('uppercase'),
                    'from'          =>  $this->cadastro->variables->get('programas_sociais_emhab.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )  
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'atendido_programa_social_emhab',
                    'label'         =>  'Já atendido:',
                    'value'         =>  boolValue($this->cadastro->variables->get('atendido_programa_social_emhab.value')),
                    'grid-col'      =>  array(
                        'lg'    =>  3,  
                    ),
                    'class'         =>  array('uppercase'),
                    'options'       =>  array(
                        array(
                            'value' =>  'f',
                            'text'  =>  'NÃO'
                        ),
                        array(
                            'value' =>  't',
                            'text'  =>  'SIM',
                        ),
                    )
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_atendimento_programa_social_emhab',
                    'label'         =>  'Data contemplação:',
                    'first_null'    =>  TRUE,
                    'readonly'      =>  !boolValue($this->cadastro->variables->get('atendido_programa_social_emhab.value')),
                    'value'         =>  $this->cadastro->variables->get('data_atendimento_programa_social_emhab.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                    
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'programas_sociais_emhab_atendido',
                    'label'         =>  'Programa atendido:',
                    'first_null'    =>  TRUE,
                    'readonly'      =>  !boolValue($this->cadastro->variables->get('atendido_programa_social_emhab.value')),
                    'dropdown'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('programas_sociais_emhab_atendido.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                    'class'         =>  array('uppercase'),
                    'from'          =>  $this->cadastro->variables->get('programas_sociais_emhab_atendido.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )  
                ),
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/unidades_familiares','js_UnidadesFamiliares_Emhab',NULL,TRUE));
    
    return $bsFormData;
}   
    
?>