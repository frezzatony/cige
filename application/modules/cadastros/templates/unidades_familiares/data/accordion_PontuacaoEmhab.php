<?php

/**
 * @author Tony Frezza
 */


$getAccordion_PontuacaoEmhab = function($arrProp = array()){
    
    $arrReturn = array(
        'tag'       =>  'div',
        'class'     =>  array('','margin-top-10','col-lg-24','nopadding'),
        'children'  =>  array(
            array(
                'tag'       =>  'div',
                'class'     =>  array('card-header','nopadding','padding-left-6','size-11','bold'),
                'text'      =>  ''
            ),
            array(
                'tag'       =>  'div',
                'class'     =>  array('card-body'),
                'children'  =>  array(
                    array(
                        'text'  =>  $this->CI->template->load('blank','cadastros/templates/unidades_familiares','accordion_PontuacoesEmhab.php',
                                array(
                                    'dataTblPontuacaoEmhab'     =>  $arrProp['data_tbl_pontuacao_emhab'],
                                    'dataTblPontuacaoSantaFe'   =>  $arrProp['data_tbl_pontuacao_santa_fe']??NULL,
                                    'cadastro'                  =>  $this->cadastro
                                ),
                            TRUE)
                    )
                )
            )
        )
    );
        
    return $arrReturn;
}   
    
?>