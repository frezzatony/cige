<?php

/**
 * @author Tony Frezza
 */


$getFormProcesso = function($arrProp = array()){
    
    
    if(
        $this->cadastro->get('item.value') AND 
        $this->cadastro->variables->get('processo_responsavel.value') != $this->CI->data->get('user.id') AND
        $arrProp['readonly']==FALSE
    ){
        $btnReceberProcesso = array(
            'tag'       =>  'div',
            'class'     =>  array('col-lg-1 container','nopadding','nomargin','padding-top-15'),
            'children'  =>  array(
                array(
                    'tag'                   =>  'button',
                    'class'                 =>  array('btn','btn-sm','btn-3d','btn-seccondary','size-11','btn-receber-processo'),
                    'title'                 =>  'Informar estar tramitando internamente no setor.',
                    'text'                  =>  '<i class="fa fa-angle-double-down"></i> Tornar-se resposável',
                    'data-id_responsavel'    =>  $this->CI->encryption->encrypt($this->CI->data->get('user.id')),
                    'data-pk_item'           =>  $this->CI->encryption->encrypt($this->cadastro->get('item.value')),
                )
            )
        );
    }
    
    
    
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'id'            =>  'formProcesso',
            'readonly'      =>  $arrProp['readonly'],
            'inputs'        =>  array(
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'processo_situacao',
                    'label'         =>  'Situação:',
                    'value'         =>  $this->cadastro->variables->get('processo_situacao.value') ? $this->cadastro->variables->get('processo_situacao.value') : 11,
                    'grid-col'      =>  array(
                        'lg'    =>  6,  
                    ),
                    'input-col'     =>  array(
                        'lg'    =>  24
                    ),
                    'from'          =>  $this->cadastro->variables->get('processo_situacao.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'processo_num_protocolo',
                    'label'         =>  'Núm. processo protocolo:',
                    'value'         =>  $this->cadastro->variables->get('processo_num_protocolo.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    ),
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'processo_dt_entrada_setor',
                    'label'         =>  'Data entrada no setor:',
                    'value'         =>  $this->cadastro->variables->get('processo_dt_entrada_setor.value'),
                    'class'         =>  array('text-right'),
                    'grid-col'      =>  array(
                        'lg'        =>  13
                    ),
                    'input-col'      =>  array(
                        'lg'        =>  8
                    ),
                ), 
                array(
                    'type'          =>  'date',
                    'id'            =>  'processo_dt_atribuicao_responsavel',
                    'label'         =>  'Data atribuição resp.:',
                    'value'         =>  $this->cadastro->variables->get('processo_dt_atribuicao_responsavel.value'),
                    'readonly'      =>  TRUE,
                    'class'         =>  array('text-right'),
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    ),
                    'input-col'      =>  array(
                        'lg'        =>  24
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'processo_nome_responsavel',
                    'label'         =>  'Resposável pelo processo.:',
                    'value'         =>  $this->cadastro->variables->get('processo_responsavel')->variables->get('nome.value'),
                    'readonly'      =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'        =>  9
                    ),
                    'input-col'      =>  array(
                        'lg'        =>  24
                    ),
                ),
                $btnReceberProcesso??NULL,
                array(
                    'type'          =>  'textarea',
                    'id'            =>  'processo_parecer_tecnico',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  'Parecer técnico:',
                    'value'         =>  $this->cadastro->variables->get('processo_parecer_tecnico.value'),
                    'data-height'   =>  180,
                ),  
                
                                                 
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    //append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/controle_revisoes_iptu','js_ControleRevisoesIptu',NULL,TRUE));
    
    return $bsFormData;
    
    
}   
    
?>