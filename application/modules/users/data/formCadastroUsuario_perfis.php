<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro_perfis = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->user->runActionUserPermissions(
                array(
                    'action'            =>  $this->user->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
                array(
                    'type'      =>  'grid',
                    'id'        =>  'profiles',
                    'label'     =>  $this->user->variables->get('profiles')->get('label'),
                    'value'     =>  $this->user->variables->get('profiles')->get('value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'dropdown',//dropdown
                            'id'            =>  'user_profile',
                            'label'         =>  $this->user->variables->get('profiles')->variables->get('user_profile')->get('label').':',
                            'grid-col'      =>  array(
                                'lg'    =>  14,  
                            ),
                            
                            'from'          =>  $this->user->variables->get('profiles')->variables->get('user_profile')->get('from'),
                            'parent'        =>  array(
                                'module'    =>  'users',
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