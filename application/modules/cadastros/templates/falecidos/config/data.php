<?php

/**
 * @author Tony Frezza
 */

 

return array(
    'schema'            =>  'cadastros',
    'table'             =>  'falecidos',
    'dynamic_filters'   =>  array(
        array(
            'id'        =>  'nome_falecido',
            'clause'    =>  'contains',
            //'value'     =>  88
        ),
        
    ),
    //'auto_load_items'   =>  TRUE,
    'actions'           =>  array(
        'viewItems'     =>  44,
        'editItems'     =>  44,
    ),
    'action_menu_controller'    =>  include(dirname(__FILE__).'/../data/actionMenuController.php'),
    'variables'         =>  array(
        array(
            'id'        =>  'situacao',
            'type'      =>  'relational_1_n',
            'column'    =>  'listas_situacoes_terrenos_cemiterios_id',
            'label'     =>  'Situação',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '20', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'descricao'
                ),
                'hide_filters'  =>  array(
                    'id',
                ),
                'order'     =>  array(
                    array(
                        'id'        =>  'descricao',
                        'dir'       =>  'ASC'
                    ),
                )
                
            ),
        ), 
        array(
            'id'        =>  'nome_requerente',
            'type'      =>  'character',
            'column'    =>  'nome_requerente',
            'label'     =>  'Nome requerente',
        ),
        array(
            'id'        =>  'endereco_requerente',
            'type'      =>  'character',
            'column'    =>  'endereco_requerente',
            'label'     =>  'Endereço Requerente',
        ),
        array(
            'id'        =>  'nome_falecido',
            'type'      =>  'character',
            'column'    =>  'nome_falecido',
            'label'     =>  'Nome falecido',
        ),
        array(
            'id'        =>  'cpf_falecido',
            'type'      =>  'character',
            'column'    =>  'cpf_falecido',
            'label'     =>  'CPF falecido',
        ),
        
        array(
            'id'        =>  'idade_falecido',
            'type'      =>  'integer',
            'column'    =>  'idade_falecido',
            'label'     =>  'Idade',
        ),
                
        array(
            'id'        =>  'nome_pai_falecido',
            'type'      =>  'character',
            'column'    =>  'nome_pai_falecido',
            'label'     =>  'Nome pai',
        ),
        array(
            'id'        =>  'nome_mae_falecido',
            'type'      =>  'character',
            'column'    =>  'nome_mae_falecido',
            'label'     =>  'Nome mãe',
        ),
        
        array(
            'id'        =>  'data_falecimento',
            'type'      =>  'date',
            'column'    =>  'data_falecimento',
            'label'     =>  'Data falecimento',
        ),
        array(
            'id'        =>  'hora_falecimento',
            'type'      =>  'character',
            'column'    =>  'hora_falecimento',
            'label'     =>  'Hora falecimento',
        ),
        array(
            'id'        =>  'termo_certidao_obito',
            'type'      =>  'character',
            'column'    =>  'termo_certidao_obito',
            'label'     =>  'Termo Cert. Óbito',
        ),
        array(
            'id'        =>  'folhas',
            'type'      =>  'character',
            'column'    =>  'folhas',
            'label'     =>  'Folhas',
        ),
        array(
            'id'        =>  'livro',
            'type'      =>  'character',
            'column'    =>  'livro',
            'label'     =>  'Livro',
        ),
        array(
            'id'        =>  'cemiterio',
            'type'      =>  'relational_1_n',
            'column'    =>  'cadastros_cemiterios_id',
            'label'     =>  'Cemitério',
            'from'          =>  array(
                'module'    =>  'cadastros',
                'request'       =>  '19', //id do cadastro pertinente
                'value'         =>  array(
                    'id'
                ),
                'text'          =>  array(
                    'nome'
                ),
                'hide_filters'  =>  array(
                    'id',
                ),
                'order'     =>  array(
                    array(
                        'id'        =>  'nome',
                        'dir'       =>  'ASC'
                    ),
                )
                
            ),
        ),
        array(
            'id'        =>  'quadra',
            'type'      =>  'character',
            'column'    =>  'quadra',
            'label'     =>  'Quadra',
        ),
        array(
            'id'        =>  'fileira',
            'type'      =>  'character',
            'column'    =>  'fileira',
            'label'     =>  'Fileira',
        ), 
        array(
            'id'        =>  'sepultura',
            'type'      =>  'character',
            'column'    =>  'sepultura',
            'label'     =>  'Sepultura',
        ),
        array(
            'id'        =>  'lado',
            'type'      =>  'relational_1_n',
            'column'    =>  'lado',
            'label'     =>  'Lado',
            'options'   =>  array(
                array(
                    'text'      =>  '',
                    'value'     =>  0
                ),
                array(
                    'text'      =>  'Direito',
                    'value'     =>  1
                ),
                 array(
                    'text'      =>  'Esquerdo',
                    'value'     =>  2
                ),
            )
        ),
        array(
            'id'        =>  'numero_tumulo',
            'type'      =>  'character',
            'column'    =>  'numero_tumulo',
            'label'     =>  'Núm. túmulo',
        ),
        array(
            'id'        =>  'caixa_arquivo',
            'type'      =>  'character',
            'column'    =>  'caixa_arquivo',
            'label'     =>  'Caixa arquivo',
        ),
        array(
            'id'        =>  'reserva_terreno',
            'type'      =>  'bool',
            'column'    =>  'reserva_terreno',
            'label'     =>  'Reserva de terreno',
            
        ),
        array(
            'id'        =>  'protocolo',
            'type'      =>  'character',
            'column'    =>  'protocolo',
            'label'     =>  'Protocolo',
        ), 
        array(
            'id'        =>  'causa_mortis',
            'type'      =>  'character',
            'column'    =>  'causa_mortis',
            'label'     =>  'Causa mortis',
        ),
        array(
            'id'        =>  'observacoes',
            'type'      =>  'character',
            'column'    =>  'observacoes',
            'label'     =>  'Observações',
        ),
        
             
    ),
    'rules'         =>  array(),
    'list_items'    =>  array(
        'order'     =>  array(
            array(
                'id'    =>  'nome_falecido',
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
                'id'    =>  'nome_falecido',
                'text'  =>  'Nome falecido',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  6,
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
            array(
                'id'    =>  'reserva_terreno',
                'text'  =>  'Reserva de terreno',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
                )
            ),
            array(
                'id'    =>  'cemiterio',
                'text'  =>  'Cemitério',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
                )
            ),
            array(
                'id'    =>  'data_falecimento',
                'text'  =>  'Data de falecimento',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
                )
            ),
            array(
                'id'    =>  'caixa_arquivo',
                'text'  =>  'Caixa Arquivo',
                'class' =>  '',
                'head-col'      =>  array(
                    'lg'        =>  3,
                )
            ),
            
            
        ),
    ),
);

?>