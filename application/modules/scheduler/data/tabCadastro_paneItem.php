<?php

/**
 * @author Tony Frezza
 */


    
$getTabCadastro_paneItem = function(){
    
    include(dirname(__FILE__).'/formScheduler.php');
    
    $formScheduler = $getFormScheduler();
    
    $bootstrap = new Bootstrap;
    $bootstrap->tabs(
        array(
            'template'  =>  'vertical',
            'tab_group_col' =>  array(
                'lg'    =>  3
            ),
            'nodes'     =>  array(
                array(
                    'tab'       =>  array(
                        'text'     =>  'Tarefa'
                    ),
                    'pane'      =>  array(
                        'children'  =>  array(
                            array(
                                'children'      =>  $formScheduler['html']
                            ),
                            array(
                                'tag'   =>  'script',
                                'type'  =>  'text/javascript',
                                'text'  =>  $this->common->getJqueryJavascript($formScheduler['javascript'])
                            ),
                            array(
                                'tag'   =>  'script',
                                'type'  =>  'text/javascript',
                                'text'  =>  $this->common->getJqueryJavascript($this->template->load('blank','scheduler','jsFormScheduler',NULL,TRUE))
                            )
                        )
                    )
                )
            )
            
        )
    );
    
    return $bootstrap->getHtmlData();
}
    
    
    
?>
