<?php

/**
 * @author Tony Frezza
 */


class BsFormTemplate_2{
    
    private $form;
    function __construct(Bsform $form){
        $this->CI = &get_instance();
        $this->form = $form;
        
    }
    
    public function getHtmlData(){
        
        $bootstrap = new Bootstrap;
        
        $arrMenu = array();
        $arrForms = array();
        
        foreach($this->form->get('nodes') as $key=>$node){
            
            
            $nodeClass = array(
                'list-group-item',
                'bsform-node',
                'bsform-node-'.$key,
                'size-11',
                (($node['active'] ?? NULL) ? 'active' : NULL)
            );
            
            $arrMenu[] = array(
                'tag'       =>  'a',
                'class'     =>  $nodeClass,
                'text'      =>  $node['title'],
            );
            
             
            $formClass = $this->form->get('class');
            $formClass= (is_array($formClass) ? explode(' ',$formClass) : $formClass);
            $formClass .= ' col-lg-19 padding-top-10 bg-white bsform-body bordered bsform-node-'.$key;
            
            
            if($this->form->get('no_panel') !== TRUE){
                $arrForms[] = array(
                    'tag'       =>  'div',
                    'class'     =>  $formClass,
                    'style'     =>  'display:none;',
                    'children'  =>  array(),
                );
            }
            
            $arrInputsData = array();
            
            $arrInputs = $node['inputs'] ?? NULL;
            if($arrInputs){
                foreach($arrInputs as $input){
                    
                    
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
                    
                    if($this->form->get('readonly')){
                        $input['readonly'] = true;    
                    }
                    
                    
                    if(array_key_exists('input_class',$input) == FALSE){
                        $input['input_class'] = array();
                    }
                    
                    $input['class'] = $this->CI->common->append($input['input_class'] ?? array(),'input-sm');
                    
                    $arrForms[sizeof($arrForms)-1]['children'][] = $this->form->{$input['type']}->getHtmlData($input);
                }      
            } 
        }
        

        $formClass =  $this->CI->common->append($this->form->get('class'),!($this->form->get('no_form_class') ?? FALSE) ? array('bsform') : array());
        
        $arrColMenu = array(
            'col-lg-' . ($this->form->get('col_menu.lg') ?? 5),
            'col-md-' . ($this->form->get('col_menu.md') ?? 5),
            'col-sm-' . ($this->form->get('col_menu.sm') ?? 5),
            'col-xs-' . ($this->form->get('col_menu.xs') ?? 5)
            
        );
        
        $arrDataForm = array(
            'tag'               =>  'div',
            'id'                =>  $this->form->get('id'),
            'class'             =>  $formClass,
            'data-url-save'     =>  $this->form->get('url_save'),
            'data-token'        =>  $this->form->get('token'),
            //'url_edit'      =>  $this->form->get('url_edit'),
            'children'      =>  array(
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-lg-24','nopadding','nomargin'),
                    'children'  =>  array(
                        array(
                            'tag'       =>  'div',
                            'class'     =>  append($arrColMenu,array('nopadding','nomargin')),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'div',
                                    'class'     =>  'list-group border-bottom padding-top-20 bsform-menu text-right',
                                    'children'  =>  $arrMenu,
                                )
                            )
                        ),
                        array(
                            'tag'       =>  'div',
                            'class'     =>  'bsform-form',
                            'children'  =>  $arrForms
                        ),
                    )
                ),
            )
            
        );
        
        $arrReturn = array(
            'form'      =>  $arrDataForm,
        );
        return $arrReturn; 

    }
}

?>