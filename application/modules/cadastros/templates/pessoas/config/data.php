<?php

/**
 * @author Tony Frezza
 */

 
return array(
    'schema'            =>  'cadastros',
    'table'             =>  'pessoas',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  FALSE,
    'actions'           =>  array(
        'viewItems'     =>  67,
        'editItems'     =>  68,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
    
        array(
            'id'        =>  'situacao',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_situacoes_cadastros_id',
            'label'     =>  'Situação',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '12', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '1',
                    ),
                     array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  '2',
                    )
                ),
            ),
        ),
              
        array(
            'id'        =>  'tipo',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_pessoas_id',
            'label'     =>  'Tipo',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '38', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'nome',
            'type'      =>  'character',
            'column'    =>  'nome',
            'label'     =>  'Nome',
        ),
        array(
            'id'        =>  'nome_fantasia',
            'type'      =>  'character',
            'column'    =>  'nome_fantasia',
            'label'     =>  'Nome fantasia',
        ),
        
        array(
            'id'        =>  'nome_civil',
            'type'      =>  'character',
            'column'    =>  'nome_civil',
            'label'     =>  'Nome Civil',
        ),
        array(
            'id'        =>  'observacoes_dados_civis',
            'type'      =>  'character',
            'column'    =>  'observacoes_dados_civis',
            'label'     =>  'Observações Nome Civil',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'pai_desconhecido',
            'type'      =>  'bool',
            'column'    =>  'pai_desconhecido',
            'label'     =>  'Pai desconhecido',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'nome_pai',
            'type'      =>  'character',
            'column'    =>  'nome_pai',
            'label'     =>  'Nome do pai',
        ),
        
        array(
            'id'        =>  'mae_desconhecida',
            'type'      =>  'bool',
            'column'    =>  'mae_desconhecida',
            'label'     =>  'Mãe desconhecida',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'nome_mae',
            'type'      =>  'character',
            'column'    =>  'nome_mae',
            'label'     =>  'Nome da mãe',
        ),
        
        array(
            'id'        =>  'data_nascimento',
            'type'      =>  'date',
            'column'    =>  'data_nascimento',
            'label'     =>  'Data de nascimento',
        ),
        
        array(
            'id'        =>  'sexo',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipo_sexo_id',
            'label'     =>  'Sexo',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '39', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'estado_civil',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_estados_civis_id',
            'label'     =>  'Estado Civil',
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '40', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'descricao',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'nacionalidade',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_nacionalidades_id',
            'label'     =>  'Nacionalidade',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '41', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'descricao',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'naturalizado',
            'type'      =>  'bool',
            'column'    =>  'naturalizado',
            'label'     =>  'Naturalizado(a)',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'pais_origem',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastro_paises_origem_id',
            'label'     =>  'País de Origem',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '37', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'nome',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        array(
            'id'        =>  'data_chegada_pais_origem',
            'type'      =>  'date',
            'column'    =>  'data_chegada_pais_origem',
            'label'     =>  'Data da chegada',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'cidade_natural',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_cidades_natural_id',
            'label'     =>  'Cidade Natural',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '16', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'nome',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
            'filter_configs'    =>  array(
                'input_type'        =>  'textbox',
                'from'      =>  array(
                    'search'    =>  'text',
                )
            ),
        ),
        
        array(
            'id'        =>  'grau_instrucao',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_graus_instrucao_id',
            'label'     =>  'Grau de instrução',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '42', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'descricao',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        array(
            'id'        =>  'ano_grau_instrucao',
            'type'      =>  'integer',
            'column'    =>  'ano_grau_instrucao',
            'label'     =>  'Ano grau de instrução',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'aposentado',
            'type'      =>  'bool',
            'column'    =>  'aposentado',
            'label'     =>  'Aposentado(a)',
        ),
        
        array(
            'id'        =>  'data_falecimento',
            'type'      =>  'date',
            'column'    =>  'data_falecimento',
            'label'     =>  'Data de falecimento',
        ),
        
        array(
            'id'        =>  'necessidade_especial',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_necessidades_especiais_pessoas_id',
            'label'     =>  'Necessidade Especial',
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '43', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'descricao',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        array(
            'id'        =>  'observacoes_necessidade_especial',
            'type'      =>  'character',
            'column'    =>  'observacoes_necessidade_especial',
            'label'     =>  'Observações Necessidade Especial',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'capaz_trabalho',
            'type'      =>  'bool',
            'column'    =>  'capaz_trabalho',
            'label'     =>  'Capaz para Trabalhar',
        ),
        
        array(
            'id'        =>  'rg',
            'type'      =>  'character',
            'column'    =>  'rg',
            'label'     =>  'RG',
        ),
        array(
            'id'        =>  'orgao_emissor_rg',
            'type'      =>  'character',
            'column'    =>  'orgao_emissor_rg',
            'label'     =>  'Órgão Emissor RG',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'data_emissao_rg',
            'type'      =>  'date',
            'column'    =>  'data_emissao_rg',
            'label'     =>  'Data Emissão RG',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'estado_emissor_rg',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_estados_emissor_rg_id',
            'label'     =>  'Estado Emissor RG',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '17', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'nome',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'cpf_cnpj',
            'type'      =>  'character',
            'column'    =>  'cpf_cnpj',
            'label'     =>  'CPF/CNPJ',
            'mask'      =>  'cpf_cnpj',
        ),
        
        array(
            'id'        =>  'certidao_nascimento',
            'type'      =>  'character',
            'column'    =>  'certidao_nascimento',
            'label'     =>  'Certidão de nascimento',
        ),
        
        array(
            'id'        =>  'certidao_casamento',
            'type'      =>  'character',
            'column'    =>  'certidao_casamento',
            'label'     =>  'Certidão de casamento',
        ),
        
        array(
            'id'        =>  'pis_pasep',
            'type'      =>  'character',
            'column'    =>  'pis_pasep',
            'label'     =>  'PIS/PASEP',
        ),
        
        array(
            'id'        =>  'ctps',
            'type'      =>  'character',
            'column'    =>  'ctps',
            'label'     =>  'Nº CTPS',
        ),
        array(
            'id'        =>  'serie_ctps',
            'type'      =>  'character',
            'column'    =>  'serie_ctps',
            'label'     =>  'Série CTPS',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'data_emissao_ctps',
            'type'      =>  'date',
            'column'    =>  'data_emissao_ctps',
            'label'     =>  'Data Emissão CTPS',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'estado_emissor_ctps',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_estados_emissor_ctps_id',
            'label'     =>  'Estado Emissor RG',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '17', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'nome',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'titulo_eleitor',
            'type'      =>  'character',
            'column'    =>  'titulo_eleitor',
            'label'     =>  'Nº Título Eleitor',
        ),
        array(
            'id'        =>  'zona_titulo_eleitor',
            'type'      =>  'character',
            'column'    =>  'zona_titulo_eleitor',
            'label'     =>  'Zona Título de Eleitor',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'secao_titulo_eleitor',
            'type'      =>  'character',
            'column'    =>  'secao_titulo_eleitor',
            'label'     =>  'Seção Título de Eleitor',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'estado_emissor_titulo_eleitor',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_estados_titulo_eleitor_id',
            'label'     =>  'Estado Título Eleitor',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '17', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'nome',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'cnh',
            'type'      =>  'character',
            'column'    =>  'cnh',
            'label'     =>  'Nº CNH',
        ),
        array(
            'id'        =>  'categoria_cnh',
            'type'      =>  'character',
            'column'    =>  'categoria_cnh',
            'label'     =>  'Categoria CNH',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'data_validade_cnh',
            'type'      =>  'date',
            'column'    =>  'data_validade_cnh',
            'label'     =>  'Data Validade CNH',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'observacao_cnh',
            'type'      =>  'character',
            'column'    =>  'observacao_cnh',
            'label'     =>  'Observação CNH',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'estado_emissor_cnh',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_estados_emissor_cnh_id',
            'label'     =>  'Estado Emissor CNH',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '17', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'nome',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'certificado_reservista',
            'type'      =>  'character',
            'column'    =>  'certificado_reservista',
            'label'     =>  'N° Cert. Reservista',
        ),
        array(
            'id'        =>  'orgao_certificado_reservista',
            'type'      =>  'character',
            'column'    =>  'orgao_certificado_reservista',
            'label'     =>  'Órgão Cert. Reservista',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'categoria_certificado_reservista',
            'type'      =>  'character',
            'column'    =>  'categoria_certificado_reservista',
            'label'     =>  'Categoria Cert. Reservista',
            'no_filter' =>  TRUE,
        ),
        array(
            'id'        =>  'data_emissao_certificado_reservista',
            'type'      =>  'date',
            'column'    =>  'data_emissao_certificado_reservista',
            'label'     =>  'Data Emissão Cert. Reservista',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'cartao_sus',
            'type'      =>  'character',
            'column'    =>  'cartao_sus',
            'label'     =>  'Nº Carão SUS',
        ),
        
        array(
            'id'        =>  'nis',
            'type'      =>  'character',
            'column'    =>  'nis',
            'label'     =>  'NIS',
        ),
        
        array(
            'id'        =>  'inscricao_estadual',
            'type'      =>  'character',
            'column'    =>  'inscricao_estadual',
            'label'     =>  'Inscrição estadual',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'entidade_publica',
            'type'      =>  'bool',
            'column'    =>  'entidade_publica',
            'label'     =>  'Entidade pública',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'inativo_receita_federal',
            'type'      =>  'bool',
            'column'    =>  'inativo_receita_federal',
            'label'     =>  'Inativo na Receita Federal',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'esfera',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_esferas_pessoas_juridicas_id',
            'label'     =>  'Esfera',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '56', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'id',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        array(
            'id'        =>  'unidade_gestora',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_unidades_gestoras_pessoas_juridicas_id',
            'label'     =>  'Tipo Unidade Gestora',
            'no_filter' =>  TRUE,
            'from'      =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '57', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'order'         =>  array(
                    array(
                        'id'        =>  'descricao',
                        'dir'       =>  'ASC',
                    )
                ),
                
            ),
        ),
        
        array(
            'id'        =>  'codigo_unidade_gestora',
            'type'      =>  'character',
            'column'    =>  'codigo_unidade_gestora',
            'label'     =>  'Código Unidade Gestora',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'mei',
            'type'      =>  'bool',
            'column'    =>  'mei',
            'label'     =>  'MEI',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'        =>  'responsavel_mei',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_pessoas_id_responsavel_mei',
            'label'     =>  'Responsável MEI',
            'no_filter' =>  TRUE,
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
                //'variables'     =>  array(
//                    'nome','cpf_cnpj'
//                ),
                'return_data'   =>  array(
                    array(
                        'id'    =>  'cpf_cnpj',
                        'name'  =>  'cpf',
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
                            'id'    =>  'nome',
                            'text'  =>  'Nome',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  10,
                            )
                        ),
                        array(
                            'id'    =>  'cpf_cnpj',
                            'text'  =>  'CPF',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  11,
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
            'id'        =>  'observacoes_pessoa',
            'type'      =>  'character',
            'column'    =>  'observacoes',
            'label'     =>  'Observações',
            'no_filter' =>  TRUE,
        ),
        
        array(
            'id'            =>  'contatos',
            'label'         =>  'Contatos',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'pessoas_contatos',
            'pk_column'     =>  'cadastros_pessoas_id',
            'no_filter' =>  TRUE,
            'variables'     =>  array(
                array(
                    'id'        =>  'contato_tipo',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'listas_meios_contatos_id',
                    'label'     =>  'Meio de contato',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '45', //id do cadastro pertinente
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
                    ),
                ),
                array(
                    'id'        =>  'contato_preferencial',
                    'type'      =>  'bool',
                    'column'    =>  'preferencial',
                    'label'     =>  'Preferencial',
                ),
                array(
                    'id'        =>  'contato_invalido',
                    'type'      =>  'bool',
                    'column'    =>  'invalido',
                    'label'     =>  'Inválido',
                ),
                array(
                    'id'        =>  'contato_descricao',
                    'type'      =>  'character',
                    'column'    =>  'descricao',
                    'label'     =>  'Descrição',
                ),
                array(
                    'id'        =>  'contato_horario',
                    'type'      =>  'character',
                    'column'    =>  'horario_contato',
                    'label'     =>  'Horário para contato',
                ),
                array(
                    'id'        =>  'contato_complemento',
                    'type'      =>  'character',
                    'column'    =>  'complemento',
                    'label'     =>  'Complemento',
                ),
            )
        ),
        
        array(
            'id'            =>  'enderecos',
            'label'         =>  'Endereços',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'pessoas_enderecos',
            'pk_column'     =>  'cadastros_pessoas_id',
            //'no_filter' =>  TRUE,
            'variables'     =>  array(
                array(
                    'id'        =>  'tipo_endereco',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'listas_tipos_enderecos_id',
                    'label'     =>  'Tipo de endereço',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '46', //id do cadastro pertinente
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
                    ),
                ),
                
                array(
                    'id'        =>  'cep_endereco',
                    'type'      =>  'character',
                    'column'    =>  'cep',
                    'label'     =>  'CEP',
                ),
                array(
                    'id'        =>  'pais_endereco',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'cadastros_paises_id',
                    'label'     =>  'País',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '37', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'nome'
                        ),
                        'filters'   =>  array(
                            array(
                                'id'        =>  'situacao',
                                'clause'    =>  'equal_integer',
                                'value'     =>  '1', //Ativo
                            ),
                        ),
                    ),
                ),
                array(
                    'id'        =>  'estado_endereco',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'cadastros_estados_id',
                    'label'     =>  'Estado',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '17', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'nome'
                        ),
                        
                        'filters'   =>  array(
                            array(
                                'id'        =>  'situacao',
                                'clause'    =>  'equal_integer',
                                'value'     =>  '1', //Ativo
                            ),
                        ),
                    ),
                ),
                array(
                    'id'        =>  'cidade_endereco',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'cadastros_cidades_id',
                    'label'     =>  'Cidade',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '16', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'nome'
                        ),
                                                
                        'filters'   =>  array(
                            array(
                                'id'        =>  'situacao',
                                'clause'    =>  'equal_integer',
                                'value'     =>  '1', //Ativo
                            ),
                        ),
                    ),
                ),
                array(
                    'id'        =>  'bairro_endereco',
                    'type'      =>  'character',
                    'column'    =>  'bairro',
                    'label'     =>  'Bairro',
                ),
                array(
                    'id'        =>  'logradouro_endereco',
                    'type'      =>  'character',
                    'column'    =>  'logradouro',
                    'label'     =>  'Logradouro',
                ),
                array(
                    'id'        =>  'numero_endereco',
                    'type'      =>  'character',
                    'column'    =>  'numero',
                    'label'     =>  'Número',
                ),
                array(
                    'id'        =>  'complemento_endereco',
                    'type'      =>  'character',
                    'column'    =>  'complemento',
                    'label'     =>  'Complemento',
                ),
                array(
                    'id'        =>  'ponto_referencia_endereco',
                    'type'      =>  'character',
                    'column'    =>  'ponto_referencia',
                    'label'     =>  'Ponto de referência',
                ),
                array(
                    'id'        =>  'endereco_estrangeiro_endereco',
                    'type'      =>  'bool',
                    'column'    =>  'endereco_estrangeiro',
                    'label'     =>  'Endereço estrangeiro',
                ),
            ),
        ),
        array(
            'id'            =>  'ocupacoes',
            'label'         =>  'Ocupações / Empregos',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'pessoas_ocupacoes',
            'pk_column'     =>  'cadastros_pessoas_id',
            //'no_filter' =>  TRUE,
            'variables'     =>  array(
                array(
                    'id'        =>  'ocupacao_ocupacoes',
                    'type'      =>  'character',
                    'column'    =>  'ocupacao',
                    'label'     =>  'Ocupação / Cargo',
                ),
                array(
                    'id'        =>  'principal_ocupacoes',
                    'type'      =>  'bool',
                    'column'    =>  'principal',
                    'label'     =>  'Principal',
                ),
                array(
                    'id'        =>  'local_trabalho_ocupacoes',
                    'type'      =>  'character',
                    'column'    =>  'local_trabalho',
                    'label'     =>  'Local de trabalho',
                ),
                array(
                    'id'        =>  'remuneracao_ocupacoes',
                    'type'      =>  'number',
                    'column'    =>  'remuneracao',
                    'label'     =>  'Remuneração',
                ),
                array(
                    'id'        =>  'data_admissao_ocupacoes',
                    'type'      =>  'date',
                    'column'    =>  'data_admissao',
                    'label'     =>  'Data início',
                ),
                array(
                    'id'        =>  'inativo_ocupacoes',
                    'type'      =>  'bool',
                    'column'    =>  'inativo',
                    'label'     =>  'Não exerce mais a ocupação',
                ),
            )
        ),
        array(
            'id'            =>  'doencas_cronicas',
            'label'         =>  'Doenças crônicas',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'pessoas_doencas_cronicas',
            'pk_column'     =>  'cadastros_pessoas_id',
            'no_filter' =>  TRUE,
            'variables'     =>  array(
                array(
                    'id'        =>  'doencas_cronicas_doenca',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'listas_classificacao_internacional_doencas_id',
                    'label'     =>  'Doença - CID 10',
                    'from'          =>  array(
                        'variables' =>  array('cid_10'),
                        'module'    =>  'cadastros',
                        'request'       =>  '55', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'nomenclatura',
                                                       
                        ),
                        'order'         =>  array(
                            array(
                                'id'        =>  'nomenclatura',
                                'dir'       =>  'ASC',
                            )
                        ),
                        'return_data'   =>  array(
                            array(
                                'id'    =>  'cid_10',
                                'name'  =>  'cid_10',
                            )
                        ),
                        'filters'       =>  array(
                            array(
                                'id'        =>  'situacao',
                                'clause'    =>  'equal_integer',
                                'value'     =>  1
                            ),
                            array(
                                'id'        =>  'doenca_cronica',
                                'clause'    =>  'equal_bool',
                                'value'     =>  't'
                            )
                        ),
                        'list_items'    =>  array(
                            
                            'columns'   =>  array(
                            
                                array(
                                    'id'    =>  'id',
                                    'text'  =>  'Código',
                                    'class' =>  '',
                                    'head-col'      =>  array(
                                        'lg'        =>  2,
                                        'md'        =>  2,
                                    )
                                ),
                                
                                array(
                                    'id'    =>  'cid_10',
                                    'text'  =>  'CID 10',
                                    'class' =>  '',
                                    'head-col'      =>  array(
                                        'lg'        =>  3,
                                        'md'        =>  3,
                                    )
                                ),
                                
                                array(
                                    'id'    =>  'nomenclatura',
                                    'text'  =>  'Nomenclatura',
                                    'class' =>  '',
                                    'head-col'      =>  array(
                                        'lg'        =>  15,
                                        'md'        =>  15,
                                    )
                                ),
                                array(
                                    'id'            =>  'doenca_cronica',
                                    'text'          =>  ' Crônica',
                                    'list-class'    =>  'text-centered',
                                    'head-col'      =>  array(
                                        'lg'        =>  4,
                                        'md'        =>  4,
                                    )
                                ),
                                        
                                        
                            ),
                        )
                        
                    ),
                    'filter_configs'    =>  array(
                        'input_type'    =>  'textbox',
                        'from'          =>  array(
                            'search'    =>  'text',
                        )
                    ),
                ),
                array(
                    'id'        =>  'doencas_cronicas_incapacitante_trabalho',
                    'type'      =>  'bool',
                    'column'    =>  'incapacitante_trabalho',
                    'label'     =>  'Incapacitante para trabalho',
                ),
                array(
                    'id'        =>  'doencas_cronicas_observacoes',
                    'type'      =>  'character',
                    'column'    =>  'observacoes',
                    'label'     =>  'Observações',
                ),
            )
        ),
        array(
            'id'            =>  'programas_sociais',
            'label'         =>  'Inscrição em programas sociais',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'pessoas_programas_sociais',
            'pk_column'     =>  'cadastros_pessoas_id',
            'variables'     =>  array(
                array(
                    'id'        =>  'programas_sociais_programa',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'listas_programas_sociais_id',
                    'label'     =>  'Programa Social',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '49', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao'
                        ),
                        'order'         =>  array(
                            array(
                                'id'        =>  'descricao',
                                'dir'       =>  'ASC',
                            )
                        ),
                        
                    ),
                    'filter_configs' =>  array(
                        'input_type'    =>  'textbox',
                        'from'      =>  array(
                            'search'    =>  'text',
                        )
                    ),
                ),
                array(
                    'id'        =>  'programas_sociais_remuneracao',
                    'type'      =>  'number',
                    'column'    =>  'remuneracao',
                    'label'     =>  'Remuneração',
                ),
                array(
                    'id'        =>  'programas_sociais_data_inicio',
                    'type'      =>  'date',
                    'column'    =>  'data_inicio',
                    'label'     =>  'Data início',
                ),
                array(
                    'id'        =>  'programas_sociais_observacoes',
                    'type'      =>  'character',
                    'column'    =>  'observacoes',
                    'label'     =>  'Observações',
                    'no_filter' =>  TRUE,
                ),
            )
        ),
        
    ),
    'rules'         =>  array(
       
    ),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id' =>  'nome',
                'dir'       =>  'ASC'
            ),
        ),
        'columns'   =>  array(
            array(
                'id'    =>  'id',
                'text'  =>  'Código',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'nome',
                'text'  =>  'Nome/Razão Social',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  9,
                )
            ),
            array(
                'id'    =>  'cpf_cnpj',
                'text'  =>  'CPF/CNPJ',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  5,
                )
            ), 
            array(
                'id'    =>  'tipo',
                'text'  =>  'Tipo pessoa',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  5,
                )
            ),
            array(
                'id'    =>  'situacao',
                'text'  =>  'Situação',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
                )
            ), 
        ),
    ),
);

?>