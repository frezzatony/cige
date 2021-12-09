<?php

/**
 * @author Tony Frezza
 */


$getFormItensRevisar = function($arrProp = array()){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'id'            =>  'formItensRevisar',
            'readonly'      =>  $arrProp['readonly'],
            'inputs'        =>  array(
                 
                 array(
                    'type'      =>  'grid',
                    'id'        =>  'itens_revisar',
                    'label'     =>  'Itens a revisar',
                    'body_style'=>  'height: 300px;',
                    'value'     =>  $this->cadastro->variables->get('itens_revisar.value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'dropdown',
                            'id'            =>  'tipo_item_revisar',
                            'label'         =>  'Tipo de contato:',
                            'input_class'   =>  array('bold'),
                            'grid-col'      =>  array(
                                'lg'    =>  9,  
                            ),
                            'from'          =>  $this->cadastro->variables->get('itens_revisar')->variables->get('tipo_item_revisar')->get('from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            )  
                        ),
                       
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'observacoes_item_revisar',
                            'label'         =>  'Observações:',
                            'grid-col'      =>  array(
                                'lg'        =>  15
                            ),
                        ),
                                               
                    )
                ),
                
                                                           
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    //append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/controle_revisoes_iptu','js_ControleRevisoesIptu',NULL,TRUE));
    
    return $bsFormData;
    
    
}   
    
?>