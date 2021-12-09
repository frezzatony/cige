<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Externallist_bsform extends Bsform_defaults{

    function __construct($arrProp = array()){

        parent::__construct($arrProp);
        
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','required','update_on','ajax_options','input-key-style','return_data','text'));
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }
        
        $arrHiddenInput = $arrInput;
        $arrHiddenInput['id'] = $this->getInputId($arrInput);
        $arrHiddenInput['type'] = 'hidden';
        $arrHiddenInput['no_grid'] = TRUE;
        $arrInput['return_data'] = NULL;
        
        if($arrInput['value'] ?? FALSE){
            
            
            $arrProp = $arrInput;
            $arrProp['from']['filters'] = $arrProp['filters']?? array(); 
            
            $arrProp['from']['filters'][] = array(
                'id'        =>  $arrInput['from']['value'][0],
                'clause'    =>  'equal',
                'value'     =>  $arrInput['value'],
            );
            $arrProp['from']['limit'] = 1;
            
            $arrInput['options'] = $this->getInputOptions($arrProp);
            $arrInput['value'] = $arrInput['options'][0]['value'] ?? NULL;
            $arrInput['text']  = $arrInput['options'][0]['text'] ?? NULL;
            $arrInput['return_data'] = $arrInput['options'][0]['data']?? NULL;
            
            $arrHiddenInput['value'] = $arrInput['value'];
        }
        
        $arrDataToken = $arrInput['parent'] ?? NULL;
        $arrDataToken['variable'] = $arrHiddenInput['id'];
        $arrDataToken['internal'] = TRUE;
        $arrDataToken['source'] = 'externallist';
        $arrDataToken['method'] = $arrInput['method'] ?? NULL;
        $arrDataToken['request_id'] = $arrInput['parent']['request'] ?? NULL;
        $arrDataToken['request_url'] = $arrInput['parent']['url'] ?? NULL;
        $arrDataToken['parent'] = $arrInput['parent'] ??NULL;
        
        $token = $this->CI->encryption->encrypt(
            $this->CI->json->getAllAsString($arrDataToken)    
        );
        
        $href = $arrInput['url'] ?? (BASE_URL.'rest');
        
        
        $arrInputKeyType = ($arrInput['hide_key']??NULL) ? 'hidden' : 'textbox';
        
        $bsform = new BsForm(
            array(
                'no_panel'  =>  TRUE,
                'inputs'    =>  array(
                    $arrHiddenInput,
                    array(
                        'type'          =>  $arrInputKeyType,
                        'class'         =>  array('externallist-input-value','text-right'),
                        'no_grid'       =>  TRUE,
                        'no_fieldset'   =>  TRUE,
                        'readonly'      =>  $arrInput['readonly_key'] ?? FALSE,
                        'data-readonly-key' =>  $arrInput['readonly_key'] ?? FALSE,
                        'value'         =>  $arrInput['value'] ?? NULL,
                    ),
                    array(
                        'type'          =>  'textbox',
                        'class'         =>  array('externallist-input-text'),
                        'no_grid'       =>  TRUE,
                        'no_fieldset'   =>  TRUE,
                        'value'         =>  $arrInput['text'] ?? NULL,
                    ),
                    array(
                        'type'          =>  'hidden',
                        'class'         =>  array('externallist-last-text-value'),
                        'no_grid'       =>  TRUE,
                        'no_fieldset'   =>  TRUE,
                        'value'         =>  $arrInput['text'] ?? NULL,
                    ),
                )
            )
        );
        
        $bsformData = $bsform->getHtmlData()['form']['children'];
        $inputValue = $bsformData[0];
        $inputKey = $bsformData[1];
        $inputText = $bsformData[2];
        $inputLastTextValue = $bsformData[3];
        
        $inputTextWidthPercent = ($arrInput['hide_key']??NULL) ? '85' : '70';
        
        if(($arrInput['readonly'] ?? FALSE)){
            $inputValue['readonly'] = TRUE;
            
            $inputText['readonly'] = TRUE;
            $inputLastTextValue['readonly'] = TRUE;
        }
        
        
        foreach($arrInput['return_data']??array() as $extraData){
            $strName = $extraData['name'];
            foreach($extraData as $key => $val){
                $inputValue['data-return-'.$strName.'-'.$key] = $val;    
            }  
        }
        
        foreach($arrInput['data']??array() as $key => $attribute){
            $inputValue['data-'.$key] = (is_array($attribute) ? implode(' ', $attribute) : $attribute);
        }
        
        
        $inputKeyStyle = 'max-width:70px;';
        $inputKeyStyle .= $arrInput['input-key-style'] ?? NULL;
         
        $arrReturn = array(
            'tag'           =>  'div',
            'class'         =>  $this->CI->common->append(array('nopadding','externallist-inputs'),($arrInput['grid-class']??array())),
            'href'          =>  $href,
            'data-token'    =>  $token,
            'children'      =>  array(
                $inputValue,
                $inputLastTextValue,
                array(
                    'tag'       =>  'div',
                    'style'     =>  $inputKeyStyle,
                    'class'     =>  array('form-group','col-lg-6','nopadding','margin-right-2',($arrInputKeyType=='hidden' ?'softhide':'inline-block')),
                    'children'  =>  array(
                        $inputKey,
                    )
                ),
                array(
                    'tag'       =>  'div',
                    'style'     =>  'min-width:180px; width: '.$inputTextWidthPercent.'%',
                    'class'     =>  array('form-group','inline-block','col-lg-16','nopadding','margin-right-2'),
                    'children'  =>  array(
                        $inputText,
                    )
                ),      
            )
        
        );
        
        $searchButtonClass = array('form-group','col-lg-2','nopadding');        
        if(($arrInput['readonly'] ?? FALSE)){
            append($searchButtonClass,array('softhide'));
        }
        else{
            append($searchButtonClass,array('inline-block'));
        }
        
        $arrReturn['children'][] = array(
            'tag'       =>  'div',
            'class'     =>  $searchButtonClass,
            'children'  =>  array(
                array(
                    'tag'       =>  'a',
                    'title'     =>  'Pesquisar',
                    'class'     =>  array('btn','btn-secondary','size-11','btn-sm','nomargin','externallist-button-search'),
                    'children' =>  array(
                        array(
                            'tag'       =>  'i',
                            'class'     =>  array('fa','fa-search')
                        )
                    )
                )
            )
        );   
        
        
        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid']){
            
            $arrInput['id'] = $inputKey['id'];
            
            $arrInput['formgroup-class'] = $arrInput['formgroup-class'] ?? array();
            append($arrInput['formgroup-class'],array('nomargin'));
             
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
}

?>