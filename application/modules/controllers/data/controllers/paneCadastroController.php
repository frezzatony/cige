<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function(){
    
        
    include(dirname(__FILE__).'/forms/formCadastroTipo_Controller.php');
    include(dirname(__FILE__).'/forms/formCadastroTipo_Relatorio.php');
    
    $bsformCadastroController = $getFormCadastroTipo_Controller();
    $bsformCadastroRelatorio = $getFormCadastroTipo_Relatorio();
    
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
                            $bsformCadastroController['form'],
                            $bsformCadastroRelatorio['form'],
                        )
                    )
                )                
            )
        )
    );
    
    
    $javascriptReturn = $this->template->load('blank','controllers','jsControllers_view',NULL,TRUE);
    append($javascriptReturn,"\n".$bsformCadastroController['javascript']);
    append($javascriptReturn,"\n".$bsformCadastroRelatorio['javascript']);
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $javascriptReturn,
    );
    
    return $arrReturn;
    
}    
?>