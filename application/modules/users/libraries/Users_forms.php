<?php

/**
 * @author Tony Frezza

 */


class Users_forms extends Data{
    
    protected $CI;
         
    function __construct(){
        
        parent::__construct();        
    }
    
    public function formEditUser(Users $user){
        
        $readOnly = !$user->get('user_permissions.edit');
        
        if(in_array($user->get('item.value'),array(1))){
            $readOnly = TRUE;
        }
        
        $form = new BsForm(
            
        );
       
        $formData = $form->getHtmlData();
        
        $htmlForm = new Html;
        $htmlForm->add($formData['form']);
               
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
        
        $arrButtonsUnsetByClass = array(
            'bsform-btn-group-save-dropdown','bsform-btn-remove'   
        );
        
        $buttonsHtmlData = $user->getRequestButtons(
            array(
                'buttons'           =>  $formData['buttons'],
                'unset_by_class'    =>  $arrButtonsUnsetByClass
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData,
                'parent_id' =>  $idFormFooter,
            )
        );
        
        
        return array(
            'title'     =>  'Cadastros | '.$user->get('descricao_singular'),
            'body'      =>  $htmlForm->getHtml(),
            'footer'    =>  $htmlFooter->getHtml(),
        );
    }

}

?>