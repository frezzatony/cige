<?php

/**
 * @author Tony Frezza
 */


$getFormDocumentos= function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
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
                    'id'            =>  'cpf_cnpj',
                    'label'         =>  'CPF:',
                    'value'         =>  $this->cadastro->variables->get('cpf_cnpj')->get('value'),
                    'placeholder'   =>  '___.___.___-__',
                    'data-mask'     =>  '999.999.999-99',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'rg',
                    'label'         =>  'RG:',
                    'value'         =>  $this->cadastro->variables->get('rg')->get('value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'certidao_nascimento',
                    'value'         =>  $this->cadastro->variables->get('certidao_nascimento.value'),
                    'label'         =>  'Certidão de nascimento:',
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'certidao_casamento',
                    'value'         =>  $this->cadastro->variables->get('certidao_nascimento.value'),
                    'label'         =>  'Certidão de casamento:',
                    'input-col'     =>  array(
                        'lg'        =>  12
                    ),
                    'grid-col'      =>  array(
                        'lg'        =>  10
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'orgao_emissor_rg',
                    'value'         =>  $this->cadastro->variables->get('orgao_emissor_rg.value'),
                    'label'         =>  'Órgão Emissor RG:',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_emissao_rg',
                    'value'         =>  $this->cadastro->variables->get('data_emissao_rg.value'),
                    'label'         =>  'Data Emissão RG:',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'estado_emissor_rg',
                    'label'         =>  'Estado Emissor RG:',
                    'grid-col'      =>  array(
                        'lg'        =>  8
                    ),
                    'first_null'    =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('estado_emissor_rg.value'),
                    'from'          =>  $this->cadastro->variables->get('estado_emissor_rg.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-lg-8','height-42'),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'pis_pasep',
                    'value'         =>  $this->cadastro->variables->get('pis_pasep.value'),
                    'label'         =>  'PIS/PASEP:',
                    'data-mask'     =>  '###.#####.##.#',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'ctps',
                    'value'         =>  $this->cadastro->variables->get('ctps.value'),
                    'label'         =>  'Nº CTPS:',
                    'data-mask'     =>  '999999999',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'serie_ctps',
                    'value'         =>  $this->cadastro->variables->get('serie_ctps.value'),
                    'label'         =>  'Série CTPS:',
                    'data-mask'     =>  '999999999',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_emissao_ctps',
                    'value'         =>  $this->cadastro->variables->get('data_emissao_ctps.value'),
                    'label'         =>  'Data Emissão CTPS:',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'estado_emissor_ctps',
                    'label'         =>  'Estado Emissor CTPS:',
                    'grid-col'      =>  array(
                        'lg'        =>  8
                    ),
                    'first_null'    =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('estado_emissor_ctps.value'),
                    'from'          =>  $this->cadastro->variables->get('estado_emissor_ctps.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'titulo_eleitor',
                    'value'         =>  $this->cadastro->variables->get('titulo_eleitor.value'),
                    'label'         =>  'Nº Título Eleitor:',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'zona_titulo_eleitor',
                    'value'         =>  $this->cadastro->variables->get('zona_titulo_eleitor.value'),
                    'label'         =>  'Zona:',
                    'data-mask'     =>  '9999',
                    'grid-col'      =>  array(
                        'lg'        =>  2
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'secao_titulo_eleitor',
                    'value'         =>  $this->cadastro->variables->get('secao_titulo_eleitor.value'),
                    'label'         =>  'Seção:',
                    'data-mask'     =>  '9999',
                    'grid-col'      =>  array(
                        'lg'        =>  2
                    )  
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'estado_emissor_titulo_eleitor',
                    'label'         =>  'Estado Título Eleitor:',
                    'grid-col'      =>  array(
                        'lg'        =>  16
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'first_null'    =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('estado_emissor_titulo_eleitor.value'),
                    'from'          =>  $this->cadastro->variables->get('estado_emissor_titulo_eleitor.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cnh',
                    'value'         =>  $this->cadastro->variables->get('cnh.value'),
                    'label'         =>  'Nº CNH:',
                    'data-mask'     =>  '9999999999999999999',
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'categoria_cnh',
                    'value'         =>  $this->cadastro->variables->get('categoria_cnh.value'),
                    'label'         =>  'Categoria CNH:',
                    'grid-col'      =>  array(
                        'lg'        =>  3
                    )  
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_validade_cnh',
                    'value'         =>  $this->cadastro->variables->get('data_validade_cnh.value'),
                    'label'         =>  'Data Validade CNH:',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'estado_emissor_cnh',
                    'label'         =>  'Estado Emissor CNH:',
                    'grid-col'      =>  array(
                        'lg'        =>  8
                    ),
                    'first_null'    =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('estado_emissor_cnh.value'),
                    'from'          =>  $this->cadastro->variables->get('estado_emissor_cnh.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'observacao_cnh',
                    'value'         =>  $this->cadastro->variables->get('observacao_cnh.value'),
                    'label'         =>  'Observações CNH:',
                    'grid-col'      =>  array(
                        'lg'        =>  24
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  20
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'certificado_reservista',
                    'value'         =>  $this->cadastro->variables->get('certificado_reservista.value'),
                    'label'         =>  'N° Cert. Reservista:',
                    'data-mask'     =>  '9999999999999999999',
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'orgao_certificado_reservista',
                    'value'         =>  $this->cadastro->variables->get('orgao_certificado_reservista.value'),
                    'label'         =>  'Órgão Cert. Reservista:',
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'categoria_certificado_reservista',
                    'value'         =>  $this->cadastro->variables->get('categoria_certificado_reservista.value'),
                    'label'         =>  'Categoria Cert. Reservista:',
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_emissao_certificado_reservista',
                    'value'         =>  $this->cadastro->variables->get('data_emissao_certificado_reservista.value'),
                    'label'         =>  'Data Emissão Cert. Reserv:',
                    'grid-col'      =>  array(
                        'lg'        =>  10
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  12
                    ), 
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cartao_sus',
                    'value'         =>  $this->cadastro->variables->get('cartao_sus.value'),
                    'label'         =>  'Nº Carão SUS:',
                    'data-mask'     =>  '9999999999999999999',
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nis',
                    'value'         =>  $this->cadastro->variables->get('nis.value'),
                    'label'         =>  'NIS:',
                    'data-mask'     =>  '9999999999999999999',
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    )  
                ),
                
            )
        )    
    );
   
    return $bsForm->getHtmlData();
    
}

?>