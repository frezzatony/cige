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
                    'label'         =>  'Código:',
                    'value'         =>  $this->cadastro->get('item.value'),
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'        =>  4,  
                    ),
                    
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'protocolo',
                    'label'         =>  'Protocolo:',
                    'value'         =>  $this->cadastro->variables->get('protocolo')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'reserva_terreno',
                    'label'         =>  'Reserva de terreno:',
                    'value'         =>  $this->cadastro->variables->get('reserva_terreno')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  6,  
                    ),
                    'options'       =>  array(
                        array(
                            'text'      =>  'SIM',
                            'value'     =>  'SIM'
                        ),
                        array(
                            'text'      =>  'NÃO',
                            'value'     =>  'NÃO'
                        ),                                    
                    ),
                    
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao',
                    'label'         =>  'Situação:',
                    'value'         =>  $this->cadastro->variables->get('situacao')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  6,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome_requerente',
                    'label'         =>  'Nome requerente:',
                    'value'         =>  $this->cadastro->variables->get('nome_requerente')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'endereco_requerente',
                    'label'         =>  'Endereço requerente:',
                    'value'         =>  $this->cadastro->variables->get('endereco_requerente')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome_falecido',
                    'label'         =>  'Nome falecido:',
                    'value'         =>  $this->cadastro->variables->get('nome_falecido')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  16
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cpf_falecido',
                    'label'         =>  'CPF Falecido:',
                    'value'         =>  $this->cadastro->variables->get('cpf_falecido')->get('value'),
                    'placeholder'   =>  '___.___.___-__',
                    'data-mask'     =>  '999.999.999-99',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'integer',
                    'id'            =>  'idade_falecido',
                    'label'         =>  'Idade:',
                    'value'         =>  $this->cadastro->variables->get('idade_falecido')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  3
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome_pai_falecido',
                    'label'         =>  'Nome pai:',
                    'value'         =>  $this->cadastro->variables->get('nome_pai_falecido')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome_mae_falecido',
                    'label'         =>  'Nome mãe:',
                    'value'         =>  $this->cadastro->variables->get('nome_mae_falecido')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_falecimento',
                    'label'         =>  'Data falecimento:',
                    'value'         =>  $this->cadastro->variables->get('data_falecimento')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'hora_falecimento',
                    'label'         =>  'Hora falecimento:',
                    'data-mask'     =>  '99:99',
                    'value'         =>  $this->cadastro->variables->get('hora_falecimento')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'termo_certidao_obito',
                    'label'         =>  'Termo Cert. Óbito:',
                    'value'         =>  $this->cadastro->variables->get('termo_certidao_obito')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'folhas',
                    'label'         =>  'Folhas Cert. Óbito:',
                    'value'         =>  $this->cadastro->variables->get('folhas')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'livro',
                    'label'         =>  'Livro Cert. Óbito:',
                    'value'         =>  $this->cadastro->variables->get('livro')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'cemiterio',
                    'label'         =>  'Cemitério:',
                    'value'         =>  $this->cadastro->variables->get('cemiterio')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  7,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('cemiterio')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'quadra',
                    'label'         =>  'Quadra:',
                    'value'         =>  $this->cadastro->variables->get('quadra')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  2
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'fileira',
                    'label'         =>  'Fileira:',
                    'value'         =>  $this->cadastro->variables->get('fileira')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  2
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'sepultura',
                    'label'         =>  'Sepultura:',
                    'value'         =>  $this->cadastro->variables->get('sepultura')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  2
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'lado',
                    'label'         =>  'Lado:',
                    'value'         =>  $this->cadastro->variables->get('lado')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4,  
                    ),
                    'options'       => $this->cadastro->variables->get('lado')->get('options') 
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'numero_tumulo',
                    'label'         =>  'Núm tpumulo:',
                    'value'         =>  $this->cadastro->variables->get('numero_tumulo')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  3
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'caixa_arquivo',
                    'label'         =>  'Caixa arquivo:',
                    'value'         =>  $this->cadastro->variables->get('caixa_arquivo')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  3
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'causa_mortis',
                    'label'         =>  'Causa mortis:',
                    'value'         =>  $this->cadastro->variables->get('causa_mortis')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                ),
                                        
            ) 
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>