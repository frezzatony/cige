<?php

/**
 * @author Tony Frezza
 */



$getPaneEnderecos = function(){
    
    include(dirname(__FILE__).'/../pessoasCommon/formEnderecos.php');
    
    $formEnderecos = $getFormEnderecos();
    
    $javascriptReturn = $formEnderecos['javascript'];
    
    $arrReturn = array(
        'html_data'     =>  $formEnderecos['form'],
        'javascript'    =>  $javascriptReturn,
    );
    
    return $arrReturn;
    
}

?>