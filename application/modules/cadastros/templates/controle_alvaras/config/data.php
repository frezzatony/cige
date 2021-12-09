<?php

/**
 * @author Tony Frezza
 */


require(dirname(__FILE__).'/variable_habitese.php');

return array(
    'schema'            =>  'cadastros',
    'table'             =>  'controle_alvaras',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome_requerente',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    //'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  32,
        'editItems'     =>  45,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
        array(
            'id'        =>  'numero_processo',
            'type'      =>  'character',
            'column'    =>  'numero_processo',
            'label'     =>  'Número processo',
        ),
        array(
            'id'        =>  'data_processo',
            'type'      =>  'date',
            'column'    =>  'data_processo',
            'label'     =>  'Data processo',
        ),
        array(
            'id'        =>  'numero_alvara',
            'type'      =>  'character',
            'column'    =>  'numero_alvara',
            'label'     =>  'Número alvará',
        ),
        array(
            'id'        =>  'data_alvara',
            'type'      =>  'date',
            'column'    =>  'data_alvara',
            'label'     =>  'Data alvará',
        ),
        
        $variable_habitese,        
        
        array(
            'id'        =>  'cpf_cnpj_requerente',
            'type'      =>  'character',
            'column'    =>  'cpf_cnpj_requerente',
            'label'     =>  'CPF/CNPJ requerente',
            'mask'      =>  'cpf_cnpj',
        ),
        array(
            'id'        =>  'nome_requerente',
            'type'      =>  'character',
            'column'    =>  'nome_requerente',
            'label'     =>  'Nome requerente',
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
            'id'        =>  'codigo_imovel',
            'type'      =>  'character',
            'column'    =>  'codigo_imovel',
            'label'     =>  'Código imóvel',
        ),
        array(
            'id'        =>  'area_obra',
            'type'      =>  'number',
            'column'    =>  'area_obra',
            'label'     =>  'Área obra (m²)',
        ),
        array(
            'id'        =>  'tipo_sistema_construtivo',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_sistemas_construtivos_id',
            'label'     =>  'Sistema construtivo',
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
                    'situacao',
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'        =>  'descricao',
                        'dir'       =>  'ASC'
                    )
                )
            ),
        ),
        array(
            'id'        =>  'tipo_empreendimento_construtivo',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_empreendimentos_construtivos_id',
            'label'     =>  'Empreendimento construtivo',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '24', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'hide_filters'  =>  array(
                    'situacao',
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
                'order'     =>  array(
                    array(
                        'id'        =>  'descricao',
                        'dir'       =>  'ASC'
                    )
                )
            ),  
        ),
        array(
            'id'        =>  'obra_referida',
            'type'      =>  'character',
            'column'    =>  'obra_referida',
            'label'     =>  'Obra referida',
        ),
        array(
            'id'        =>  'endereco_obra',
            'type'      =>  'character',
            'column'    =>  'endereco_obra',
            'label'     =>  'Endereço obra',
        ),
        array(
            'id'        =>  'numero_endereco_obra',
            'type'      =>  'character',
            'column'    =>  'numero_endereco_obra',
            'label'     =>  'Núm. end. obra',
        ),
        array(
            'id'        =>  'bairro_obra',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_bairros_id_endereco_obra',
            'label'     =>  'Bairro obra',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '15', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'hide_filters'  =>  array(
                    'situacao',
                    'cidade',
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal',
                        'value'     =>  '1', //ativo
                    ),
                    array(
                        'id'        =>  'cidade',
                        'clause'    =>  'equal',
                        'value'     =>  'sao bento do sul', //ativo
                    ),
                ),
            ),  
        ),
        
        array(
            'id'        =>  'responsavel_tecnico',
            'type'      =>  'character',
            'column'    =>  'responsavel_tecnico',
            'label'     =>  'Responsável técnico',
        ),
        array(
            'id'        =>  'empresa_executora',
            'type'      =>  'character',
            'column'    =>  'empresa_executora',
            'label'     =>  'Empresa executora',
        ),
        array(
            'id'        =>  'art_rrt',
            'type'      =>  'character',
            'column'    =>  'art_rrt',
            'label'     =>  'ART/RRT',
        ),
        
        array(
            'id'        =>  'setor_arquivo_urbanismo',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_setores_arquivo_urbanismo_id',
            'label'     =>  'Setor arquivo',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '23', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'hide_filters'  =>  array(
                    'situacao',
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'situacao',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                ),
            ),  
        ),
        array(
            'id'        =>  'caixa_arquivo',
            'type'      =>  'character',
            'column'    =>  'caixa_arquivo',
            'label'     =>  'Caixa arquivo',
        ),
        array(
            'id'        =>  'observacoes',
            'type'      =>  'character',
            'column'    =>  'observacoes',
            'label'     =>  'Observacoes',
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
                'id'    =>  'numero_processo',
                'text'  =>  'Núm. processo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'data_processo',
                'text'  =>  'Data processo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'numero_alvara',
                'text'  =>  'Número alvará',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'data_alvara',
                'text'  =>  'Data alvará',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'nome_requerente',
                'text'  =>  'Requerente',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  6,
                )
            ),
            array(
                'id'    =>  'caixa_arquivo',
                'text'  =>  'Caixa arquivo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  2,
                )
            ),
            array(
                'id'    =>  'setor_arquivo_urbanismo',
                'text'  =>  'Setor arquivo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  6,
                )
            ),
        ),
    ),
);

?>