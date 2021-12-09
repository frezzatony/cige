<?php

/**
 * @author Tony Frezza
 */


$getFormObservacoes = function(){
    
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
                    'type'          =>  'summernote',
                    'id'            =>  'observacoes',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  'Observações:',
                    'value'         =>  $this->cadastro->variables->get('observacoes.value'),
                    'data-height'   =>  228,
                ),
            )
        )    
    );
   
    return $bsForm->getHtmlData();
    
}

?>