<?php

/**
 * @author Tony Frezza
 */


$getFormEnderecos = function(){
    
    //definindo values default para que o grid mantenha uma organizacao dos dados
    $valuesDefault = array(
        0   =>  array(
            array(
                'id'        =>  'tipo_endereco',
                'value'     =>  1
            ),
            array(
                'id'        =>  'pais_endereco',
                'value'     =>  1, //Default: BRASIL 
            ),
        ),
        1   =>  array(
            array(
                'id'        =>  'tipo_endereco',
                'value'     =>  2
            ),
            array(
                'id'        =>  'pais_endereco',
                'value'     =>  1, //Default: BRASIL 
            ),
        ),
        2   =>  array(
            array(
                'id'        =>  'tipo_endereco',
                'value'     =>  3
            ),
            array(
                'id'        =>  'pais_endereco',
                'value'     =>  1, //Default: BRASIL 
            ),
        ),
    );
    
    $enderecosValue = $this->cadastro->variables->get('enderecos.value');
    $enderecosValue = $enderecosValue ? $enderecosValue : array();
    
    if(!$enderecosValue){
        $enderecosValue = $valuesDefault;
    }
    else{
        foreach($enderecosValue as $keyRow => $row){
            $keyInputTiposEnderecos = array_search('tipo_endereco',array_column($row,'id'));
            $enderecosValue[$keyRow][$keyInputTiposEnderecos]['value'] = $valuesDefault[$keyRow][0]['value']??NULL;
        }
    }
    //fim definindo values default para que o grid para ordem dos dados
    
            
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
            'id'            =>  'CFMnIw4VOeqS',
            'ajax'          =>  TRUE,
            'inputs'        =>  array(
                array(
                    'type'      =>  'grid',
                    'template'  =>  2,
                    'id'        =>  'enderecos',
                    'body_style'=>  'height: 340px;',
                    'value'     =>  $enderecosValue,
                    'tabs'      =>  array(
                        array(
                            'text'  =>  'Endereço principal',
                        ),
                        array(
                            'text'  =>  'Endereço de correspondência',
                        ),
                        array(
                            'text'  =>  'Endereço comercial',
                        ),
                    ),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'hidden',
                            'id'            =>  'tipo_endereco',  
                        ),
                        array(
                            'type'          =>  'externallist',
                            'id'            =>  'pais_endereco',
                            'label'         =>  'País:',
                            'grid-col'      =>  array(
                                'lg'    =>  16,  
                            ),
                            'from'          =>  $this->cadastro->variables->get('enderecos')->variables->get('pais_endereco')->get('from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            )  
                        ), 
                        array(
                            'type'          =>  'checkbox',
                            'id'            =>  'endereco_estrangeiro_endereco',
                            'label'         =>  'Endereço estrangeiro',
                            'data-value'    =>  'SIM',
                            'grid-col'      =>  array(
                                'lg'        =>  6
                            ),
                            'formgroup-class'   =>   array('margin-top-14','margin-bottom-6')
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'cep_endereco', 
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
                        ),  
                        array(
                            'type'          =>  'externallist',
                            'id'            =>  'estado_endereco',
                            'label'         =>  'Estado:',
                            'input-key-style'   =>  'width: 50px',
                            'grid-col'     =>  array(
                                'lg'        =>  24,
                            ),
                            'input-col'     =>  array(
                                'lg'        =>  10
                            ),
                            'from'          =>  $this->cadastro->variables->get('enderecos')->variables->get('estado_endereco')->get('from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            )  
                        ),
                        array(
                            'type'          =>  'externallist',
                            'id'            =>  'cidade_endereco',
                            'label'         =>  'Cidade:',
                            'grid-col'      =>  array(
                                'lg'    =>  10,  
                            ),
                            'from'          =>  $this->cadastro->variables->get('enderecos')->variables->get('cidade_endereco')->get('from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            ),
                            'input-key-style'   =>  'width: 50px', 
                        ),
                         
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'bairro_endereco',
                            'label'         =>  'Bairro:',
                            'class'         =>  array('uppercase'),
                            'grid-col'      =>  array(
                                'lg'    =>  14,  
                            ),
                            'input-col'     =>  array(
                                'lg'        =>  11,  
                            ),
                        ),
                        
                        
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'logradouro_endereco',
                            'label'         =>  'Logradouro:',
                            'class'         =>  array('uppercase'),
                            'grid-col'      =>  array(
                                'lg'    =>  13,  
                            ),
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'numero_endereco', 
                            'label'         =>  'Número:',
                            'class'         =>  array('uppercase'), 
                            'grid-col'      =>  array(
                                'lg'        =>  5
                            )
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'complemento_endereco', 
                            'label'         =>  'Complemento:', 
                            'grid-col'      =>  array(
                                'lg'        =>  12
                            )
                        ), 
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'ponto_referencia_endereco', 
                            'label'         =>  'Ponto de referência:', 
                            'grid-col'      =>  array(
                                'lg'        =>  12
                            )
                        ),                         
                    )
                ),
            )
        )    
    );
    
    $arrReturn = $bsForm->getHtmlData(); 
    append($arrReturn['javascript'],"\n");
    append($arrReturn['javascript'],$this->CI->template->load('blank','cadastros/templates/pessoas','pessoaFisica/js_FormEnderecos',NULL,TRUE));
    
    
    return $arrReturn;
    
}

?>