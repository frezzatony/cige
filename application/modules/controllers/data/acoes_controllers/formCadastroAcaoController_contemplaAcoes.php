<?php

/**
 * @author Tony Frezza
 */


$getFormCadastroAcaoController_contemplaAcoes = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->acaoController->runActionUserPermissions(
                array(
                    'action'            =>  $this->acaoController->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
                array(
                    'type'      =>  'grid',
                    'id'        =>  'acoes_filhas',
                    'label'     =>  $this->acaoController->variables->get('acoes_filhas.label'),
                    'value'     =>  $this->acaoController->variables->get('acoes_filhas.value'),
                    'inputs'    =>  array(
                        array(
                            'type'  =>  'dropdown',
                            'id'    =>  'acao_filha',
                            'from'  =>  array_merge(
                                $this->acaoController->variables->get('acoes_filhas')->variables->get('acao_filha.from'),
                                array(
                                    'filters'   =>  array(
                                        array(
                                            'id'        =>  'id',
                                            'clause'    =>  'not_equal',
                                            'value'     =>  $this->acaoController->get('item.value'), 
                                        ),
                                        array(
                                            'id'        =>  'controller',
                                            'clause'    =>  'equal',
                                            'value'     =>  $this->acaoController->variables->get('controller.value'), 
                                        ),
                                    ),
                                )
                            )
                        )    
                    )
                ),
            ),
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>