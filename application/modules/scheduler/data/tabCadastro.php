<?php

/**
 * @author Tony Frezza
 */


    
$getHtmlDataTabCadastro = function(){
    
    
    include(dirname(__FILE__).'/tabCadastro_paneItem.php');
    
    $bootstrap = new Bootstrap;
    $bootstrap->tabs(
        array(
            'template'  =>  'horizontal',
            'nodes'     =>  array(
                array(
                    'tab'   =>  array(
                        'text'     =>  '<i class="fa fa-th"></i> Item'
                    ),
                    'pane'  =>  array(
                        'children'      =>  $getTabCadastro_paneItem()
                    )
                ),
                array(
                    'tab'   =>  array(
                        'text'     =>  '<i class="fa fa fa-list-alt"></i> Histórico de alterações'
                    ),
                    'pane'  =>  array(
                        'text'  =>  'Em desenvolvimento...'
                    )
                )
            )
        )
    );
    
    return $bootstrap->getHtmlData();
}
    
    
    
?>
