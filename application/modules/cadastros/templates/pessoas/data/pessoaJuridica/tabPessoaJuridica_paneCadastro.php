<?php

/**
 * @author Tony Frezza
 */



$getPaneCadastro = function(){
    
    include(dirname(__FILE__).'/formGeral.php');
    //include(dirname(__FILE__).'/formDocumentos.php');
//    include(dirname(__FILE__).'/formDadosCivis.php');
    
    $formGeral = $getFormGeral();
    //$formDocumentos = $getFormDocumentos();
//    $formDadosCivis = $getFormDadosCivis();
    
    $bootstrap = new Bootstrap;
    $bootstrap->tabs(
        array(
            'template'  =>  'horizontal',
            'class'     =>  array('nomargin','nopadding',),
            'tab_content_class' =>  array('bg-white'),
            'nodes'     =>  array(
                array(
                    'active'    =>  TRUE,
                    'tab'       =>  array(
                        'text'      =>  'Geral'
                    ),
                    'pane'  =>  array(
                        'children'  =>  array(
                            array(
                                'tag'       =>  'div',
                                'class'     =>  array(
                                    'col-lg-20','nopadding','nomargin'
                                ),
                                'children'  =>  array(
                                    $formGeral['form'],
                                    array(
                                        'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($formGeral['javascript']??NULL)),TRUE),
                                    )    
                                )
                            )
                        )
                    )
                ),
                
            )
        )
    );
    
        
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
    );
    
    return $arrReturn;
    
}

?>