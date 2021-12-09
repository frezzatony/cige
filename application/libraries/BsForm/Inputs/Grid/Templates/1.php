<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Grid_BsFormTemplate_1 extends Grid_bsForm_defaults{

    
    function __construct($arrProp = array()){

        parent::__construct();
        
        if($arrProp){
            $this->set($arrProp);
        }
        
        $this->arrNoAttribute = $this->CI->common->append($this->arrNoAttribute,array('class','inputs','body_style','parent_id','template','no_form_class','no_panel','id'));
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }  
        $arrInput['template'] = 1;
        $arrInput['no_form_class'] = TRUE;
        $arrInput['no_panel'] = TRUE;
        
        $arrTemp = $arrInput;
        $arrTemp['grid_class'] = array('child','bsgrid-row-child');
        $arrTemp['body_class'] = $arrTemp['body_class'] ?? array();
        append($arrTemp['body_class'],array('bsform-grid-body','container-fluid','nopadding','padding-top-6'));
        $arrTemp['body_style'] = $arrTemp['body_style'] ?? array();
        
        //criando um form a parte, para servir de modelo, tanto para o clique de ADD no grid, quanto para popular quando recebidos valores já armazenados
        $arrTemp['parent_id'] = $arrTemp['id'];
        
        $arrTemp['input_class'] = array('no_init');
        
        
        
        $bsFormTemplateData = $this->getBsFormTemplate($arrTemp)['form'];
         
        
        $arrReturn = array(
            'tag'       =>  'div',
            'id'        =>  $this->getInputId($arrInput),
            'class'     =>  array('bsform-grid','bsform-grid-template-1','card','container-fluid','nopadding'),
            'children'  =>  array(
                array(
                    'tag'       =>  'div',
                    'class'     =>  'card-header nopadding padding-left-6',
                    'children'  =>  array(
                        array(
                            'tag'       =>  'span',
                            'class'     =>  'size-11 color-black',
                            'text'      =>  ($arrInput['label'] ?? '&nbsp;'),
                        ),
                        array(
                            'tag'       =>  'div',
                            'class'     =>  'pull-right',
                            'children'  =>  array(
                            )
                        ),
                    )
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('bsform-row','bsform-row-model','container','bsform-grid-row-model','softhide','noppading','margin-left-4','margin-right-4','bg-gray'),
                    'children'  =>  array(
                        array(
                            'tag'       =>  'div',
                            'class'     =>  array('container','nopadding','grid-form'),
                            'children'  =>  array(
                                $bsFormTemplateData,
                                $this->getRowFooter($arrInput),
                            )
                        ),  
                    )
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  $arrTemp['body_class'],
                    'style'     =>  $arrTemp['body_style'],
                    'children'  =>  array(
                          
                    )
                )
            ),
        );        
        
        foreach ($arrInput as $key => $attribute){
            if (!in_array($key, $this->arrNoAttribute)){
                $arrReturn[$key] = string_to_array($attribute);
            }
        }
        
        //add o botao adicionar, se houver permissao
        if(!($arrInput['readonly'] ?? FALSE)){
            $arrReturn['children'][0]['children'][1]['children'][] = $this->getAddButton();
        }
        
        if(is_array($arrInput['value']) AND sizeof($arrInput['value'] ?? NULL)){
            
            $arrTemp['input_class'] = NULL;
                        
            $arrReturn['children'][2]['children'] = $this->getRows($arrTemp,$arrInput['value']);       
        }
        
        
        
        //add o GRID
        $arrInput['no_label'] = TRUE;
        $arrReturn = $this->getDefaultLayout(
            array(
                'input'     =>  $arrInput,
                'children'  =>  $arrReturn,
            )
        );
        
        return $arrReturn;
    }
    
    /**
     * PRIVATES
     */
     
    
    private function getBsFormTemplate($arrProp = array()){
        
        if($this->get('uuid-rows')){
            
            array_unshift($arrProp['inputs'],array(
                'id'    =>  'row_id',
                'type'  =>  'hidden',
            ));
               
        }
        
        $bsform = new BsForm($arrProp);
        
        return $bsform->getHtmlData();
        
    }
}

?>