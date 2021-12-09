<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function(){
        
    include(dirname(__FILE__).'/formCadastroUsuario.php');
    include(dirname(__FILE__).'/formCadastroUsuario_perfis.php');
    $bsformCadastro = $getFormCadastro();
    $bsformCadastro_perfis = $getFormCadastro_perfis();
    
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
                        'style'     =>  'height: 300px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro['form']
                        )
                    )
                ),
                array(
                    'tab'           =>  array(
                        'text'      =>  'Perfis'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 300px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro_perfis['form']
                        )
                    )
                )              
            )
        )
    );
    
    $javasriptReturn = $bsformCadastro['javascript'];
    append($javasriptReturn,$bsformCadastro_perfis['javascript']);
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $javasriptReturn,
    );
    
    return $arrReturn;
    
}    
?>