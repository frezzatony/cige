<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function(){
    
        
    include(dirname(__FILE__).'/formCadastroAcaoController.php');
    include(dirname(__FILE__).'/formCadastroAcaoController_contemplaAcoes.php');
    $bsformCadastroAcaoController = $getFormCadastroAcaoController();
    $bsformCadastroAcaoController_contemplaAcoes = $getFormCadastroAcaoController_contemplaAcoes();
    
    $bootstrap = new Bootstrap;    
    $bootstrap->tabs(
        array(
            'template'      =>  'vertical',
            'tab_group_col' =>  array(
                'lg'    =>  4,
            ),
            'nodes'         =>  array(
                array(
                    'active'        =>  TRUE,
                    
                    'tab'           =>  array(
                        'text'      =>  'Cadastro'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 240px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastroAcaoController['form']
                        )
                    )
                ),
                array(
                    'tab'       =>  array(
                        'text'  =>  'Contempla outras ações'
                    ),
                    'pane'      =>  array(
                        'style'     =>  'height: 240px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastroAcaoController_contemplaAcoes['form']
                        )
                    )
                )               
            )
        )
    );
    
    $javasriptReturn = $bsformCadastroAcaoController['javascript'];
    
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $javasriptReturn,
    );
    
    return $arrReturn;
    
}    
?>