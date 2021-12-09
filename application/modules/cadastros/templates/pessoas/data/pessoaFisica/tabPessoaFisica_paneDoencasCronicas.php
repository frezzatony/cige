<?php

/**
 * @author Tony Frezza
 */



$getPaneDoencasCronicas = function(){
    
    include(dirname(__FILE__).'/formDoencasCronicas.php');
        
    $formDoencasCronicas = $getFormDoencasCronicas();
    
    
    $javascriptReturn = $formDoencasCronicas['javascript'];
    
    $arrReturn = array(
        'html_data'     =>  $formDoencasCronicas['form'],
        'javascript'    =>  $javascriptReturn,
    );
    
    append($arrReturn['javascript'],$this->CI->template->load('blank','cadastros/templates/pessoas','pessoaFisica/js_FormDoencasCronicas',NULL,TRUE));
    return $arrReturn;
    
}

?>