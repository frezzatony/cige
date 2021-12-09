<?php

/**
 * @author Tony Frezza
 */


return array(
    'schema'            =>  'cadastros',
    'table'             =>  'controle_notas_almoxarifado',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'fornecedor',
            'clause'    =>  'contain',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  FALSE,
    'actions'           =>  array(
        'viewItems'     =>  100,
        'editItems'     =>  101,
    ),
    'hide_filters'      =>  array(
        'id','last_activity'
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
        
        array(
            'id'        =>  'fornecedor',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_pessoas_id_fornecedor',
            'label'     =>  'Fornecedor',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '44', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'hide_filters'  =>  array(
                    'id',
                ),
                'search'        =>  array(
                    'cpf_cnpj','nome'
                ),
                'variables'     =>  array(
                    'nome','cpf_cnpj',
                ),
                'return_data'   =>  array(
                    array(
                        'id'    =>  'cpf_cnpj',
                        'name'  =>  'cpf_cnpj',
                    ),
                ),
                'hide_filters'  =>  array(
                   'situacao','tipo','last_activity','data_nascimento','sexo','estado_civil',
                   'aposentado','data_falecimento','necessidade_especial','capaz_trabalho','programas_sociais'
                ),
                'list_items'        =>  array(
                    'columns'   =>  array(
                        array(
                            'id'    =>  'id',
                            'text'  =>  'Código',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  3,
                            )
                        ),
                        
                        array(
                            'id'    =>  'cpf_cnpj',
                            'text'  =>  'CPF/CNPJ',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  6,
                            )
                        ),
                        array(
                            'id'    =>  'nome',
                            'text'  =>  'Nome / Razão Social',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  10,
                            )
                        ),
                        
                    )
                )
            ),
            'filter_configs'    =>  array(
                'input_type'        =>  'textbox',
                'from'      =>  array(
                    'search'    =>  'text',
                )
            ),
        ),
        array(
            'id'        =>  'numero_nf',
            'type'      =>  'character',
            'column'    =>  'numero_nf',
            'label'     =>  'Número',
        ),
        array(
            'id'        =>  'valor_nf',
            'type'      =>  'number',
            'column'    =>  'valor_nf',
            'label'     =>  'Valor',
        ),
        array(
            'id'        =>  'data_entrada_nf',
            'type'      =>  'date',
            'column'    =>  'data_entrada',
            'label'     =>  'Data de entrada',
        ),
        array(
            'id'        =>  'data_saida_nf',
            'type'      =>  'date',
            'column'    =>  'data_saida',
            'label'     =>  'Data de saída',
        ),
    ),
    'rules'         =>  array(
        array(
            'id'        =>  'fornecedor',
            'rule'      =>  'notempty',
            'message'   =>  'Fornecedor deve ser informado.'
        ),
        array(
            'id'        =>  'numero_nf',
            'rule'      =>  'notempty',
            'message'   =>  'Número da NF deve ser informado.'
        ),        
    ),
    'list_items'    =>  array(
        'columns'   =>  array(
            array(
                'id'    =>  'numero_nf',
                'text'  =>  'Nota Fiscal',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'valor_nf',
                'text'  =>  'Valor (R$)',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'data_entrada_nf',
                'text'  =>  'Data de entrada',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
                )
            ),
            array(
                'id'    =>  'data_saida_nf',
                'text'  =>  'Data de saída',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
                )
            ),
            array(
                'id'    =>  'fornecedor',
                'text'  =>  'Fornecedor',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  14,
                )
            ),
        ),
        'order' =>  array(
            array(
                'id'        =>  'data_entrada_nf',
                'dir'       =>  'DESC'
            ),
            array(
                'id'        =>  'data_saida_nf',
                'dir'       =>  'DESC'
            )
        )
    ),
);

?>