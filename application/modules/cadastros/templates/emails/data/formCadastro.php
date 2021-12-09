<?php

/**
 * @author Tony Frezza
 */


$getFormCadastro = function(){
        
        $pwd = $this->cadastro->variables->get('pass.value');
        
        $ciphering = "AES-128-CTR";
        $decryption_iv = '1234567891011121';
        $options = 0;
        $decryption_key = "GeeksforGeeks";
          
        
        $pwd =openssl_decrypt ($pwd, $ciphering, 
                $decryption_key, $options, $decryption_iv);
        //FIM PARA DESCRIPTOGRAFAR
    
    
    $bsForm = new BsForm(
        array(
            'class'         =>  'tab-enter',
            'readonly'      =>  !$this->cadastro->runActionUserPermissions(
                array(
                    'action'            =>  $this->cadastro->get('configs.actions.editItems'),
                    'user_id'           =>  $this->CI->data->get('user.id'),
                    'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
                )
            ),
            'inputs'        =>  array(
                
               array(
                    'type'          =>  'textbox',
                    'id'            =>  'id_item',
                    'label'         =>  'Código',
                    'value'         =>  $this->cadastro->get('item.value'),
                    'placeholder'   =>  'NOVO',
                    'readonly'      =>  TRUE,
                    'input_class'   =>  'text-right',
                    'grid-col'      =>  array(
                        'lg'    =>  12,  
                    ),
                    'input-col'     =>  array(
                        'lg'        =>  8
                    ),
                    
                ),
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'login',
                    'label'         =>  'Login',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('login.value'),
                    //'input_class'   =>  array('uppercase'),
                    'grid-col'     =>  array(
                        'lg'        =>  24
                    ),
                ),  
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nome',
                    'label'         =>  'Nome',
                    'required'      =>  TRUE,
                    'value'         =>  $this->cadastro->variables->get('nome.value'),
                    //'input_class'   =>  array('uppercase'),
                    'grid-col'     =>  array(
                        'lg'        =>  24
                    ),
                ),   
                
                array(
                    'type'          =>  'textbox',
                    'id'            =>  'nn',
                    'label'         =>  'Pass',
                    'required'      =>  TRUE,
                    'value'         =>  $pwd,
                    //'input_class'   =>  array('uppercase'),
                    'grid-col'     =>  array(
                        'lg'        =>  24
                    ),
                ), 
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'conta_criada',
                    'label'         =>  'Conta Criada',
                    'required'      =>  TRUE,
                    'value'         =>  boolValue($this->cadastro->variables->get('conta_criada.value')),
                    'options'       =>  array(
                        array(
                            'value' =>  1,
                            'text'  =>  'SIM'
                        ),
                        array(
                            'value' =>  0,
                            'text'  =>  'Não'
                        ),
                    ),
                    'grid-col'     =>  array(
                        'lg'        =>  24
                    ),
                ),
                
                array(
                    'type'          =>  'dropdown',
                    'id'            =>  'conta_acessada',
                    'label'         =>  'Conta acessada',
                    'required'      =>  TRUE,
                    'value'         =>  boolValue($this->cadastro->variables->get('conta_acessada.value')),
                    'options'       =>  array(
                        array(
                            'value' =>  1,
                            'text'  =>  'SIM'
                        ),
                        array(
                            'value' =>  0,
                            'text'  =>  'Não'
                        ),
                    ),
                    'grid-col'     =>  array(
                        'lg'        =>  24
                    ),
                ),                        
            )
        )   
    );
    
    return $bsForm->getHtmlData();
    
    
}   
    
?>