<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Main extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->modulo = new Modulos();
    }
    
    public function index(){ 
        
        
        if($this->uri->getKey('alterar')!== FALSE){
            $this->viewChangeModulo();
        }
        else if($this->uri->getKey('save-change')!== FALSE){
            $this->saveChange();
        }  
                            
    }
    
    private function saveChange(){
        
        $this->auth_model->login();
        
        $arrModulos = $this->modulos->getUserModulos(
            array(
                'user_id'       =>  $this->data->get('user.id'),
                'entity_id'     =>  $this->data->get('user.configs.entity'),
            )
        );
        
        $idNewModulo = (int)$this->input->get_post('modulo');
        $keyModulo = array_search($idNewModulo,array_column($arrModulos,'modulo_id')); 
        
        if($keyModulo===FALSE){
            $this->main_model->erro();
        }
        //NAO HOUVE ALTERACAO
        else if($idNewModulo == $this->data->get('user.configs.modulo') AND 1==1){
            Common::printJson(
                array(
                    'status'    =>  'none',
                    'messages'  =>  array(
                        array(
                            'type'      =>  'success',
                            'message'   =>  'Este é o módulo atual e não foi alterado.',
                        )
                    ) 
                )
            );
            return;
        }
        
        //HOUVE ALTERAÇAO, SERÁ GRAVADO
        $this->users->update(
            array(
                'id'    =>  $this->data->get('user.id'),
                'data'  =>  array(
                    'configs'   =>  array(
                        'modulo'            =>  $arrModulos[$keyModulo]['modulo_id'],
                        'modulo_descricao'  =>  $arrModulos[$keyModulo]['modulo_descricao'],
                    )
                ),
            )
        );
        
        $userLogged = $this->auth->user($this->data->get('user.id'));
        $this->data->set('user',$userLogged);
        
        Common::printJson(
            array(
                'status'    =>  'ok',
                'messages'  =>  array(
                    array(
                        'type'      =>  'success',
                        'message'   =>  'Módulo ativo: '.strtoMAIsuculo($this->data->get('user.configs.modulo_descricao')),
                    )
                ) 
            )
        );
    }
    
    private function viewChangeModulo(){
        
        $this->auth_model->login();
        
        $arrModulos = $this->modulos->getUserModulos(
            array(
                'user_id'       =>  $this->data->get('user.id'),
                'entity_id'     =>  $this->data->get('user.configs.entity'),
            )
        );
        
        $inputModuloOptions = array();
        foreach($arrModulos as $modulo){
            $inputModuloOptions[] = array(
                'value'     =>  $modulo['modulo_id'],
                'text'      =>  strtoMAIsuculo($modulo['modulo_descricao'])
            );
        }
        
        $bsForm = new BsForm(
            array(
                'inputs'    =>  array(
                    array(
                        'type'      =>  'dropdown',
                        'id'        =>  'modulo',
                        'label'     =>  'Seus módulos disponíveis:',
                        'options'   =>  $inputModuloOptions
                    )
                )
            )
        );
        
        $htmlBody = $bsForm->getHtml();
                
        $htmlBody = new Html;
        $htmlBody->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('container-fluid','padding-top-14'),
                'children'  =>  array(
                    $bsForm->getHtmlData()['form']
                )
                
            )
        );
        
        $htmlFooter = new Html;
        $htmlFooter->add(
            array(
                'tag'       =>  'button',
                'class'     =>  array('btn','btn-secondary','btn-sm','btn-3d','btn-change-modulo'),
                'text'      =>  '<i class="fa fa-check"></i>&nbsp;Confirmar',
            )
        );
        
        Common::printJson(
            array(
                'title'         =>  'Selecionar módulo',
                'body'          =>  $htmlBody->getHtml(),
                'footer'        =>  $htmlFooter->getHtml(),
                'body_height'   =>  '80'
            )
        ); 
    }
        
}
