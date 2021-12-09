<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Icon_bsform extends Bsform_defaults{
    
    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','required'));
        
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/bootstrap-iconpicker/js/iconset/iconset-fontawesome-4-all.js');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.js');
                
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
   
        //add o INPUT
        $arrInput['id'] = $this->getInputId($arrInput);
        $arrReturn['id'] = $arrInput['id'].'_icon';
        $arrReturn['tag'] = 'button';
        $arrReturn['class'] = $this->CI->common->append($arrInput['class']??array(),array('bsform-icon btn btn-secondary padding-left-26 width-70'));
        $arrReturn['class'] = $this->CI->common->append($arrReturn['class'],$arrInput['input_class']??array());
        $arrReturn['value'] = $arrInput['value'] ?? NULL;
        $arrReturn['autocomplete'] = 'off';
        unset($arrReturn['class'][array_search('input-sm',$arrReturn['class'])]);
        //<button type="button" id="myEditor_icon" class="btn btn-secondary padding-left-26" style="width: 70px;"></button>
                                    				         //<input type="hidden" name="icon" class="item-menu" />
        foreach ($arrInput as $key => $attribute){
            if (!in_array($key, $this->arrNoAttribute)){
                $arrReturn[$key] = (is_array($attribute) ? implode(' ', $attribute) : $attribute);
            }
        }
        
        
        $hidden = new Hidden_bsform(
            array(
                'id'        => $arrInput['id'],
                'value'     => $arrInput['value'] ?? NULL,
                'no_grid'   =>  TRUE,
            )
        );
        
        if($arrInput['readonly'] ?? FALSE){
            $arrReturn['readonly'] = true;
        }
        
        
        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            
            $arrReturn = $this->getDefaultLayout(
                array(
                    'input'     => $arrInput,
                    'children'  => array(
                        $arrReturn,
                        $hidden->getHtmlData()
                    ),
                )
            );
        }
        
        return $arrReturn;

    }
    
    /**
     * PRIVATES
     */
}

?>