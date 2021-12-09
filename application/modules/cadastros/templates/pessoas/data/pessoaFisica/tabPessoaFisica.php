<?php

/**
 * @author Tony Frezza
 */

include(dirname(__FILE__).'/tabPessoaFisica_paneCadastro.php');
include(dirname(__FILE__).'/../pessoasCommon/tabPessoa_paneEnderecos.php');
include(dirname(__FILE__).'/../pessoasCommon/tabPessoa_paneContatos.php');
include(dirname(__FILE__).'/tabPessoaFisica_paneOcupacao.php');
include(dirname(__FILE__).'/tabPessoaFisica_paneDoencasCronicas.php');
include(dirname(__FILE__).'/../pessoasCommon/tabPessoa_paneObservacoes.php');


$paneCadastroData = $getPaneCadastro();
$paneEnderecosData = $getPaneEnderecos();
$paneContatosData = $getPaneContatos();
$paneOcupacaoData = $getPaneOcupacao();
$paneDoencasCronicasData =$getPaneDoencasCronicas();
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
                'style'         =>  'height: 380px;',
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
                
                'style'         =>  'height: 380px;',
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
                'style'         =>  'height: 380px;',
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
                'text'          =>  'Ocupação'
            ),
            'pane'      =>  array(
                'class'         =>  array(''),
                'style'         =>  'height: 380px;',
                'children'      =>  array(
                    $paneOcupacaoData['html_data'],
                    array(
                        'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneOcupacaoData['javascript']??NULL)),TRUE),
                    ) 
                ),
            )
        ),
        array(
            'tab'       =>  array(
                'text'          =>  'Doenças Crônicas'
            ),
            'pane'      =>  array(
                'class'         =>  array(''),
                'style'         =>  'height: 380px;',
                'children'      =>  array(
                    $paneDoencasCronicasData['html_data'],
                    array(
                        'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneDoencasCronicasData['javascript']??NULL)),TRUE),
                    ) 
                ),
            )
        ),
    )
);

//Programas Sociais para quem tem permissao
if(
    $this->cadastro->runActionUserPermissions(
        array(
            'action'            =>  80,
            'user_id'           =>  $this->CI->data->get('user.id'),
            'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
        )
    )
){
    
    include(dirname(__FILE__).'/tabPessoaFisica_paneProgramasSociais.php');
    $paneProgramasSociais = $getPaneProgramasSociais();
    
    //Observacoes
    append($arrReturn['nodes'],
        array(
            array(
                'tab'       =>  array(
                    'text'          =>  'Programas Sociais'
                ),
                'pane'      =>  array(
                    'class'         =>  array(''),
                    'style'         =>  'height: 380px;',
                    'children'      =>  array(
                        $paneProgramasSociais['html_data'],
                        array(
                            'text'      =>  $this->CI->template->load('jquery',NULL,'Blank_view',array('javascript'=>($paneProgramasSociais['javascript']??NULL)),TRUE),
                        ) 
                    ),
                )
            )
        )
    );
    
}

//Observacoes
append($arrReturn['nodes'],
    array(
        array(
            'tab'       =>  array(
                'text'          =>  'Observacoes'
            ),
            'pane'      =>  array(
                'class'         =>  array('bordered'),
                'style'         =>  'height: 380px;',
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