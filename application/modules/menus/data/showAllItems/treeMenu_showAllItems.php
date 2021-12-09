<?php

/**
 * @author Tony Frezza
 */

    
    $getModuloNodes = function($arrProp = array()) use (&$getModuloNodes){
        
        
        $arrReturn = array(
        );
        
        foreach($arrProp['nodes'] as $key => $node){
            if($node['sistema_modulos_id']==$arrProp['modulo']['id_value']){
                
                $nodeChildren = $node['children']??NULl;
                unset($node['children']);
                
                $node = $this->menus->getNode($node);
                $dataJsTree = array(
                
                );
                
                if($node['atributos']['href'] != '#'){
                    $dataJsTree['icon'] = 'fa '.($node['atributos']['icon']??'fa-list-alt');
                }
                
                
                $arrReturn[] = array(
                    'tag'       =>  'ul',
                    'children'  =>  array(
                        array(
                            'tag'           =>  'li',
                            'text'          =>  $node['atributos']['title'],
                            'data-href'     =>  $node['atributos']['href'],
                            'data-jstree'   =>  json_encode($dataJsTree,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                        )
                    )    
                );
                
                if($nodeChildren){
                    
                    $arrReturn[sizeof($arrReturn)-1]['children'][0]['children'] = $getModuloNodes(
                        array(
                            'modulo'    =>  $arrProp['modulo'],
                            'nodes'     =>  $nodeChildren
                        )
                    );
                }
                
                
                //remove o nó para diminuir a cara do loop nas proximas iteracoes
                unset($arrProp['nodes'][$key]);
            }
        }
        return $arrReturn;
        
    };
    
    $getTreeMenuHtmlData = function() use($getModuloNodes){
        
        $arrModulos = $this->modulos->getItems(
            array(
                'simple_get_items'  =>  TRUE,
                'order'     =>  array(
                    array(
                        'column'    =>  'descricao',
                        'dir'       =>  'ASC'
                    )
                )
            )
        );
        
        $arrMainMenu = $this->menus->getMainMenuData(
            array(
                'user_id'   =>  $this->data->get('user.id')
            )
        );
        
        
        $arrReturn = array(
            'tag'       =>  'div',
            'id'        =>  'menus-show-all-items',
            'style'     =>  'height: 400px; overflow-y: auto;',
            'class'     =>  array('container-fluid','col-lg-24','nopadding','nomargin','softhide'),
            'children'  =>  array(
                
            )
                        
        );
        
        foreach($arrModulos as $modulo){
            $arrModuloNodes = $getModuloNodes(
                array(
                    'modulo'    =>  $modulo,
                    'nodes'     =>  &$arrMainMenu,
                    
                )
            );
            
            
            $arrReturn['children'][] = array(
                'tag'       =>  'ul',
                'children'  =>  array(
                    array(
                        'tag'       =>  'li',
                        'text'      =>  $modulo['descricao_value'],
                        'children'  =>  $arrModuloNodes,
                    )
                )
            );
            
        }
        return $arrReturn;
    };

?>