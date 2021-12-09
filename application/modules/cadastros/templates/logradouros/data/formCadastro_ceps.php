<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro_ceps = function($arrProp = array()){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  $arrProp['readonly_forms'],
            'inputs'        =>  array(
                array(
                    'type'      =>  'grid',
                    'id'        =>  'ceps',
                    'label'     =>  'CEPs',
                    'value'     =>  $this->cadastro->variables->get('ceps')->get('value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'cep',
                            'label'         =>  $this->cadastro->variables->get('ceps')->variables->get('cep')->get('label').':',
                            'grid-col'      =>  array(
                                'lg'        =>  6 
                            ),
                            'data-mask'     =>  '99.999-999',
                            'placeholder'   =>  '__.___-___',
                        ),
                        array(
                            'type'          =>  'integer',
                            'id'            =>  'numero_inicio',
                            'label'         =>  $this->cadastro->variables->get('ceps')->variables->get('numero_inicio')->get('label').':',
                            'grid-col'      =>  array(
                                'lg'        =>  6 
                            ),
                        ),
                        array(
                            'type'          =>  'integer',
                            'id'            =>  'numero_fim',
                            'label'         =>  $this->cadastro->variables->get('ceps')->variables->get('numero_fim')->get('label').':',
                            'grid-col'      =>  array(
                                'lg'        =>  6 
                            ),
                        ),
                        
                        array(
                            'type'          =>  'dropdown',
                            'id'            =>  'lado_logradouro',
                            'label'         =>  $this->cadastro->variables->get('ceps')->variables->get('lado_logradouro')->get('label').':',
                            'grid-col'      =>  array(
                                'lg'    =>  6,  
                            ),
                            'from'          =>  $this->cadastro->variables->get('ceps')->variables->get('lado_logradouro')->get('from'),
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