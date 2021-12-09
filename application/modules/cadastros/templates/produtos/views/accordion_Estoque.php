<?php

/**
 * @author Tony Frezza
 */
   
    $bootstrap = new Bootstrap;
    
    $bootstrap->grid(
        array(
            'id'        =>  'grid_estoque',
            'href'      =>  BASE_URL.'cadastros/'.$cadastro->get('url').'/method/getDataEstoque',
            'class'     =>  array('margin-top-10','bordered'),
            'style'     =>  'height: 176px;',
            'header'    =>  array(
                array(
                    'text'          =>  'Almoxarifado',
                    'class'         =>  array('col-lg-6',),
                    'list-class'    =>  array('col-lg-6',),
                ),
                array(
                    'text'          =>  'Quantidade',
                    'class'         =>  array('col-lg-6','text-centered'),
                    'list-class'    =>  array('col-lg-6','text-centered'),
                ),
                array(
                    'text'          =>  'Ações',
                    'class'         =>  array('col-lg-3','padding-right-4','text-centered'),
                    'list-class'    =>  array('col-lg-3','text-centered'),
                ),
            ),
            'data'      =>  $dataTblEsqtoque,
            'footer'    =>  FALSE
        )
    );
    $htmlGridEstoque =  $bootstrap->getHtml();
    
    $bootstrap->reset();
    $bootstrap->accordion(
        array(
            'multiple'  =>  FALSE,
            'nodes'     =>  array(
                array(
                    'header'    =>  array(
                        'title'     =>  '<i class="las la-boxes size-16"></i>Estoque',
                        'class'     =>  array(''),
                        'active'    =>  TRUE,
                    ),
                    'content'   =>  array(
                        'class' =>  array('padding-4','inhert-shadow','bg-white'),
                        'text'  =>  $htmlGridEstoque,
                    )
                ),
            )  
        )
    );
    
    echo $bootstrap->getHtml();
    
?>

    
