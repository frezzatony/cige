<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function($arrProp = array()){
    
        
    include(dirname(__FILE__).'/formCadastro.php');
    include(dirname(__FILE__).'/formDepositos.php');
    include(dirname(__FILE__).'/formAtributos.php');
    
    $readOnlyForms = !$this->cadastro->runActionUserPermissions(
        array(
            'action'            =>  $this->cadastro->get('configs.actions.'.$this->cadastro->variables->get('almoxarifado.value').'.editItems'),
            'user_id'           =>  $this->CI->data->get('user.id'),
            'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
        )
    );
    
    
    $bsformCadastro = $getFormCadastro(
        array(
            'readonly_forms'    =>  $readOnlyForms,
        )
    );
    $jsReturn = $bsformCadastro['javascript'];
    
    
    $bsformDepositos= $getFormDepositos(
        array(
            'readonly_forms'    =>  $readOnlyForms,
        )
    );
    append($jsReturn,$bsformDepositos['javascript']);
    
    
    $bsformAtributos = $getFormAtributos(
        array(
            'readonly_forms'    =>  $readOnlyForms,
        )
    );
    append($jsReturn,$bsformAtributos['javascript']);
    
    
    include(dirname(__FILE__).'/accordion_Estoque.php');
    $arrdataAccordionEstoque = $getAccordion_Estoque($arrProp);
    
    $bootstrap = new Bootstrap;    
    $bootstrap->tabs(
        array(
            'template'      =>  'vertical',
            'tab_group_col' =>  array(
                'lg'    =>  3,
            ),
            'nodes'         =>  array(
                array(
                    'active'        =>  TRUE,
                    
                    'tab'           =>  array(
                        'text'      =>  'Item'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro['form'],
                            $arrdataAccordionEstoque,
                        )
                    )
                ),
                array(
                    //'active'        =>  TRUE,
                    
                    'tab'           =>  array(
                        'text'      =>  'Depósitos'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bordered','padding-6','bg-white'),
                        'children'  =>  array(
                            $bsformDepositos['form']
                        )
                    )
                ),
                array(
                    //'active'        =>  TRUE,
                    
                    'tab'           =>  array(
                        'text'      =>  'Atributos'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformAtributos['form']
                        )
                    )
                ),
                                
            )
        )
    );
    
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $jsReturn,
    );
    
    return $arrReturn;
    
}    
?>