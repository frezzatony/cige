<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro_leisDivulgacao = function($arrProp = array()){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  $arrProp['readonly_forms'],
            'inputs'        =>  array(
                array(
                    'type'      =>  'grid',
                    'id'        =>  'leis',
                    'label'     =>  $this->cadastro->variables->get('leis')->get('label'),
                    'value'     =>  $this->cadastro->variables->get('leis')->get('value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'lei',
                            'label'         =>  $this->cadastro->variables->get('leis')->variables->get('lei')->get('label').':',
                            'grid-col'      =>  array(
                                'lg'        =>  6 
                            ),
                        ),
                        array(
                            'type'          =>  'integer',
                            'id'            =>  'ano',
                            'label'         =>  $this->cadastro->variables->get('leis')->variables->get('ano')->get('label').':',
                            'grid-col'      =>  array(
                                'lg'        =>  4 
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