<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Grid_bsForm_defaults extends Bsform_defaults{
    
    
    protected function getAddButton(){
        $arrData = array(
            'tag'       =>  'a',
            'class'     =>  array('btn','btn-secondary','btn-sm','grid-button-add-row','nopadding','padding-left-2','padding-right-2','size-11'),
            'children'  =>  array(
                array(
                    'tag'       =>  'i',
                    'class'     =>  'fa fa-plus size-10',
                ),
                array(
                    'text'  =>  'Adicionar'
                )
            )
        );
        
        return $arrData;  
    }
    
    protected function getRows($arrInput,$arrValues,$noFooter=FALSE){
        
        $arrDataReturn = array();
        unset($arrInput['id']);
        
        foreach($arrValues as $keyRow => $rowValue){
            
            //replace de _{variable}
            foreach($rowValue as &$value){
                $value['id'] = str_replace('_{variable}_','_',$value['id']??NULL); 
            }
            
            if($rowValue){
 
                foreach($arrInput['inputs'] as &$input){
                    //$input['value'] = $input['text'] = '';
                    
                    $keyInputValue = array_search($input['id'],array_column($rowValue,'id'));
                    
                    if($keyInputValue !== FALSE){
                        $input['value'] = $rowValue[$keyInputValue]['value'] ?? NULL;
                        $input['text'] = $rowValue[$keyInputValue]['text'] ?? NULL;
                        
                    }
                }    
            }
            
            $arrInput['eq'] = $arrInput['eq'] ?? $keyRow;
            $bsForm = new BsForm($arrInput);
            $arrDataReturn[] =  array(
                'tag'       =>  'div',
                'class'     =>  array('bsform-grid-row','bsform-row','bsform-body','container','noppading','margin-left-4','margin-right-4','bg-gray'),
                'children'  =>  array(
                    array(
                        'tag'       =>  'div',
                        'class'     =>  array('container','nopadding','grid-form'),
                        'children'  =>  array(
                            $bsForm->getHtmlData()['form'],
                            ($noFooter ? array() : $this->getRowFooter($arrInput)),
                        )
                    ),
                )
            ); 
            
            
        }
        
        return $arrDataReturn;
    }
    
    protected function getRowFooter($arrInput){
        
        $arrReturn =  array(
            'tag'       =>  'div',
            'class'     =>  'block col-md-24 nopadding',
            'children'  =>  array(
            )
        );
        //add os botoes ordenar e remover, se houver permissao
        if(!($arrInput['readonly'] ?? FALSE)){
            
            $arrReturn['children'][] = array(
                'tag'       =>  'div',
                'class'     =>  array('pull-left','padding-right-4'),
                'children'  =>  array(
                    array(
                        'tag'       =>  'a',
                        'title'     =>  'Arrastar para ordenar',
                        'class'     =>  array('btn','btn-sm','btn-secondary','size-11','noborder','grid-button-order-row'),
                        'children'  =>  array(
                            array(
                                'tag'       =>  'i',
                                'class'     =>  'fa fa-reorder',
                            )
                        )
                    )
                )
            );
            
            
            $arrReturn['children'][] = array(
                'tag'       =>  'div',
                'class'     =>  array('pull-right','padding-right-4'),
                'children'  =>  array(
                    array(
                        'tag'       =>  'a',
                        'title'     =>  'Remover grupo de dados',
                        'class'     =>  array('btn','btn-sm','btn-secondary','size-11','grid-button-remove-row'),
                        'children'  =>  array(
                            array(
                                'tag'       =>  'i',
                                'class'     =>  'fa fa-trash',
                            )
                        )
                    )
                )
            );
        }
        return $arrReturn;
           
    }
}
?>