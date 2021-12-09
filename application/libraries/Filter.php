<?php

/**
 * @author Tony Frezza

 */

class Filter extends Data{

    
    
    function __construct($arrProp = array())    {
        
        parent::__construct($arrProp);
        
        $this->CI->config->load('filter', TRUE);
                
        $directory = dirname(__FILE__).'/Filter/';
        
        require_once($directory.'Filter_inputs_defaults.php');
        $this->_scanInputDirectory($directory.'Inputs/');
        
        require_once($directory.'Filter_typeforms_defaults.php');
        $this->_scanInputDirectory($directory.'TypeForms/');
                
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/filter/css/filter.css');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/filter/js/filter.js');
        
    }
    
    public function getAsText($arrProp = array()){
        
        if($arrProp){
            $this->set($arrProp);
        }    
        
        $strReturn = '';
        
        $query = new Query();
        
                
        foreach($this->get('dynamic_filters') as $filter){
            
            $strReturn .= ($strReturn ? ' / ' : '');
            
            if(!($filter['id']??NULL)){
                continue;
            }
            
            $variable = $this->get('variables')->get($filter['id']);
            
            $variable->set(array('value'=>$filter['value']??NULL));
            $variable->updateRelacionalValue();
            
            $strReturn .= $this->get('variables')->get($filter['id'].'.label');
            
            $objName = ($filter['clause']??NULL).'_clauses';            
            if(property_exists($query,$objName)){
                $optionsInput = $query->{$objName}->getOptionsInput();
                $strReturn .= ' '.$optionsInput['text'];      
            }
            
            
            
            if(is_array($variable->get('value')??NULL)){
                foreach($variable->get('value') as $key => $val){
                    
                    if($key>0){
                        $strReturn.= ' e';
                    }
                    
                    $strReturn .= ' '.$val;
                    
                    
                }
            }
            else{
                
                $value = $variable->get('value');
                $value = $variable->get('text') ?$variable->get('text') : $value;
                
                $strReturn .= ' ' . ($value??'\'NULL\'');    
            }
            
        }
        
        
        return $strReturn;
        
    }
    
    public function getHtml(){
        
        $html = new Html;
        
        $idHeader = $html->add(
            array(
                'tag'           =>  'div',
                'class'         =>  array('col-lg-24','nopadding','filter-header','card-header','padding-left-6'),
                'children'      =>  array(
                    array(
                        'tag'       =>  'i',
                        'class'     =>  'fa fa-search margin-left-6 nomargin',
                    ),
                    array(
                        'tag'       =>  'span',
                        'class'     =>  'size-12',
                        'text'      =>  'Localizar itens'
                    )
                )
            )
        );
        
        $idBody = $html->add(
            array(
                'tag'           =>  'div',
                'class'         =>  array('filter-body card-block row padding-bottom-6'),
            )
        );
               
        $idLeftColumn = $html->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('col-lg-20','padding-top-6 padding-bottom-6','nopadding','filter-column-filters'),
                'parent_id' =>  $idBody
            )
        );
        
        $idRightColumn = $html->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('col-lg-4','padding-top-4','nopadding','filter-column-rightbuttons'),
                'parent_id' =>  $idBody
            )
        );
        
        $idButtonsGroup = $html->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-right',
                'parent_id' =>  $idRightColumn,
            )
        );
        
        $idRowFixedFilters = $html->add(
            array(
                'tag'           =>  'div',
                'parent_id'     =>  $idLeftColumn,
                'class'         =>  array('col-lg-24','nopadding','filter-fixed-filters'),
            )
        );
        
        $idRowDinamicFilters = $html->add(
            array(
                'tag'           =>  'div',
                'class'         =>  array('col-lg-24','nopadding','filter-dinamic-filters'),
                'parent_id'     =>  $idLeftColumn,
            )
        );
        
        
        $idColumnDinamicFilters = $html->add(
            array(
                'tag'           =>  'div',
                'class'         =>  array('col-md-14','nopadding','filter-column-left'),
                'parent_id'     =>  $idRowDinamicFilters,
            )
        );
        
        
        $idColumnButtons = $html->add(
            array(
                'tag'           =>  'div',
                'class'         =>  array('col-md-10','nopadding','filter-column-right'),
                'parent_id'     =>  $idRowDinamicFilters,
            )
        );
        
        $HtmlDataRowModel = $this->_getRowModel();
        $HtmlDataRowModel['parent_id'] = $idColumnDinamicFilters;
        
        $idRowModel = $html->add($HtmlDataRowModel);
        
        $idGroupButtonsActions = $html->add($this->_getActionsButtons($idColumnButtons));
         
        $idFirstRow = $html->add($this->_getFixedRows($idColumnDinamicFilters));
               
        return $html->getHtml();
                
    }
    
    private function _getActionsButtons($parentId){
        
        $arrHtmlData = array(
            'tag'           =>  'div',
            'class'         =>  array('btn-group',),
            'role'          =>  'group',
            'parent_id'     =>  $parentId,
            'children'      =>  array(
                 array(
                    'tag'       =>  'a',
                    'class'     =>  array('btn','btn-primary-outline','btn-sm','nomargin','filter-btn-search'),
                    'text'      =>  '<i class="fa fa-search"></i> Pesquisar'
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('btn-group'),
                    'role'      =>  'group',
                    'children'  =>  array(
                        array(
                            'tag'       =>  'div',
                            'class'     =>  array('btn-group'),
                            'children'  =>  array(
                                array(
                                    'tag'           =>  'a',
                                    'class'         =>  'btn btn-primary-outline btn-sm dropdown-toggle nomargin ',
                                    'data-toggle'   =>  'dropdown',
                                ),
                                array(
                                    'tag'       =>  'ul',
                                    'class'     =>  array('dropdown-menu'),
                                    'children'  =>  array(
                                        array(
                                            'tag'       =>  'li',
                                            'class'     =>  'size-11 ',
                                            'children'  =>  array(
                                                array(
                                                    'tag'       =>  'a',
                                                    'class'     =>  array('dropdown-item','filter-btn-add-filter-row'),
                                                    'children'  =>  array(
                                                        array(
                                                            'tag'   =>   'i',
                                                            'class' =>  array('fa fa-plus')
                                                        ),
                                                        array(
                                                            'tag'   =>  'span',
                                                            'text'  =>  'Adicionar filtro'
                                                        ),
                                                    )
                                                ),
                                                array(
                                                    'tag'       =>  'a',
                                                    'class'     =>  array('dropdown-item','filter-btn-reset'),
                                                    'children'  =>  array(
                                                        array(
                                                            'tag'   =>   'i',
                                                            'class' =>  array('fa fa-asterisk')
                                                        ),
                                                        array(
                                                            'tag'   =>  'span',
                                                            'text'  =>  'Reiniciar pesquisa'
                                                        ),
                                                    )
                                                ),
                                            )
                                        ),
                                    )
                                )
                            ),
                        ),
                    ),
                )
            )
        );
        
        return $arrHtmlData;
    }
    private function _getClauseListHtmlData($filterClauses=array(),$inputOption){
        
        $arrHtmlData = array(
            'tag'                   =>  'select',
            'class'                 =>  array('form-control','input-sm','padding-3','size-11','height-24','filter-clause-selector'),
            'data-default-value'    =>  ($inputOption['clause'] ?? NULL),
            'data-last-value'       =>  ($inputOption['clause'] ?? NULL),
            'children'              =>  array()
        );
        
        $query = new Query();
        
        foreach($this->CI->config->item('clauses','filter') as $clause){
            
            if($filterClauses AND in_array($clause,$filterClauses)===FALSE){
                continue;
            }
            
            $objName = $clause.'_clauses';
            
            if(property_exists($query,$objName)){
                $optionsInput = $query->{$objName}->getOptionsInput();
                $optionsInput['tag'] = 'option';
                if($optionsInput['value']==($inputOption['clause']??NULL)){
                    $optionsInput['selected'] = 'selected';
                }
                
                $arrHtmlData['children'][] = $optionsInput;    
            }
        }
        
        return $arrHtmlData;
    }
    
    private function _getColumnsTypeForms_One(){
        
        $arrHtmlData = array(
            'tag'           =>  'div',
            'class'         =>  array('col-xs-24','col-sm-24','col-md-24','col-lg-24','nopadding','nomargin','filter-typeform-column-1'),
            'children'      =>  array(
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-xs-24','col-sm-24','col-md-24','col-lg-24','nopadding','nomargin','filter-typeform-column'),
                )            
            )
        );
        
        return $arrHtmlData;
    }
    
    private function _getColumnsTypeForms_Two(){
        
        $arrHtmlData = array(
            'tag'           =>  'div',
            'class'         =>  array('col-xs-24','col-sm-24','col-md-24','col-lg-24','nopadding','nomargin','filter-typeform-column-2'),
            'children'      =>  array(
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-xs-11','col-sm-11','col-md-11','col-lg-11','nopadding','nomargin','filter-typeform-column'),
                ), 
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-xs-2','col-sm-2','col-md-2','col-lg-2','nopadding','nomargin','size-12','text-centered','padding-top-4'),
                    'text'      =>  'e'
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-xs-11','col-sm-11','col-md-11','col-lg-11','nopadding','nomargin','filter-typeform-column'),
                ),           
            )
        );
        
        return $arrHtmlData;
        
    }
    
    private function _getColumnsTypeForms_Zero(){
        
        $arrHtmlData = array(
            'tag'           =>  'div',
            'class'         =>  array('col-xs-24','col-sm-24','col-md-24','col-lg-24','nopadding','nomargin','filter-typeform-column-0','height-24'),
            'children'      =>  array()
        );
        
        return $arrHtmlData;
    }
    
    private function _getFixedRows($parentId){
        
        $arrHtmlData = array(
            'parent_id'     =>  $parentId,
            'children'      =>  array()
        );
        
        $arrFilters =  $this->get('dynamic_filters') ?? NULL;
        if(!$arrFilters){
            $arrFilters = array(array_values($this->get('data'))[0]->get('id'));
        }
        
        
        foreach($arrFilters as $key=>$input){
            
            $arrDataRow = $this->_getRowModel($input);            
            
            
            if (($keySearch = array_search('filter-row-inputs-model',$arrDataRow['class'])) !== false) {
                unset($arrDataRow['class'][$keySearch]);
            }
            if (($keySearch = array_search('softhide',$arrDataRow['class'])) !== false) {
                unset($arrDataRow['class'][$keySearch]);
            }

            $arrDataRow['class'] = $this->CI->common->append($arrDataRow['class'],array('filter-row-fixed','col-lg-24'));
            //remove botao remove-row
            if($key==0){
                unset($arrDataRow['children'][3]);    
            }
            
                 
            //input selecionado
            $keyInput = array_search($input,array_column($arrDataRow['children'][0]['children'][0]['children'],'value'));
            
            if($keyInput===FALSE){
                $keyInput = 0;
            }
            
            $optionInput = $arrDataRow['children'][0]['children'][0]['children'][$keyInput] ?? NULL;
            
            if(!$optionInput){
                continue;
            }
            $arrDataRow['children'][0]['children'][0]['children'][$keyInput]['selected'] = 'selected';
            $optionInputTypeForm = $optionInput['data-input-type'];
            $optionInputClauses = explode(',',$optionInput['data-operators']);
            //fim input selecionado
            
            
            //option clauses
            $optionClauses = $arrDataRow['children'][1]['children'][0];
            foreach($optionClauses['children'] as $key => $option){
                if(in_array($option['value'],$optionInputClauses)===FALSE){
                    unset($arrDataRow['children'][1]['children'][0]['children'][$key]);
                }       
            }
            $arrDataRow['children'][1]['children'][0]['children'] = array_values($arrDataRow['children'][1]['children'][0]['children']);
            $optionClausesNumColumns =  $arrDataRow['children'][1]['children'][0]['children'][0]['data-num-cols-input'] ?? 1;
            //fim option clauses
            
            $keyColumnTypeForms = 3;
            $keyColumnZeroColumns = 0;
            $keyColumnOneColum = 1;
            $keyColumnTwoColumns = 2;
            
            
            //typeform
            $inputsTypeForms = $arrDataRow['children'][2]['children'][3]['children'];
            
            foreach($inputsTypeForms as $key => $typeForm){
                if($typeForm['children'][0]['data-input'] == $optionInputTypeForm){
                    $inputsTypeForms = $typeForm;
                } 
                unset($arrDataRow['children'][2]['children'][2]['children'][$key]);
            }
            unset($arrDataRow['children'][2]['children'][$keyColumnTypeForms]); //remover a linha dos typeForms
            //fim typeform
                        
            //columns
            if($optionClausesNumColumns == 0){
                //remove outras colunas
                unset($arrDataRow['children'][2]['children'][$keyColumnOneColum]);
                unset($arrDataRow['children'][2]['children'][$keyColumnTwoColumns]);
                $arrDataRow['children'][2]['children'] = array_values($arrDataRow['children'][2]['children']);
                
                $arrDataRow['children'][2]['children'][0]['children'][0]['children'] = array(
                    $inputsTypeForms
                );
            }
            else if($optionClausesNumColumns == 1){
                //remove outras colunas
                unset($arrDataRow['children'][2]['children'][$keyColumnZeroColumns]);
                unset($arrDataRow['children'][2]['children'][$keyColumnTwoColumns]);
                $arrDataRow['children'][2]['children'] = array_values($arrDataRow['children'][2]['children']);
                
                $arrDataRow['children'][2]['children'][0]['children'][0]['children'] = array(
                    $inputsTypeForms
                );
            }
            else{
                //remove outras colunas
                unset($arrDataRow['children'][2]['children'][$keyColumnZeroColumns]);
                unset($arrDataRow['children'][2]['children'][$keyColumnOneColum]);
                $arrDataRow['children'][2]['children'] = array_values($arrDataRow['children'][2]['children']);
                
                $arrDataRow['children'][2]['children'][0]['children'][0]['children'] = array(
                    $inputsTypeForms
                );
                $arrDataRow['children'][2]['children'][0]['children'][2]['children'] = array(
                    $inputsTypeForms
                );
            }
            //fim columns
            $arrHtmlData['children'][] = $arrDataRow;
        }
        
        
        
        
        
        return $arrHtmlData;
                
    }
    private function _getInputsTypeFormsHtmlData($arrData = NULL,$arrDataReturn = NULL,$variableParent = NULL){
        
        if(!$arrDataReturn){
            $arrDataReturn = array(
                'children'      =>  array()
            );    
        }
        
        if(!$arrData){
            
            $arrData = $this->get('data');
        }
        
        $arrInputsFormWithData = $this->CI->config->item('input_type_forms_with_data','filter');
        
        foreach($arrData as $variable){
            
            $variableInputType = $variable->inputType;
            
            if($variable->get('filter_configs.input_type')){
                $variableInputType = $variable->get('filter_configs.input_type');
            }
            else if(is_array($variableInputType)){
                
                $keyType = array_search($variable->get('filter_configs.input_type') ?? $variableInputType[0], $variableInputType);
                $variableInputType = $variableInputType[$keyType];
            }
            
                       
            if(($variable->variables ?? NULL) && $variable->get('from.variables')===NULL){
                
                $arrDataReturn = self::_getInputsTypeFormsHtmlData($variable->variables->get(),$arrDataReturn,$variable);                
            }
            else if(in_array($variableInputType,$arrInputsFormWithData) AND ($variable->get('filter_configs.from.search') ?? 'value') == 'value'){
                
                $className  = $variableInputType.'_typeform_filter';
                
                if(class_exists($className) === FALSE){
                    $className = 'dropdown'.'_typeform_filter';
                }
                
                $tmpInputTypeForm = new $className($variable->get());
                
                $arrDataReturn['children'][] =  $tmpInputTypeForm->getFormHtmlData()['form'];
                
                
                 
            }
            else if(
                array_key_exists($variableInputType,$arrDataReturn['children'])==FALSE AND
                in_array($variableInputType,$this->CI->config->item('input_type_forms','filter'))
            ){
                
                $className  = $variableInputType.'_typeform_filter';
                
                if(class_exists($className) === FALSE){
                    continue;
                }
                
                $tmpInputTypeForm = new $className();
                //$arrDataReturn['children'][$variableInputType] =  $tmpInputTypeForm->getFormHtmlData()['form'];
                $arrDataReturn['children'][$variableInputType] =  $tmpInputTypeForm->getFormHtmlData()['form'];
            }

            
        }
        
        return $arrDataReturn;
        
    }
    
    private function _getInputsOptionListHtmlData($inputOption=NULL,$arrData = NULL,$variableParent = NULL){
        
        $arrHtmlData = array(
            'tag'                   =>  'select',
            'class'                 =>  array('form-control','input-sm','padding-3','size-11','height-24','filter-input-selector'),
            'data-default-value'    =>  ($inputOption['id'] ?? NULL),
            'data-default-clause'   =>  ($inputOption['clause'] ?? NULL),
            'data-last-value'       =>  ($inputOption['id'] ?? NULL),
            'children'              =>  array()
        );
        
        if($arrData == NULL){
            $arrData = $this->get('data');
        }
        
        foreach($arrData as $variable){
            
            $variableInputType = $variable->inputType;
            
            if($variable->get('filter_configs.input_type')){
                $variableInputType = $variable->get('filter_configs.input_type');
            }
            else if(is_array($variableInputType)){
                $keyType = array_search($variable->get('filter_configs.input_type') ?? $variableInputType[0], $variableInputType);
                $variableInputType = $variableInputType[$keyType];
                
                
            }
            
            if(!isset($this->{$variableInputType}) OR $variable->get('no_filter')){
                continue;
            }
            
            if($variableParent AND !$variable->get('parent')){
                $variable->set('parent',$variableParent);
                
                $variable->set('id',
                    $variableParent->get('id').'.'.
                    $variable->get('id')
                );
                
            }
            
            $optionsInput = $this->{$variableInputType}->getOptionsInput($variable,$variableParent);
            
            if(in_array($variableInputType,$this->CI->config->item('input_type_forms_with_optgroup','filter'))){
                
                                
                $optionsInput['tag'] = 'optgroup'; 
                
                if($variable->get('parent')){
                    $optionsInput['label'] = $variableParent->get('label').' - ' . $optionsInput['label'];
                    
                }
                
                $childrenVariables = $variable->get('from') ? $this->CI->modules->getVariables($variable->get('from')) : $variable->variables;
                                
                $arrHtmlInput = self::_getInputsOptionListHtmlData($inputOption,$childrenVariables->get(),$variable); 
                $optionsInput['children'] = $arrHtmlInput['children'];
                
            }
            else{
                
                $optionsInput['tag'] = 'option';
                $optionsInput['data-mask'] = $variable->get('mask') ?? NULL;
                if(($optionsInput['value']??NULL)==($inputOption['id']??NULL)){
                    $optionsInput['selected'] = 'selected';
                    $optionsInput['data-value'] = $inputOption['value'] ?? NULL;
                    
                }    
            }
            $arrHtmlData['children'][] = $optionsInput;
        }
        
        return $arrHtmlData;
    }
    
    private function _getOperatorsHtmlData($parentId){
        
        $bsForm = new BsForm($this->CI->config->item('operator_form','filter'));
        
        $arrHtmlData = $bsForm->getHtmlData()['form'];
        $arrHtmlData['parent_id'] = $parentId;
        
        return $arrHtmlData;
        
    }
    
    private function _getRowModel($inputOption=NULL){
        $arrHtmlData = array(
            'tag'       =>  'div',
            'class'     =>  array('margin-bottom-3', 'nopadding','filter-row-inputs','filter-row-inputs-model','softhide',), //softhide
            'children'  =>  array(
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-xs-7 col-sm-7 col-md-7 col-lg-7','nopadding','margin-right-6'),
                    'children'  =>  array(
                        $this->_getInputsOptionListHtmlData($inputOption)
                    )                   
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-xs-6 col-sm-6 col-md-6 col-lg-6','nopadding','margin-right-6'),
                    'children'  =>  array(
                        $this->_getClauseListHtmlData(array(),$inputOption)
                    )
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-xs-9 col-sm-9 col-md-9 col-lg-9','nopadding','filter-typeforms'),
                    'children'  =>  array(
                        $this->_getColumnsTypeForms_Zero(),
                        $this->_getColumnsTypeForms_One(),
                        $this->_getColumnsTypeForms_Two(),
                        $this->_getInputsTypeFormsHtmlData() 
                    )
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('col-xs-1 col-sm-1 col-md-1 col-lg-1','nopadding'),
                    'children'  =>  array(
                        array(
                            'tag'       =>  'a',
                            'class'     =>  array('btn','btn-sm','color-red','bordered','size-8','filter-btn-remove-filter'),
                            'title'     =>  'Remover filtro',
                            'text'      =>  '<i class="fa fa-minus"></i>',
                        )
                    )
                )
            ),
        );
        
        return $arrHtmlData;
        
    }
    
    private function _scanInputDirectory($directory){
        
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
       
        foreach($scanned_directory as $input_file){
            
            if(is_dir($directory.$input_file)){
                continue; 
            } 
            
            require_once($directory.$input_file);
            
            $objectName = preg_replace('/.php/', '', $input_file);
            $className = $objectName.'_filter';
            
            $this->{strtolower($objectName)} = new $className;
            
        }   
    }
}

?>
