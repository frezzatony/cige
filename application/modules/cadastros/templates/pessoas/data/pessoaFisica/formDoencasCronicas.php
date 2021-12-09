<?php

/**
 * @author Tony Frezza
 */


$getFormDoencasCronicas = function(){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'id'            =>  'pessoas_formDoencasCronicas',
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
                    'id'        =>  'doencas_cronicas',
                    'body_style'=>  'height: 340px;',
                    'label'     =>  'Doenças Crônicas',
                    'value'     =>  $this->cadastro->variables->get('doencas_cronicas.value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'doencas_cronicas_doenca_cid_10',
                            'label'         =>  'CID 10:',
                            'readonly'      =>  TRUE,
                            'grid-col'      =>  array(
                                'lg'        =>  3
                            ),
                        ),
                        array(
                            'type'          =>  'externallist',
                            'id'            =>  'doencas_cronicas_doenca',
                            'label'         =>  'Doença crônica:',
                            'grid-col'      =>  array(
                                'lg'        =>  14
                            ),
                            'hide_key'      =>  TRUE,
                            'from'          =>  $this->cadastro->variables->get('doencas_cronicas')->variables->get('doencas_cronicas_doenca.from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            )
                        ),
                        array(
                            'type'          =>  'checkbox',
                            'id'            =>  'doencas_cronicas_incapacitante_trabalho',
                            'label'         =>  'Incapacitante para trabalho',
                            'data-value'    =>  'SIM',
                            'grid-col'      =>  array(
                                'lg'        =>  7
                            ),
                            'formgroup-class'   =>  array('margin-top-14','margin-bottom-6')
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'doencas_cronicas_observacoes',
                            'label'         =>  'Observações',
                            'grid-col'      =>  array(
                                'lg'        =>  24
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