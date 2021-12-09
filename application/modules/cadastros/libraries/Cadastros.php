<?php

/**
 * @author Tony Frezza
 */

class Cadastros extends Data{
    
    protected $CI;
    private $dataLog = array();
    public $variables;
    public $get_data;
    
    
    function __call($method,$args){
        
    }
    
    
    function __construct($arrProp = array()){
        
        parent::__construct();
        $this->variables = new Variables;
        
        $this->CI->load->library('../modules/cadastros/libraries/Cadastros_get_data');
        $this->CI->template->loadJs(BASE_URL.'assets/modules/cadastros/cadastros.js');
                  
        if($arrProp){
            if($arrProp['request']??NULL){
                $arrProp['requests_id'] = array($arrProp['request']?? NULL);    
            }
            
            $this->set($arrProp);
            
            if(!$this->get('configs')){
                $this->set('configs',$this->CI->config->item('cadastros'));
            }
            
            if(!$this->get('module')){
                $this->set('module','cadastros');   
                $this->set('path_templates','/templates/'.clearSpecialChars($this->get('url')));
                $this->set('template_sufix','_cadastros_controller');
            }
            
            $this->setRequest();
        }
    }
    
    public function getActionMenuController($arrProp = array()){
        
        if(!$this->get('actions_user')){
            $arrProp['pk_controller'] = $arrProp['pk_controller'] ?? $this->get('id');
            $arrProp['user_id'] = $arrProp['user_id'] ?? $this->CI->data->get('user.id'); 
            $arrProp['entity_id'] = $arrProp['entity_id'] ?? $this->CI->data->get('user.configs.entity');
                        
            $this->set('actions_user',$this->CI->controllers_model->getControllerActionsByUser($arrProp));    
        }
                  
        if(!($arrProp['menu']??NULL) AND !$this->get('data.action_menu_controller')){
            return NULL;
        }
        else if(!($arrProp['menu']??NULL)){
            $arrProp['menu'] = $this->get('data.action_menu_controller');
        }
        
        $arrMenu = $this->clearMenuItens(
            array(
                'menu'          =>  $arrProp['menu'],
                'user_actions'  =>  array_column($this->get('actions_user'),'id'),
                'is_admin'      =>  $this->CI->users->isAdmin($this->CI->data->get('user.id')),
                'unset'         =>  $arrProp['unset']??NULL
            )
        );
        
        if(!$arrMenu){
            return NULL;
        }
        
        $bootstrap = new Bootstrap;
        
        $idActionMenu = $bootstrap->div(
            array(
                'class'     =>  'col-md-24',
            )
        );
        
                
        foreach($arrMenu as $node){
               
            if(array_key_exists('children',$node) === FALSE){
                
                if(!($node['atributos']['href'] ?? NULL)){
                    continue;
                }
                $flagHasNodes = true;
                
                $node = $this->CI->menus->getNode($node);
                if($node['atributos']['href'] ?? NULL){
                    if(strpos($node['atributos']['href'],'/')==0){
                        $node['atributos']['href'] = substr($node['atributos']['href'],1);
                    }
                    $hrefNode = '{BASE_URL}'.$this->get('configs.uri_segment').'/';
                    $hrefNode .= $this->get('url') ? $this->get('url').'/' : '';
                    $node['atributos']['href'] = $hrefNode.$node['atributos']['href'];
                    
                }
                 
                $bootstrap->button(
                    array(
                        'parent_id'         =>  $idActionMenu,
                        'tag'               =>  'button',
                        'href'              =>  $this->CI->menus->getNodeHref($node,($arrProp['parse']??NULL)),
                        'text'              =>  $node['atributos']['title'].'&nbsp;',
                        'size'              =>  'sm',
                        'color'             =>  'primary-outline',
                        'icon_left'         =>  $node['atributos']['icon'],
                        'icon_left_size'    =>  10,
                        'class'             =>  array_merge(
                            $node['atributos']['class'],
                            array(
                                'padding-left-10','padding-right-10',
                                (($node['atributos']['need_selected_items'] ?? FALSE) ? 'need_selected_items' : '')
                            )
                        ),
                        'disabled'          =>  ($node['atributos']['need_selected_items'] ?? FALSE),
                        'data-token'        =>  $this->getToken($node['atributos']['token']??NULL),
                    )
                );
                
                continue;
            }
            
            $flagHasNodes = true;
            $flagDisabled = false;
            $nodeLvl0Children = array();
            
            foreach($node['children'] as $nodeChild1){
                
                $nodeChild1 = $this->CI->menus->getNode($nodeChild1);
                
                
                if($nodeChild1['atributos']['href'] ?? NULL){
                    
                    if(strpos($nodeChild1['atributos']['href'],'/')==0){
                        $nodeChild1['atributos']['href'] = substr($nodeChild1['atributos']['href'],1);
                    }
                    
                    $hrefNode = '{BASE_URL}'.$this->get('configs.uri_segment').'/';
                    $hrefNode .= $this->get('url') ? $this->get('url').'/' : '';
                    $nodeChild1['atributos']['href'] = $hrefNode.$nodeChild1['atributos']['href'];
                    
                }
                
                
                
                $nodeLvl0Children[] = array(
                    'icon_left'     =>  $nodeChild1['atributos']['icon'],
                    'href'          => NULL,
                    'class'         =>  array_merge(  
                        array(
                            'load-' . ($nodeChild1['atributos']['open'] ?? ''),
                            ($nodeChild1['atributos']['modal-size'] ?? NULL),
                            (($nodeChild1['atributos']['need_selected_items'] ?? FALSE) ? 'need_selected_items' : ''),
    
                        ),
                        string_to_array($nodeChild1['atributos']['class'] ?? NULL)
                    ),
                    //'style'         => 'font-size: 11px;', 
                    'text'          =>  $nodeChild1['atributos']['title'],
                    'disabled'      =>  ($nodeChild1['atributos']['need_selected_items'] ?? FALSE),
                    'data-token'    =>  $this->getToken($nodeChild1['atributos']['token']??NULL),
                );
                
                if(($nodeChild1['atributos']['need_selected_items'] ?? FALSE) AND !$flagDisabled){
                    $flagDisabled = true;
                }
                
                $nodeHref =  $this->CI->menus->getNodeHref($nodeChild1);
                
                if(isset($nodeChild1['atributos']['data-form']) AND array_key_exists('uri',$nodeChild1['atributos']['data-form'])){
                    foreach($nodeChild1['atributos']['data-form']['uri'] as $key => $val){
                        $nodeHref .='/'.$key.'/'.$val;    
                    }
                }
                
                $nodeHrefGet = '';
                
                if(isset($nodeChild1['atributos']['data-form']) AND array_key_exists('get',$nodeChild1['atributos']['data-form'])){
                    foreach($nodeChild1['atributos']['data-form']['get'] as $key => $val){
                        if($nodeHrefGet){
                            $nodeHrefGet .= '&';
                        }   
                        $nodeHrefGet .= $key.'='.$val; 
                    }
                }
                
                if($nodeHrefGet){
                    $nodeHrefGet .= '&';
                }
                
                if($nodeHref == ''){
                    $nodeHref = BASE_URL.'cadastros/'.$this->get('url');
                }
                
                $nodeHrefGet .= 'load=modal';
                $nodeHref .=  '?'.$nodeHrefGet;                
                $nodeLvl0Children[sizeof($nodeLvl0Children)-1]['href'] = $nodeHref; 
                
                if(isset($nodeChild1['atributos']['data-form']) AND array_key_exists('post',$nodeChild1['atributos']['data-form'])){
                    foreach($nodeChild1['atributos']['data-form']['post'] as $key => $val){
                        $nodeLvl0Children[sizeof($nodeLvl0Children)-1]['data-form-post-'.$key] = $val;    
                    }
                    
                }
                
            }
             
            $idNodeLvl0 = $bootstrap->button_dropdown(
                array(
                    'parent_id'         =>  $idActionMenu,
                    'size'              =>  'sm',
                    'color'             =>  'primary-outline',
                    'text'              =>  $node['atributos']['title'],
                    'data-form'         =>  $node['atributos']['data-form'] ?? NULL,
                    'icon_left'         =>  $node['atributos']['icon'] ??  NULL,
                    'icon_left_size'    =>  10,
                    'nodes'             =>  $nodeLvl0Children, 
                    'class'             =>  array(
                        'padding-left-10',
                        ($flagDisabled ? 'need_selected_items' : '')
                    ),
                    'disabled'          =>  $flagDisabled,   
                )
            ); 

        }  
        
        return $flagHasNodes ? $bootstrap->getHtml() : NULL;
        
    }
    
