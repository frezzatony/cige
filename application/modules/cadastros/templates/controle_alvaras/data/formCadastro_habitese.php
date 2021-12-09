<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro_habitese = function(){
    
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
                    'type'      =>  'grid',
                    'id'        =>  'habitese',
                    'label'     =>  'Habite-se',
                    'value'     =>  $this->cadastro->variables->get('habitese')->get('value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'numero_habitese',
                            'grid-col'      =>  array(
                                'lg'        =>  5,
                            ),
                            'label'         =>  $this->cadastro->variables->get('habitese')->variables->get('numero_habitese')->get('label'),
                        ),
                        array(
                            'type'          =>  'date',
                            'id'            =>  'data_habitese',
                            'grid-col'      =>  array(
                                'lg'        =>  5,
                            ),
                            'label'         =>  $this->cadastro->variables->get('habitese')->variables->get('data_habitese')->get('label'),
                        ),
                        array(
                            'type'          =>  'number',
                            'id'            =>  'area_habitese',
                            'grid-col'      =>  array(
                                'lg'        =>  5,
                            ),
                            'label'         =>  $this->cadastro->variables->get('habitese')->variables->get('area_habitese')->get('label'),
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'observacoes_habitese',
                            'grid-col'      =>  array(
                                'lg'        =>  7,
                            ),
                            'label'         =>  $this->cadastro->variables->get('habitese')->variables->get('observacoes_habitese')->get('label'),
                        ),
                    )
                ),
            )  
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>