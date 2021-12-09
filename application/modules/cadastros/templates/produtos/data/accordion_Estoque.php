<?php

/**
 * @author Tony Frezza
 */


$getAccordion_Estoque = function($arrProp = array()){
    
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
                        'text'  =>  $this->CI->template->load('blank','cadastros/templates/produtos','accordion_Estoque.php',
                                array(
                                    'dataTblEsqtoque'   =>  $arrProp['data_tbl_estoque']??NULL,
                                    'cadastro'          =>  $this->cadastro
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