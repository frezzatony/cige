<?php

/**
 * @author Tony Frezza
 */


return 
    array(
        'id'            =>  'YINFWOQRVzUo', //id deve ser informada, para salvar o form em cache, pois possui inputs com ajax
        'inputs'        =>  array(
            array(
                'type'          =>  'icon',
                'label'         =>  'Ícone:',
                'id'            =>  'icon',
                'name'          =>  'icon',
            ),
            array(
                'type'          =>  'textbox',
                'label'         =>  'Título:',
                'name'          =>  'text',
                'id'            =>  'text'
            ),
            array(
                'type'          =>  'dropdown',
                'label'         =>  'Tipo de controller:',
                'name'          =>  'tipo_controller',
                'id'            =>  'tipo_controller',
                'first_null'    =>  TRUE,
                'from'          =>  array(
                    'module'    =>  'tipos_controllers',
                    'value'     =>  array(
                        'id',
                    ),
                    'text'      =>  array(
                        'descricao'
                    ),
                    'return_data'   =>  array(
                        array(
                            'id'    =>  'uri',
                        )
                    )
                )
            ),
            array(
                'type'          =>  'dropdown',
                'label'         =>  'Controller:',
                'name'          =>  'controller',
                'id'            =>  'controller',
                'first_null'    =>  TRUE,
                'from'      =>  array(
                    'module'        =>  'controllers',
                    //'method'        =>  'getControllers',
                    'filters'       =>  array(
                        array(
                            'id'        =>  'tipo',
                            'clause'    =>  'equal',
                            'value'     =>  '{this.inputs.#tipo_controller.value}'   
                        )
                    ),
                    'value'         =>  array(
                        'id'
                    ),
                    'text'          =>  array(
                        'descricao_plural'
                    ),
                    'order'         =>  array(
                        array(
                            'id'        =>  'descricao_plural'
                        )
                    ),
                    'return_data'   =>  array(
                        array(
                            'id'    =>  'url',
                        )
                    )
                ),
                'update_on'     =>  array(
                    array(
                        'selector'      =>  'form.#tipo_controller',
                        'bind'          =>  'change',    
                    )
                ),
                
            ),
            array(
                'type'          =>  'dropdown',
                'label'         =>  'Ação:',
                'name'          =>  'acao',
                'id'            =>  'acao',
                'first_null'    =>  TRUE,
                'from'      =>  array(
                    'module'        =>  'acoes_controllers',
                    'filters'       =>  array(
                        array(
                            'id'        =>  'controller',
                            'clause'    =>  'equal',
                            'value'     =>  '{this.inputs.#controller.value}'   
                        )
                    ),
                    'value'         =>  array(
                        'id'
                    ),
                    'text'          =>  array(
                        'descricao'
                    ),
                ),
                'update_on'     =>  array(
                    array(
                        'selector'      =>  'form.#controller',
                        'bind'          =>  'change',    
                    ),
                ),
            ),
            array(
                'type'          =>  'textbox',
                'label'         =>  'URL:',
                'name'          =>  'href',
                'id'            =>  'href'
            ),
            array(
                'type'          =>  'dropdown',
                'label'         =>  'Modo de exibição',
                'name'          =>  'load',
                'id'            =>  'load',
                'options'       =>  array(
                    array(
                        'value'     =>  'page',
                        'text'      =>  'Carregar página'    
                    ),
                    array(
                        'value'     =>  'modal',
                        'text'      =>  'Carregar em Modal'    
                    ),
                )
            ),
            array(
                'type'          =>  'dropdown',
                'label'         =>  'Item para administradores:',
                'id'            =>  'admin_node',
                'options'   =>  array(
                    array(
                        'text'      =>  'Não',
                        'value'     =>  'f'
                    ),
                    array(
                        'text'      =>  'Sim',
                        'value'     =>  't'
                    )
                ),
            ),
            
        )
    );
    
    
?>