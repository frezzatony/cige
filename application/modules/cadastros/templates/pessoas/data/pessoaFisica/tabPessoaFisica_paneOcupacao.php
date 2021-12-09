<?php

/**
 * @author Tony Frezza
 */



$getPaneOcupacao = function(){
    
    include(dirname(__FILE__).'/formOcupacao.php');
        
    $formOcupacao = $getFormOcupacao();
    
    
    $javascriptReturn = $formOcupacao['javascript'];
    
    $arrReturn = array(
        'html_data'     =>  $formOcupacao['form'],
        'javascript'    =>  $javascriptReturn,
    );
    
    return $arrReturn;
    
}

?>