<?php

/**
 * @author Tony Frezza
 */


$getFormAcompanhamentoRetorno = function(){
    
    include_once(dirname(__FILE__).'/../models/Unidades_familiares_model.php');
    $UnidadesFamiliares_Model = new Unidades_familiares_model;
    
    
    if((int)$this->cadastro->get('item.value')){
        $integrantesData = $UnidadesFamiliares_Model->getIntegrantesData(
            array(
                'full_integrantes'  =>  TRUE,
                'data'              =>  new Data(
                    array(
                        'unidade_familiar'  =>  (int)$this->cadastro->get('item.value'),   
                    )
                ),
                'limit'             =>  array(
                    'length'    =>  'NULL',
                    'start'     =>  'NULL'
                )
                
            )
        );
    
        $optionsIntegrantePresente = array();
        foreach($integrantesData as $integrantesData){
            $optionsIntegrantePresente[] = array(
                'value'     =>  (int)$integrantesData['id'],
                'text'      =>  'CPF: '.$this->CI->mask->mask($integrantesData['cpf_cnpj'],'cpf_cnpj').' - '.strtoMAIsuculo($integrantesData['nome']),
            );
        }
    }
    
    
    $acompanhamentoRetornoValues = array();
    
    foreach($this->cadastro->variables->get('acompanhamentos_retorno.value') as $valueRow){
        //
//        $keyIdRow = array_search('id',array_column($valueRow,'id'));
//        
//        $valueRow[] = array(
//            'id'        =>  'row_id',
//            'value'     =>  $this->CI->encryption->encrypt($valueRow[$keyIdRow]['value'])
//        );
//        
        $acompanhamentoRetornoValues[] = $valueRow;
    }
    
    $bsForm = new BsForm(
        array(
            'id'            =>  'form_unidadesFamiliares_AcompanhamentoRetorno',
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
                    'type'          =>  'grid',
                    'id'            =>  'acompanhamentos_retorno',
                    'value'         =>  $acompanhamentoRetornoValues,
                    'body_style'    =>  'height: 340px;',
                    'uuid-rows'     =>  TRUE,
                    //'readonly'      =>  (int)$this->cadastro->get('item.value') ? FALSE : TRUE, 
                    'inputs'    =>  array(
                        
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'id_item',
                            'label'         =>  'Unidade Familiar:',
                            'value'         =>  (int)$this->cadastro->get('item.value'),
                            'readonly'      =>  TRUE,
                            'class'         =>  array('text-right','bsform-input-no-value'),
                            'grid-col'      =>  array(
                                'lg'        =>  5    
                            ),
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'cpf_titular_unidade_familiar',
                            'label'         =>  'CPF Titular:',
                            'value'         =>  $this->cadastro->variables->get('titular')->variables->get('cpf_cnpj.value'),
                            'readonly'      =>  TRUE,
                            'class'         =>  array('bsform-input-no-value'),
                            'grid-col'      =>  array(
                                'lg'        =>  5    
                            ),
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'nome_titular_unidade_familiar',
                            'label'         =>  'Titular da Unidade Familiar:',
                            'value'         =>  strtoMAIsuculo($this->cadastro->variables->get('titular.text')),
                            'readonly'      =>  TRUE,
                            'class'         =>  array('bsform-input-no-value'),
                            'grid-col'      =>  array(
                                'lg'        =>  9    
                            ),
                        ),
                        array(
                            'type'          =>  'date_time',
                            'id'            =>  'dt_ultima_atualizacao',
                            'label'         =>  'Última alteração:',
                            'readonly'      =>  TRUE,
                            'class'         =>  array('bsform-input-no-value'),
                            'grid-col'      =>  array(
                                'lg'        =>  5    
                            ),
                        ),
                        array(
                            'type'          =>  'date',
                            'id'            =>  'dt_acompanhamento',
                            'label'         =>  'Data de presença:',
                            'grid-col'      =>  array(
                                'lg'        =>  6    
                            ),
                        ),
                        array(
                            'type'          =>  'dropdown',
                            'id'            =>  'integrante_presente_acompanhamento_retorno',
                            'label'         =>  'Integrante presente:',
                            'options'       =>  $optionsIntegrantePresente??NULL,
                            'grid-col'      =>  array(
                                'lg'        =>  18    
                            ),
                        ),
                        array(
                            'type'          =>  'summernote',
                            'id'            =>  'descricao_acompanhamento_retorno',
                            'label'         =>  'Descrição do acompanhamento:',
                            'height'        =>  '60px',
                            'grid-col'      =>  array(
                                'lg'        =>  24    
                            ),
                        ),
                    )                   
                ), 
            )
        )   
    );
        
    $bsFormData = $bsForm->getHtmlData();
    //append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/unidades_familiares','js_UnidadesFamiliares_AcompanhamentoRetorno',NULL,TRUE));
    
    return $bsFormData;
}   
    
?>