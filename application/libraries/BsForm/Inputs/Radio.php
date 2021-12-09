<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Radio_bsform extends Bsform_defaults{

    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/checkbox-radio/css/checkbox_radio_img_sprite.css');
                        
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','required'));

    }
   
    
    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }             
        
       
        $arrInput['id'] = $this->getInputId($arrInput);
        $arrInput['options'] = $this->getInputOptions($arrInput);
        
        //READONLY convertendo para Textbox
        if($arrInput['readonly'] ?? FALSE){
            return $this->getHtmlDataReadOnly($arrInput);
        }
        
        $arrData = array(
            'children'  =>  array()
        );
        
        
        
        foreach($arrInput['options'] as $option){
            //add o INPUT
            $arrReturn = array();    
            $arrReturn['id'] = $arrReturn['name'] = $arrInput['id'];
            $arrReturn['tag'] = 'input';
            $arrReturn['type'] = 'radio';
            $arrReturn['value'] = $option['value'] ?? NULL;
            $arrReturn['class'] = array_merge(
                ($arrInput['class'] ?? array()),
                array('form-control')
            );
           
            if(($arrInput['value']??NULL) AND $arrInput['value']==$option['value']){
                $arrReturn['checked'] = 'checked';
            }
    
            foreach ($arrInput as $key => $attribute){
                if (!in_array($key, $this->arrNoAttribute)){
                    $arrReturn[$key] = (is_array($attribute) ? implode(' ', $attribute) : $attribute);
                }
            }
            
            
            if($arrInput['disabled'] ?? FALSE){
                $arrReturn['disabled'] = true;
            }
            
            $arrFormGroup = $this->getFormGroup($arrInput);
            
            $arrReturn = array(
                'tag'       =>  'div',
                'class'     =>  array_merge(
                    array('radio','radio-xs'),
                    $arrFormGroup['class']
                ),
                'children'  =>  array(
                    array(
                        'tag'       =>  'label',
                        'children'  =>  array(
                            $arrReturn,
                            array(
                                'tag'       =>  'i',
                                'class'     =>  'fa fa-lg icon-radio',
                            ),
                            array(
                                'text'  =>  $option['text'] ?? NULL
                            )
                        ),
                    )
                )
            );
            $arrData['children'][] = $arrReturn;
            
        }
        
        
        //$arrInput['no_label'] = TRUE;
        $arrInput['no_no_fieldset'] = TRUE;
        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            
            $arrReturn = $this->getDefaultLayout(
                array(
                    'input'     => $arrInput,
                    'children'  => $arrData,
                )
            );
        }
        
        return $arrReturn;

    }

    function getHtmlDataReadOnly($arrInput = array()){
    
        $textbox = new Textbox_bsform($arrInput);
        
        if($textbox->get('value')){
            $keyValue = array_search($textbox->get('value'),array_column($textbox->get('options'),'value'));
            
            if($keyValue !== FALSE){
                $optionValue = $textbox->get('options.'.$keyValue);
                $textbox->set('value',$optionValue['text']);
            }
        }
        

        return $textbox->getHtmlData();

    }
    

    /**
     * PRIVATES
     */
}

?>