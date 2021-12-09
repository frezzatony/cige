<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function(){
    
    $jsReturn = '';
        
    $arrProp = array(
        'readonly' => FALSE,
    );
    
    //Definindo readonly dos forms
    if(
        !$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.editItems'),
            )
        )
        OR
        $this->cadastro->variables->get('processo_situacao.value')==9
    ){
       $arrProp['readonly'] = TRUE;
    }
    
    if($arrProp['readonly']){
        
        $arrProp['readonly'] = !$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  113, //Alterar situação de Revisão de Iptu já encerrada
            )
        );
        
    }
    
    //Fim Definindo readonly dos forms
    include(dirname(__FILE__).'/tabRevisao.php');
    
    include(dirname(__FILE__).'/formItensRevisar.php');
    include(dirname(__FILE__).'/formDocumentacao.php');
    include(dirname(__FILE__).'/formProcesso.php');
    include(dirname(__FILE__).'/formAnotacoes.php');
    
    $tabRevisaoData = $getTabRevisao($arrProp);
    $bsformItensRevisar = $getFormItensRevisar($arrProp);
    $bsformDocumentacao = $getFormDocumentacao($arrProp);
    $bsformProcesso= $getFormProcesso($arrProp);
    $bsformAnotacoes= $getFormAnotacoes($arrProp);
    
    $jsReturn = $this->CI->template->load('blank','cadastros/templates/controle_revisoes_iptu','js_ControleRevisoesIptu',NULL,TRUE);
    append($jsReturn,$bsformItensRevisar['javascript']);
    append($jsReturn,$bsformDocumentacao['javascript']);
    append($jsReturn,$bsformProcesso['javascript']);
    append($jsReturn,$bsformAnotacoes['javascript']);
    
    
    $bootstrap = new Bootstrap;    
    $bootstrap->tabs(
        array(
            'template'      =>  'vertical',
            'tab_group_col' =>  array(
                'lg'    =>  3,
            ),
            'nodes'         =>  array(
                array(
                    'active'        =>  TRUE,
                    'tab'           =>  array(
                        'text'      =>  'Revisão'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bg-white'),
                        'children'  =>  $tabRevisaoData['html_data'],
                    )
                ),
                
                array(
                    
                    'tab'           =>  array(
                        'text'      =>  'Itens a revisar',
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bg-white',),
                        'children'  =>  array(
                            $bsformItensRevisar['form']
                        )
                    )
                ),
                array(
                    
                    'tab'           =>  array(
                        'text'      =>  'Doc. requerida',
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bg-white'),
                        'children'  =>  array(
                            $bsformDocumentacao['form']
                        )
                    )
                ),
                
                array(
                    
                    'tab'           =>  array(
                        'text'      =>  'Processo',
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bordered','padding-6','bg-white'),
                        'children'  =>  array(
                            $bsformProcesso['form']
                        )
                    )
                ),
                
                 array(
                    
                    'tab'           =>  array(
                        'text'      =>  'Anotações',
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 350px;',
                        'class'     =>  array('bordered','padding-6','padding-top-10','bg-white'),
                        'children'  =>  array(
                            $bsformAnotacoes['form']
                        )
                    )
                ),
                        
            )
        )
    );
    
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $jsReturn,
    );
    
    return $arrReturn;
    
}    
?>