<?php

/**
 * @author Tony Frezza
 */


return array(
    'schema'            =>  'cadastros',
    'table'             =>  'unidades_familiares',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'titular',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    'auto_load_items'   =>  FALSE,
    'actions'           =>  array(
        'viewItems'     =>  76,
        'editItems'     =>  77,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
        
        array(
            'id'        =>  'titular',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_pessoas_id_titular',
            'label'     =>  'Titular',
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
                'url_data'      =>  BASE_URL.'cadastros/unidades_familiares/method/externallist_integrantes_data',
                'variables'     =>  array(
                    'nome','cpf_cnpj','rg','nis',
                    
                    //'data_nascimento','sexo','estado_civil',
//                    'necessidade_especial','observacoes_necessidade_especial',
//                    'certidao_nascimento', 'certidao_casamento','pis_pasep', 'ctps', 'serie_ctps',
//                    'titulo_eleitor','zona_titulo_eleitor','secao_titulo_eleitor','cartao_sus',
//                    'ocupacoes','programas_sociais','enderecos'
                ),
                'return_data'   =>  array(
                    array(
                        'id'    =>  'cpf_cnpj',
                        'name'  =>  'cpf',
                    ),
                    array(
                        'id'    =>  'nis',
                        'name'  =>  'nis',
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
                                'lg'        =>  6,
                            )
                        ),
                        array(
                            'id'    =>  'nis',
                            'text'  =>  'NIS',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  5,
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
            'id'        =>  'titular_responsavel',
            'type'      =>  'bool',
            'column'    =>  'titular_responsavel',
            'label'     =>  'Titular é responsável pela Uni. Fam.',
        ),
        array(
            'id'            =>  'integrantes',
            'label'         =>  'Integrantes',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'unidades_familiares_integrantes',
            'pk_column'     =>  'unidades_familiares_id',
            'variables'     =>  array(
                array(
                    'id'        =>  'integrantes_integrante',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'cadastros_pessoas_id',
                    'label'     =>  'Nome',
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
                        'url_data'      =>  BASE_URL.'cadastros/unidades_familiares/method/externallist_integrantes_data',
                        'variables'     =>  array(
                            'nome','cpf_cnpj','nis','data_nascimento'
                        ),
                        'return_data'   =>  array(
                            array(
                                'id'    =>  'cpf_cnpj',
                                'name'  =>  'cpf',
                            ),
                            array(
                                'id'    =>  'nis',
                                'name'  =>  'nis',
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
                                        'lg'        =>  6,
                                    )
                                ),
                                array(
                                    'id'    =>  'nis',
                                    'text'  =>  'NIS',
                                    'class' =>  '',
                                    'head-col'      =>  array(
                                        'lg'        =>  5,
                                    )
                                ),
                            )
                        )
                    ),
                    'filter_configs'    =>  array(
                        'input_type'    =>  'textbox',
                        'label'         =>  'Nome do integrante',
                        'from'          =>  array(
                            'search'    =>  'text',
                        )
                    ),
                ),
                array(
                    'id'        =>  'integrantes_responsavel_unidade_familiar',
                    'type'      =>  'bool',
                    'column'    =>  'reponsavel_unidade_familiar',
                    'label'     =>  'Responsável pela unidade familiar',
                ),
                array(
                    'id'        =>  'integrantes_grau_parentesco',
                    'type'      =>  'relational_1_n',
                    'column'    =>  'listas_graus_parentesco_id',
                    'label'     =>  'Grau de parentesco com o titular',
                    'from'          =>  array(
                        'module'    =>  'cadastros',
                        'request'       =>  '54', //id do cadastro pertinente
                        'value'         =>  array(
                            'id'
                        ),
                        'text'          =>  array(
                            'descricao'
                        ),                     
                        'filters'   =>  array(
                            array(
                                'id'        =>  'situacao',
                                'clause'    =>  'equal',
                                'value'     =>  '1', //Ativo
                            ),
                        ),
                        'order'     =>  array(
                            array(
                                'id'    =>  'descricao'
                            )
                        )
                    ),
                ),
            )
        ),
        
        array(
            'id'        =>  'cadunico',
            'type'      =>  'character',
            'column'    =>  'cadunico',
            'label'     =>  'CadÚnico',
        ),
        
        array(
            'id'        =>  'data_inicio_residencia',
            'type'      =>  'date',
            'column'    =>  'data_inicio_residencia',
            'label'     =>  'Reside no local desde',
        ),
        
        array(
            'id'        =>  'vinculo_moradia',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_vinculos_moradias_id',
            'label'     =>  'Vínculo com a moradia',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '52', //id do cadastro pertinente
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
                        'id'        =>  'ativo',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'    =>  'descricao'
                    )
                )
            ),
        ),
        
        array(
            'id'        =>  'tipo_moradia',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_moradias_id',
            'label'     =>  'Tipo de moradia',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '53', //id do cadastro pertinente
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
                        'id'        =>  'ativo',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'    =>  'descricao'
                    )
                ),
            ),
        ),
        
        array(
            'id'        =>  'sistema_construtivo_moradia',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_sistemas_construtivos_id_moradia',
            'label'     =>  'Material da moradia',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '25', //id do cadastro pertinente
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
                        'id'        =>  'ativo',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'    =>  'descricao'
                    )
                ),
            ),
        ),
        
        array(
            'id'        =>  'situacao_moradia',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_situacoes_moradias_id',
            'label'     =>  'Situação da moradia',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '51', //id do cadastro pertinente
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
                        'id'        =>  'ativo',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'    =>  'descricao'
                    )
                ),
            ),
        ),
        
        array(
            'id'        =>  'programas_sociais_emhab',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_programas_sociais_emhab_id',
            'label'     =>  'Programa de interesse',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '50', //id do cadastro pertinente
                'first_null'    =>  TRUE,
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
                        'id'        =>  'ativo',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'    =>  'descricao'
                    )
                ),
            ),
            'filter_configs'    =>  array(
                'label'     =>  'Emhab - Programa Social de interesse'
            )
        ),
        array(
            'id'        =>  'atendido_programa_social_emhab',
            'type'      =>  'bool',
            'column'    =>  'atendido_programa_social_emhab',
            'label'     =>  'Emhab - Já atendido em programa social',
        ),
        array(
            'id'        =>  'programas_sociais_emhab_atendido',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_programas_sociais_emhab_atendido',
            'label'     =>  'Programa já atendido',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '50', //id do cadastro pertinente
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
                        'id'        =>  'ativo',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'    =>  'descricao'
                    )
                ),
            ),
            'filter_configs'    =>  array(
                'label'     =>  'Emhab - Programa Social já Atendido'
            )
        ),
        array(
            'id'        =>  'data_atendimento_programa_social_emhab',
            'type'      =>  'date',
            'column'    =>  'data_atendimento_programa_social_emhab',
            'label'     =>  'Emhab - Data de atendimento em programa social',
        ),
        array(
            'id'        =>  'acompanhamentos_retorno',
            'type'          =>  'relational_n_n',
            'schema'        =>  'cadastros',
            'table'         =>  'unidades_familiares_acompanhamento_retorno',
            'pk_column'     =>  'unidades_familiares_id',
            'no_filter' =>  TRUE,
            'variables' =>  array(
                array(
                    'type'      =>  'integer',
                    'id'        =>  'integrante_presente_acompanhamento_retorno',
                    'column'    =>  'cadastros_pessoas_id_integrante_presente',
                ),
                array(
                    'type'      =>  'date_time',
                    'id'        =>  'dt_ultima_atualizacao',
                    'column'    =>  'dt_ultima_atualizacao',
                ),
                array(
                    'type'      =>  'date',
                    'id'        =>  'dt_acompanhamento',
                    'column'    =>  'dt_acompanhamento',
                ),
                
                array(
                    'type'      =>  'character',
                    'id'        =>  'descricao_acompanhamento_retorno',
                    'column'    =>  'descricao_acompanhamento_retorno',
                )
            )
        ),
        array(
            'id'        =>  'observacoes',
            'type'      =>  'character',
            'column'    =>  'observacoes',
            'label'     =>  'Observações',
            'no_filter' =>  TRUE,
        ),
    ),
    'rules'         =>  array(),
    'list_items'    =>  array(
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
                'id'    =>  'titular.variables.cpf_cnpj',
                'text'  =>  'CPF Titular',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),    
            array(
                'id'    =>  'titular.variables.nome',
                'text'  =>  'Titular / Responsável',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  9,
                )
            ),            
        ),
    ),
);

?>