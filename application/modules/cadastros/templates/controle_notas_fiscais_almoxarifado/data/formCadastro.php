<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
    
    $bsForm = new BsForm(
        array(
            'id'            =>  'form_controleNotasAlmoxarifado_cadastro',
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
                    'type'          =>  'hidden',
                    'id'            =>  'id_item',
                    'value'         =>  $this->cadastro->get('item.value'),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cpf_cnpj_fornecedor',
                    'label'         =>  'CPF/CNPJ :',
                    'class'         =>  array('text-right'),
                    'readonly'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('fornecedor')->variables->get('cpf_cnpj.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                ),
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'fornecedor',
                    'label'         =>  'Fornecedor:',
                    'grid-col'      =>  array(
                        'lg'        =>  17
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  24 
                    ),
                    'readonly_key'  =>  TRUE,
                    'hide_key'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('fornecedor.value'),
                    'from'          =>  $this->cadastro->variables->get('fornecedor.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id'),
                        'url'       =>  $this->cadastro->get('url'),
                    )
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'numero_nf',
                    'label'         =>  'Número da Nota Fiscal:',
                    'class'         =>  array('text-right'),
                    'value'         =>  $this->cadastro->variables->get('numero_nf.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                ),
                array(
                    'type'          =>  'number',
                    'id'            =>  'valor_nf',
                    'label'         =>  'Valor da Nota Fiscal (R$):',
                    'class'         =>  array('text-right'),
                    'value'         =>  $this->cadastro->variables->get('valor_nf.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  17,  
                    ),
                    'input-col'     =>  array(
                        'lg'    =>  10
                    )
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_entrada_nf',
                    'label'         =>  'Data recebimento:',
                    'class'         =>  array('text-right'),
                    'value'         =>  $this->cadastro->variables->get('data_entrada_nf.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_saida_nf',
                    'label'         =>  'Data repassada:',
                    'class'         =>  array('text-right'),
                    'value'         =>  $this->cadastro->variables->get('data_saida_nf.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  17,  
                    ),
                    'input-col'     =>  array(
                        'lg'    =>  10
                    )
                ),
                                          
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/controle_notas_fiscais_almoxarifado','js_ControleNotasAlmoxarifado',NULL,TRUE));
    
    return $bsFormData;
    
    
}   
    
?>