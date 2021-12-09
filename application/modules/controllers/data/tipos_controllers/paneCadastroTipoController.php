<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function(){
    
        
    include(dirname(__FILE__).'/formCadastroTipoController.php');
    $bsformCadastroTipoController = $getFormCadastroTipoController();
    
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
                        'text'      =>  'Cadastro'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 200px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastroTipoController['form']
                        )
                    )
                )                
            )
        )
    );
    
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $bsformCadastroTipoController['javascript']
    );
    
    return $arrReturn;
    
}    
?>