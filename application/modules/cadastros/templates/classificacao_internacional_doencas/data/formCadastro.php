<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
    
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
                        'lg'    =>  3,  
                    ),
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cid_10',
                    'label'         =>  'Código CID 10:',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('cid_10.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  4
                    ),
                    'data-mask'     =>  'A99.9999',
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'doenca_cronica',
                    'label'         =>  'Doença Crônica:',
                    'value'         =>  boolValue($this->cadastro->variables->get('doenca_cronica.value')),
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                    'options'       =>  array(
                        array(
                            'value' =>  'f',
                            'text'  =>  'NÃO'
                        ),
                        array(
                            'value' =>  't',
                            'text'  =>  'SIM',
                        ),
                    )
                    
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao',
                    'label'         =>  'Situação:',
                    'value'         =>  $this->cadastro->variables->get('situacao')->get('value'),
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
                    )
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nomenclatura',
                    'label'         =>  'Nomenclatura:',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('nomenclatura.value'),
                    'grid-col'     =>  array(
                        'lg'        =>  24
                    ),
                ),  
                array(
                    'type'          =>  'summernote',
                    'id'            =>  'descritivo',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  'Descritivo da doença:',
                    'value'         =>  $this->cadastro->variables->get('descritivo.value'),
                    'data-height'   =>  160,
                ),                          
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>