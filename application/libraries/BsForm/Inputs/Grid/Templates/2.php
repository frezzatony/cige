<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Grid_BsFormTemplate_2 extends Grid_bsForm_defaults{

    
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
        
        if(!($arrInput['tabs']??NULL)){
           return array();
            
        }
        
        $tempForm = $arrInput;
          
        $tempForm['template'] = 1;
        $tempForm['no_form_class'] = TRUE;
        $tempForm['no_panel'] = TRUE;
        

        $tempForm['grid_class'] = array('child','bsgrid-row-child');
        $tempForm['body_class'] = $tempForm['body_class'] ?? array();
        append($tempForm['body_class'],array('bsform-grid-body','container-fluid','nopadding','padding-top-6'));
        $tempForm['body_style'] = $tempForm['body_style'] ?? array();
        
        $arrTabs = array(
            'class' =>  array('bsform-grid-body','nopadding'),
            'nodes' =>  array()
        );       
        
        foreach($arrInput['tabs'] as $key => $tab){
            $tempForm['eq'] = $key;
            $paneData = $this->getRows($tempForm,array(($arrInput['value'][$key]??NULL)),TRUE);
            
            $arrTabs['nodes'][] = array(
                'tab'   =>  $tab,
                'pane'  =>  array(
                    'children'  =>  $paneData   
                )
            );
                   
        }
        
        
        //cria tabs
        $bootstrap = new Bootstrap;
        $bootstrap->tabs($arrTabs);
         
        
        $arrReturn = array(
            'tag'       =>  'div',
            'id'        =>  $this->getInputId($arrInput),
            'class'     =>  array('bsform-grid','bsform-grid-template-2','container-fluid','nopadding'),
            'children'  =>  $bootstrap->getHtmlData(),
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
     
    
}

?>