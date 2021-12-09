<?php

/**
 * @author Tony Frezza
 */


$getFormDepositos = function($arrProp = array()){
    
    
    $depositos = new Cadastros(
        array(
            'url'   =>  'depositos',
            
        )
    );
    
    $dataDepositos = $depositos->getItems(
        array(
            'order'  => $depositos->getOrderBy(
                array(
                    array(
                        'id'    =>  'descricao',
                        'dir'   =>  'ASC'
                    )
                )
            ),
            'simple_get_items'  =>  TRUE,  
        ),
    );
    
    $dataInputs = array(
        array(
            'tag'       =>  'div',
            'class'     =>  array('col-lg-12','nopadding','nomargin','size-12'),
            'text'      =>  'O item é armazenado no(s) depósito(s):',
        ),
    );
    
    
    foreach($dataDepositos as $key => $row){
        $dataInputs[] = array(
            'type'  =>  'checkbox',
            'label' =>  $row['descricao_value']
        );
    }
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  ($arrProp['readonly_forms']??TRUE),
            'inputs'        =>  $dataInputs,
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>