<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function($arrProp = array()){
    
    $jsReturn = '';
        
    include(dirname(__FILE__).'/formCadastro.php');
    include(dirname(__FILE__).'/formIntegrantes.php');
    include(dirname(__FILE__).'/formObservacoes.php');
    
    $bsformCadastro = $getFormCadastro();
    $bsformIntegrantes = $getFormIntegrantes();
    $bsformObservacoes = $getFormObservacoes();
    
    $bootstrap = new Bootstrap;
    $jsReturn = $bsformCadastro['javascript'];
    append($jsReturn,$bsformIntegrantes['javascript']);
    
    $arrTabs = array(
        'template'      =>  'vertical',
        'tab_group_col' =>  array(
            'lg'    =>  3,
        ),
        'nodes'         =>  array(
            array(
                'active'        =>  TRUE,                
                'tab'           =>  array(
                    'text'      =>  'Cadastro'
                ),
                'pane'          =>  array(
                    'style'     =>  'height: 350px;',
                    'class'     =>  array('bordered','padding-6','bg-gray'),
                    'children'  =>  array(
                        $bsformCadastro['form']
                    )
                )
            ),
            array(                
                'tab'           =>  array(
                    'text'      =>  'Integrantes'
                ),
                'pane'          =>  array(
                    'style'     =>  'height: 350px;',
                    //'class'     =>  array('','padding-6','bg-gray'),
                    'children'  =>  array(
                        $bsformIntegrantes['form']
                    )
                )
            ),  
                         
        )
    );
    
    
    if($this->cadastro->runActionUserPermissions(
        array(
            'action'            =>  90, //Gerenciar Dados Emhab de Unidades Familiares
            'user_id'           =>  $this->CI->data->get('user.id'),
            'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
        )
    )){
       include(dirname(__FILE__).'/formEmhab.php');
       $bsformEmhab = $getFormEmhab($arrProp); 
       append($jsReturn,$bsformEmhab['javascript']);
       
       include(dirname(__FILE__).'/accordion_PontuacaoEmhab.php');
       $arrdataAccordionPontuacaoEmhab = $getAccordion_PontuacaoEmhab($arrProp);
       
       $arrTabs['nodes'][] = array(
            
            //'active'        =>  TRUE,
            'tab'           =>  array(
                'text'      =>  'Emhab'
            ),
            'pane'          =>  array(
                'style'     =>  'height: 350px;',
                'class'     =>  array('bordered','padding-6','bg-gray'),
                'children'  =>  array(
                    $bsformEmhab['form'],
                    $arrdataAccordionPontuacaoEmhab
                )
            )
        ); 
    }
    
    
    $arrTabs['nodes'][] = array(
            
        'tab'           =>  array(
            'text'      =>  'Observações'
        ),
        'pane'          =>  array(
            'style'     =>  'height: 350px;',
            'class'     =>  array('bordered','padding-6','bg-gray'),
            'children'  =>  array(
                $bsformObservacoes['form']
            )
        )
    ); 
    
    
    
    
    $bootstrap->tabs($arrTabs);
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $jsReturn,
    );
    
    return $arrReturn;
    
}    
?>