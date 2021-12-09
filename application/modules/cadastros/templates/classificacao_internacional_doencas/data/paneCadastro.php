<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function(){
    
        
    include(dirname(__FILE__).'/formCadastro.php');
    include(dirname(__FILE__).'/formObservacoes.php');
    $bsformCadastro = $getFormCadastro();
    $bsformObservacoes = $getFormObservacoes();
    
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
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro['form']
                        )
                    )
                ),
                array(
                    'tab'           =>  array(
                        'text'      =>  'Observações'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformObservacoes['form']
                        )
                    )
                )               
            )
        )
    );
    
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $bsformCadastro['javascript']
    );
    
    append($arrReturn['javascript'],$bsformObservacoes['javascript']);
    return $arrReturn;
    
}    
?>