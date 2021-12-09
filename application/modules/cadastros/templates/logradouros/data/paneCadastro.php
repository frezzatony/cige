<?php

/**
 * @author Tony Frezza
 */
    
    
$getPaneCadastro = function(){
    
    $cidadeValue = $this->cadastro->variables->get('cidade.value');
     
    $readOnlyForms = TRUE;
    
    //Default: Sao Bento do Sul
    if($cidadeValue == 4593){
        
        $readOnlyForms = !$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
            )
        );
        
        
    }
    
    //Diferente de: Sao Bento do Sul
    if($readOnlyForms && $cidadeValue != 4593){
        
        $readOnlyForms = !$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  99, //editar outras cidades diferentes de Sao Bento do Sul
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
            )
        );        
    }  
     
     
    include(dirname(__FILE__).'/formCadastro.php');
    include(dirname(__FILE__).'/formCadastro_bairrosLocalidades.php');
    include(dirname(__FILE__).'/formCadastro_leisDivulgacao.php');
    include(dirname(__FILE__).'/formCadastro_ceps.php');
    include(dirname(__FILE__).'/formCadastro_observacoes.php');
    
    $bsformCadastro = $getFormCadastro(
        array(
            'readonly_forms'    =>  $readOnlyForms,
        )
    );
    $bsformCadastro_bairrosLocalidades = $getFormCadastro_bairrosLocalidades(
        array(
            'readonly_forms'    =>  $readOnlyForms
        )
    );
    $bsformCadastro_leisDivulgacao = $getFormCadastro_leisDivulgacao(
        array(
            'readonly_forms'    =>  $readOnlyForms
        )
    );
    $bsformCadastro_ceps = $getFormCadastro_ceps(
        array(
            'readonly_forms'    =>  $readOnlyForms
        )
    );
    $bsformCadastro_observacoes = $getFormCadastro_observacoes(
        array(
            'readonly_forms'    =>  $readOnlyForms
        )
    );
    
    
    
    $bootstrap = new Bootstrap;    
    $bootstrap->tabs(
        array(
            'template'      =>  'vertical',
            'tab_group_col' =>  array(
                'lg'    =>  5,
            ),
            'nodes'         =>  array(
                array(
                    'active'        =>  TRUE,
                    'tab'           =>  array(
                        'text'      =>  'Cadastro'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 400px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro['form']
                        )
                    )
                ),
                array(
                    'tab'           =>  array(
                        'text'      =>  'Bairros/Localidades'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 400px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro_bairrosLocalidades['form']
                        )
                    )
                ), 
                array(
                    'tab'           =>  array(
                        'text'      =>  'Leis de Divulgação'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 400px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro_leisDivulgacao['form']
                        )
                    )
                ), 
                array(
                    'tab'           =>  array(
                        'text'      =>  'CEPs'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 400px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro_ceps['form']
                        )
                    )
                ), 
                array(
                    'tab'           =>  array(
                        'text'      =>  'Observações'
                    ),
                    'pane'          =>  array(
                        'style'     =>  'height: 400px;',
                        'class'     =>  array('bordered','padding-6'),
                        'children'  =>  array(
                            $bsformCadastro_observacoes['form']
                        )
                    )
                ),             
            )
        )
    );
    
    
    $arrReturn = array(
        'html_data'     =>  $bootstrap->getHtmlData(),
        'javascript'    =>  $bsformCadastro['javascript']
    );
    
    return $arrReturn;
    
}    
?>