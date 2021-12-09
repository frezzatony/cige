<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{
    
    private $menu;
    
    function __construct(){
        
        parent::__construct();
     
        $this->menu = new Menus(
            array(
                'module'    =>  'menus',
                'configs'   =>  array(
                    'module_path'   =>  'menus',
                    'log_schema'    =>  'sistema',
                ),
                'data_file'         =>  'data_mainmenu',
                'pk_value'          =>  1,
                'pk_column'         =>  'id',
            )
        );        
    }
    
    public function index(){       
        
        if($this->uri->getKey('getitems')!== FALSE){
            $this->getMenuItems();
            return;
        }
        else if($this->uri->getKey('save')!== FALSE){
            $this->save();
            return;
        }     
        $this->viewEdit();     
    }
    
    /** 
    * PRIVATES 
    **/
    
    private function getMenuItems(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->menu->runActionUserPermissions(
            array(
                'action'            =>  $this->menu->get('configs.actions.editItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        if($this->encryption->decrypt($this->input->get_post('token'))!='ajax'){
            return;
        }
        
        
        $moduloId = (int)$this->input->get_post('modulo');
        
        $arrItems = $this->getMainMenuItems(
            array(
                'modulo_id'     =>  $moduloId,
                'entity_id'     =>  $this->data->get('user.configs.entity'),
            )
        );
        
        $arrItems = $this->getJsonMenuItems(
            array(
                'items'     =>  $arrItems,
            )
        );
        
        Common::printJson(
            array(
                'menu_data'    =>  $arrItems
            )
        );
    }
    
    private function save(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->menu->runActionUserPermissions(
            array(
                'action'            =>  $this->menu->get('configs.actions.editItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        if($this->encryption->decrypt($this->input->get_post('token'))!='ajax'){
            return;
        }
        
        $idModulo = $this->input->get_post('modulo');
        $keyVariableNodes = array_search('itens',array_column($this->menu->get('data.variables'),'id'));
        $this->menu->append('data.variables.'.$keyVariableNodes.'.relational_filters',
            array(
                'id'        =>  'sistema_modulo',
                'clause'    =>  'equal',
                'value'     =>  $idModulo
            )
        );
                
        $arrMenu = $this->json->getFullArray($this->input->get_post('menu'),FALSE);
        $arrMenu = $this->common->getUnbuildTree($arrMenu);
        
        foreach($arrMenu as &$node){ 
            
            $node['controller_type_id'] = $node['tipo_controller'] ?? NULL;
            $node['controller_id'] = $node['controller'] ?? NULL;
            $node['action'] = $node['acao'] ?? NULL;
            $node['module_id'] = $idModulo;
            $node['attributes'] =  array(
                'icon'      =>  'fa ' . str_replace('fa ','',$node['icon'] ?? NULL),
                'title'     =>  $node['text'] ?? NULL,
                'class'     =>  $node['class'] ?? NULL,
                'href'      =>  ($node['href'] ?? NULL) ? $node['href'] :  '#',
                'load'      =>  $node['load'] ?? NULL
            );
        }
        
        $this->menu->setItem(1); //main menu
        $this->menu->setNodes($arrMenu);
        
        $this->menu->variables->append('itens',
            array(
                'filters'       =>  array(
                    array(
                        'id'        =>  'sistema_modulo',
                        'clause'    =>  'equal_integer',
                        'value'     =>  $idModulo
                    )
                )  
            )
        );
        
        
        $responseUpdate = $this->menu->update();
        
        if(is_array($responseUpdate)){
            Common::printJson($responseUpdate); 
            return;
        }
        
             
        Common::printJson(
            array(
                'status'    =>  $responseUpdate ? 'ok' : 'error',
                'id'        =>  $responseUpdate,
                'token'     =>  $this->menu->getToken(),
                'console'   =>  array(
                    array(
                        'date_time' =>  date('d/m/Y|H:i:s'),
                        'message'   =>  '[Main menu]: Foi atualizado.',
                        'type'      =>  'success',
                    )
                )
            )
        ); 
             
    }
    
    private function viewEdit(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->menu->runActionUserPermissions(
            array(
                'action'            =>  $this->menu->get('configs.actions.editItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $arrModulos = $this->modulos_model->getModulos();
        $idModuloAtual = $this->data->get('user.configs.modulo');
        
        $bsForm = new BsForm(
            array(
                'inputs'        =>  array(
                    array(
                        'type'      =>  'dropdown',
                        'id'        =>  'moduloMenu',
                        'label'     =>  'Módulo:',
                        'options'   =>  $this->bsform->getOptionsFromData(
                            array(
                                'value_key' =>  'id',
                                'text_key'  =>  'descricao',   
                                'data'      =>  $arrModulos
                            )
                        ),
                        'value'     =>  $idModuloAtual,
                        'grid-col'  =>  array(
                            'lg'        =>  24,
                            'md'        =>  24
                        )
                    ),
                )
            )
        );
        $this->template->set('htmlFormModulos',$bsForm->getHtml());
        
        
        
        //form para edição de nós
        $bsform = new BsForm(include(dirname(__FILE__).'/../data/bsform_main_menu.php'));
        
        $bsformData = $bsform->getHtmlData();
        
        $html = new Html;
        
        $html->add($bsformData['form']);    
            
        $this->template->set('formEditNodes',$html->getHtml());
        $this->template->append('javascript',$bsformData['javascript']);
         
        $this->template->set('token',$this->encryption->encrypt('ajax'));
        $this->make_bread->add('Menus',FALSE,FALSE);
        $this->make_bread->add('Main Menu',FALSE,FALSE);
        
        $jsViewMainMenu = $this->template->load('blank','menus','jsMain_menu_edit_view',NULL,TRUE);        
        $this->template->append('javascript',$jsViewMainMenu);
        
        $arrTemplate = $this->common->getTemplate();
        $this->template->load($arrTemplate['template'],'menus', 'Main_menu_edit_view');
        
    }
    
    private function getJsonMenuItems($arrProp = array()){
        
        $arrReturn = array();
        
        foreach($arrProp['items'] as $node){
            
            $arrReturn[] = array(
                'id'                =>  $node['id'] ?? NULL,
                'href'              =>  $node['atributos']['href'] ?? NULL,
                'text'              =>  $node['atributos']['title'] ?? NULL,
                'icon'              =>  $node['atributos']['icon'] ?? NULL,
                'tipo_controller'   =>  $node['sistema_tipos_controllers_id'] ?? NULL,
                'controller'        =>  $node['sistema_controllers_id'] ?? NULL,
                'acao'              =>  $node['sistema_controllers_acoes_id'] ?? NULL,
                'load'              =>  $node['atributos']['load'] ?? NULL,
                'admin_node'        =>  $node['admin_node'] ?? NULL,
                'can_edit'          =>  $node['can_edit'] ?? NULL,
                'can_delete'        =>  $node['can_delete'] ?? NULL,
            );
            
            if($node['children']??NULL){
                
                $arrReturn[sizeof($arrReturn)-1]['children'] = self::getJsonMenuItems(
                    array(
                        'items'     =>  $node['children']
                    )
                );
            }
        }
        
        return $arrReturn;
    }
    
    private function getMainMenuItems($arrProp = array()){
        
        $arrProp['modulo_id'] = $arrProp['modulo_id'] ?? $this->data->get('user.configs.modulo');
        $arrData = $this->menus_model->getTreeMainMenuData($arrProp);
        
        return $arrData;
    }
    
    private function loadJsPlugins($arrTemplate){
        
        $this->template->loadJs(BASE_URL.'assets/plugins/jquery-menu-editor/jquery-menu-editor.js');
        
        if($arrTemplate['template']=='ajax'){
            $this->template->append('javascript',$this->template->load('blank','menus','jsLoadPluginMenuEditor',NULL,TRUE));
        }
        
    }
    
    
}