    public function getButtonsController($arrProp = array()){
        
        if(!$this->get('actions_user')){
            $this->set('actions_user',$this->CI->controllers_model->getControllerActionsByUser($arrProp));            
        }
        
        $arrProp['menu'] = $this->clearMenuItens(
            array(
                'menu'          =>  $arrProp['menu'],
                'user_actions'  =>  array_column($this->get('actions_user')??array(),'id'),
                'is_admin'      =>  $this->CI->users->isAdmin($this->CI->data->get('user.id'))
            )
        );
        
        if(!$arrProp['menu']){
            return NULL;
        }
        
        $bootstrap = new Bootstrap;
        
        foreach($arrProp['menu'] as $node){
            
            $type = $node['type'] ?? 'button';
            unset($node['type']);
            
            $bootstrap->$type($node);
        }
        
        return array(
            'html'      =>  $bootstrap->getHtmlData()  
        );
       
        
    }
    
    public function getDataAsParent(){
        
        return array(
            'module'        =>  $this->get('module'),
            'request'       =>  $this->get('id'),
            'action'        =>  $this->get('action') ? $this->get('action') : $this->get('data.actions.viewItems'),
            'variable'      =>  $this->get('variable'),
        );
    }
    
    public function getDifferenceValues($arrProp = array()){
        
        return $this->variables->getDifferenceValues($arrProp);        
        
    }
    
