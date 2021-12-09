<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Main_cadastros extends CI_Controller{
    
    protected $cadastro;
    private $tempController;
    
    function __construct($arrProp = array()){

        parent::__construct();
        
        if(($arrProp['init']??FALSE)){
            $this->initSelf();
            $this->initDefaults();
            
        } 
    }
    
    
    public function index(){ 
        
        $arrTemplate = $this->common->getTemplate();
        
        if($this->uri->getKey('view') !== FALSE){
            if($this->input->get_post('load')=='modal' AND !in_array($arrTemplate['template'],array('modal','ajax'))){
                $this->setJsModal();
            }
            else{
                $this->editItem();
                return;    
            }
        }
        else if($this->uri->getKey('getitems')!== FALSE){
            $this->getItemsGrid();
            return;
        }
        else if($this->uri->getKey('save')!== FALSE){
            $this->save();
            return;
        }
        else if($this->uri->getKey('delete')!== FALSE){
            $this->delete();
            return;
        }
        else if($this->uri->getKey('export')!== FALSE){
            $this->export();
            return;
        }
        else if($this->uri->getKey('method')!==FALSE){
            $this->getMethod();
            return;
        }
               
        $this->listItems(array());
        
        return TRUE;
        
    }
    
    
    public function delete(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
                'permission'        =>  'delete',
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            
            $this->main_model->erroPermissao();
        }
        
                
        $arrPks = $this->input->post('pk') ?? NULL;
        if(!$arrPks){
            Common::printJson(
                array(
                    'messages'  =>  array(
                        array(
                            'type'      =>  'info',
                            'message'   =>  '<i class="fa fa-info-circle margin-right-10"></i>Não há itens selecionados.'
                        )
                    )
                )
            );
            return FALSE;
        }
        
        
        $arrResponseDelete = array();
        
        if(method_exists($this,'beforeDelete')){
            $dataReturn = $this->beforeDelete();
            
            if($dataReturn['cadastro']??NULL){
                $this->cadastro = $dataReturn['cadastro'];    
            }
        }
        
        $dataReturn = $this->callControllerMethod('beforeDelete',
            array(
                'pk'    =>  $arrPks
            )
        );
        
        if($dataReturn['cadastro']??NULL){
            $this->cadastro = $dataReturn['cadastro'];    
        }
        
        if($dataReturn['pk']??NULL){
            $arrPks = $dataReturn['pk'];    
        }
        
        if($dataReturn['response']??NULL){
           append($arrResponseDelete,$dataReturn['response']);    
        }     
        
        
        //EXCLUSAO
        if($arrPks){
            append($arrResponseDelete,$this->cadastro->delete($arrPks));
        }
        
        
        $dataReturn = $this->callControllerMethod('afterDelete',
            array(
                'response_delete'   =>  $arrResponseDelete
            )
        );        
        if($dataReturn['cadastro']??NULL){
            $this->cadastro = $dataReturn['cadastro'];    
        }
        
        
        $arrMessages = array();
        $arrConsole = array();
        
        
        $flagAllDeleted = TRUE;
        $failItensCount = 0;        
        
        foreach($arrResponseDelete as $response){
                
                
            if(!$response['status']){
                
                $flagAllDeleted = FALSE;
                
                $failItensCount++;
                
                $message = '[Cadastro]['.$this->cadastro->get('descricao_singular').'][Código:'.$response['pk'].']: Não pode ser excluído. ';
                $message .= $this->config->item($response['error']['code'],'db_errors');
                $arrConsole[] = array(
                    'date_time' =>  date('d/m/Y|H:i:s'),
                    'message'   =>  $message
                );
                
            }
            else{
                //LOG DE ATIVIDADE DO CADASTRO
                $this->logger->setLog(
                    array(
                        'schema'        =>  ($this->cadastro->get('data.schema') ?? $this->config->item('db_log_schema','cadastros')).'_'.$this->config->item('db_log_sufix','cadastros'),
                        'table_log'     =>  ($this->cadastro->get('data.schema') ?? $this->config->item('db_log_schema','cadastros')).'_'.$this->cadastro->get('data.table'),
                        'item_id'       =>  $response['pk'],
                        'user_id'       =>  $this->data->get('user.id'),
                        'action'        =>  'DELETE',
                    )
                );
                
                
                $arrConsole[] = array(
                    'date_time' =>  date('d/m/Y|H:i:s'),
                    'message'   =>  '[Cadastro]['.$this->cadastro->get('descricao_singular').'][Código:'.$response['pk'].']: Foi excluído.'
                );   
            }
        }
        
        
        if($flagAllDeleted){
            $arrMessages = array(
                array(
                    'type'      =>  'success',
                    'message'   =>  sizeof($arrPks)==1 ? 'Item excluído.' : 'Itens excluídos',
                )
            );   
        }
        else if($failItensCount < sizeof($arrResponseDelete)){
            
            $arrMessages = array(
                array(
                    'type'      =>  'success',
                    'message'   =>  'Executada a exclusão de alguns itens.'
                ),
                array(
                    'type'      =>  'warning',
                    'message'   =>  '<i class="fa fa-exclamation-triangle margin-right-10"></i> Alguns itens não foram excluídos.<br />Consulte o Console para mais detalhes.'
                ),
            );  
        }
        else{
            $arrMessages = array(
                array(
                    'type'      =>  'error',
                    'message'   =>  '<i class="fa fa-exclamation-triangle margin-right-10"></i>A exclusão não foi executada.<br />Consulte o Console para mais detalhes.'
                ),
            );  
        }
        
        
        Common::printJson(
            array(
                'messages'  =>  $arrMessages,
                'console'   =>  $arrConsole
            ),    
        200,TRUE);
    }
    
    protected function editItem($arrProp = array()){
        
        $arrTemplate = $this->common->getTemplate();
        
        $htmlBody = new Html();
        
        $idInputContainer = random_string();  
        
        $htmlBody->add(
            $this->cadastro->getHtmlDataDefaultBody(
                array(
                    'id_input_container'    =>   $idInputContainer,
                )
            )
        ); 
        $viewData = array(
            'body'      =>  $htmlBody->getHtml(),
            'footer'    =>  '',
        );   
        
        
        //inclui dados do cadastros/templates/{template}
        
        $controllerData = $this->callControllerMethod('index');
                
        if($controllerData){ 
            
            foreach($controllerData as $key => $val){
                if($viewData[$key]??NULL){
                   append($viewData[$key],$val); 
                }
                else{
                    $viewData[$key] = $val;
                }
            }
            
        }
        
        if(($arrProp['view_data']??NULL)){
            foreach($arrProp['view_data'] as $key => $val){
                if($viewData[$key]??NULL){
                    
                   append($viewData[$key],$val); 
                }
                else{
                    $viewData[$key] = $val;
                }
            }
        }
        
        $htmlBody->resetHtml();
        
        $arrDataJs = array(
            'idInputContainer'  =>  $idInputContainer,
            'token'             =>  $this->cadastro->getToken(),
        );
        
        $htmlBody->add(
            array(
                'tag'       =>  'script',
                'type'      =>  'text/javascript',
                'text'      =>  $this->template->load('blank','cadastros','jsDefaultItem',$arrDataJs,TRUE),
            )
        );
        $viewData['body'] .= "\n" . $htmlBody->getHtml();
         
        
        if($arrTemplate['template']=='modal'){
            Common::printJson($viewData);
            return;
        }
        
        $this->output
            ->set_status_header(404)
            ->_display(); 
        
    }
    
    public function export(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
            )
        )){
            
            $this->main_model->erroPermissao();
        }
        
        
        $arrItems = $this->getItemsGrid(
            array(
                'return'    =>  TRUE,
            )
        );        
        
    }
        
    public function getItemsGrid($arrProp = array()){
        
        
        $hasMethod = $this->callControllerMethod('getItemsGrid');
        
        if($hasMethod){
            return TRUE;
        }
        
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
            )
        )){
            
            $this->main_model->erroPermissao();
        }
        
        $arrListItemsKeys = array_column($this->cadastro->get('data.list_items.columns'),'id');
        $arrConfig = $this->data->get('post');
        
        $arrConfig['order'] =  $this->cadastro->getOrderBy();
        
       
        if($this->data->get('post.order.column')!==''){
            $arrConfig['order'] =  $this->cadastro->getOrderBy(
                array(
                    array(
                        'id'        =>  $arrListItemsKeys[$this->data->get('post.order.column')] ?? $this->cadastro->get('data.list_items.columns')[0]['id'],
                        'dir'       =>  in_array($this->data->get('post.order.dir'),array('asc','desc')) ? $this->data->get('post.order.dir') : 'asc',
                    )
                )   
            );    
        }
        
        $arrConfig = array_merge($arrConfig,$arrProp);
        
        $arrItems = $this->cadastro->getItems($arrConfig);
                        
        $arrData = array();
        foreach($arrItems['items'] as $item){
            
            $this->cadastro->setItem($item);
            
            $arrRow = array(
                'href'      =>  NULL,
            );
            
            foreach($arrListItemsKeys as $listKey){
                
                $columnValue = $this->cadastro->variables->get($listKey.'.text');
                $columnValue = $columnValue ? $columnValue : $this->cadastro->variables->get($listKey.'.value');
                
                $arrRow[]= $columnValue??'';
            } 
            $arrData[] = array(
                'data'      =>  $arrRow,
                'href'      =>  $this->parser->parse_string($this->cadastro->get('configs.url_view_element'), 
                    array(
                        'modulo'        =>  $this->cadastro->get('module'),
                        'url_cadastro'  =>  $this->cadastro->get('url'),
                        'id_element'    =>  $item['id_value'],
                    ),TRUE),
                'pk_value'   =>  $item['id_value'],
            );  
        }
        
        $arrItems['items'] = $arrData;
        $arrItems['order'] = $arrConfig['order'];
        
        if(($arrProp['return']??NULL)){
            return $arrItems;
        }
        //temp($this->db->last_query());
        Common::printJson($arrItems,200,TRUE);
        
        
    }
    
    public function listItems($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        //CLOSE BUTTON
        $this->menus->addActionButtonsRightNode(
            array(
                'tag'       =>  'a',
                'class'     =>  'btn btn-primary-outline btn-sm ', //load-page
                'href'      =>   BASE_URL,
                'text'      =>  '<i class="fa fa-times"></i>'
            )
        );   
        
        $this->template->set('actionMenu',
            $this->cadastro->getActionMenuController(
                array(
                    'pk_controller' =>  $this->cadastro->get('id'),
                    'user_id'       =>  $this->data->get('user.id'),
                    'entity_id'     =>  $this->data->get('user.configs.entity'),
                    'parse'         =>  array(
                        'token'     =>  $this->cadastro->get('token'),
                    )
                )
            )
        );        
        
        $idGridItems = random_string();
        
        $arrHtmlDataListItems = $this->cadastro->getHtmlDataListItems(
            array(
                'id_grid_items'     =>  $idGridItems
            )
        );    
        $this->template->append('javascript',$arrHtmlDataListItems['javascript']);
        unset($arrHtmlDataListItems['javascript']);
        $this->template->set($arrHtmlDataListItems);
           
        $this->setJsCadastros(
            array(
                'id_grid_items'     =>  $idGridItems
            )
        );
        
        $arrTemplate = $this->common->getTemplate($arrProp);
        
        $this->template->load($arrTemplate['template'],'cadastros', $arrTemplate['view']);
                
    }
    
    
    public function save($arrProp = array()){
        
        $controllerDataSave = $this->callControllerMethod('save');
        if($controllerDataSave){
            return $controllerDataSave;
        }
        
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                'user_id'           =>  $this->data->get('user.id'),
                'entity_id'         =>  $this->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
                
        $arrValues = $this->input->post('values');
        
        $dataControllerSetValues = $this->callControllerMethod('setValues',$arrValues);
        
        $arrValues = $dataControllerSetValues ? $dataControllerSetValues : $arrValues;
        
        
        $this->cadastro->mergeValues(
            array(
                'values'        =>  $arrValues,
                'method'        =>  'database',
            )
        );        
        
        $arrDifferenceValues = $this->cadastro->getDifferenceValues(
            array(
                'method'    =>  'database'
            )
        );
        
        //Não há alterações feitas
        if(!$arrDifferenceValues AND $this->cadastro->get('item.value') != ''){
            Common::printJson(
                array(
                    'status'    =>  'info',
                    'id'        =>  $this->cadastro->get('item.value'),
                    'token'     =>  $this->cadastro->getToken(),
                    'console'   =>  array(
                        array(
                            'date_time' =>  date('d/m/Y|H:i:s'),
                            'message'   =>  '[Cadastro]['.$this->cadastro->get('descricao_singular').']['.$this->cadastro->get('item.value').']:Não há alterações para registrar',
                            'type'      =>  'success',
                        )
                    ),
                    'messages'   =>  array(
                        array(
                            'type'      =>  'info', 
                            'message'   =>  '<i class="fa fa-info-circle"></i>&nbsp;&nbsp;Não há alterações para registrar.',
                             
                        )
                    )
                )
            ); 
            return;
        }
        
        $arrData = array();
        $arrMessages = array();   
        $validationErrors = $this->cadastro->variables->validate();
        
        
        $dataBeforeUpdate = $this->callControllerMethod('beforeUpdate');
          
        if($dataBeforeUpdate['cadastro']??NULL){
            $this->cadastro = $dataBeforeUpdate['cadastro'];    
        }
        
        if($dataBeforeUpdate['messages']??NULL){ 
            $arrMessages = array_merge($arrMessages,$dataBeforeUpdate['messages']);
        }
        
        if($dataBeforeUpdate['data']??NULL){ 
            $arrData = array_merge($arrData,$dataBeforeUpdate['data']);
        }
        
        if($dataBeforeUpdate['validation']??NULL){ 
            $validationErrors = $validationErrors ? $validationErrors : array();
            $validationErrors = array_merge($validationErrors,$dataBeforeUpdate['validation']);
        }
        
        
        
        if(method_exists($this,'beforeUpdate')){

            $dataReturn = $this->beforeUpdate();
            
            if($dataReturn['cadastro']??NULL){
                $this->cadastro = $dataReturn['cadastro'];    
            }
            
            if($dataReturn['messages']??NULL){ 
                $arrMessages = array_merge($arrMessages,$dataReturn['messages']);
            }
            
            if($dataReturn['data']??NULL){ 
                $arrData = array_merge($arrData,$dataReturn['data']);
            }
            
            if($dataReturn['validation']??NULL){
                $validationErrors = $validationErrors ? $validationErrors : array();
                $validationErrors = array_merge($validationErrors,$dataReturn['validation']);
            }           
        } 
        
        
        if($validationErrors){
            
            $validationMessages = array();
            foreach($validationErrors as $error){
                if(array_search($error['key'],array_column($validationMessages,'key')) === FALSE){
                    $validationMessages[] = array(
                        'type'      =>  'error',
                        'message'   =>  $error['message']
                    );
                }
            }
            
            $arrConsole = array();
            foreach(array_column($validationMessages,'message') as $message){
                $arrConsole[] = array(
                    'date_time' =>  date('d/m/Y|H:i:s'),
                    'message'   =>  $message,
                    'type'      =>  'error', 
                );   
            }
            
            
            Common::printJson(
                array(
                    'status'    =>  'error',
                    'messages'  =>  $validationMessages,
                    'errors'    =>  $validationErrors,
                    'console'   =>  $arrConsole,
                )
            ); 
            
            return;      
        }
        
        
        
        $action = ($this->cadastro->get('item.value'))  ? 'UPDATE' : 'INSERT';        
        $responseUpdate = $this->cadastro->update();
        
        $dataAfterUpdate = $this->callControllerMethod('afterUpdate');
           
        if($dataAfterUpdate['cadastro']??NULL){
            $this->cadastro = $dataAfterUpdate['cadastro'];    
        }
        
        if($dataAfterUpdate['messages']??NULL){ 
            $arrMessages = array_merge($arrMessages,$dataAfterUpdate['messages']);
        }
        
        if($dataAfterUpdate['data']??NULL){ 
            $arrData = array_merge($arrData,$dataAfterUpdate['data']);
        }
        
        
        if(method_exists($this,'afterUpdate')){
            $dataReturn = $this->afterUpdate();
            
            if($dataReturn['cadastro']??NULL){
                $this->cadastro = $dataReturn['cadastro'];    
            }
            
            if($dataReturn['messages']??NULL){ 
                $arrMessages = array_merge($arrMessages,$dataReturn['messages']);
            }
            
            if($dataReturn['data']??NULL){ 
                $arrData = array_merge($arrData,$dataReturn['data']);
            }
        }
        //LOG DE ATIVIDADE DO CADASTRO
        $this->logger->setLog(
            array(
                'schema'        =>  ($this->cadastro->get('data.schema') ?? $this->config->item('db_log_schema','cadastros')).'_'.$this->config->item('db_log_sufix','cadastros'),
                'table_log'     =>  ($this->cadastro->get('data.schema') ?? $this->config->item('db_log_schema','cadastros')).'_'.$this->cadastro->get('data.table'),
                'item_id'       =>  $this->cadastro->get('item.value'),
                'action'        =>  $action,
                'user_id'       =>  $this->data->get('user.id'),
                'data'          =>  array(
                    'inputs'        =>  $arrDifferenceValues,  
                )
            )
        );
        
        
        if(is_array($responseUpdate)){
            Common::printJson($responseUpdate); 
            return;
        }

        $consoleResponse = '[Cadastro]['.$this->cadastro->get('descricao_singular').'][Código:' .$responseUpdate.']: Foi ';
        $consoleResponse .= ($action == 'UPDATE') ? 'atualizado.' : 'criado.';
        
        if($responseUpdate){
            array_unshift($arrMessages,
                array(
                    'type'      =>  'success',
                    'message'   =>  'Operação realizada.',
                )
            );
        }
            
        Common::printJson(
            array(
                'status'    =>  $responseUpdate ? 'ok' : 'error',
                'id'        =>  $responseUpdate,
                'token'     =>  $this->cadastro->getToken(),
                'console'   =>  array(
                    array(
                        'date_time' =>  date('d/m/Y|H:i:s'),
                        'message'   =>  $consoleResponse,
                        'type'      =>  'success',
                    )
                ),
                'messages'  =>  $arrMessages,
                'data'      =>  $arrData ?? NULL
            ),
            200,TRUE
        );
         
        
    }
    
    
    /** NAO EXTERNOS **/
    private function getMethod($method=FALSE, $arrProp = array()){
        
        $controllerName = $this->cadastro->requireTemplateFile($this->cadastro->get('token'));
        
        if($controllerName){
                
            $tempController = new $controllerName($this->cadastro);
            
            $method = clearSpecialChars(trim($this->uri->get('method')));
            if(method_exists($tempController,$method)){
                $tempController->{$method}();
                return;
            }
            else{
                $this->main_model->erro();    
            }
        }    
        
    }
    
    protected function initDefaults(){
        
        //DEFINE DADOS E VALIDAÇÕES PARA UMA AÇÃO INFORMADA QUE PODERÁ SER EXECUTADA
        $arrToken = $this->json->getFullArray($this->encryption->decrypt($this->data->get('post.token')));
        
        if(is_array($arrToken)){
            
            $this->auth_model->login();
            $this->cadastro->validateToken($arrToken);
            
            $this->cadastro->set('token',$arrToken);
            if($arrToken['parent']??NULL){
                $arrToken['parent']['variable'] = $arrToken['variable'] ?? NULL;
                $this->cadastro->setParent($arrToken['parent']);
            }
            
            if($arrToken['pk_item']??NULL){
                $this->cadastro->setItem($arrToken['pk_item']);
            }
        }
        
        //CLONE DE ITEM
        if($this->data->get('post.clone')){
            $this->cadastro->set('item',NULL);
        }
        
    }  
    
    private function callControllerMethod($method,$arrProp = array(),$force=FALSE,$nn=FALSE){
        
        $method = clearSpecialChars(trim($method));
        
        if(!$force AND is_object($this->tempController) AND method_exists($this->tempController,$method)){
            return $this->tempController->{$method}($arrProp);
        }
        else if(!$force AND is_object($this->tempController) AND !method_exists($this->tempController,$method)){
            return FALSE;
        }
        
        $this->tempController = NULL;
        
        $controllerName = $this->cadastro->requireTemplateFile($this->cadastro->get('token'));
        
        if($controllerName AND class_exists($controllerName)){
            $this->tempController = new $controllerName($this->cadastro);
        }
        
            
        return self::callControllerMethod($method,$arrProp,FALSE,TRUE);
        
    } 
    
    private function initSelf($arrProp = array()){
        
        if($this->uri->getKey('cadastros') === FALSE OR !$this->uri->get('cadastros')){
            redirect(BASE_URL, 'refresh');
        }
        
              
        //verifica se tem elemento informado
        $idItem = trim($this->data->get('post.pk_item')); 
           
        if(is_integer($idItem) OR (integer)$this->uri->get('id')){
            $idItem = $idItem ? $idItem : (integer) $this->uri->get('id');     
        }
        
        if((integer)$this->encryption->decrypt($idItem)>0){
            $idItem = (integer)$this->encryption->decrypt($idItem);
        }
        
        
        
        $arrCadastro = array(
            'url'   =>  clearSpecialChars($this->uri->get('cadastros')),
            'item'  =>  $idItem,
        );
        
        $this->cadastro = new Cadastros($arrCadastro);
        
        //não há um cadastro para a url informada
        if(!$this->cadastro->get('id')){
            redirect(BASE_URL, 'refresh');
        }
                                            
        $this->make_bread->add($this->cadastro->get('descricao_plural'), BASE_URL.'cadastros/'.$this->cadastro->get('url'),FALSE);
        
        $this->cadastro->set('token',array());
        
        if($this->uri->get('token')){
            
            $token = Json::getFullArray(
                $this->encryption->decrypt(
                    $this->uri->get('token')
                )
            );
            
            $this->cadastro->merge('token',is_array($token) ? $token : array());
        }
        
        if($this->input->get('token')){
            
            $token = Json::getFullArray(
                $this->encryption->decrypt(
                    $this->input->get('token')
                )
            );
            
            $this->cadastro->merge('token',is_array($token) ? $token : array());
        }
        
        if($this->input->post('token')){
            
            $token = Json::getFullArray(
                $this->encryption->decrypt(
                    $this->input->post('token')
                )
            );
            
            $this->cadastro->merge('token',is_array($token) ? $token : array());
        }
              
        $this->callControllerMethod(NULL);
    }
    
    private function setJsCadastros($arrProp = array()){
        
        $data = array(
            'item'          =>  $this->cadastro->get('item'),
            'url'           =>  current_url(),
            'idGridItems'   =>  $arrProp['id_grid_items']??NULL,
            'token'         =>  $this->cadastro->getToken(),
        );
        
        $jsCadastros = $this->template->load('blank','cadastros','jsCadastros_view',$data,TRUE);
        
        $this->template->append('javascript',$jsCadastros);
    }
    
    private function setJsModal($arrProp = array()){
        
        $data = array(
            'item'  =>   $this->cadastro->get('item'),
            'url'   =>  current_url(),
        );
        
        $jsSetModal = $this->template->load('blank','cadastros','jsSetModal_view',$data,TRUE);
        
        $this->cadastro->append('javascript',$jsSetModal);
                
    }
}
