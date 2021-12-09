<?php

/**
 * @author Tony Frezza
 */


$getFormAnotacoes = function($arrProp = array()){
    
          
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'id'            =>  'formAnotacoes',
            'readonly'      =>  $arrProp['readonly'],
            'inputs'        =>  array(
                 
                array(
                    'type'          =>  'summernote',
                    'id'            =>  'anotacoes',
                    'grid-col'      =>  array(
                        'lg'        =>  24,
                    ),
                    'label'         =>  'Anotações:',
                    'value'         =>  $this->cadastro->variables->get('anotacoes.value'),
                    'data-height'   =>  188,
                ),
                
                                                           
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    //append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/controle_revisoes_iptu','js_ControleRevisoesIptu',NULL,TRUE));
    
    return $bsFormData;
    
    
} ; 

   
?>