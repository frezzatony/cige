<?php

/**
 * @author Tony Frezza
 */
    
    
$setValues = function($arrProp = array()){
    
    $keyImei1 = array_search('imei1',array_column($arrProp['values'],'id'));
    $keyImei2 = array_search('imei2',array_column($arrProp['values'],'id'));
    
    $arrAtributosVal = array();
    
    $arrAtributosVal[] = array(
        array(
            'id'    =>  'nome',
            'value'  =>  'imei1',
        ),
        array(
            'id'    =>  'valor',
            'value' =>  (($keyImei1!==FALSE) ? ($arrProp['values'][$keyImei1]['value']??NULL) : NULL),
        ), 
    );
    
    $arrAtributosVal[] = array(
        array(
            'id'    =>  'nome',
            'value'  =>  'imei2',
        ),
        array(
            'id'    =>  'valor',
            'value' =>  (($keyImei2!==FALSE) ? ($arrProp['values'][$keyImei2]['value']??NULL) : NULL),
        ), 
    );
    
        
    $arrProp['values'][] = array(
        'id'    =>  'atributos',
        'value' =>  $arrAtributosVal,
    );
        
}   

?>