    public function getHtmlDataDefaultBody($arrProp = array()){
        
        $arrReturn = array(
            'children'      =>  array()
        );
        
        $arrReturn['children'][] = array(
            'tag'       =>  'input',
            'type'      =>  'hidden',
            'class'     =>  'cadastro_item_pk',
            'value'     =>  $this->get('item')
        );
        
        $arrReturn['children'][] = array(
            'tag'       =>  'input',
            'type'      =>  'hidden',
            'class'     =>  'token',
            'value'     =>  $this->getToken()
        );
        
        $arrReturn['children'][] = array(
            'tag'       =>  'input',
            'type'      =>  'hidden',
            'class'     =>  'url_save',
            'value'     =>  $arrProp['url_save'] ?? $this->get('url_save'),
        );
        
                
        $arrReturn['children'][] = array(
            'tag'       =>  'input',
            'type'      =>  'hidden',
            'class'     =>  'container-cadastro',
            'id'        =>  $arrProp['id_input_container']??NULL,
            'value'     =>  random_string(),
        );
        
        return $arrReturn;     
    }
    
    
    public function getHtmlDataListItems($arrProp = array()){
        
        $arrReturn = array();
        
        //FILTRO PARA RESULTADOS
        if(($arrProp['no_filter'] ?? NULL) !==TRUE){
            
            $variables = $this->variables;
            
            foreach($this->get('data.hide_filters') ?? array() as $variableHide){
                $variables->unset($variableHide);    
            }
            
            $filter = new Filter(
                array(
                    'data'              =>  $variables->get(),
                    'dynamic_filters'   =>  $this->get('data.dynamic_filters'),
                )
            );
            
            $arrDataJsFilter = array(
                'idGridItems'   =>  $arrProp['id_grid_items'] ?? NULL,
            );
            
            $jsFilterItems = $this->CI->template->load('blank','cadastros',($this->get('configs.views_path') ? $this->get('configs.views_path').'/':'').'jsFilterItems_view',$arrDataJsFilter,TRUE);
            $this->append('javascript',$jsFilterItems);
            
            $arrReturn['htmlFiltro'] = $filter->getHtml();  
              
        }
        
        //FIM FILTRO PARA RESULTADOS
        
        
        $arrGridHeader = array();
        foreach(($this->get('data.list_items.columns')??array()) as $keyItemList => $itemList){
            $itemList['class'] = $this->CI->common->append($itemList['class'] ?? array(),array(''));
            $arrGridHeader[] = $itemList;
        }
               
        $html = new Html;
        $idDivGrid = $html->add(
            array(
                'tag'           =>  'div',
                'class'         =>  array('nopadding','card-block container-fluid'),
            )
        );
        
        $bootstrap = new Bootstrap();
        
        if($this->get('url_data')??NULL){
            $gridUrl = $this->get('url_data');
        }
        else{
            $gridUrl = BASE_URL.$this->get('configs.uri_segment').'/';
            $gridUrl .= $this->get('url') ? $this->get('url').'/' : '';
            $gridUrl .= 'getitems';    
        }
        
        
        $bootstrap->grid(
            array(
                'id'            =>  $arrProp['id_grid_items']??NULL,
                'class'         =>  array('grid-items-cadastro'),
                'header'        =>  $arrGridHeader,
                'href'          =>  $gridUrl,
                'data-token'    =>  $this->getToken(),
                'style'         =>  'height: '.($arrProp['grid_height'] ?? 270) .'px',
                'autoload'      =>  $this->get('data.auto_load_items'),
                'footer'        =>  $arrProp['grid_footer'] ?? TRUE,
            )
        );
        
        $gridFilterData = $bootstrap->getHtmlData();
        $gridFilterData[0]['parent_id'] = $idDivGrid;
        
        $html->add($gridFilterData[0]);
        
        $arrReturn['htmlGrid'] = $html->getHtml();
        
        $arrReturn['javascript'] = $this->get('javascript');
        
        if(array_key_exists('html_append',$arrProp) !== FALSE){
            $arrReturn = array_merge($arrReturn,$arrProp['html_append']);
        }
        
        return $arrReturn;        
    }
    
