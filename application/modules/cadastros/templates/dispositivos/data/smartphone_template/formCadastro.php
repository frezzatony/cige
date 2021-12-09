<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
        
    $arrAtributosVal = array();
    
    foreach($this->cadastro->variables->get('atributos.value') ?? array() as $key => $row){
       $arrAtributosVal[$row[1]['value']] = $row[2]['value'];
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
                        'lg'    =>  4,  
                    ),
                    
                ),
                array(
                    'type'          =>  'hidden',
                    'id'            =>  'tipo',
                    'value'         =>  $this->CI->encryption->encrypt(1), //TIPO DE DISPOSITIVO,
                ),
                array(
                    'type'          =>  'textbox',
                    'label'         =>  'Tipo:',
                    'value'         =>  'Smartphone',
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  array(),
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
                        'lg'    =>  8,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  10
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'descricao',
                    'label'         =>  'Descrição:',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('descricao.value'),
                    'input_class'   =>  array(''),
                    'grid-col'     =>  array(
                        'lg'        =>  24
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  6
                    ),
                ), 
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'imei1',
                    'label'         =>  'IMEI#1:',
                    'value'         =>  $arrAtributosVal['imei1']??NULL,
                    'input_class'   =>  array(''),
                    'grid-col'     =>  array(
                        'lg'        =>  6
                    ),
                ),   
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'imei2',
                    'label'         =>  'IMEI#2:',
                    'value'         =>  $arrAtributosVal['imei2']??NULL,
                    'input_class'   =>  array(''),
                    'grid-col'     =>  array(
                        'lg'        =>  6
                    ),
                ), 
                
                                      
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>