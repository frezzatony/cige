<?php

/**
 * @author Tony Frezza

 */

    
    require(dirname(__FILE__).'/variable_bairros.php');
    require(dirname(__FILE__).'/variable_leis.php');
    require(dirname(__FILE__).'/variable_ceps.php');
    

    $variables = array(
        
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
                'hide_filters'  =>  array(
                    'id',
                ),
                'filters'   =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal',
                        'value'     =>  '1',
                    ),
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal',
                        'value'     =>  '2',
                    ),
                ),
            ),
        ),
        array(
            'id'        =>  'estado',
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
                'list_items'    =>  array(
                    'order'     =>  array(
                        array(
                            'id'    =>  'nome',
                            'dir'   =>  'ASC'
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
                            'text'  =>  'Estado',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  18,
                            )
                        ),
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
            'id'        =>  'cidade',
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
                'url_data'      =>  BASE_URL.'cadastros/logradouros/method/externallist_cidades_data',
                'list_items'    =>  array(
                    'order'     =>  array(
                        array(
                            'id'    =>  'nome',
                            'dir'   =>  'ASC'
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
                            'text'  =>  'Cidade',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  12,
                            )
                        ),
                        array(
                            'id'    =>  'estado',
                            'text'  =>  'Estado',
                            'class' =>  '',
                            'head-col'      =>  array(
                                'lg'        =>  10,
                            )
                        ),
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
            'id'        =>  'tipo_logradouro',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_tipos_logradouros_id',
            'label'     =>  'Tipo',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '13', //id do cadastro pertinente
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
                        'id'        =>  'situacao',
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
            'id'        =>  'denominacao',
            'type'      =>  'character',
            'column'    =>  'denominacao',
            'label'     =>  'Denominação',
        ),
        array(
            'id'        =>  'data_denominacao',
            'type'      =>  'date',
            'column'    =>  'dt_denominacao',
            'label'     =>  'Data denominação',
        ),
        
        array(
            'id'        =>  'extensao',
            'type'      =>  'number',
            'column'    =>  'extensao',
            'label'     =>  'Extensão (m)',
        ),
        array(
            'id'        =>  'largura',
            'type'      =>  'number',
            'column'    =>  'largura',
            'label'     =>  'Largura (m)',
        ),
        
        array(
            'id'        =>  'pavimento_asfalto',
            'type'      =>  'number',
            'column'    =>  'pavimento_asfalto',
            'label'     =>  'Pav. Aslfato (m)',
        ),
        array(
            'id'        =>  'pavimento_lajota',
            'type'      =>  'number',
            'column'    =>  'pavimento_lajota',
            'label'     =>  'Pav. Lajota (m)',
        ),
        array(
            'id'        =>  'pavimento_saibro',
            'type'      =>  'number',
            'column'    =>  'pavimento_saibro',
            'label'     =>  'Pav. Saibro (m)',
        ),
        array(
            'id'        =>  'pavimento_paralelepipedo',
            'type'      =>  'number',
            'column'    =>  'pavimento_paralelepipedo',
            'label'     =>  'Pav. Paralelep. (m)',
        ),
        array(
            'id'        =>  'pavimento_outros',
            'type'      =>  'number',
            'column'    =>  'pavimento_outros',
            'label'     =>  'Pav. Outros (m)',
        ),
        $variable_bairros,
        $variable_leis,
        $variable_ceps,
        array(
            'id'        =>  'coordenadas_mapa',
            'type'      =>  'character',
            'column'    =>  'coordenadas_mapa',
            'label'     =>  'Coordenadas Mapa',
        ),
        array(
            'id'        =>  'observacoes',
            'type'      =>  'character',
            'column'    =>  'observacoes',
            'label'     =>  'Observações',
        ),
        
    );
?>