    public function getItems($arrProp = array()){
        
        $this->CI->cadastros_model->setController($this);

        return $this->CI->cadastros_model->getItems($arrProp);
    }
     
    public function getOrderBy($arrProp = array()){
        
        if(!$arrProp AND $this->get('data.list_items.order')){
            $arrProp = $this->get('data.list_items.order');
        }
        else if(!$arrProp){
            return array();
        }
        
        $arrReturn = array();
        foreach($arrProp as $order){
            
            $arrOrderId = explode('.',$order['id']??NULL);
            $variable =  $this->variables->get($arrOrderId[0]);
            $query = new Query(
                array(
                    'data'  =>  array(
                        'variables' =>  array(
                           $variable->get(),        
                        )
                    )
                )   
            );
            
            $arrDataSelect = $query->getQuerySelectData();
            
            $keyColumn = 1;
            
            //variáveis extras
            if(sizeof($arrOrderId)> 1){
                
                $keyColumn = array_search($arrOrderId[0].'_{variable}_'.$arrOrderId[2].'_text',array_column($arrDataSelect['select'],'as'));
                
                if($keyColumn===FALSE){
                    
                    $keyColumn = array_search($arrOrderId[0].'_{variable}_'.$arrOrderId[2].'_value',array_column($arrDataSelect['select'],'as'));
                }
                
                
                
                
            }
            //fim variáveis extras
                     
            $arrReturn[] = array(
                'column'        =>  $arrDataSelect['select'][sizeof($arrDataSelect['select'])-$keyColumn]['as'],
                'dir'           =>  $order['dir'] ?? 'ASC',
            );
        }
        
        return $arrReturn;
    }
    
    public function getToken($data = array()){
        
        $arrToken = array(
            'request_url'   =>  $this->get('url'),
            'request_id'    =>  $this->get('id'),
            'item_id'       =>  $this->get('item.value'),
            'action'        =>  $this->get('action'),
            'parent'        =>  ($this->get('parent') ? $this->get('parent')->get() : NULL),
            'variable'      =>  $this->get('variable'),
        );
        
        if($data){
            $arrToken = array_merge($arrToken,$data);    
        }
        
        if($this->get('token') AND is_array($this->get('token'))){
            $arrToken = array_merge($arrToken,$this->get('token'));    
        }
        
        $strToken = $this->CI->encryption->encrypt(json_encode($arrToken));
        
        return $strToken;
    }
        
    public function mergeValues($arrProp = array()){
        
        if(!($arrProp['values'] ?? NULL)){
            return FALSE;
        }
        //reorganizando as keys
        $arrProp['values'] = array_values($arrProp['values']);
        
        foreach($this->variables->get() as $variable){
                
            $keyVariable = array_search($variable->get('id'),array_column($arrProp['values'],'id'));
            if($keyVariable===FALSE){
                $this->variables->set(
                    $variable->get('id'),
                    array(
                        'method'    =>  ($arrProp['method'] ?? NULL),
                        'value'     =>  $variable->get('value')
                    )
                );
                continue;
                $oldValue = $newValue = $variable->get('value');
            }   
            else{
                $oldValue = $replaceValue = $variable->get('value');
                $newValue = $arrProp['values'][$keyVariable]['value'] ?? NULL; 
            }
            
            
            if(is_array($newValue) AND in_array($variable->get('type'),$this->CI->config->item('with_child','config_variables'))){
                
                //VALUE FORMADO POR ROWS
                foreach($newValue as $keyRowValue => $rowValue){
                    if(!($replaceValue[$keyRowValue] ?? NULL)){
                        $replaceValue[$keyRowValue] = $rowValue;
                        continue; 
                    }
                    
                    foreach($rowValue as $columnValue){
                        $keyColumn = array_search($columnValue['id'],array_column($oldValue[$keyRowValue],'id'));
                        if($keyColumn===FALSE){
                            continue;
                        }
                        
                        $replaceValue[$keyRowValue][$keyColumn]['value'] = $columnValue['value'];
                        $replaceValue[$keyRowValue][$keyColumn]['text'] = $columnValue['text'] ?? NULL;
                        $replaceValue[$keyRowValue][$keyColumn]['method'] = $columnValue['method'] ?? NULL;
                    }
                    
                }
                
                //excluindo itens antigos, que foram removidos
                if(is_array($replaceValue) AND (sizeof($replaceValue)>sizeof($newValue))){
                    foreach($replaceValue as $key => $val){
                        if(!($newValue[$key]??NULL)){
                            unset($replaceValue[$key]);
                        }
                    }
                } 
                
                
                $this->variables->set(
                    $variable->get('id'),
                    array(
                        'method'    =>  ($arrProp['method'] ?? NULL),
                        'value'     =>  $replaceValue
                    )
                );
                                
            }
            else{
                
                $this->variables->set(
                    $variable->get('id'),
                    array(
                        'value'     =>  $newValue,
                        'text'      =>  $arrProp['values'][$keyVariable]['text'] ?? NULL,
                        'method'    =>  ($arrProp['method'] ?? NULL),
                    )
                );
            }    
        }
    }
    
