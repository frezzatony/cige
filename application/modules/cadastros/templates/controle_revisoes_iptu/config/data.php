<?php

/**
 * @author Tony Frezza
 */

 

return array(
    'schema'            =>  'cadastros',
    'table'             =>  'controle_revisoes_iptu',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'pessoa_solicitante',
            'clause'    =>  'greater',
            //'value'     =>  88
        ),
        
    ),
    //'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  106,
        'editItems'     =>  105,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
        
        array(
            'id'        =>  'pessoa_solicitante',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_pessoas_id_solicitante',
            'label'     =>  'Solicitante',
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
                   'situacao','tipo','last_activity','data_nascimento','sexo','estado_civil',
                   'aposentado','data_falecimento','necessidade_especial','capaz_trabalho','programas_sociais',
                ),
                'search'        =>  array(
                    'cpf_cnpj','nome'
                ),
                'variables'     =>  array(
                    'nome','cpf_cnpj','contatos'
                ),
                'return_data'   =>  array(
                    array(
                        'id'    =>  'cpf_cnpj',
                        'name'  =>  'cpf',
                    ),
                ),
                'filters'       =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '1', //Ativo
                    ),
                    //array(
//                        'id'        =>  'tipo',
//                        'clause'    =>  'equal_integer',
//                        'value'     =>  '1', //pessoa fisica
//                    ),
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
            'id'        =>  'pessoa_proprietario',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_pessoas_id_proprietario',
            'label'     =>  'Proprietário',
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
                   'situacao','tipo','last_activity','data_nascimento','sexo','estado_civil',
                   'aposentado','data_falecimento','necessidade_especial','capaz_trabalho','programas_sociais',
                ),
                'search'        =>  array(
                    'cpf_cnpj','nome'
                ),
                'variables'     =>  array(
                    'nome','cpf_cnpj','contatos'
                ),
                'return_data'   =>  array(
                    array(
                        'id'    =>  'cpf_cnpj',
                        'name'  =>  'cpf',
                    ),
                    array(
                        'id'    =>  'enderecos',
                        'name'  =>  'enderecos',
                    )
                ),
                'filters'       =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '1', //Ativo
                    ),
                    //array(
