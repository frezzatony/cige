<?php

/**
 * @author Tony Frezza
 */


$getFormOcupacao = function(){
    
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
                    'id'        =>  'ocupacoes',
                    'body_style'=>  'height: 340px;',
                    'label'     =>  'Ocupações',
                    'value'     =>  $this->cadastro->variables->get('ocupacoes.value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'ocupacao_ocupacoes', 
                            'label'         =>  'Ocupação / Cargo:', 
                            'class'         =>  array('uppercase'),
                            'grid-col'      =>  array(
                                'lg'        =>  10
                            )
                        ),
                         array(
                            'type'          =>  'textbox',
                            'id'            =>  'local_trabalho_ocupacoes', 
                            'label'         =>  'Local de trabalho:',
                            'class'         =>  array('uppercase'), 
                            'grid-col'      =>  array(
                                'lg'        =>  11
                            )
                        ),
                        
                        array(
                            'type'          =>  'radio',
                            'id'            =>  'principal_ocupacoes',
                            'data-value'    =>  'SIM',
                            //'grid_class'    =>  'padding-top-14',
                            'grid-col'      =>  array(
                                'lg'        =>  3,
                            ),
                            'formgroup-class'   =>   array('margin-top-8','margin-bottom-4'),
                            'options'       =>  array(
                                array(
                                    'text'      =>  'Principal',
                                    'value'     =>  'SIM'
                                )
                            )
                        ), 
                        array(
                            'type'          =>  'number',
                            'id'            =>  'remuneracao_ocupacoes', 
                            'label'         =>  'Remuneração (R$):',
                            'input_class'   =>  array('text-right'), 
                            'grid-col'      =>  array(
                                'lg'        =>  5
                            )
                        ), 
                        array(
                            'type'          =>  'date',
                            'id'            =>  'data_admissao_ocupacoes', 
                            'label'         =>  'Data início:',
                            'grid-col'      =>  array(
                                'lg'        =>  4
                            )
                        ),
                        array(
                            'type'          =>  'checkbox',
                            'id'            =>  'inativo_ocupacoes',
                            'label'         =>  'Não exerce mais esta ocupação',
                            'data-value'    =>  'SIM',
                            'grid-col'      =>  array(
                                'lg'        =>  12
                            ),
                            'formgroup-class'   =>   array('margin-top-14','margin-bottom-6')
                        ), 
                    )
                ),    
            )
        )    
    );
   
    return $bsForm->getHtmlData();
    
}

?>