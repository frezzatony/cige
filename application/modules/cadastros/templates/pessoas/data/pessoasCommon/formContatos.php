<?php

/**
 * @author Tony Frezza
 */


$getFormContatos = function(){
    
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
            'inputs'        =>  array(
                array(
                    'type'      =>  'grid',
                    'id'        =>  'contatos',
                    'label'     =>  'Contatos',
                    'body_style'=>  'height: 340px;',
                    'value'     =>  $this->cadastro->variables->get('contatos.value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'dropdown',
                            'id'            =>  'contato_tipo',
                            'label'         =>  'Tipo de contato:',
                            'input_class'   =>  array('bold'),
                            'grid-col'      =>  array(
                                'lg'    =>  7,  
                            ),
                            'from'          =>  $this->cadastro->variables->get('contatos')->variables->get('contato_tipo')->get('from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            )  
                        ),
                        array(
                            'type'          =>  'checkbox',
                            'id'            =>  'contato_preferencial',
                            'label'         =>  'Preferencial',
                            'data-value'    =>  'SIM',
                            'grid-col'      =>  array(
                                'lg'        =>  6
                            ),
                            'formgroup-class'   =>  array('margin-top-14','margin-bottom-6')
                        ),
                        array(
                            'type'          =>  'checkbox',
                            'id'            =>  'contato_invalido',
                            'label'         =>  'Inválido',
                            'data-value'    =>  'SIM',
                            'grid-col'      =>  array(
                                'lg'        =>  6
                            ),
                            'formgroup-class'   =>  array('margin-top-14','margin-bottom-6')
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'contato_descricao',
                            'label'         =>  'Contato:',
                            'input_class'   =>  array('bold'),
                            'grid-col'      =>  array(
                                'lg'        =>  15
                            ),
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'contato_complemento',
                            'label'         =>  'Complemento:',
                            'grid-col'      =>  array(
                                'lg'        =>  10
                            ),
                        ), 
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'contato_horario',
                            'label'         =>  'Horário para contato:',
                            'grid-col'      =>  array(
                                'lg'        =>  10
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