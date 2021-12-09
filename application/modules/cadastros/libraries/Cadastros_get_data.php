<?php

/**
 * @author Tony Frezza
 */

class Cadastros_get_data{
    
    private $CI;
    private $cadastro;
        
    function __construct(Cadastros $cadastro=NULL){
        
        $this->CI = &get_instance();
        $this->cadastro = $cadastro;
        
    }
    
    public function getExternalList($arrProp = array()){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->cadastro->runActionUserPermissions(
            array(
                'action'            =>  $this->cadastro->get('configs.actions.viewItems'),
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $arrProp['variable_externalList'] = $this->cadastro->getVariable(NULL,$arrProp['variable']);
        if(!$arrProp['variable_externalList']){
            $this->CI->main_model->erro();
        }
        
        $className = $arrProp['variable_externalList']->get('from.module');
        $arrConfig = $arrProp['variable_externalList']->get('from');
        
        $arrConfig['parent'] = $this->cadastro->getDataAsParent();
        $arrConfig['variable'] = $arrProp['variable'] ?? NULL;
             
        $module = new $className($arrConfig);
        
        //PERSONALIZANDO EXIBIÇÃO DO GRID DE RESULTADOS
        if(($arrConfig['list_items'] ?? NULL)){
            
            if($arrConfig['list_items']['order'] ?? NULL){
                $module->set('data.list_items.order',$arrConfig['list_items']['order']);
            }
            
            if($arrConfig['list_items']['columns'] ?? NULL){
                $module->set('data.list_items.columns',$arrConfig['list_items']['columns']);
            }
                            
        }
                                  
        if($arrProp['get_values']??NULL){
            
            $arrProp['variable_externalList']->set('value',$arrProp['pk_value']);
            $arrProp['variable_externalList']->set('filters',$arrProp['filters']);
            return $module->get_data->getExternalListValues($arrProp['variable_externalList']->get());
        }
        
        return $module->get_data->getExternalListHtmlData($arrProp);
    }
    
    public function getExternalListHtmlData($arrProp = array()){
        
         
        $arrProp['html_append'] = $arrProp['html_append'] ?? array();
        $bsform = new BsForm(
            array(
                'no_panel'  =>  TRUE,
                'inputs'    =>  array(
                    array(
                        'no_grid'       =>  TRUE,
                        'no_fieldset'   =>  TRUE,
                        'type'          =>  'hidden',
                        'value'         =>  $this->cadastro->variables->get($arrProp['variable_externalList']->get('from.text.0'))->get('id'),
                        'class'         =>  array('externallist-input-id-search'),
                    )
                )
            )
        );        
        
        
        $arrProp['html_append']['externallist_input_text_search'] = $bsform->getHtml(); 
        
        if($this->CI->input->get_post('is_boxresults')){
            $arrProp['grid_height'] = 130;
        }
        else{
            $htmlActionMenu = $this->cadastro->getActionMenuController(
                array(
                    'unset' =>  array(
                        'externallist'  =>  TRUE,
                    )
                )
            );
            $this->CI->template->set('actionMenu',$htmlActionMenu);
        }
        
        $arrHtmlDataListItems = $this->cadastro->getHtmlDataListItems($arrProp);    
        $arrHtmlDataListItems['javascript'] = '';
        
        $this->CI->template->set($arrHtmlDataListItems);
        
        return array(
            'title'     =>  'Selecionar: ' . $this->cadastro->get('descricao_singular'),
            'body'      =>  $this->CI->template->load('modal','cadastros','Get_data_externallist_view',array(),TRUE)
        );
                
    }
    
    public function getExternalListValues($variableExternalList){
        
        $variableExternalList['type'] = 'externallist';
        $variableExternalList['no_grid'] = TRUE;
        $variableExternalList['no_fieldset'] = TRUE;
        
        $bsform = new BsForm(
            array(
                'no_panel'  =>  TRUE,
                'inputs'    =>  array(
                    $variableExternalList
                )
            )
        );
        
        $bsformData = $bsform->getHtmlData()['form']['children'][0]['children'];
        $inputValue = $bsformData[0];
        temp($inputValue,TRUE);
        $inputKey = $bsformData[2];
        $inputText = $bsformData[3];
        
        $value = $inputValue['value'];
        $text = $inputText['children'][0]['value'];
        
        $dataReturn = array();
        
        foreach($inputValue as $key => $val){
            if(strpos($key,'data-return')!==false){
                $dataReturn[$key] = $val;
            }
        }
        
        return array(
            'value' =>  $value,
            'text'  =>  $text,
            'data'  =>  $dataReturn,
        );
        
    }
    
    
}