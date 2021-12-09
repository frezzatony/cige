<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Summernote_bsform extends Bsform_defaults{

    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/summernote/summernote-bs4.min.css');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/summernote/summernote-bs4.min.js');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/summernote/lang/summernote-pt-BR.min.js');
        
        
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','text'));
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
        
        
        //add o INPUT
        $arrInput['id'] = $this->getInputId($arrInput);
        $arrReturn['id'] = $arrInput['id'];
        $arrReturn['tag'] = 'textarea';
        $arrReturn['class'] = array_merge(
            ($arrInput['class'] ?? array()),
            array('form-control','summernote')
        );
        
        $arrReturn['text'] = $arrInput['value'] ?? NULL;
        $arrReturn['autocomplete'] = 'off';
        
        
        foreach ($arrInput as $key => $attribute){
            if (!in_array($key, $this->arrNoAttribute)){
                $arrReturn[$key] = (is_array($attribute) ? implode(' ', $attribute) : $attribute);
            }
        }
        
        
        if($arrInput['readonly'] ?? FALSE){
            return $this->getHtmlDataReadOnly($arrInput);
        }
        
        if($arrInput['placeholder'] ?? FALSE){
            $arrReturn['placeholder'] = $arrInput['placeholder'];
        }
        
        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            
            $arrReturn = $this->getDefaultLayout(
                array(
                    'input'     => $arrInput,
                    'children'  => $arrReturn,
                )
            );
        }
        
        return $arrReturn;

    }
    
    /**
     * PRIVATES
     */
    function getHtmlDataReadOnly($arrInput = array()){
        
        $style = '';
        
        if($arrInput['data-height']??NULL){
            $style .= 'height: '.$arrInput['data-height'].'px;';
        }
        
        $arrReturn = array(
            'children'  =>  array(
                array(
                    'tag'       =>  'div',
                    'id'        =>  $this->getInputId($arrInput),
                    'class'     =>  array_merge(
                        ($arrInput['class'] ?? array()),
                        array('col-lg-24','bordered','size-12','bg-white','nopadding','nomargin','padding-4')
                    ),
                    'style'     =>  $style,
                    'text'      =>  $arrInput['value']??NULL
                )
            )
        );
        
        
        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            
            $arrReturn = $this->getDefaultLayout(
                array(
                    'input'     => $arrInput,
                    'children'  => $arrReturn,
                )
            );
        }
        
        return $arrReturn;
        
    }
}

?>