    public function requireTemplateFile($arrProp = array()){
        
        $arrReturn =  Common::requireController(
            array(
                'module'            =>  ($arrProp['module']??$this->get('module')),
                'path_templates'    =>  ($arrProp['path_templates']??$this->get('path_templates')),
                'controller'        =>  ($arrProp['controller'] ?? $this->get('controller')),
                'template_sufix'    =>  ($arrProp['template_sufix'] ?? $this->get('template_sufix')),
            )
        );
        
        return $arrReturn;
                
    }
      
    
    public function setItem($item){
        
        if(is_array($item)){
            $this->setItemFromData($item);
            return;
        }
        
        $this->set('item',
            array(
                'value'     =>  $item
            )
        );
        
        $arrTemp = array(
            'simple_get_items'   =>  TRUE,
            'filters'           =>  array(
                array(
                    'id'        =>  'id',
                    'clause'    =>  'equal_integer',
                    'value'     =>  $item,
                ),
            ),
            'limit' => 1
        );
        
        $dataItem = $this->getItems($arrTemp);
        
        if(isset($dataItem[0])===FALSE){
            return FALSE;
        }
        
        $this->setItemFromData(Json::getFullArray($dataItem[0]));
               
    }
    
    
    
    public function setParent($arrProp = array()){
        
        if(!$arrProp){
            $arrProp = $this->get('parent');
        }
        
        $module = new $arrProp['module']($arrProp);
        
        if($arrProp['variable'] ?? NULL){
            $variable = $module->getVariable(NULL,$arrProp['variable']);
            
            if($variable->get('from')){
                
                if($variable->get('from.replace_filters')){
                                        
                    $this->set('data.dynamic_filters',$variable->get('from.replace_filters') ?? NULL);
                    
                    $this->set('data.filters',$variable->get('from.filters') ?? array()); 
                }
                else{
                    
                    $this->set('data.filters',
                        array_merge(
                            $this->get('data.filters') ?? array(),
                            $variable->get('from.filters') ?? array()
                        )
                    );
                }
                
                $this->set('data.hide_filters',
                    array_merge(
                        $this->get('data.hide_filters') ?? array(),
                        $variable->get('from.hide_filters') ?? array()
                    )
                );
                
                if($variable->get('from.list_items')){
                    
                    if($variable->get('from.list_items.order')){
                        $this->set('data.list_items.order',$variable->get('from.list_items.order'));
                    }
                    
                    if($variable->get('from.list_items.columns')){
                        $this->set('data.list_items.columns',$variable->get('from.list_items.columns'));
                    }
                    
                }
                                
            }
        }
        
        $this->set('parent',$module);
            
    }
    
