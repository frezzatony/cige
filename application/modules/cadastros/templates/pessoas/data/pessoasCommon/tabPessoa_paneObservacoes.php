<?php

/**
 * @author Tony Frezza
 */



$getPaneObservacoes = function(){
    
    include(dirname(__FILE__).'/formObservacoes.php');
        
    $formObservacoes = $getFormObservacoes();
    
    
    $javascriptReturn = $formObservacoes['javascript'];
    
    $arrReturn = array(
        'html_data'     =>  $formObservacoes['form'],
        'javascript'    =>  $javascriptReturn,
    );
    
    return $arrReturn;
    
}

?>