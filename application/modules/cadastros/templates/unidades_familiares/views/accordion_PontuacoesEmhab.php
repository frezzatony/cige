<?php

/**
 * @author Tony Frezza
 */
   
    $bootstrap = new Bootstrap;
    
    $bootstrap->grid(
        array(
            'id'        =>  'grid_pontuacao_emhab',
            'href'      =>  BASE_URL.'cadastros/'.$cadastro->get('url').'/method/getDataTblPontuacaoEmhab',
            'class'     =>  array('margin-top-10','bordered'),
            'style'     =>  'height: 176px;',
            'header'    =>  array(
                array(
                    'text'          =>  'Critério',
                    'class'         =>  array('col-lg-15','text-centered'),
                    'list-class'    =>  array('col-lg-15',),
                ),
                array(
                    'text'          =>  'Enquadramento',
                    'class'         =>  array('col-lg-6','text-centered'),
                    'list-class'    =>  array('col-lg-6','text-centered'),
                ),
                array(
                    'text'          =>  'Pontuação',
                    'class'         =>  array('col-lg-3','padding-right-4','text-centered'),
                    'list-class'    =>  array('col-lg-3','text-centered'),
                ),
            ),
            'data'              =>  $dataTblPontuacaoEmhab,
            'footer'     =>  FALSE
        )
    );
    $htmlGridPontuacaoEmhab =  $bootstrap->getHtml();
    
    $bootstrap->reset();
    
    $bootstrap->grid(
        array(
            'id'        =>  'grid_pontuacao_santa_fe',
            'href'      =>  BASE_URL.'cadastros/'.$cadastro->get('url').'/method/getDataTblPontuacaoSantaFe',
            'class'     =>  array('margin-top-10','bordered'),
            'style'     =>  'height: 176px;',
            'header'    =>  array(
                array(
                    'text'          =>  'Critério',
                    'class'         =>  array('col-lg-18','text-centered'),
                    'list-class'    =>  array('col-lg-18',),
                ),
                array(
                    'text'          =>  'Enquadramento',
                    'class'         =>  array('col-lg-6','text-centered'),
                    'list-class'    =>  array('col-lg-6','text-centered'),
                ),
            ),
            'data'              =>  $dataTblPontuacaoSantaFe,
            'footer'     =>  FALSE
        )
    );
    $htmlGridPontuacaoSantaFe=  $bootstrap->getHtml();
    
    $bootstrap->reset();
    $bootstrap->accordion(
        array(
            'multiple'  =>  TRUE,
            'nodes'     =>  array(
                array(
                    'header'    =>  array(
                        'title' =>  '<i class="fa fa-institution"></i>Pontuação em critérios da Emhab - Lei 3480/2015',
                        'class' =>  array('bold'),
                    ),
                    'content'   =>  array(
                        'class' =>  array('padding-4','inhert-shadow','bg-white'),
                        'text'  =>  $htmlGridPontuacaoEmhab,
                    )
                ),
                array(
                    'header'    =>  array(
                        'title' =>  '<i class="las la-warehouse size-14"></i>Pontuação em critérios da Loteamento Santa Fé',
                        'class' =>  array('bold'),
                    ),
                    'content'   =>  array(
                        'class' =>  array('padding-4','inhert-shadow'),
                        'text'  =>  $htmlGridPontuacaoSantaFe,
                    )
                ),
            )  
        )
    );
    
    echo $bootstrap->getHtml();
    
?>

    
