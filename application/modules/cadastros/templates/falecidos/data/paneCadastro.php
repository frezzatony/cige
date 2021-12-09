<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function(){
    
        
    include(dirname(__FILE__).'/formCadastro.php');
    include(dirname(__FILE__).'/formCadastro_observacoes.php');
    
    $bsformCadastro = $getFormCadastro();
    $bsformCadastro_observacoes = $getFormCadastro_observacoes();
    
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
                        'style'     =>  'height: 320px;',
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
                        'style'     =>  'height: 320px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro_observacoes['form']
                        )
                    )
                ),               
            )
        )
    );
    
    $javascriptReturn = $bsformCadastro['javascript'];
    append($javascriptReturn,$bsformCadastro_observacoes['javascript']);
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $javascriptReturn,
    );
    
    return $arrReturn;
    
}    
?>