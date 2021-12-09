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
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    
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
                    'from'          =>  $this->cadastro->variables->get('situacao')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                
                array(
                    'type'          =>  'externallist',
                    'id'            =>  'cidade',
                    'label'         =>  'Cidade:',
                    'value'         =>  $this->cadastro->variables->get('cidade')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    
                    'from'          =>  $this->cadastro->variables->get('cidade')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'localidade',
                    'label'         =>  'É localidade:',
                    'value'         =>  $this->cadastro->variables->get('localidade')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'options'       =>  array(
                        array(
                            'value'     =>  'SIM',
                            'text'      =>  'SIM',
                        ),
                        array(
                            'value'     =>  'NÃO',
                            'text'      =>  'NÃO',
                        )
                    )
                    
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome',
                    'label'         => 'Nome:',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('nome')->get('value'),
                    'input_class'   =>  array('uppercase','bold'),
                    'grid-col'      =>  array(
                        'lg'        =>  24
                    ),
                ),                   
            )  
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>