<?php

/**
 * @author Tony Frezza
 */


$getFormRevisao = function($arrProp = array()){
    
          
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'id'            =>  'formRevisao',
            'readonly'      =>  $arrProp['readonly'],
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
                        'lg'    =>  3,  
                    ),
                    'input-col'      =>  array(
                        'lg'        =>  24
                    ),
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'dt_abertura_controle',
                    'label'         =>  'Data abertura do controle:',
                    'value'         =>  $this->cadastro->variables->get('dt_abertura_controle.value'),
                    'readonly'      =>  TRUE,
                    'class'         =>  array('text-right'),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    ),
                    'input-col'      =>  array(
                        'lg'        => 24
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'processo_dt_encerramento',
                    'label'         =>  'Data encerramento do processo:',
                    'value'         =>  $this->cadastro->variables->get('processo_dt_encerramento.value'),
                    'readonly'      =>  TRUE,
                    'class'         =>  array('text-right'),
                    'grid-col'      =>  array(
                        'lg'        =>  14
                    ),
                    'input-col'      =>  array(
                        'lg'        =>  10
                    ),
                ),
                          
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'matricula_cartorio',
                    'label'         =>  'Matrícula cartório:',
                    'value'         =>  $this->cadastro->variables->get('matricula_cartorio.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'inscricao_imobiliaria',
                    'label'         =>  'Inscrição imobiliária:',
                    'value'         =>  $this->cadastro->variables->get('inscricao_imobiliaria.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  6
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'codigo_imovel_erp',
                    'label'         =>  'Cód. imóvel sistema:',
                    'value'         =>  $this->cadastro->variables->get('codigo_imovel_erp.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  13
                    ),
                    'input-col'      =>  array(
                        'lg'        =>  8
                    ),
                ),
                
               
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cpf_pessoa_solicitante',
                    'label'         =>  'CPF solicitante:',
                    'value'         =>  $this->cadastro->variables->get('pessoa_solicitante')->variables->get('cpf_cnpj.value'),
                    'readonly'      =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'pessoa_solicitante',
                    'label'         =>  'Solicitante:',
                    'grid-col'      =>  array(
                        'lg'        =>  20
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  15 
                    ),
                    'readonly_key'  =>  TRUE,
                    'hide_key'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('pessoa_solicitante.value'),
                    'from'          =>  $this->cadastro->variables->get('pessoa_solicitante.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id'),
                        'url'       =>  $this->cadastro->get('url'),
                    )
                ),
                
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cpf_pessoa_proprietario',
                    'label'         =>  'CPF/CNPJ prop.:',
                    'value'         =>  $this->cadastro->variables->get('pessoa_proprietario')->variables->get('cpf_cnpj.value'),
                    'readonly'      =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'pessoa_proprietario',
                    'label'         =>  'Proprietário:',
                    'grid-col'      =>  array(
                        'lg'        =>  20
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  15 
                    ),
                    'readonly_key'  =>  TRUE,
                    'hide_key'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('pessoa_proprietario.value'),
                    'from'          =>  $this->cadastro->variables->get('pessoa_proprietario.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id'),
                        'url'       =>  $this->cadastro->get('url'),
                    )
                ),
                
                array(
                    'type'          =>  'textarea',
                    'id'            =>  'detalhamento_revisao',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  'Detalhamento da solicitação:',
                    'value'         =>  $this->cadastro->variables->get('detalhamento_revisao.value'),
                    'data-height'   =>  88,
                ),
                
                                                           
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    //append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/controle_revisoes_iptu','js_ControleRevisoesIptu',NULL,TRUE));
    
    return $bsFormData;
    
    
} ; 

   
?>