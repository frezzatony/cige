<?php

/**
 * @author Tony Frezza
 */

$getFormPessoaJuridica = function(){
    
    $bsform = new BsForm(
        array(
            'template'      =>  1,
            'class'         =>  array('tab-enter','padding-6','margin-bottom-4','bg-gray','bordered'),
            'col_menu'      =>  array(
                'lg'    =>  3
            ),
            'readonly'      =>  !$this->cadastro->runActionUserPermissions(
                array(
                    'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                    'user_id'           =>  $this->CI->data->get('user.id'),
                    'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
                )
            ),
            'module'        =>  'cadastros',
            'inputs'        =>  array(
                        
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  'Código:',
                    'value'         =>  $this->cadastro->get('item.value'),
                    'placeholder'   =>  'Novo',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                    
                    
                ),
                array(
                    'type'          =>  'hidden',
                    'id'            =>  'tipo',
                    'value'         =>  $this->CI->encryption->encrypt(2), //TIPO DE PESSOA,
                ),
                array(
                    'type'          =>  'textbox',
                    'label'         =>  'Tipo de pessoa:',
                    'value'         =>  'PESSOA JURÍDICA', //pessoa jurídica
                    'grid-col'      =>  array(
                        'lg'    =>  4,  
                    ),
                    'readonly'      =>  TRUE,
                    
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'situacao',
                    'label'         =>  'Situação:',
                    'value'         =>  $this->cadastro->variables->get('situacao')->get('value'),
                    'grid-col'      =>  array(
                        'lg'    =>  11,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  5,
                    ),
                    'from'          =>  $this->cadastro->variables->get('situacao')->get('from'),
                    'parent'        =>  array(
                        'module'    =>  'cadastros',
                        'request'   =>  $this->cadastro->get('id')
                    )
                    
                ),
                array(
                    'type'          =>  'textbox',
                    'label'         =>  'Última edição:',
                    'input_class'   =>  'text-right',
                    'readonly'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('last_activity.value').'h',
                    'grid-col'      =>  array(
                        'lg'    =>  5,  
                    ),
                    
                ), 
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome',
                    'label'         =>  'Razão Social:',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('nome')->get('value'),
                    'input_class'   =>  array('uppercase','bold'),
                    'grid-col'      =>  array(
                        'lg'        =>  11
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome_fantasia',
                    'label'         =>  'Nome fantasia:',
                    'value'         =>  $this->cadastro->variables->get('nome_fantasia')->get('value'),
                    'input_class'   =>  array('uppercase',''),
                    'grid-col'      =>  array(
                        'lg'        =>  11
                    ),
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'cpf_cnpj',
                    'label'         =>  'CNPJ:',
                    'value'         =>  $this->cadastro->variables->get('cpf_cnpj.value'),
                    'placeholder'   =>  '__.___.___/____-__',
                    'data-mask'     =>  '##.###.###/####-##',
                    'grid-col'      =>  array(
                        'lg'        =>  5
                    ),
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'inscricao_estadual',
                    'label'         =>  'Inscrição estadual:',
                    'value'         =>  $this->cadastro->variables->get('inscricao_estadual.value'),
                    'grid-col'      =>  array(
                        'lg'        =>  18
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  6
                    )
                ),
                                         
            )
        )    
    );
    
    return $bsform->getHtmlData();
}

?>