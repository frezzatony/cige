<?php

/**
 * @author Tony Frezza
 */


$getTabRevisao = function($arrProp = array()){
    
    $jsReturn = '';
    
    include(dirname(__FILE__).'/formRevisao.php');
    include(dirname(__FILE__).'/formEnderecoRevisao.php');
    
    $bsformRevisao = $getFormRevisao($arrProp);
    $bsformEnderecoRevisao = $getFormEnderecoRevisao($arrProp);
    
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
                                    'col-lg-24','nopadding','nomargin'
                                ),
                                'children'  =>  array(
                                    $bsformRevisao['form'],
                                    array(
                                        'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($bsformRevisao['javascript']??NULL)),TRUE),
                                    ),
                                )
                            )
                        )
                    )
                ),
                array(
                    'tab'       =>  array(
                        'text'      =>  'Endereço'
                    ),
                    'pane'  =>  array(
                        'children'  =>  array(
                            array(
                                'tag'       =>  'div',
                                'class'     =>  array(
                                    'col-lg-24','nopadding','nomargin'
                                ),
                                'children'  =>  array(
                                    $bsformEnderecoRevisao['form'],
                                    array(
                                        'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($bsformEnderecoRevisao['javascript']??NULL)),TRUE),
                                    ),
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
      
};

?>