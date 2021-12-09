<?php

/**
 * @author Tony Frezza
 */



$getPaneContatos = function(){
    
    include(dirname(__FILE__).'/../pessoasCommon/formContatos.php');
    
    $formContatos = $getFormContatos();
    
    $javascriptReturn = $formContatos['javascript'];
    
    $arrReturn = array(
        'html_data'     =>  $formContatos['form'],
        'javascript'    =>  $javascriptReturn,
    );
    
    return $arrReturn;
    
}

?>