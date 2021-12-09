<?php

/**
 * @author Tony Frezza
 */


$getFormEnderecoRevisao = function($arrProp = array()){
    
          
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'id'            =>  'formEnderecoRevisao',
            'readonly'      =>  $arrProp['readonly'],
            'inputs'    =>  array(
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'revisao_endereco_cep', 
                    'label'         =>  'CEP:',
                    'data-mask'     =>  '99.999-999',
                    'placeholder'   =>  '__.___-__', 
                    'grid-col'      =>  array(
                        'lg'        =>  3
                    ),
                    'token'         =>  $this->CI->encryption->encrypt(
                        $this->CI->json->getAllAsString(
                            array(
                                'internal'      =>  TRUE,
                                'source'        =>  'cep'
                            )
                        )
                    ),
                    'value'         =>  $this->cadastro->variables->get('revisao_endereco_cep.value'),
                ),  
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'revisao_endereco_bairro',
                    'label'         =>  'Bairro:',
                    'class'         =>  array('uppercase'),
                    'grid-col'      =>  array(
                        'lg'    =>  14,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  11,  
                    ),
                    'value'         =>  $this->cadastro->variables->get('revisao_endereco_bairro.value'),
                ),
                
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'revisao_endereco_logradouro',
                    'label'         =>  'Logradouro:',
                    'class'         =>  array('uppercase'),
                    'grid-col'      =>  array(
                        'lg'    =>  13,  
                    ),
                    'value'         =>  $this->cadastro->variables->get('revisao_endereco_logradouro.value'),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'revisao_endereco_numero', 
                    'label'         =>  'Número:',
                    'class'         =>  array('uppercase'), 
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    ),
                    'value'         =>  $this->cadastro->variables->get('revisao_endereco_numero.value'),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'revisao_endereco_complemento', 
                    'label'         =>  'Complemento:', 
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                    'value'         =>  $this->cadastro->variables->get('revisao_endereco_complemento.value'),
                ), 
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'revisao_endereco_ponto_referencia', 
                    'label'         =>  'Ponto de referência:', 
                    'grid-col'      =>  array(
                        'lg'        =>  12
                    ),
                    'value'         =>  $this->cadastro->variables->get('revisao_endereco_ponto_referencia.value'),
                ),                         
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    //append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/controle_revisoes_iptu','js_ControleRevisoesIptu',NULL,TRUE));
    
    return $bsFormData;
    
    
} ; 

   
?>