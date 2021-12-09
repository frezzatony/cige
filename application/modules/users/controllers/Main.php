<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
    }
    
    function index(){           
                       
        if($this->uri->getKey('changepassword')!== FALSE AND $this->uri->get('view')=='render' AND $this->data->get('ajax')){
            $this->viewChangePassword();;               
        }
        else if($this->uri->getKey('changepassword')!== FALSE AND $this->uri->get('changepassword')=='set' AND $this->data->get('ajax')){    
            $this->change_password();    
        }
        
        return;
    }
    
    public function change_password(){
       
        $this->auth_model->login();
        
        $data = new Data($this->input->post('values'));
        
        $keyOldPasswordNode = array_search('password',array_column($data->get(),'id'));
        $oldPasswordNode = $data->get()[$keyOldPasswordNode];
        
        $identity = $this->data->get('user.username');
        
        //VERIFICA A SENHA ANTIGA
        if(!$this->auth->login($identity,$oldPasswordNode['value'])){
             Common::printJson(
                array(
                    'status'    =>  'error',
                    'messages'  =>  array(
                        'Senha antiga não confere.'
                    )
                )
            );
            return;
        }
        
        $keyConfirmNewPassword = array_search('confirm_new_password',array_column($data->get(),'id'));
        $confirmNewPasswordNode = $data->get()[$keyConfirmNewPassword];
        
        $variables = new Variables(
            array(
                'variables' =>  $data->get(),
                'rules'     =>  array(
                    array(
                        'id'        =>  'new_password',
                        'rule'      =>  'length',
                        'min'       =>  6,
                        'message'   =>  'O campo nova senha deve conter no mínimo 6 caracteres.'
                    ),
                    array(
                        'id'        =>  'new_password',
                        'rule'      =>  'equals',
                        'compare'   =>  $confirmNewPasswordNode['value'],
                        'message'   =>  'A nova senha digitada não confere.'
                    ),
                )
            )
        );
        
        $validationErrors = $variables->validate();
        if($validationErrors){
            
            Common::printJson(
                array(
                    'status'    =>  'error',
                    'messages'  =>  array_column($validationErrors,'message')
                )
            );
            return;
     
        }
        
        $user = new Users();
        $user->setItem($this->data->get('user.id'));
        $change = $user->change_password($confirmNewPasswordNode['value']);    

        Common::printJson(
            array(
                'status'    =>  'success',
                'messages'  =>  array(
                    '<i class="fa fa-key"></i> Senha atualizada'
                )
            )
        ); 
    }
  
    public function viewChangePassword(){
        
        $bsForm = new BsForm(
            array(
                'template'      =>  1,
                'id'            =>  'bsform-change-password',
                'url_save'      =>  BASE_URL.'users/changepassword/set',
                'class'         =>  array(
                    'tab-enter','bg-white','card','bordered','col-lg-24','padding-top-10','no-auto-bsform'
                ),
                'inputs'        =>  array(
                    array(
                        'type'      =>  'password',
                        'id'        =>  'password',
                        'label'     =>  'Senha atual', 
                        'required'  =>  TRUE, 
                    ),
                    array(
                        'type'      =>  'password',
                        'id'        =>  'new_password',
                        'label'     =>  'Nova senha', 
                        'required'  =>  TRUE, 
                    ),
                    array(
                        'type'      =>  'password',
                        'id'        =>  'confirm_new_password',
                        'label'     =>  'Confirme nova senha', 
                        'required'  =>  TRUE, 
                    ),
                )
            )
        );
        $this->template->set('htmlForm',$bsForm->getHtml());
        
        $bsFormData = $bsForm->getHtmlData();
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
                        
        $htmlFooter->add(
            array(
                'parent_id' =>  $idFormFooter,
                'children'  =>  array(
                    array(
                        'tag'               =>  'a',
                        'class'             =>  'btn btn-info btn-sm btn-3d bsform-btn-save',
                        'text'              =>  '<i class="fa fa-key"></i> Atualizar senha',
                        'data-parent-id'    =>  $bsForm->get('id')
                    )
                ),
                
            )
        );
        
        $this->template->set('htmlFooterButtons',$htmlFooter->getHtml());
        Common::printJson(
            array(
                'title'         =>  '<i class="fa fa-key"></i> Alterar senha',
                'body'          =>  $this->template->load('modal','users','changePassword_view',array(),TRUE),
                'modal_size'    =>  'sm',
                'body_height'   =>  '220',
                'footer'        =>  $this->template->load('modal','users','footerChangePassword_view',array(),TRUE),
            )
        );     
    }
    
}
