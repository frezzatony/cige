<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Group_bsForm_defaults extends Bsform_defaults{
    
    protected function getDefaultInputs($arrInput){

        $arrInput['inputs'] = $arrInput['inputs'] ?? array();
        $arrIdsInputs = array_column($arrInput['inputs']['id'] ?? array(),'id'); 
        
        if(!in_array('id',$arrIdsInputs)){
            $arrInput['inputs'][] = $this->getInputPk($arrInput);
        }
        
        return $arrInput['inputs'];        
        
    }
    
    protected function getBody($arrInput){
        
        $arrReturn = array(
            'tag'       =>  'div',
            'id'        =>  $arrInput['id'],
            'class'     =>  array('bsform-group','container-fluid','nopadding'),
            'children'  =>  array(
                
            ) 
        );
        
        
        return $arrReturn;    
        
    }
    
    protected function getHeader($arrInput){
        
        
        if(!($arrInput['label'] ?? NULL)){
            return array();
        }
        
        $buttonCollapseIcon = ($arrInput['open'] ?? FALSE) ? 'minus' : 'angle-down';
        return array(
            'tag'       =>  'div',
            'class'     =>  array('bsform-group-header','card-header','nopadding','padding-left-6','bg-gray'),
            'children'  =>  array(
                array(
                    'tag'       =>  'span',
                    'class'     =>  array('size-11','color-black','bold'),
                    'text'      =>  $arrInput['label']
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('pull-right'),
                    'children'  =>  array(
                        array(
                            'tag'       =>  'a',
                            'class'     =>  array('btn','btn-secondary','btn-sm','group-button-collapse','nopadding','padding-left-2','padding-right-2','size-11'),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'i',
                                    'class'     =>  array('fa','size-10',' fa-'.$buttonCollapseIcon),
                                ),
                            )
                        )
                    )
                )
            )
        );
    }
    
    protected function getInputPk($arrInput){
        
        
        $arrReturn = array(
            'type'          =>  'hidden',
            'id'            =>  'id',
            'value'         =>  $arrInput['pk_value'] ?? 1,    
            
        ) ;
       
        return $arrReturn;    
    }
    
}
?>