    public function setRequest(){
                
        if($this->get('url') OR $this->get('requests_id')){
            
            if((int)$this->get('requests_id.0') AND $this->CI->data->get('temp.cadastros.id.'.$this->get('requests_id.0'))){
                $dataRequest = $this->CI->data->get('temp.cadastros.id.'.$this->get('requests_id.0'));
            }        
            else{
                $dataRequest = $this->CI->cadastros_model->getRequests($this->get());
                
                if(!$dataRequest){
                    return FALSE;
                } 
                $dataRequest = $dataRequest[0];
                
                $this->CI->data->set('temp.cadastros.id.'.$this->get('requests_id.0'),$dataRequest);    
            }
            
            
            
            
            
            $this->set($dataRequest);   
        }

        $dataConfigFile = $this->get('data_file') ? $this->get('data_file') : 'data'; 
        $moduleDataFile = APPPATH.'modules/'.$this->get('configs.module_path').'/config/'.$dataConfigFile.'.php';
        
        
        if(file_exists($moduleDataFile)==TRUE){
            
            $arrData = require $moduleDataFile;
            
            foreach($arrData as $key => $val){
                
                
                if(is_array($val)){
                    $this->set('data.'.$key,
                        array_merge(
                            ($this->get('data.'.$key) ?? array()),
                            $val
                        )
                    );   
                }
                else{
                    $this->set('data.'.$key,$val);
                }
            }
        }
        
        
        if(!($this->get('data.schema'))){
            $this->set('data.schema','cadastros');
        }
                      
        $dataFile = 'modules/'.$this->get('configs.module_path').'/templates/'.clearSpecialChars($this->get('url')).'/config/data.php';
        
        if(file_exists(APPPATH.$dataFile)==TRUE){
            $arrData = require APPPATH.$dataFile;
            
            foreach($arrData as $key => $val){
                
                if($key == 'actions'){
                    $this->set('configs.actions',
                        array_merge(
                            string_to_array($this->get('configs.actions')),
                            $val
                        )
                    );
                }
                
                
                if(is_array($val)){
                    $this->set('data.'.$key,
                        array_merge(
                            ($this->get('data.'.$key) ?? array()),
                            $val
                        )
                    );   
                }
                else{
                    $this->set('data.'.$key,$val);
                }
            } 
        }
        
        //algumas validações e atualizações de CADASTROS
        if($this->get('id')  AND !$this->get('request_by_config')){
            
            $flagNeedUpdate = FALSE;
            $arrDataUpdate = array(
                'atributos'     =>  array()
            );
            
            //base de logs para CADASTROS
            //cria, caso necessario
            if(!$this->get('atributos.logs_initialized') AND $this->get('data.table')){
                $this->CI->logger->initDatabaseLog(
                    array(
                        'table'     =>  $this->get('data.table'),
                        'schema'    =>  $this->get('data.schema'),
                        'schema_log'=>  $this->get('data.schema').'_logs',
                        'table_log' =>  $this->get('data.schema').'_'.$this->get('data.table')
                    )
                );
                $flagNeedUpdate = TRUE;
                append($arrDataUpdate['atributos'],array('logs_initialized'=>TRUE));
                                
            }    
            
            //atualizando dados do controller no banco
            if($flagNeedUpdate){
                
                $controller = new Controllers(
                    array(
                        'item'      =>  $this->get('id')    
                    )
                );
                
                foreach($arrDataUpdate as $key => $val){                    
                    $controller->variables->set($key,array('value'=>$val));
                }
                
                $controller->update();
                
            }
        }
        
        if(is_array($this->get('data'))){
            $arrProp = array(
                'variables' =>  $this->get('data.variables'),
                'rules'     =>  $this->get('data.rules'), 
            );
            $this->variables->set($arrProp);
            
            
            if($this->get('data.id_controller')){
                $this->set('id',$this->get('data.id_controller'));
            }
            
        }
        
        
        if($this->get('parent')){
            $this->setParent();    
        }
        
        
        if($this->get('item')){
            $this->setItem($this->get('item'));    
        }
        
        
        $this->set('token',$this->CI->encryption->encrypt($this->get('url'))); 
              
        $urlSaveCadastro = $this->CI->config->item('url_save_element','cadastros');
        if($this->get('module')!='cadastros'){
            $urlSaveCadastro = BASE_URL.$this->get('uri_segment').'/save';
        }
        
                
        $this->set(
            'url_save',$this->CI->parser->parse_string($urlSaveCadastro, 
                array(
                    'modulo'        =>  $this->get('module'),
                    'url_cadastro'  =>   $this->get('url'),
                ),TRUE
            )
        ); 
        
        
        
        $this->set('data.filters',
            $this->get('data.filters') ?? array()
        );
        
        $this->set('data.filter_groups',
            $this->get('data.filter_groups') ?? array()
        );
        
        $this->get_data = new Cadastros_get_data($this);
         
        return $this;
    }
       
    public function setUserPermissions($arrProp = array()){
        
        $this->set('user_permissions',isset($arrProp['permissions']) ?  $arrProp['permissions'] : $this->getUserPermissions($arrProp));
           
        return;   
    }
    
    
    public function delete($arrPks = array()){
        
        if(!$arrPks){
            return FALSE;
        }
        
        $arrResponse = array();
        
        foreach($arrPks as $pkValue){
            
            $arrFilters = array(
                array(
                    'id'        =>  'id',
                    'clause'    =>  'equal',
                    'value'     =>  $pkValue    
                )
            );

            $dataItem = new DataItems(
                array(
                    'data'      =>  $this->get('data'),
                    'filters'   =>  $arrFilters,
                )
            );
            
            
            $arrDataExecuteDelete = $dataItem->delete();
            
            $arrResponse[] = array(
                'status'    =>  $arrDataExecuteDelete['status'],
                'error'     =>  $arrDataExecuteDelete['error'],
                'pk'        =>  $pkValue,
            );
        }
        
        return $arrResponse;
        
    }
    
