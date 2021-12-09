<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
    
    $tipoFrom = $this->cadastro->variables->get('tipo.from');
    $tipoFrom['filters'] = $tipoFrom['filters'] ?? array();
     
    foreach($this->arrIdsTemplates as $key => $val){
        $tipoFrom['filters'][] = array(
            'id'        =>  'id',
            'clause'    =>  'not_equal_integer',
            'value'     =>  $key
        );
    }
    
    
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
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao',
                    'label'         =>  'Situação cadastro:',
                    'value'         =>  $this->cadastro->variables->get('situacao.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    ),
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'descricao',
                    'label'         =>  'Descrição:',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('descricao.value'),
                    'input_class'   =>  array(''),
                    'grid-col'     =>  array(
                        'lg'        =>  6
                    ),
                ), 
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'tipo',
                    'label'         =>  'Tipo:',
                    'value'         =>  $this->cadastro->variables->get('tipo.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'from'          =>  $tipoFrom,
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    ),
                    'cryptographic_value'   =>  TRUE,
                    
                ),  
                
                array(
                    'type'      =>  'grid',
                    'id'        =>  'atributos',
                    'label'     =>  'Atributos',
                    'value'     =>  $this->cadastro->variables->get('atributos.value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'nome',
                            'label'         =>  'Nome:',
                            'grid-col'      =>  array(
                                'lg'        =>  7 
                            ),
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'valor',
                            'label'         =>  'Valor:',
                            'grid-col'      =>  array(
                                'lg'        =>  17 
                            ),
                        ),
                    )
                ),                       
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>