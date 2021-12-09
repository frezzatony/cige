<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneAcompanhamentoRetorno = function($arrProp = array()){
    
    $jsReturn = '';
        
    include(dirname(__FILE__).'/formAcompanhamentoRetorno.php');
    
    $bsformAcompanhamentoRetorno = $getFormAcompanhamentoRetorno();
    $jsReturn = $bsformAcompanhamentoRetorno['javascript'];
    
    $arrReturn = array(
        'html_data'     =>  array(
            $bsformAcompanhamentoRetorno['form']
        ),
        'javascript'    =>  $jsReturn,
    );
    
    return $arrReturn;
    
}    
?>