<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function($arrProp = array()){
    

    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  ($arrProp['readonly_forms']??TRUE),
            'inputs'        =>  array(
                
               array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  'Código:',
                    'value'         =>  $this->cadastro->get('item.value'),
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao',
                    'label'         =>  'Situação cadastro:',
                    'value'         =>  $this->cadastro->variables->get('situacao.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao.from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    ),
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'descricao',
                    'label'         =>  'Descrição:',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('descricao.value'),
                    'input_class'   =>  array(''),
                    'grid-col'     =>  array(
                        'lg'        =>  10
                    ),
                ),                    
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>