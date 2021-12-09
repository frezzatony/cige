<?php

/**
 * @author Tony Frezza
 */



$getActionMenuControllerItem = function($arrProp = array()){
    
    
    if((int)$this->cadastro->variables->get('tipo.value')){
        $arrDataTipo = array(
            'text'  =>  $this->cadastro->variables->get('tipo.text'),
            'id'    =>  $this->cadastro->variables->get('tipo.value')
        );
    }
    else if((int)($arrProp['tipo']??NULL)){
        $tempCadastro = new Cadastros(
            array(
                'request'   =>  70, //Dispositivos
                'item'      =>  $arrProp['tipo']
            )
        );
        
        $arrDataTipo = array(
            'text'  =>  $tempCadastro->variables->get('tipo.text'),
            'id'    =>  $tempCadastro->variables->get('tipo.value')
        );
    }
    
    
    
    $arrMenu = array(
        array(
            'atributos' =>  array(
                'title'     =>  'Novo',
                'icon'      =>  'la la-file size-12',
            ),
            'children'  =>  array(
                array(
                    'action'        =>  122,
                    'atributos'     =>  array(
                        'title'     =>  ($arrDataTipo['text']??' '),
                        'icon'      =>  'fa fa-fax size-13',
                        'href'      =>  '/view/tipo/'.($arrDataTipo['id']??NULL),
                        'class'     =>  array('editar-cadastro','novo-item-mesmo-tipo'),
                    )
                ),
                array(
                    'action'        =>  122,
                    'atributos'     =>  array(
                        'title'     =>  'Escolher modelo',
                        'icon'      =>  'fa fa-fax size-13',
                        'href'      =>  '/view',
                        'class'     =>  array('editar-cadastro','novo-item'),
                    )
                ),
            ), 
        ),
    
        array(
            'atributos' =>  array(
                'title'     =>  'Gerenciar', 
            ),
            'children'  =>  array(
                array(
                    'action'    =>  122,
                    'atributos' =>  array(
                        'title'     =>  'Excluir',
                        'icon'      =>  'fa fa-trash',
                        'href'      =>  '/delete',
                        'class'     =>  array('cadastro-excluir-item','need-item'), 
                    )
                ),
                array(
                    'action'    =>  122,
                    'atributos' =>  array(
                        'title'     =>  'Gerar uma cópia',
                        'icon'      =>  'fa fa-copy',
                        'href'      =>  '/view',
                        'class'     =>  array('cadastro-clone-item','need-item'), 
                    )
                ),
            )
        ),
    );
   
        
    return $arrMenu;
   
        
}  
?>