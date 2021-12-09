<?php

/**
 * @author Tony Frezza
 */


$getFormProgramasSociais = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'readonly'      =>  !$this->cadastro->runActionUserPermissions(
                array(
                    'action'            =>  80, //Gerenciar Programas Sociais de Pessoas
                    'user_id'           =>  $this->CI->data->get('user.id'),
                    'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
                array(
                    'type'      =>  'grid',
                    'id'        =>  'programas_sociais',
                    'body_style'=>  'height: 340px;',
                    'label'     =>  'Inscrição em Programas Sociais Nacionais',
                    'value'     =>  $this->cadastro->variables->get('programas_sociais.value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'dropdown',
                            'id'            =>  'programas_sociais_programa',
                            'label'         =>  'Programa Social Nacional:',
                            'grid-col'      =>  array(
                                'lg'    =>  15,  
                            ),
                            'from'          =>  $this->cadastro->variables->get('programas_sociais')->variables->get('programas_sociais_programa.from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            )
                            
                        ),
                        array(
                            'type'          =>  'number',
                            'id'            =>  'programas_sociais_remuneracao', 
                            'label'         =>  'Remuneração (R$):',
                            'input_class'   =>  array('text-right'), 
                            'grid-col'      =>  array(
                                'lg'        =>  5
                            )
                        ), 
                        array(
                            'type'          =>  'date',
                            'id'            =>  'programas_sociais_data_inicio', 
                            'label'         =>  'Data início:',
                            'grid-col'      =>  array(
                                'lg'        =>  4
                            )
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'programas_sociais_observacoes', 
                            'label'         =>  'Observações:',
                            'grid-col'      =>  array(
                                'lg'        =>  24
                            )
                        ),
                    )
                ),    
            )
        )    
    );
   
    return $bsForm->getHtmlData();
    
}

?>