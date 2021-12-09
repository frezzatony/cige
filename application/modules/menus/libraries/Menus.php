<?php

/**
 * @author Tony Frezza
 */


class Menus extends Cadastros{
    
    private $actionButtonsRightNodes = array();
           
    function __construct($arrProp = array()){
        
        $arrProp['module'] = 'menus';
        
        parent::__construct($arrProp);
        
    }
    
    public function getMainMenu($arrProp = array()){
        
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/file-icon/file-icon-vivid.css');
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/file-icon/file-icon-extra.css');
          
        $arrProp['user_id'] = $arrProp['user_id'] ?? $this->CI->data->get('user.id');
        $arrProp['entity_id'] = $arrProp['entity_id'] ?? $this->CI->data->get('user.configs.entity');
        $arrProp['modulo_id'] = $arrProp['modulo_id'] ?? $this->CI->data->get('user.configs.modulo');
        
        $arrProp['modulo_id'] = $arrProp['modulo_id'] ? $arrProp['modulo_id'] : 2; //ACESSO PUBLICO
        
        $arrMenu = $this->getMainMenuData($arrProp);
              
        $html = new Html;
        
        $idMainMenu = $html->add(
            array(
                
            )
        );
        
        foreach($arrMenu as $node){
            $arrDataHtmlNode = $this->getMainMenuNode($node);
            $html->add($arrDataHtmlNode);
        }
        
        $userName =  $this->CI->data->get('user.nome');
        $arrUserName = string_to_array($userName,' ');
        $userFirstName = array_shift($arrUserName);
        $userLastName = array_pop($arrUserName);
        $userSeparatorName = array_pop($arrUserName);
        
    
        $strUserName = $userFirstName;
        if(in_array($userSeparatorName,array('da','de','do'))){
            $strUserName .= ' ' . $userSeparatorName;
        }
        $strUserName .= ' '.$userLastName;
        $strUserName = nomePessoa($strUserName);
        //USER LOGADO
        $html->add( 
             array(
                'tag'       =>  'li',
                'class'     =>  'dropdown right',
                'children'  =>  array(
                    array(
                        'tag'           =>  'a',
                        'href'          =>  '#',
                        'class'         =>  'dropdown-toggle',
                        'data-toggle'   =>  'dropdown',
                        'tabindex'      =>  '-1',
                        'children'      =>  array(
                            array(
                                'tag'       =>  'span',
                                'text'      => $strUserName,       
                            )
                        )
                    ),
                    array(
                        'tag'       =>  'ul',
                        'class'     =>  'dropdown-menu',
                        'children'  =>  array(
                            array(
                                'tag'       =>  'li',
                                'children'  =>  array(
                                    array(
                                        'tag'       =>  'a',
                                        'class'     =>  'load-modal',
                                        'href'      =>  BASE_URL.'users/changepassword/view/render',
                                        'tabindex'  =>  '-1',
                                        'children'  =>  array(
                                            array(
                                                'tag'       =>  'i',
                                                'class'     =>  'fa fa-key', 
                                            ),
                                            array(
                                                'tag'   =>  'span',
                                                'text'  =>  'Alterar senha',
                                                'title' =>  'Alterar senha',
                                            )
                                        )
                                    )   
                                )
                            ),
                            array(
                                'tag'       =>  'li',
                                'children'  =>  array(
                                    array(
                                        'tag'       =>  'a',
                                        'class'     =>  array('btn-logout'),
                                        'href'      =>  BASE_URL.'login/logout',
                                        'tabindex'  =>  '-1',
                                        'children'  =>  array(
                                            array(
                                                'tag'       =>  'i',
                                                'class'     =>  'fa fa-power-off', 
                                            ),
                                            array(
                                                'tag'   =>  'span',
                                                'text'  =>  'Logout'
                                            )
                                        )
                                    )   
                                )
                            ),
                        )
                    )
                )   
            )
        );
        //FIM USER LOGADO
        
        //ENTIDADE
        $entityTree = $this->CI->entidades_model->getEntityTreeParent(array('pk_value'=>$arrProp['entity_id']));
         
        $strEntity = '';
        foreach($entityTree as $entity){
            if($strEntity){
                $strEntity .= ' / ';
            }
            
            $strEntity .= $entity['descricao'];
        }
                 
        
        $html->add(
             array( 
                'tag'       =>  'li',
                'class'     =>  'dropdown right',
                'children'  =>  array(
                    array(
                        'tag'       =>  'a',
                        'href'      =>  '#',
                        'class'     =>  'btn-change-entity',
                        'text'      =>  $strEntity,
                    ),
                    array(
                        'tag'   =>  'script',
                        'type'  =>  'text/javascript',
                        'text'  =>  $this->CI->common->getJqueryJavascript($this->CI->load->view('jsAlterarEntidade',NULL,TRUE,'entidades')),
                    )
                )   
            )
        );
        
        //FIM ENTIDADE
        
        //TODOS OS ITENS DE MENUS PARA ADMINISTRADORES
        if($this->CI->users->isAdmin($this->CI->data->get('user.id'))){
            $html->add(
                 array( 
                    'tag'       =>  'li',
                    'class'     =>  'dropdown right',
                    'children'  =>  array(
                        array(
                            'tag'       =>  'a',
                            'href'      =>  '#',
                            'class'     =>  'btn-mainmenu-show-all-items',
                            'title'     =>  'Exibir todos os itens de menus',
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'i',
                                    'class'     =>  'fa fa-bars', 
                                ),
                                array(
                                    'tag'   =>  'script',
                                    'type'  =>  'text/javascript',
                                    'text'  =>  $this->CI->common->getJqueryJavascript($this->CI->load->view('jsMainMenu_showAllItems',NULL,TRUE,'menus')),
                                )
                            )
                            
                        ),
                    )   
                )
            );
        }
        
        $html->add(
             array( 
                'tag'       =>  'li',
                'class'     =>  'dropdown right',
                'children'  =>  array(
                    array(
                        'tag'       =>  'a',
                        'href'      =>  '#',
                        'class'     =>  '',
                        'title'     =>  'Favoritos',
                        'children'  =>  array(
                            array(
                                'tag'       =>  'i',
                                'class'     =>  'las la-star', 
                            ),
                        )
                        
                    ),
                )   
            )
        );
        //FIM TODOS OS ITENS DE MENUS PARA ADMINISTRADORES
        return $html->getHtml();
    }
    
    public function getMainMenuData($arrProp = array()){
        
        return $this->CI->menus_model->getMainMenuData($arrProp);
    }
    
    
    
    /*** Action Buttons Right **/
    
    public function addActionButtonsRightNode($node){
        
        if(array_key_exists('id',$node)===FALSE){
            $node['id'] = random_string();
            $node['random_id'] = TRUE;
        }
        
        $this->actionButtonsRightNodes[] = $node;  
    }
    public function getActionButtonsRight(){

        $html = new Html;
        
        foreach($this->actionButtonsRightNodes as $node){
            $html->add($node);
        }
        
        return $html->getHtml();
    }
    
        
    public function getNode($node = array()){
        
        $node['atributos']['class'] = string_to_array($node['atributos']['class'] ?? array());
        $node['atributos']['href'] = $node['atributos']['href'] ?? NULL; 
        
        if($node['atributos']['load'] ?? NULL){
            $node['atributos']['class'][] = 'load-'.$node['atributos']['load'];
        }            
        
        if($node['cadastro']['id'] ?? NULL){
            
           $nodeHref = $node['atributos']['href'];
            $node['atributos']['href'] = $this->CI->config->item('controlles_url','menus')[2];
            $node['atributos']['href'] .= $node['cadastro']['url'];
            
            $node['atributos']['href'] .= $nodeHref;
        } 
        else{
           $node['atributos']['href'] = $node['atributos']['href'] ?? '#';
           $node['atributos']['href'] = $this->CI->parser->parse_string($node['atributos']['href'],array('BASE_URL'=>BASE_URL),TRUE);
        }
        
        
        $node['tipo_controller'] = strtoMINusculo(clearSpecialChars($node['tipo_controller']??NULL));
                
        return $node;
    }

    public function getNodeHref($node,$parse=array()){
        
        if(($node['atributos'] ?? NULL)){    
            return  $this->CI->parser->parse_string($node['atributos']['href'] ?? NULL,array_merge(array('BASE_URL'=>BASE_URL),($parse??array())),TRUE);            
        }

    }
    
    public function setNodes($arrNodes){
        
        $arrValues = array(
            array(
                'id'        =>  'itens',
                'value'     =>  array()
            )
        );
        
        foreach($arrNodes as $node){
            
            $arrValues[0]['value'][] = array(
                array(
                    'id'        =>  'id',
                    'value'     =>  $node['id'] ?? NULL,
                ),
                array(
                    'id'        =>  'item_pai',
                    'value'     =>  $node['parent_id'] ?? NULL
                ),
                array(
                    'id'        =>  'ordem',
                    'value'     =>  ($node['order'] ?? NULL)+1,
                ),
                array(
                    'id'        =>  'controller_tipo',
                    'value'     =>  $node['controller_type_id'] ?? NULL
                ),
                array(
                    'id'        =>  'controller_id',
                    'value'     =>  $node['controller_id'] ?? NULL
                ),
                array(
                    'id'        =>  'controller_acao',
                    'value'     =>  $node['action'] ?? NULL
                ),
                array(
                    'id'        =>  'sistema_modulo',
                    'value'     =>  $node['module_id'] ?? NULL
                ),
                array(
                    'id'        =>  'atributos',
                    'value'     =>  $node['attributes'] ?? NULL
                ),
                array(
                    'id'        =>  'admin_node',
                    'value'     =>  $node['admin_node'] ?? NULL
                ), 
                array(
                    'id'        =>  'can_delete',
                    'value'     =>  $node['can_delete'] ?? NULL
                ),  
            );
        }
        
        $this->mergeValues(
            array(
                'values'        =>  $arrValues,
                'method'        =>  'database',
            )
        );
        
        //print_R($this->variables->get('itens')->variables->Get('admin_node')->get()); exit;
                
    }
    
    /**
     * PRIVATES
     **/
     
    private function getMainMenuNode($node = array()){
        
        $arrDataReturn = array();
        
        $node = $this->getNode($node);
        
        $arrChildren = array();
        if(($node['children'] ?? NULL)){
            foreach($node['children'] as $childNode){
                $childNode['is_child'] = TRUE;
                $childNodeHtmlData = self::getMainMenuNode($childNode);
                if($childNodeHtmlData){
                    $arrChildren[] = $childNodeHtmlData;
                }
            }
        } 
        
        if(($node['atributos']['href']==NULL OR $node['atributos']['href']=='#' AND !($arrChildren)) AND $node['is_admin']!='t'){
            return NULL;
        }
        
        
        if(!($node['atributos']['load']??NULL)){
           $node['atributos']['load'] = 'page'; 
        }
        
        $node['atributos']['class'] = $this->CI->common->append($node['atributos']['class'],array('load-'.$node['atributos']['load']));
        append($node['atributos']['class'],array('controller_'.$node['tipo_controller']));
        
        $arrDataReturn = array(
            'tag'       =>  'li',
            'class'     =>  'dropdown',
            'children'  =>  array(
                array(
                    'tag'           =>  'a',
                    'href'          =>  $node['atributos']['href'],
                    'class'         =>  $node['atributos']['class'],
                    'data-toggle'   =>  'dropdown',
                    'tabindex'      =>  '-1',
                ),
            )  
        );
        
        
        if($node['is_child']??NULL){
            
            $arrDataReturn['children'][0]['children'] = array(
                array(
                    'tag'       =>  'i',
                    'class'     =>  $node['atributos']['icon'] ?? NULL,
                ),
                array(
                    'tag'       =>  'span',
                    'text'      =>  $node['atributos']['title']
                )
            
            );
        }
        else{
            $arrDataReturn['children'][0]['children'] = array(
                array(
                    'tag'       =>  'span',
                    'text'      =>  $node['atributos']['title']
                )
            );
        }
        
        if($arrChildren){
            
            if($node['is_child']??NULL){
                $arrDataReturn['class'] = 'dropdown-submenu';    
            }
            $arrDataReturn['children'][] = array(
                'tag'       =>  'ul',
                'class'     =>  'dropdown-menu',
                'children'  =>  $arrChildren,
                
            );
        }
        
        return $arrDataReturn;
    }
}

?>