<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Group_BsFormTemplate_2 extends Group_bsForm_defaults{

    
    function __construct($arrProp = array()){

        parent::__construct();
        
        if($arrProp){
            $this->set($arrProp);
        }
    }

    function getHtmlData($arrInput = array()){
        
        if(!$arrInput){
            $arrInput = $this->get();
        }  
        
        
        $arrInput['template'] = 1;
        $arrInput['no_form_class'] = TRUE;
        $arrInput['no_panel'] = TRUE;
        
        
        $arrInput['inputs'] = $this->getDefaultInputs($arrInput);
        
        $arrReturn = $this->getBody($arrInput);
        
        foreach(($arrInput['tabs'] ?? array()) as $key => $tab){
            $arrInput['tabs'][$key]['id'] = $tab['id'] ?? random_string(); 
        }
        
        
        $arrReturn['children'][] = array(
            'tag'       =>  'div',
            'class'     =>  array('bordered_tabs'),
            'children'  =>  array(
                $this->getTabsHeader($arrInput),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('tab-content','nopadding'),
                    'children'  =>  $this->getTabs($arrInput)
                )
            )
        );
        
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
    
    private function getTabs($arrInput){
        
        $arrReturn = array();
        
        $arrInput['value'] = $arrInput['value'] ?? array();
        
        foreach(($arrInput['tabs'] ?? array()) as $tab){
            
            $keyInputPk = array_search('id',array_column($arrInput['inputs'],'id'));
            
            if($keyInputPk===FALSE){
                continue;
            }
            
            $arrInput['inputs'][$keyInputPk]['value'] = $tab['pk_value'] ?? NULL;
            
            $formValues = NULL;
            foreach($arrInput['value'] as $key => $rowValue){
                
                $keyRowInputPk = array_search('id',array_column($rowValue,'id'));
                
                if($keyInputPk !== FALSE AND $rowValue[$keyRowInputPk]['value'] == $arrInput['inputs'][$keyInputPk]['value']){
                    $formValues = $rowValue;
                    unset($arrInput['value'][$key]);
                }
            }
            
            
            if($formValues){
                foreach($formValues as $inputValue){
                    $keyInput = array_search($inputValue['id'],array_column($arrInput['inputs'],'id'));
                    
                    if($keyInput !== FALSE){
                        $arrInput['inputs'][$keyInput]['value'] = $inputValue['value'];
                    }
                }
            }

            //criando um form a parte, para servir de modelo        
            $bsFormTemplate = new BsForm($arrInput);
            
            $bsFormTemplateData = $bsFormTemplate->getHtmlData()['form'];
            
            $tab['open'] = $tab['open'] ?? FALSE;
            
            $arrReturn[] = array(
                'tag'       =>  'div',
                'id'        =>  'bsform-tab-group-'.$tab['id'],
                'class'     =>  array('bsform-group-row','tab-pane',($tab['open'] ? 'active' : '')),
                'children'  =>  array(
                    array(
                        'tag'       =>  'div',
                        'class'     =>  array('bsform-group-body','container-fluid','nopadding'),
                        'children'  =>  array(
                            $bsFormTemplateData,      
                        )
                    )
                )
            );
        }
        
        
        return $arrReturn;
        
    }
    
    private function getTabsHeader($arrInput){
        
        $arrReturn = array();
        
        foreach(($arrInput['tabs'] ?? array()) as $key => $tab){
            
            $arrReturn[] = array(
                'tag'       =>  'li',
                'class'     =>  array('nav-item',($tab['open']??NULL ? 'active' : '')),
                'children'  =>  array(
                    array(
                        'tag'           =>  'a',
                        'href'          =>  '#bsform-tab-group-'.$tab['id'],
                        'data-toggle'   =>  'tab',
                        'class'         =>  'nav-link',
                        'children'      =>  array(
                            array(
                                'tag'       =>  'span',
                                'class'     =>  array('size-11'),
                                'text'      =>  $tab['label'] ?? NULL
                            )
                        )
                    )
                
                )
            );
            
        }
        
        $arrReturn = array(
            'tag'       =>  'ul',
            'class'     =>  array('nav','nav-tabs'),
            'children'  =>  $arrReturn
        );
        
        return $arrReturn;    
    }
    
}

?>