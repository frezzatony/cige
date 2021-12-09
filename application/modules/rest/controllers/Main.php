<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');



class Main extends CI_Controller{
    
    private $arrDataToken;
    
    function __construct(){
        
        parent::__construct();
        $this->arrDataToken = $this->json->getFullArray($this->encryption->decrypt($this->input->get_post('token')));
        
        if(!$this->arrDataToken){
            $this->main_model->erro();
        }
        
    }
    
    public function index(){ 
        
        if($this->arrDataToken['internal']==TRUE){
            $this->auth_model->login();
            if(method_exists($this,strtoMINusculo($this->arrDataToken['source']))){
                $this->{strtoMINusculo($this->arrDataToken['source'])}();    
            }
            return;
        }
        
        $this->main_model->erro();
                            
    }
    
    
    /**
     * PRIVATES
     **/
     
    private function cep(){
        
        $this->load->model('ceps_model');
        
        $dataEndereco = $this->ceps_model->getEndereco(
            array(
                'cep'       =>  $this->input->get_post('cep'),
            )
        );
        
        $this->common->printJson($dataEndereco);   
    }
    
    private function input_options(){
        
        $cachedForm = $this->cache->file->get('bsform_'.$this->arrDataToken['form']);
        
        if(!$cachedForm){
            Common::printJson(
                array(
                    'status'    =>  'error',
                    'message'   =>  'Formulário não disponível em cache',
                )
            );
            return;
        }
        $arrValues = $this->input->post('values');
        
        $bsform = new BsForm($cachedForm);
        $bsform->setValues($arrValues);
        
        $arrProp = array(
            'input_id'      =>  $this->arrDataToken['input_id'],
            'index_value'   =>  $this->input->post('index_value'),
        );
        
        $arrInputData = $bsform->getInputHtmlData($arrProp);
        
        
        $arrOptions = array();
        foreach($arrInputData['children'] as $child){
            if(($child['tag']??NULL) == 'option'){
                $arrOptions[] = $child;
            }
        }
        Common::printJson(
            array(
                'status'        =>  'ok',
                'options'       =>  $arrOptions
            )
        );        
    }
    
    
    private function externallist(){
        
        $arrConfigs = $this->arrDataToken;
        $arrConfigs['no_filter'] = $this->input->get_post('no_filter') ? TRUE : FALSE;
        $arrConfigs['grid_footer'] = $this->input->get_post('grid_footer')!='' ? $this->input->get_post('grid_footer') : TRUE;
        
        $className = strtoMINusculo($arrConfigs['module']);
        
        if(!in_array($className,$this->data->get('modules'))){
            $this->main_model->erro();
        }
        
        $module = new $className($arrConfigs);
        
        if($this->input->get_post('get_values')){
            $arrConfigs['get_values'] = TRUE;
            $arrConfigs['pk_value'] = $this->input->get_post('pk_value');
            $arrConfigs['filters'] = $this->input->get_post('filters');
        }
        
        $view = $module->get_data->getExternalList($arrConfigs); 
                
        Common::printJson($view);        
    }
    
        
}
