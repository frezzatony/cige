<?php

/**
 * @author Tony Frezza
 */

include(dirname(__FILE__).'/tabPessoaJuridica_paneCadastro.php');
include(dirname(__FILE__).'/../pessoasCommon/tabPessoa_paneEnderecos.php');
include(dirname(__FILE__).'/../pessoasCommon/tabPessoa_paneContatos.php');
include(dirname(__FILE__).'/../pessoasCommon/tabPessoa_paneObservacoes.php');


$paneCadastroData = $getPaneCadastro();
$paneEnderecosData = $getPaneEnderecos();
$paneContatosData = $getPaneContatos();
$paneObservacoesData = $getPaneObservacoes();

$arrReturn =  array(
    'template'      =>  'vertical',
    'tab_group_col' =>  array(
        'lg'    =>  3
    ),
    'nodes'     =>  array(
        array(
            'active'    =>  TRUE,
            'tab'       =>  array(
                'text'          =>  'Cadastro'
            ),
            'pane'      =>  array(
                'style'         =>  'height: 340px;',
                'id'            =>  'cadastros_formGeral',
                'class'         =>  array('bg-gray'),
                'children'      =>  
                    $paneCadastroData['html_data'],
            )
        ),
        array(
            
            'tab'       =>  array(
                'text'          =>  'Endereços'
            ),
            'pane'      =>  array(
                
                'style'         =>  'height: 340px;',
                'children'      =>  array(
                    $paneEnderecosData['html_data'],
                    array(
                        'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneEnderecosData['javascript']??NULL)),TRUE),
                    ),
                ),
            )
        ),
        array(
            'tab'       =>  array(
                'text'          =>  'Contatos'
            ),
            'pane'      =>  array(
                'class'         =>  array(''),
                'style'         =>  'height: 340px;',
                'children'      =>  array(
                    $paneContatosData['html_data'],
                    array(
                        'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneContatosData['javascript']??NULL)),TRUE),
                    ),
                ),
            )
        ),
        array(
            'tab'       =>  array(
                'text'          =>  'Observacoes'
            ),
            'pane'      =>  array(
                'class'         =>  array('bordered'),
                'style'         =>  'height: 340px;',
                'children'      =>  array(
                    $paneObservacoesData['html_data'],
                    array(
                        'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneObservacoesData['javascript']??NULL)),TRUE),
                    ) 
                ),
            )
        )
    )
);


return $arrReturn;


?>