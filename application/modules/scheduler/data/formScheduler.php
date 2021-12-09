<?php

/**
 * @author Tony Frezza
 */


$getFormScheduler = function(){
    
    $arrOptionsModulo = array();
    $arrOptionsMetodo = array();
    
    $modulosRegistrados = $this->cadastro->getRegisteredModules();
    if($modulosRegistrados){
        
        $modulosNomes = array_column($modulosRegistrados,'name');
        array_multisort($modulosNomes, SORT_ASC, $modulosRegistrados);
        
        foreach($modulosRegistrados as $modulo){
            
            if(($modulo['methods']??NULL)){
                foreach($modulo['methods'] as $method){
                    $arrOptionsMetodo[] = array(
                        'value'         =>  strtoMINusculo($method['name']),
                        'text'          =>  ucfirst($method['description']), 
                        'data-modulo'   =>  strtoMINusculo($modulo['name']),
                    );
                }    
            }
            
            $arrOptionsModulo[] = array(
                'value'         =>  strtoMINusculo($modulo['name']),
                'text'          =>  ucfirst($modulo['name']),
            );
        }    
    }
    
    
    $bsform = new BsForm(
        array(
            'id'            =>  'ID4zVpSOu0NT',
            'class'         =>  array('tab-enter','padding-6','margin-bottom-4','bg-gray','bordered'),
            'readonly'      =>  !$this->cadastro->runActionUserPermissions(
                array(
                    'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                    'user_id'           =>  $this->data->get('user.id'),
                    'entity_id'         =>  $this->data->get('user.configs.entity'),
                )
            ),
            'inputs'    =>  array(
            
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  'Código:',
                    'value'         =>  $this->cadastro->get('item.value'),
                    'placeholder'   =>  'Nova',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  3,  
                    ),
                    
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'ativo',
                    'label'         =>  'Status',
                    'value'         =>  $this->cadastro->variables->get('ativo.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  21,  
                    ),
                    'input-col'     =>  array(
                        'lg'    =>  5
                    ),
                    'options'       =>  array(
                        array(
                            'value'     =>  'SIM',
                            'text'      =>  'Habilitado'
                        ),
                        array(
                            'value'     =>  'NÃO',
                            'text'      =>  'Desabilitado'
                        )
                    )
                ),
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'descricao',
                    'label'         =>  'Descrição:',
                    'value'         =>  $this->cadastro->variables->get('descricao.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  24,  
                    ),
                    'input-col'     =>  array(
                        'lg'    =>  12
                    ),
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'modulo',
                    'label'         =>  'Módulo invocado',
                    'value'         =>  $this->cadastro->variables->get('modulo.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  5,  
                    ),
                    'options'       =>  $arrOptionsModulo
                ),
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'metodo',
                    'label'         =>  'Método invocado',
                    'value'         =>  $this->cadastro->variables->get('metodo.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                    'options'       =>  $arrOptionsMetodo
                ),
                array(
                    'type'          =>  'hidden',
                    'id'            =>  'periodicidade',
                    'value'         =>  $this->cadastro->variables->get('periodicidade.value') ? $this->cadastro->variables->get('periodicidade.value') : '* * * * *',
                    
                ),
                array(
                    'tag'           =>  'div',
                    'class'         =>  array('col-lg-24','size-11','nopadding','padding-4'),
                    'children'      =>  array(
                            array(
                                'tag'       =>  'div',
                                'class'     =>  array('col-lg-24','size-11','nopadding'),
                                'children'  =>  array(
                                    array(
                                        'tag'   =>  'label',
                                        'text'  =>  'Periodicidade:',
                                    ),
                                )
                            ),
                            
                            array(
                                'tag'           =>  'div',
                                'id'            =>  'periodicidade_cron',
                                'class'         =>  array('col-lg-24','size-11','nopadding','padding-4','bg-white'),
                                'grid-col'      =>  array(
                                    'lg'    =>  24,  
                                ),
                        ),
                    )
                ),
                array(
                    'type'      =>  'integer',
                    'id'        =>  'dias_logs',
                    'label'     =>  'Nº Dias armazenar logs de execução:',
                    'value'     =>  $this->cadastro->variables->get('dias_logs.value'),
                    'grid-col'      =>  array(
                        'lg'    =>  7,  
                    ),
                ), 
                array(
                    'type'      =>  'summernote',
                    'id'        =>  'observacoes',
                    'label'     =>  'Observacoes:',
                    'value'     =>  $this->cadastro->variables->get('observacoes.value'),
                    'data-height'   =>  140,
                )                
            )
        )
    );
    
    $bsformData = $bsform->getHtmlData();
    $arrDataReturn = array(
        'html'          =>  array($bsformData['form']),
        'javascript'    =>  $bsformData['javascript']
    ); 
    return $arrDataReturn;
}

?>