<?php

/**
 * @author Tony Frezza
 */


$getFormDadosCivis = function(){
    
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
                    'type'          =>  'textbox',
                    'id'            =>  'nome_civil',
                    'label'         =>  'Nome Civil:',
                    'value'         =>  $this->cadastro->variables->get('nome_civil.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  11
                    )  
                ),
                array(
                    'type'          =>  'summernote',
                    'id'            =>  'observacoes_dados_civis',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  'Observações:',
                    'value'         =>  $this->cadastro->variables->get('observacoes_dados_civis.value'),
                    'data-height'   =>  200,
                ),
            )
        )    
    );
   
    return $bsForm->getHtmlData();
    
}

?>