<?php

/**
 * @author Tony Frezza
 */


$getFormDocumentacao = function($arrProp = array()){
    
    $bsForm = new BsForm(
        array(
            'class'         =>  array('tab-enter'),
            'id'            =>  'formDocumentacao',
            'readonly'      =>  $arrProp['readonly'],
            'inputs'        =>  array(
                 
                array(
                    'type'      =>  'grid',
                    'id'        =>  'documentacao_revisao',
                    'label'     =>  'Documentação requerida',
                    'body_style'=>  'height: 300px;',
                    'value'     =>  $this->cadastro->variables->get('documentacao_revisao.value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'dropdown',
                            'id'            =>  'documento_documentacao_revisao',
                            'label'         =>  'Tipo de contato:',
                            'input_class'   =>  array('bold'),
                            'grid-col'      =>  array(
                                'lg'    =>  10,  
                            ),
                            'from'          =>  $this->cadastro->variables->get('documentacao_revisao')->variables->get('documento_documentacao_revisao')->get('from'),
                            'parent'        =>  array(
                                'module'    =>  'cadastros',
                                'request'   =>  $this->cadastro->get('id')
                            )  
                        ),
                       
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'observacoes_documentacao_revisao',
                            'label'         =>  'Observações:',
                            'grid-col'      =>  array(
                                'lg'        =>  14
                            ),
                        ),
                                               
                    )
                )
                                                           
            )
        )   
    );
    
    $bsFormData = $bsForm->getHtmlData();
    //append($bsFormData['javascript'],$this->CI->template->load('blank','cadastros/templates/controle_revisoes_iptu','js_ControleRevisoesIptu',NULL,TRUE));
    
    return $bsFormData;
    
    
}   
    
?>