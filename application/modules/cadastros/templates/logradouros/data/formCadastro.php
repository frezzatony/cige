<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function($arrProp = array()){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  $arrProp['readonly_forms'],
            'id'            =>  'form_logradouros_cadastro',
            'inputs'        =>  array(
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  $this->cadastro->variables->get('id')->get('label').':',
                    'value'         =>  $this->cadastro->get('item.value'),
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  3,  
                    ),
                    
                    
                ),
                array(
                    'type'          =>  'date',
                    'id'            =>  'data_denominacao',
                    'label'         =>  'Data denominação',
                    'value'         =>  $this->cadastro->variables->get('data_denominacao.value').':',
                    'input_class'   =>  array('uppercase'),
                    'grid-col'      =>  array(
                        'lg'        =>  17
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  6
                    ),
                ),

                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao',
                    'label'         =>  $this->cadastro->variables->get('situacao')->get('label').':',
                    'value'         =>  $this->cadastro->variables->get('situacao.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  24
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'estado',
                    'label'         =>  'Estado:',
                    'value'         =>  $this->cadastro->variables->get('estado.value') ? $this->cadastro->variables->get('estado.value') : 24,//default: SANTA CATARINA
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('estado.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    ),
                    'input-key-style'   =>  'width: 40px;',
                    
                ),
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'cidade',
                    'label'         =>  'Cidade:',
                    'value'         =>  $this->cadastro->variables->get('cidade.value'),//default: SANTA CATARINA
                    'hide_key'      =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'        =>  17,  
                    ),
                    'input-col' =>  array(
                        'lg'        =>  14
                    ),
                    'from'          =>  $this->cadastro->variables->get('cidade.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id'),
                        'url'       =>  $this->cadastro->get('url'),
                    )
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'tipo_logradouro',
                    'label'         =>  $this->cadastro->variables->get('tipo_logradouro')->get('label').':',
                    'value'         =>  $this->cadastro->variables->get('tipo_logradouro.value'),
                    'first_null'    =>  TRUE,
                    'grid-col'      =>  array(
                        'lg'    =>  5,  
                    ),
                    'from'          =>  $this->cadastro->variables->get('tipo_logradouro')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'denominacao',
                    'label'         =>  $this->cadastro->variables->get('denominacao')->get('label').':',
                    
                    'value'         =>  $this->cadastro->variables->get('denominacao.value'),
                    'input_class'   =>  array('uppercase','bold'),
                    'grid-col'      =>  array(
                        'lg'        =>  19 
                    ),
                ),
                array(
                    'type'          =>  'number',
                    'id'            =>  'extensao',
                    'label'         =>  $this->cadastro->variables->get('extensao')->get('label').':',
                    
                    'value'         =>  formataFLOATImprime($this->cadastro->variables->get('extensao.value')),
                    'grid-col'      =>  array(
                        'lg'        =>  4 
                    ),
                ),
                array(
                    'type'          =>  'number',
                    'id'            =>  'largura',
                    'label'         =>  $this->cadastro->variables->get('largura')->get('label').':',
                    'value'         =>  formataFLOATImprime($this->cadastro->variables->get('largura.value')),
                    'grid-col'      =>  array(
                        'lg'        =>  20 
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  5
                    ),
                ),
                
                array(
                    'type'          =>  'number',
                    'id'            =>  'pavimento_asfalto',
                    'label'         =>  $this->cadastro->variables->get('pavimento_asfalto')->get('label').':',
                    
                    'value'         =>  formataFLOATImprime($this->cadastro->variables->get('pavimento_asfalto.value')),
                    'grid-col'      =>  array(
                        'lg'        =>  4 
                    ),
                    
                ),
                array(
                    'type'          =>  'number',
                    'id'            =>  'pavimento_lajota',
                    'label'         =>  $this->cadastro->variables->get('pavimento_lajota')->get('label').':',
                    
                    'value'         =>  formataFLOATImprime($this->cadastro->variables->get('pavimento_lajota.value')),
                    'grid-col'      =>  array(
                        'lg'        =>  4 
                    ),
                    
                ),
                array(
                    'type'          =>  'number',
                    'id'            =>  'pavimento_saibro',
                    'label'         =>  $this->cadastro->variables->get('pavimento_saibro')->get('label').':',
                    
                    'value'         =>  formataFLOATImprime($this->cadastro->variables->get('pavimento_saibro.value')),
                    'grid-col'      =>  array(
                        'lg'        =>  4 
                    ),
                    
                ),
                array(
                    'type'          =>  'number',
                    'id'            =>  'pavimento_paralelepipedo',
                    'label'         =>  $this->cadastro->variables->get('pavimento_paralelepipedo')->get('label').':',
                    
                    'value'         =>  formataFLOATImprime($this->cadastro->variables->get('pavimento_paralelepipedo.value')),
                    'grid-col'      =>  array(
                        'lg'        =>  4 
                    ),
                    
                ),
                array(
                    'type'          =>  'number',
                    'id'            =>  'pavimento_outros',
                    'label'         =>  $this->cadastro->variables->get('pavimento_outros')->get('label').':',
                    
                    'value'         =>  formataFLOATImprime($this->cadastro->variables->get('pavimento_outros.value')),
                    'grid-col'      =>  array(
                        'lg'        =>  4 
                    ),
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'coordenadas_mapa',
                    'label'         =>  $this->cadastro->variables->get('coordenadas_mapa')->get('label').':',
                    
                    'value'         =>  $this->cadastro->variables->get('coordenadas_mapa.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  20 
                    ),
                ),
            ) 
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    
    append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/logradouros','js_Logradouros',NULL,TRUE));
    
    return $bsFormData;
    
    
}   
    
?>