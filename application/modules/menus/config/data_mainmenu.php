<?php

/**
 * @author Tony Frezza

 */

 

return array(
    
    'schema'            =>  'sistema',
    'table'             =>  'menus',
    'variables'         =>  array(
        array(
            'id'        =>  'id',
            'type'      =>  'integer',
            'column'    =>  'id',
            'label'     =>  'id',
            'value'     =>  1,
        ),
        array(
            'id'        =>  'nome',
            'type'      =>  'character',
            'column'    =>  'nome',
            'label'     =>  'Nome',
            'value'     =>  'Main'
        ),
        array(
            'id'            =>  'itens',
            'type'          =>  'relational_n_n',
            'schema'        =>  'sistema',
            'table'         =>  'menus_itens',
            'pk_column'     =>  'sistema_menus_id',
            'uuid'          =>  TRUE,
            'preserv_order' =>  FALSE,            
            'variables'     =>  array(
                array(
                    'id'        =>  'item_pai',
                    'type'      =>  'uuid',
                    'column'    =>  'id_item_pai',
                ),
                array(
                    'id'        =>  'ordem',
                    'type'      =>  'integer',
                    'column'    =>  'ordem',
                ),
                array(
                    'id'        =>  'controller_tipo',
                    'type'      =>  'integer',
                    'column'    =>  'sistema_tipos_controllers_id',
                ),
                array(
                    'id'        =>  'controller_id',
                    'type'      =>  'integer',
                    'column'    =>  'sistema_controllers_id',
                ),
                array(
                    'id'        =>  'controller_acao',
                    'type'      =>  'integer',
                    'column'    =>  'sistema_controllers_acoes_id',
                ),
                array(
                    'id'        =>  'sistema_modulo',
                    'type'      =>  'integer',
                    'column'    =>  'sistema_modulos_id',
                ),
                array(
                    'id'        =>  'atributos',
                    'type'      =>  'json',
                    'column'    =>  'atributos',
                ),
                array(
                    'id'        =>  'admin_node',
                    'type'      =>  'bool',
                    'column'    =>  'admin_node',
                ),
            ),
        )
    ),
);

?>