    public function update(){
        
        if(array_key_exists('schema',$this->get('data'))===FALSE){
            $this->set('data.schema','cadastros');
        }
        
        $itemId = $this->get('item.value');       
        $arrFilters = array(
            array(
                'id'        =>  'id',
                'clause'    =>  'equal',
                'value'     =>  $itemId    
            )
        );
        
        if(is_array($this->get('filters'))){
            $arrFilters = array_merge(
                $arrFilters,
                $this->get('filters')
            );
        }
        
        
        $dataRequest = new Data($this->get('data'));
        $dataRequest->set('variables',$this->variables->getData());
        
        $dataItem = new DataItems(
            array(
                'pk_value'  =>  $itemId,
                'pk_column' =>  'id',
                'data'      =>  $dataRequest->get(),
                'filters'   =>  $arrFilters,
            )
        );
        
        $this->set('data.update',$dataItem->updateItem());
        
        if(!is_array($this->get('item'))){
            $this->set('item',array());
        }
        
        $this->set('item.value',$this->get('data.update'));
        $this->variables->set('id',array('value'=>$this->get('item.value')));
        
        //pode melhorar, mas para funcionar vem do banco!
        $dataItem->set('filters',
            array(
                array(
                    'id'        =>  'id',
                    'clause'    =>  'equal',
                    'value'     =>  $this->get('item.value')    
                )
            )
        );
        $dataItem->set('limit',1);
        $dataItem->set('group_by_id',TRUE);
        
        $arrData = $dataItem->getItems()[0] ?? NULL;
        
        $this->setItem($arrData);
        
        return $this->get('data.update');  
         
    }
    
    public function runActionUserPermissions($arrProp = array()){
        
        $arrProp['user_id'] = $arrProp['user_id']?? $this->CI->data->get('user.id');
        $arrProp['entity_id'] = $arrProp['entity_id'] ?? $this->CI->data->get('user.configs.entity');
        
        if($this->CI->users->isAdmin($arrProp['user_id']??NULL)){
            return TRUE;
        }
        
        
        if($this->get('parent')){
            $arrProp['action'] = $this->get('parent')->get('configs.actions.viewItems');
            return $this->get('parent')->runActionUserPermissions($arrProp);
        }
        
        if(!($arrProp['controller_type_id'] ?? NULL)){
            $arrProp['controller_type_id'] = 2; //TIPO DE CONTROLLER, PADRÂO 2 para CADASTROS  
        }
        
        
        if(!$this->get('actions_user')){
            $arrProp['pk_controller'] = $this->get('id');
            $this->set('actions_user',$this->CI->controllers_model->getControllerActionsByUser($arrProp));
        }
        
        return in_array($arrProp['action'],array_column($this->get('actions_user')??array(),'id'));
    }
    
    public function validateToken($arrToken = array()){
        
        if(
            array_key_exists('request_id',$arrToken)===FALSE OR array_key_exists('request_url',$arrToken)===FALSE
        ){
             
             Common::printJson(
                array(
                    'error'     =>  true,
                    'logout'    =>  true,
                    'messages'  =>  array(
                        array(
                            'type'      =>  'error',
                            'message'   =>  'Dados violados',
                        )
                    )
                )
                ,203
             );
             
             return FALSE;                
        }
        
        return TRUE;   
    }
    
    public function getVariable($variables = NULL,$variableId = NULL){
            
        $inputReturn = NULL;
        
        if($variables == NULL){
            $variables =  $this->variables;  
        }
        
        $inputReturn = $variables->get($variableId ? $variableId : $this->get('variable'));
        
        if(!$inputReturn){
            
            
            foreach($variables->get() as $variable){
                $varType = (string)$variable->get('type'); 
                              
                if(!in_array($varType,array('relational_n_n'))){
                    continue;
                }
                
                $inputReturn = $this->getVariable($variables->get($variable->get('id'))->variables,$variableId);
                
                if($inputReturn){
                    break;
                } 
            }
        }
        
        return $inputReturn;
            
    }  
    
    /**
     * INIT MODULO
     **/
     
