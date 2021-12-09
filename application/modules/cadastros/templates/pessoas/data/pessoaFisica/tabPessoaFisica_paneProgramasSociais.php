<?php

/**
 * @author Tony Frezza
 */



$getPaneProgramasSociais = function(){
    
    include(dirname(__FILE__).'/formProgramasSociais.php');
        
    $formProgramasSociais = $getFormProgramasSociais();
    
    
    $javascriptReturn = $formProgramasSociais['javascript'];
    
    $arrReturn = array(
        'html_data'     =>  $formProgramasSociais['form'],
        'javascript'    =>  $javascriptReturn,
    );
    
    return $arrReturn;
    
}

?>