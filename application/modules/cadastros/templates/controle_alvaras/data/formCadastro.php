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
                        'lg'    =>  24,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  4
                    ),  
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'numero_processo',
                    'label'         =>  $this->cadastro->variables->get('numero_processo')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('numero_processo')->get('value'),
                    'input_class'   =>  array('bold'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_processo',
                    'label'         =>  $this->cadastro->variables->get('data_processo')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('data_processo')->get('value'),
                    'input_class'   =>  array('bold'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'numero_alvara',
                    'label'         =>  $this->cadastro->variables->get('numero_alvara')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('numero_alvara')->get('value'),
                    'input_class'   =>  array('bold'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_alvara',
                    'label'         =>  $this->cadastro->variables->get('data_alvara')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('data_alvara')->get('value'),
                    'input_class'   =>  array('bold'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    )
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cpf_cnpj_requerente',
                    'grid-col'      =>  array(
                        'lg'        =>  5,
                    ),
                    'data-mask'     =>  'cpf_cnpj',
                    'label'         =>  $this->cadastro->variables->get('cpf_cnpj_requerente')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('cpf_cnpj_requerente')->get('value'),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome_requerente',
                    'label'         =>  $this->cadastro->variables->get('nome_requerente')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('nome_requerente')->get('value'),
                    'input_class'   =>  array('uppercase','bold'),
                    'grid-col'      =>  array(
                        'lg'        =>  19
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'matricula_cartorio',
                    'label'         =>  $this->cadastro->variables->get('matricula_cartorio')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('matricula_cartorio')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'inscricao_imobiliaria',
                    'label'         =>  $this->cadastro->variables->get('inscricao_imobiliaria')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('inscricao_imobiliaria')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  8
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'codigo_imovel',
                    'label'         =>  $this->cadastro->variables->get('codigo_imovel')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('codigo_imovel')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'number',
                    'id'            =>  'area_obra',
                    'label'         =>  $this->cadastro->variables->get('area_obra')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('area_obra')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'tipo_sistema_construtivo',
                    'label'         =>  $this->cadastro->variables->get('tipo_sistema_construtivo')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('tipo_sistema_construtivo')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  8,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('tipo_sistema_construtivo')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )  
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'tipo_empreendimento_construtivo',
                    'label'         =>  $this->cadastro->variables->get('tipo_empreendimento_construtivo')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('tipo_empreendimento_construtivo')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  8,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('tipo_empreendimento_construtivo')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'obra_referida',
                    'label'         =>  $this->cadastro->variables->get('obra_referida')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('obra_referida')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  8
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'endereco_obra',
                    'label'         =>  $this->cadastro->variables->get('endereco_obra')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('endereco_obra')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'numero_endereco_obra',
                    'label'         =>  $this->cadastro->variables->get('numero_endereco_obra')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('numero_endereco_obra')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'bairro_obra',
                    'label'         =>  $this->cadastro->variables->get('bairro_obra')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('bairro_obra')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  8,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('bairro_obra')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )  
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'responsavel_tecnico',
                    'label'         =>  $this->cadastro->variables->get('responsavel_tecnico')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('responsavel_tecnico')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'empresa_executora',
                    'label'         =>  $this->cadastro->variables->get('empresa_executora')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('empresa_executora')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'art_rrt',
                    'label'         =>  $this->cadastro->variables->get('art_rrt')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('art_rrt')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'setor_arquivo_urbanismo',
                    'label'         =>  $this->cadastro->variables->get('setor_arquivo_urbanismo')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('setor_arquivo_urbanismo')->get('value'),
                    'first_null'    =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'    =>  8,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('setor_arquivo_urbanismo')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'caixa_arquivo',
                    'label'         =>  $this->cadastro->variables->get('caixa_arquivo')->get('label'),
                    'value'         =>  $this->cadastro->variables->get('caixa_arquivo')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
            ) 
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>