    public function initAfterModule(){
        
        if($this->get('module')=='cadastros'){
            $this->CI->scheduler->registerModule(
                array(
                    'name'      =>  'Cadastros',
                    'methods'   =>  array(
                        array(
                            'name'          =>  'agendado',
                            'description'   =>  'Verificar prazos',
                            'parameters'    =>  array()
                        ),
                    )
                )   
            );
        }
        
    }
    /**
     * 
     * PRIVATES
     * 
     **/
    private function clearMenuItens($arrProp = array()){
        
        if(!$arrProp['user_actions'] AND !($arrProp['is_admin']??NULL)){
            return NULL;
        }
        
        foreach($arrProp['menu'] as $key => $node){
            if($node['children']??NULL){
                $node['children'] = self::clearMenuItens(
                    array(
                        'menu'          =>  $node['children'],
                        'user_actions'  =>  $arrProp['user_actions'],
                        'is_admin'      =>  $arrProp['is_admin'] ?? NULL,
                        'unset'         =>  $arrProp['unset'] ?? NULL,
                    )
                );
            }
            
            //para nao ficar um if com muitas verificacoes dentro, dividi em varios ifs
            if(!($node['action']??NULL) AND !($node['children']??NULL)){
                unset($arrProp['menu'][$key]);
            }
            
            if(($arrProp['unset'] ?? NULL) && is_array($arrProp['unset'])){
                
                foreach($arrProp['unset'] as $keyUnset => $valUnset){
                    if(($node[$keyUnset]??NULL) != $valUnset){
                        unset($arrProp['menu'][$key]);   
                    }
                }
            }
            
            if(is_array($node['action']??NULL) AND (!($arrProp['is_admin']??NULL))){
                $flagRemove = TRUE;
                foreach($node['action'] as $action){
                    if(in_array($action,$arrProp['user_actions'])){
                        $flagRemove = FALSE;
                    }
                }
                
                if($flagRemove){
                    unset($arrProp['menu'][$key]);
                }
                
            }
            
            else if(($node['action']??NULL) AND (!($arrProp['is_admin']??NULL) AND !is_array($node['action']??NULL) AND !in_array($node['action']??NULL,$arrProp['user_actions']))){
                unset($arrProp['menu'][$key]);
            }
            
            
            
        }
        
        return $arrProp['menu'];    
    } 
    
    
    private function getItemValues($arrData){
        
        $arrDataReturn = array();
        
        foreach($arrData as $key => $val){
            
            $val = Json::getFullArray($val);
            
            if(substr($key,strlen($key)-6) == '_value'){
                
                if(is_array($val)){
                    
                    $inputValue = array();
                    foreach($val as $rowKey => $rowValue){
                        if(is_array($rowValue)){
                            
                            $inputValue[$rowKey] = self::getItemValues($rowValue);    
                        }
                        else{
                            $inputValue[$rowKey] = Json::getFullArray($rowValue);
                        }
                        
                    }
                    
                    $val = $inputValue;
                }
                
                $idKey = array_search(substr($key,0,strlen($key)-6),array_column($arrDataReturn,'id'));

                if($idKey===FALSE){
                    
                    $arrDataReturn[] = array(
                        'id'    =>  substr($key,0,strlen($key)-6),
                        'value' =>  $val,
                    );
                }
                else{
                    $arrDataReturn[$idKey]['value'] = $val;
                }

            }
            else if(substr($key,strlen($key)-5) == '_text'){
                
                $idKey = array_search(substr($key,0,strlen($key)-5),array_column($arrDataReturn,'id'));
                if($idKey===FALSE){
                    $arrDataReturn[] = array(
                        'id'    =>  substr($key,0,strlen($key)-5),
                        'text'  =>  $val,
                    );
                }
                else{
                    $arrDataReturn[$idKey]['text'] = $val;
                }
            }
            else{
                
                $idKey = array_search($key,array_column($arrDataReturn,'id'));
                if($idKey===FALSE AND is_string($val)){
                    $arrDataReturn[] = array(
                        'id'    =>  $key,
                        'value' =>  $val,
                        'text'  =>  $val,
                    );
                    
                }
                if($idKey===FALSE AND is_array($val)){
                    $arrDataReturn[] = $val;
                }
                else{
                    $arrDataReturn[$idKey]['value'] = $val;
                }
            }
            
        }
        
        
        return $arrDataReturn;
        
    }
    
    private function setItemFromData($arrData){
        
        $arrData = $this->getItemValues($arrData);

        foreach($arrData as $key => &$data){
            
            self::setDataVariables($data,$arrData); 
        }
        
        //temp($arrData);
        
        $this->variables->set($arrData); 
             
    }
    
    private function setDataVariables(&$dataItem,&$dataCollection){
        
        $arrVariables = explode('_{variable}_',$dataItem['id']); 
        
        $keyParent = array_search($arrVariables[0],array_column($dataCollection,'id'));
        
        if($keyParent===FALSE){
            return;
        }
        
        if(sizeof($arrVariables)>1){
            $dataCollection[$keyParent]['variables'] = $dataCollection[$keyParent]['variables'] ?? array();
            unset($arrVariables[0]);
            $dataCollection[$keyParent]['variables'][] = array(
                'id'        =>  $arrVariables[1],
            );
            
            $dataItem['id'] = implode('_{variable}_',$arrVariables);
            
            self::setDataVariables($dataItem,$dataCollection[$keyParent]['variables']);    
        }
        else{
            
            
            append($dataCollection[$keyParent],$dataItem); 
        }
        
        
    }
}

?>