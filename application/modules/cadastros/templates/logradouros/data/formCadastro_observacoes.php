<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro_observacoes = function($arrProp = array()){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  $arrProp['readonly_forms'],
            'inputs'        =>  array(
                array(
                    'type'          =>  'summernote',
                    'id'            =>  'observacoes',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  'Observações:',
                    'value'         =>  $this->cadastro->variables->get('observacoes.value'),
                    'data-height'   =>  178,
                ), 
            )  
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>