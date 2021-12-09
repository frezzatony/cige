<?php

/**
 * @author Tony Frezza
 */


$getFormAtributos = function($arrProp = array()){
    

    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  ($arrProp['readonly_forms']??TRUE),
            'inputs'        =>  array(
                
                array(
                    'type'      =>  'grid',
                    'id'        =>  'atributos',
                    'label'     =>  'Atributos',
                    'value'     =>  $this->cadastro->variables->get('atributos.value'),
                    'inputs'    =>  array(
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'nome',
                            'label'         =>  'Nome:',
                            'grid-col'      =>  array(
                                'lg'        =>  7 
                            ),
                        ),
                        array(
                            'type'          =>  'textbox',
                            'id'            =>  'valor',
                            'label'         =>  'Valor:',
                            'grid-col'      =>  array(
                                'lg'        =>  17 
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