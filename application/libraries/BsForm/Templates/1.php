<?php

/**
 * @author Tony Frezza

 */


class BsFormTemplate_1{
    
    private $form;
    function __construct($form){
        $this->CI = &get_instance();
        $this->form = $form;
        
        $this->arrNoAttribute =array('class','url_save','token','no_panel',);
    }
    
    public function getHtmlData(){
        
        $arrInputs = $this->form->get('inputs'); 
        
        $arrDataForm = array(
            'children'          =>  array(),
        );
        
        $formClass =  $this->CI->common->append($this->form->get('class'),!($this->form->get('no_form_class') ?? FALSE) ? array('bsform','bsform-body','container-fluid nopadding nomargin') : array('bsform-body'));
        
        if($this->form->get('no_panel') !== TRUE){
            $arrDataForm = array(
                'tag'               =>  'div',
                'id'                =>  $this->form->get('id'),
                'class'             =>  $formClass,
                'data-url-save'     =>  $this->form->get('url_save'),
                'data-token'        =>  $this->form->get('token'),
                'style'             =>  $this->form->get('style'),
            );
        }
        
        
        $arrInputsData = array();
        foreach($arrInputs ?? array() as $input){
            
            if(!$input){
                continue;
            }
            
            $input['parent_id'] = $this->form->get('parent_id') ? $this->form->get('parent_id') : $this->form->get('id');
            
            if($input['ajax']??NULL){
                
                $input['data-token'] = $this->CI->encryption->encrypt(
                    json_encode(
                        array(
                            'internal'      =>  TRUE,
                            'source'        =>  'input_options',
                            'form'          =>  $this->form->get('parent_id') ? $this->form->get('parent_id') : $this->form->get('id'),
                            'input_id'      =>  $input['id'],
                        ),
                        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                    )
                ); 
            }
            
            if(($input['type']??NULL) AND !property_exists($this->form,$input['type'])){
                
                $bootstrap = new Bootstrap();
                $bootstrap->{$input['type']}($input);
                
                $arrDataForm['children'][] = $bootstrap->getHtmlData();
                continue;
            }
            else if(($input['tag']??NULL)){
                
                $bootstrap = new Bootstrap();
                $bootstrap->{$input['tag']}($input);
                $arrDataForm['children'][] = $bootstrap->getHtmlData()[0];
                continue;
            }
            
            if(!($input['class'] ?? NULL)){
                $input['class'] = array();
            }
            else if(is_string($input['class'])){
                $input['class'] = explode(' ',$input['class']);    
            }
            
            $input['class'] = array_merge(
                $input['class'],
                array('input-sm')
                
            ); 
            
            if($this->form->get('input_class')){
                $input['class'] = array_merge(
                    $input['class'],
                    string_to_array($this->form->get('input_class'))
                );  
            }
                       
            if(property_exists($this->form,$input['type']) === FALSE){
                $input['type'] = 'textbox';
            }
            
            if($this->form->get('readonly')){
                $input['readonly'] = true;    
            }
            
            if($this->form->get('grid_class') AND !($input['grid_class'] ?? NULL)){
                $input['grid_class'] = $this->form->get('grid_class');
            }
            
            if(array_search('bsform-input-no-value',string_to_array($input['class']??NULL))!==FALSE){
               $input['grid_class'] = $input['grid_class'] ?? array();
               append($input['grid_class'],'bsform-input-no-value');
            }
            
            $arrDataForm['children'][] = $this->form->{$input['type']}->getHtmlData($input);
        }
        
        
        $arrDataButtons = array(
            array(
                'tag'               =>  'a',
                'class'             =>  'btn btn-secondary btn-3d btn-sm bsform-btn-remove',
                'text'              =>  '<i class="fa fa-trash-alt"></i> Excluir',
                'data-parent-id'    =>  $this->form->get('id'),
            ),
            array(
                'tag'               =>  'a',
                'class'             =>  'btn btn-success btn-3d btn-sm bsform-btn-save',
                'text'              =>  '<i class="fa fa-save"></i> Salvar',
                'data-parent-id'    =>  $this->form->get('id'),
            ),
        );
        
        $arrReturn = array(
            'form'      =>  $arrDataForm,
            'buttons'   =>  $arrDataButtons
        );
        return $arrReturn;  

    }
}

?>