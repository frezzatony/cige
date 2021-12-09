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
    
    $paiDesconhecidoValue = $this->cadastro->variables->get('pai_desconhecido.value');
    $maeDesconhecidaValue = $this->cadastro->variables->get('mae_desconhecida.value');
    $paisDeOrigemValue = $this->cadastro->variables->get('pais_origem.value') ? $this->cadastro->variables->get('pais_origem.value') : 1;
    
    //Defalult: 1-Nenhuma
    $necessidadeEspecialDefaultValue = 1;
    $necessidadeEspecialValue = $this->cadastro->variables->get('necessidade_especial.value') ? $this->cadastro->variables->get('necessidade_especial.value') : $necessidadeEspecialDefaultValue; 
    
    
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'readonly'      =>  $formReadOnly,
            'inputs'        =>  array(
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome_mae',
                    'label'         =>  'Nome completo da mãe:',
                    'value'         =>  ($maeDesconhecidaValue =='SIM' ? NULL : $this->cadastro->variables->get('nome_mae.value')),
                    'readonly'      =>  ($maeDesconhecidaValue=='SIM' ? TRUE : FALSE),
                    'class'         =>  array('ucfirst'),
                    'grid-col'      =>  array(
                        'lg'        =>  18
                    ) 
                ),
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'mae_desconhecida',
                    'label'         =>  'Mãe desconhecida',
                    'data-value'    =>  'SIM',
                    'value'         =>  $maeDesconhecidaValue,
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                    'formgroup-class'   =>  array('margin-top-14','margin-bottom-6')
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome_pai',
                    'value'         =>  ($paiDesconhecidoValue =='SIM' ? NULL : $this->cadastro->variables->get('nome_pai.value')),
                    'label'         =>  'Nome completo do pai:',
                    'readonly'      =>  ($paiDesconhecidoValue=='SIM' ? TRUE : FALSE),
                    'class'         =>  array('ucfirst'),
                    'grid-col'      =>  array(
                        'lg'        =>  18
                    )  
                ),
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'pai_desconhecido',
                    'label'         =>  'Pai desconhecido',
                    'data-value'    =>  'SIM',
                    'value'         =>  $paiDesconhecidoValue,
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                    'formgroup-class'   =>   array('margin-top-14','margin-bottom-6')
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_nascimento',
                    'label'         =>  'Data de Nasc.:',
                    'value'         =>  $this->cadastro->variables->get('data_nascimento.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'estado_civil',
                    'label'         =>  'Estado Civil:',
                    'grid-col'      =>  array(
                        'lg'        =>  8
                    ),
                    'first_null'    =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('estado_civil.value') ? $this->cadastro->variables->get('estado_civil.value')  : 8, //Default: NAO INFORMADO
                    'from'          =>  $this->cadastro->variables->get('estado_civil.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'aposentado',
                    'label'         =>  'Aposentado(a)',
                    'data-value'    =>  'SIM',
                    'value'         =>  $this->cadastro->variables->get('aposentado.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  11
                    ),
                    'formgroup-class'   =>  array('margin-top-14','margin-bottom-6')
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'nacionalidade',
                    'label'         =>  'Nacionalidade:',
                    'grid-col'      =>  array(
                        'lg'        =>  7
                    ),
                    'value'         =>  $this->cadastro->variables->get('nacionalidade.value'),
                    'from'          =>  $this->cadastro->variables->get('nacionalidade.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'naturalizado',
                    'label'         =>  'Naturalizado',
                    'data-value'    =>  'SIM',
                    'value'         =>  $this->cadastro->variables->get('naturalizado.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    ),
                    'formgroup-class'   =>  array('margin-top-14','margin-bottom-4')
                ),
                
                array(
                    'type'              =>  'dropdown',
                    'id'                =>  'pais_origem',
                    'label'             =>  'País de Origem:',
                    'data-pais-default' =>  1,//cadastro de Paises: 1 - Brasil
                    'grid-col'          =>  array(
                        'lg'        =>  5
                    ),
                    'value'             =>  $paisDeOrigemValue,
                    'from'              =>  $this->cadastro->variables->get('pais_origem.from'),
                    'parent'            =>  array(
                        'module'        =>  'cadastros',
                        'request'       =>  $this->cadastro->get('id')
                    )
                ),
                
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_chegada_pais_origem',
                    'label'         =>  'Data da chegada:',
                    'readonly'      =>  ($paisDeOrigemValue==1 ? TRUE : FALSE),
                    'value'         =>  ($paisDeOrigemValue==1 ? NULL : $this->cadastro->variables->get('data_chegada_pais_origem.value')),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
                
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'cidade_natural',
                    'label'         =>  'Cidade Natural:',
                    'grid-col'      =>  array(
                        'lg'        =>  16
                    ),
                    'value'         =>  $this->cadastro->variables->get('cidade_natural.value'),
                    'from'          =>  $this->cadastro->variables->get('cidade_natural.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'grau_instrucao',
                    'label'         =>  'Grau de instrução:',
                    'grid-col'      =>  array(
                        'lg'        =>  18
                    ),
                    'value'         =>  $this->cadastro->variables->get('grau_instrucao.value'),
                    'from'          =>  $this->cadastro->variables->get('grau_instrucao.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    ),
                ),
                
                array(
                    'type'          =>  'year',
                    'id'            =>  'ano_grau_instrucao',
                    'label'         =>  'Ano grau de instrução:',
                    'value'         =>  $this->cadastro->variables->get('ano_grau_instrucao.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  20,
                    ),
                    'input_class'   =>  array('text-right'), 
                ),
                array(
                    'tag'           =>  'div',
                    'class'         =>  array('col-lg-24','nopaddin','nomargin'),
                ),
                array(
                    'type'                  =>  'dropdown',
                    'id'                    =>  'necessidade_especial',
                    'label'                 =>  'Possui deficiência:',
                    'data-value-default'    =>  $necessidadeEspecialDefaultValue,//tipo default: Nenhuma
                    'grid-col'              =>  array(
                        'lg'        =>  6
                    ),
                    'value'                 =>  $necessidadeEspecialValue,
                    'from'                  =>  $this->cadastro->variables->get('necessidade_especial.from'),
                    'parent'                =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    ),
                ),
                array(
                    'type'          =>  'checkbox',
                    'id'            =>  'capaz_trabalho',
                    'label'         =>  'Capaz para Trabalhar',
                    'data-value'    =>  'SIM',
                    'value'         =>  ($this->cadastro->get('item.value') ? $this->cadastro->variables->get('capaz_trabalho.value') : 'SIM'),
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                    'formgroup-class'   =>   array('margin-top-14','margin-bottom-6')
                ),
                 array(
                    'type'          =>  'textbox',
                    'id'            =>  'observacoes_necessidade_especial',
                    'label'         =>  'Observações deficiência:',
                    'value'         =>  $this->cadastro->variables->get('observacoes_necessidade_especial.value'),
                    'class'         =>  array('uppercase'),
                    'grid-col'      =>  array(
                        'lg'        =>  18
                    )  
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_falecimento',
                    'label'         =>  'Data de falecimento:',
                    'value'         =>  $this->cadastro->variables->get('data_falecimento.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
            )
        )    
    );
    
    $arrReturn = $bsForm->getHtmlData(); 
    append($arrReturn['javascript'],"\n");
    append($arrReturn['javascript'],$this->CI->template->load('blank','cadastros/templates/pessoas','pessoaFisica/js_FormGeral',NULL,TRUE));
    return $arrReturn;
    
}

?>