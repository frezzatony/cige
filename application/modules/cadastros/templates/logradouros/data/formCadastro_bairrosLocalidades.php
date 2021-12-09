<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro_bairrosLocalidades = function($arrProp = array()){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  $arrProp['readonly_forms'],
            'id'            =>  'form_logradouros_bairrosLocalidades',
            'inputs'        =>  array(
                array(
                    'type'      =>  'grid',
                    'id'        =>  'bairros',
                    'label'     =>  'Bairros adjacentes',
                    'value'     =>  $this->cadastro->variables->get('bairros')->get('value'),
                    'body_style'    =>  'height: 354px;',
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'radio',
                            'id'            =>  'inicio',
                            'data-value'    =>  'SIM',
                            'grid_class'    =>  'padding-top-14',
                            'grid-col'      =>  array(
                                'lg'        =>  4,
                            ),
                            'options'       =>  array(
                                array(
                                    'text'      =>  'Início',
                                    'value'     =>  'SIM'
                                )
                            )
                        ),
                        array(
                            'type'          =>  'externallist',//dropdown
                            'id'            =>  'bairro_localidade',
                            'label'         =>  $this->cadastro->variables->get('bairros')->variables->get('bairro_localidade')->get('label').':',
                            'grid-col'      =>  array(
                                'lg'    =>  14,  
                            ),
                            
                            'from'          =>  $this->cadastro->variables->get('bairros')->variables->get('bairro_localidade')->get('from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
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