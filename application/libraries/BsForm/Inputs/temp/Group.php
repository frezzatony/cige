<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group_bsform extends Bsform_defaults
{

    protected $CI;

    function __construct()
    {

        parent::__construct();
        $this->CI = &get_instance();

    }

    public function getInputDataHtml($arrInput = array())
    {
       
        $arrInput['id'] = $this->getInputId($arrInput);
        
        //criando um form a parte, para gerar os inputs filhos
        $form = new form;
        $form->setNew(
            array(
                'no_panel'  =>  true,
                'method'    => $arrInput['method'],
                'inputs'    =>  $arrInput['inputs']
            )
        );
        $arrValues = $this->getInputValue($arrInput); 
        
        $arrValues = $this->CI->datagroup->getRemoveParentName(
            array(
                'parent_name'   =>  $form->query->group->getColumnValueName($arrInput),
                'data'          =>  $arrValues
            )
        );
        
        
        foreach($arrValues as $keyChild => $childValue){
            
            unset($arrValues[$keyChild]);
            
            $keyInput = str_replace($form->query->getColumnValueName($arrInput).'_','',$keyChild);    
            
            $arrValues[$keyInput] = $childValue;
                
            
        }
        $form->setValues($arrValues);
        
        //montando o header do Panel
        $arrReturn = array(
            'tag' => 'div',
            'class' => 'panel panel-primary bordered panel-group',
            'id' => $arrInput['id'],
            'children' => array(
                array(
                    'tag' => 'div',
                    'class' => 'panel-heading text-semi-black bg-gray',
                    'children' => array(
                        array(
                            'tag' => 'span',
                            'class' => 'panel-title size-13 bolder',
                            'text' => $arrInput['label'],
                        ),
                        array(
                            'tag' => 'ul',
                            'class' => 'nav navbar-right panel_toolbox',
                        ),
                    )
                ),
                array(
                    'tag' => 'div',
                    'class' => 'panel-body bordered',
                    'children' => array(
                        array(
                            'text'  =>  $form->getFormHtml()
                        )
                    )
                ),
            )
        );

        $arrInput['no_label'] = true;
        //add o GRID
        if (!isset($arrInput['no_grid']) || !$arrInput['no_grid'])
        {
            $arrReturn = $this->getDefaultLayout(array(
                'input' => $arrInput,
                'children' => $arrReturn,
                ));
        }
        return $arrReturn;
    }
    
    function getInputValue($arrInput = array())
    {
        
        return $arrInput['value'][0] ?? array();

    }

    /**
     * PRIVATES
     */
     
}

?>