//                        'id'        =>  'tipo',
//                        'clause'    =>  'equal_integer',
//                        'value'     =>  '1', //pessoa fisica
//                    ),
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
                            'text'  =>  'Nome',
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
            'id'        =>  'dt_abertura_controle',
            'type'      =>  'date',
            'column'    =>  'dt_abertura_controle',
            'label'     =>  'Data abertura controle',
            'not_compare_difference'     =>  TRUE,
            'no_db'   =>  TRUE,
        ),
        
        array(
            'id'        =>  'matricula_cartorio',
            'type'      =>  'character',
            'column'    =>  'matricula_cartorio',
            'label'     =>  'Matrícula cartório',
        ),
        array(
            'id'        =>  'inscricao_imobiliaria',
            'type'      =>  'character',
            'column'    =>  'inscricao_imobiliaria',
            'label'     =>  'Inscrição imobiliária',
        ),
        array(
            'id'        =>  'codigo_imovel_erp',
            'type'      =>  'character',
            'column'    =>  'codigo_imovel_erp',
            'label'     =>  'Código imóvel sistema',
        ),
        array(
            'id'        =>  'detalhamento_revisao',
            'type'      =>  'character',
            'column'    =>  'detalhamento_revisao',
            'label'     =>  'Detalhamento revisão',
        ),
        
        
        array(
            'id'        =>  'revisao_endereco_cep',
            'type'      =>  'character',
            'column'    =>  'revisao_endereco_cep',
            'label'     =>  'Cep endereço revisão',
        ),
        array(
            'id'        =>  'revisao_endereco_bairro',
            'type'      =>  'character',
            'column'    =>  'revisao_endereco_bairro',
            'label'     =>  'Bairro endereço revisão',
        ),
        array(
            'id'        =>  'revisao_endereco_logradouro',
            'type'      =>  'character',
            'column'    =>  'revisao_endereco_logradouro',
            'label'     =>  'Logradouro endereço revisão',
        ),
        array(
            'id'        =>  'revisao_endereco_numero',
            'type'      =>  'character',
            'column'    =>  'revisao_endereco_numero',
            'label'     =>  'Número endereço revisão',
        ),
        array(
            'id'        =>  'revisao_endereco_complemento',
            'type'      =>  'character',
            'column'    =>  'revisao_endereco_complemento',
            'label'     =>  'Complemento endereço revisão',
        ),
        array(
            'id'        =>  'revisao_endereco_ponto_referencia',
            'type'      =>  'character',
            'column'    =>  'revisao_endereco_ponto_referencia',
            'label'     =>  'Ponto referência endereço revisão',
        ),
        
        
        array(
            'id'            =>  'itens_revisar',
            'label'         =>  'Itens a revisar',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'controle_revisoes_iptu_itens_revisar',
            'pk_column'     =>  'cadastros_controle_revisoes_iptu_id',
            'no_filter' =>  TRUE,
            'variables'     =>  array(
                array(
                    'id'        =>  'tipo_item_revisar',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'listas_tipos_itens_rev_iptu_id',
                    'label'     =>  'Meio de contato',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '64', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao'
                        ),
                                               
                        'filters'   =>  array(
                            array(
                                'id'        =>  'situacao',
                                'clause'    =>  'equal_integer',
                                'value'     =>  '1', //Ativo
                            ),
                        ),
                        'order' =>  array(
                            array(
                                'id'    =>  'descricao',
                            )
                        ),
                    ),
                ),
                array(
                    'id'        =>  'observacoes_item_revisar',
                    'type'      =>  'character',
                    'column'    =>  'observacoes',
                    'label'     =>  'Observações',
                ),
            )
        ),
        
        array(
            'id'            =>  'documentacao_revisao',
            'label'         =>  'Documentação requerida',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'controle_revisoes_iptu_documentos',
            'pk_column'     =>  'cadastros_controle_revisoes_iptu_id',
            'no_filter' =>  TRUE,
            'variables'     =>  array(
                array(
                    'id'        =>  'documento_documentacao_revisao',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'listas_tipos_documentos_id',
                    'label'     =>  'Documento',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '63', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao'
                        ),
                                               
                        'filters'   =>  array(
                            array(
                                'id'        =>  'situacao',
                                'clause'    =>  'equal_integer',
                                'value'     =>  '1', //Ativo
                            ),
                        ),
                        'order' =>  array(
                            array(
                                'id'    =>  'descricao',
                            )
                        ),
                    ),
                ),
                array(
                    'id'        =>  'observacoes_documentacao_revisao',
                    'type'      =>  'character',
                    'column'    =>  'observacoes',
                    'label'     =>  'Observações',
                ),
            )
        ),
        
        
        array(
            'id'        =>  'processo_situacao',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_situacoes_cadastros_id_situacao_processo',
            'label'     =>  'Situação do processo',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '12', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'hide_filters'  =>  array(
                    'id',
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '10',
                    ),
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '9',
                    ),
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '11',
                    ),
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '12',
                    ),
                ),
                'order' =>  array(
                    array(
                        'id'    =>  'descricao',
                        'dir'   =>  'ASC'
                    )
                )
            ),
        ),
        array(
            'id'        =>  'processo_num_protocolo',
            'type'      =>  'character',
            'column'    =>  'processo_num_protocolo',
            'label'     =>  'Núm. processo protocolo',
        ),
        array(
            'id'        =>  'processo_dt_entrada_setor',
            'type'      =>  'date',
            'column'    =>  'processo_dt_entrada_setor',
            'label'     =>  'Data entrada processo no setor',
            
        ),
        array(
            'id'        =>  'processo_dt_atribuicao_responsavel',
            'type'      =>  'date',
            'column'    =>  'processo_dt_atribuicao_responsavel',
            'label'     =>  'Data atribuição responsável processo',
            'not_compare_difference'     =>  TRUE,
            'no_db'   =>  TRUE,
        ),
        array(
            'id'        =>  'processo_dt_encerramento',
            'type'      =>  'date',
            'column'    =>  'processo_dt_encerramento',
            'label'     =>  'Data encerramento processo',
            
        ),
        array(
            'id'        =>  'processo_responsavel',
            'type'      =>  'relational_1_n',
            'column'    =>  'usuarios_usuarios_id_responsavel_processo',
            'label'     =>  'Responsável pelo processo',
            'from'          =>  array(
                'module'    =>  'users',
                'request'       =>  '2', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'hide_filters'  =>  array(
                   
                ),
                'search'        =>  array(
                    'nome'
                ),
                'variables'     =>  array(
                    'nome',
                ),
                
                'filters'       =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '1', //Ativo
                    ),
                ),
                
                'list_items'        =>  array(
                    'columns'   =>  array(
                        
                        array(
                            'id'    =>  'nome',
                            'text'  =>  'Nome',
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
            'id'        =>  'processo_parecer_tecnico',
            'type'      =>  'character',
            'column'    =>  'processo_parecer_tecnico',
            'label'     =>  'Parecer técnico processo',
        ),
        
        
        array(
            'id'        =>  'anotacoes',
            'type'      =>  'character',
            'column'    =>  'anotacoes',
            'label'     =>  'Anotações',
        ),
        
        
        
    ),
    'rules'         =>  array(
        
    ),
    'list_items'    =>  array(
        'order'             =>  array(
            array(
                'id'        =>  'dt_abertura_controle',
                'dir'       =>  'DESC',
            )
        ),
        'columns'   =>  array(
            array(
                'id'    =>  'id',
                'text'  =>  'Cód.',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  1,
                ),
                'list-class'    =>  array('text-right'),
            ),            
            array(
                'id'    =>  'processo_situacao',
                'text'  =>  'Situação protocolo',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  3,
                ),
                'list-class'    =>  array('text-centered'),
            ),
            array(
                'id'    =>  'dt_abertura_controle',
                'text'  =>  'Data controle',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  2,
                ),
                'list-class'    =>  array('text-centered'),
            ),   
            array(
                'id'    =>  'pessoa_solicitante.variables.nome',
                'text'  =>  'Solicitante',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  4,
                ),
                
                
            ),
                       
            array(
                'id'    =>  'codigo_imovel_erp',
                'text'  =>  'Cód. Imóv. Sis.',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  2,
                ),
                'list-class'    =>  array('text-centered'),
            ),
            array(
                'id'    =>  'matricula_cartorio',
                'text'  =>  'Matr. Cartório',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  2,
                ),
                'list-class'    =>  array('text-centered'),
            ),
            array(
                'id'    =>  'inscricao_imobiliaria',
                'text'  =>  'Insc. Imob.',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  2,
                ),
                'list-class'    =>  array('text-centered'),
            ),   
            array(
                'id'    =>  'processo_num_protocolo',
                'text'  =>  'Núm. Prot.',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  2,
                ),
                'list-class'    =>  array('text-centered'),
            ),
            array(
                'id'    =>  'processo_dt_entrada_setor',
                'text'  =>  'Data ent. processo',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  3,
                ),
                'list-class'    =>  array('text-centered'),
            ), 
            array(
                'id'    =>  'processo_responsavel',
                'text'  =>  'Responsável processo',
                'class' =>  array('text-centered'),
                'head-col'      =>  array(
                    'lg'        =>  3,
                ),
                //'list-class'    =>  array('text-centered'),
            ),            
        ),
    ),
);

?>