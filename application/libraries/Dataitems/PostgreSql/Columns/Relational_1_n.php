<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relational_1_n_Columns_PostgreSql extends Columns_PostgreSql_defaults{
    
    protected $CI;
    private $character;
    
    function __construct($arrProp = array()){
        $this->CI = &get_instance();   
        $this->set($arrProp);
        $this->character = new Character_Variables($arrProp);
    }
    
    
    public function getSelectData(){
        
        $arrDataReturn = array(
            'base_select'   =>  array(
                'select'        =>  array(),
                'where'         =>  array(),
                'or_where'      =>  array(),
                'group_by'      =>  array(),
            ),
            'with'          =>  array(),
        );
        
        
        
        if($this->get('options')){
            $arrDataReturn = $this->getSelectDataOptions($arrDataReturn);
        }
        else if($this->get('from')){            
            $arrDataReturn = $this->getSelectDataFrom($arrDataReturn);  
        }
        
        return $arrDataReturn;
    }
    
    
    public function getUpdateData(){
        
        $value = $this->character->getValue();              
        $arrDataReturn = array(
            'set'   =>  array(
                array(
                    'column'    =>  $this->getColumnName(),
                    'value'     =>  ($value!=NULL ? $value : 'DEFAULT'),
                    'escape'   =>   ($value ? TRUE : NULL)
                )
            ),
            'where' =>  array(), 
        );
        
        
        return $arrDataReturn; 
    }

    
    /**
     * 
     * PRIVATES
     **/
     
    
    private function getSelectDataFrom($arrDataReturn){
        
        $className = $this->get('from.module');
         
        $module = new $className(
            array(
                'requests_id'   =>  array($this->get('from.request')),
                'is_child'      =>  TRUE,
            )
        );
        
        $data = $module->get('data');
        
        if(array_key_exists('schema',$data)===FALSE){
            $data['schema'] = $className;
        }
        
        $dataVariablesPreservId = array_merge(
            array_values($this->get('from.value')),
            array_values($this->get('from.text'))   
        );
        
        $dataVariablesPreservId = array_merge(
            $dataVariablesPreservId,
            array_values($this->get('from.variables') ?? array())   
        );
        
       
        
        foreach($data['variables'] as $key=>$variable){
            if(!in_array($variable['id'],$dataVariablesPreservId)){
                unset($data['variables'][$key]);
            }
        }
        
        
        $dataitems = new DataItems(
            array(
                'data'      =>  $data,
                'filters'   =>  ($this->get('filters') ?? NULL),
                'order'     =>  ($this->get('order') ??  NULL),
                'limit'     =>  ($this->get('limit') ??  NULL),
            )
        );
        
        $arrDataSelect = $dataitems->getDataSelect();
        
        $strAs = $this->get('parent.column_alias') ? $this->get('parent.column_alias').'_' : '';
               
        $tableJoinAs = '"' . $arrDataSelect['from']['as'].'"';
        $tableJoin = $arrDataSelect['from']['db_schema'].'.'.$arrDataSelect['from']['table'].' AS '.$tableJoinAs;
        $tableJoinOn = '"'.$this->get('parent.table_alias').'".'.$this->get('column').' = "'.$arrDataSelect['from']['as'].'".id';
        
        //column VALUE
        $strSelectValue = '';
        foreach($this->get('from.value') as $column){
            if(is_array($column)){
                continue;
            }
            
            if($strSelectValue){
                $strSelectValue .= ',';
            }
            //$strSelectValue .= $tableJoinAs.'.'.$column;
            if($module->variables->get($column)){
                $strSelectValue .= $tableJoinAs.'.'.$module->variables->get($column)->get('column');    
            }
        }
        //FIM column VALUE
        
        //column TEXT
        $strSelectText = '';
        foreach($this->get('from.text') as $column){
            if(is_array($column)){
                continue;
            }
            
            if($strSelectText){
                $strSelectText .= ',';
            }
            
            if($module->variables->get($column)){
                $strSelectText .= $tableJoinAs.'.'.$module->variables->get($column)->get('column');    
            }
            
            
        }
        //FIM column TEXT
        
        if($strSelectValue){
            $arrDataReturn['base_select']['select'][] = array(
                'column'    =>  $strSelectValue,
                'as'        =>  $strAs.$this->getColumnValueName($this->get()),
            );    
        }
        if($strSelectText){
            $arrDataReturn['base_select']['select'][] = array(
                'column'    =>  $strSelectText,
                'as'        =>  $strAs.$this->getColumnTextName($this->get()),
            );    
        }
        
        $arrDataReturn['base_select']['join'][] = array(
            'table'     =>  $tableJoin,
            'on'        =>  $tableJoinOn ,
            'type'      =>  'LEFT',
            'escape'    =>  FALSE
        );
        
        $arrDataReturn['base_select']['group_by'][] = '"'.$arrDataSelect['from']['as'].'".id';
        
        append($arrDataReturn['base_select']['join'], $arrDataSelect['join']);
        append($arrDataReturn['base_select']['group_by'],$arrDataSelect['group_by']);
        append($arrDataReturn['with'],$arrDataSelect['with']);
        
         //VARIAVEIS EXTRAS 
        if($this->get('from.variables')){
            
            foreach($this->get('from.variables') as $variable){
                if(is_array($variable)){
                    continue;
                }
                  
                //VALUE DE VARIABLES
                $keyColumnVariableValue = array_search($variable.'_value',array_column($arrDataSelect['select'],'as'));
                if($keyColumnVariableValue !== FALSE){
                    
                    
                    $strColumnValueAs = $strAs.$this->getColumnVariableName($this->get());
                    $strColumnValueAs .= '_'.$this->getColumnValueName(
                        array(
                            'id'        =>  $variable
                        )
                    );
                    
                    $strColumn = $arrDataSelect['select'][$keyColumnVariableValue]['column'];
                    $strTableAs = '"' . $arrDataSelect['from']['as'].'".';
                    
                    if(strpos($strColumn,'".')===FALSE){
                        $strColumn = $strTableAs.$strColumn;
                    }
                    
                    
                    //'column'    =>  '"' . $arrDataSelect['from']['as'].'".'.$arrDataSelect['select'][$keyColumnVariableValue]['column'],
                    $arrDataReturn['base_select']['select'][] = array(
                        'column'    =>  $strColumn,
                        'as'        =>  $strColumnValueAs,
                    );
                    
                }
                //FIM VALUE DE VARIABLES
                
                //TEXT DE VARIABLES
                $keyColumnVariableText = array_search($variable.'_text',array_column($arrDataSelect['select'],'as'));
                if($keyColumnVariableText !== FALSE){
                    $strColumnValueAs = $strAs.$this->getColumnVariableName($this->get());
                    $strColumnValueAs .= '_'.$this->getColumnTextName(
                        array(
                            'id'        =>  $variable
                        )
                    );
                    
                    //'column'    =>  '"' . $arrDataSelect['from']['as'].'".'.$arrDataSelect['select'][$keyColumnVariableText]['column'],
                    
                    $strColumn = $arrDataSelect['select'][$keyColumnVariableText]['column'];
                    $strTableAs = '"' . $arrDataSelect['from']['as'].'".';
                    
                    if(strpos($strColumn,'".')===FALSE){
                        $strColumn = $strTableAs.$strColumn;
                    }
                    
                    
                    $arrDataReturn['base_select']['select'][] = array(
                        'column'    =>  $strColumn,
                        'as'        =>  $strColumnValueAs,
                    );
                }
                //FIM TEXT DE VARIABLES  
                
                //VARIAVEIS FILHAS
                if($this->get('id')=='controller_acao'){
                    foreach($arrDataSelect['select']??array() as $select){
                        $strAsVariable = $variable.'_{variable}_';
                        
                        if(substr(($select['as']??NULL),0,(strlen($strAsVariable)))==$strAsVariable){
                            $select['as'] = $this->getColumnVariableName($this->get()).'_'.$select['as'];
                            $arrDataReturn['base_select']['select'][] = $select;
                        }    
                    }
                }
                //FIM VARIAVEIS FILHAS
            }          
        }
        //FIM VARIAVEIS EXTRAS
        
        if($this->get('filters')){
            
            $arrFilters = $this->get('filters');
            
            foreach($arrFilters as $keyFilter => $filter){
                if(($filter['search']??NULL)){
                                        
                    switch($filter['search']){
                        case 'text':{
                            $this->set('filters',array($filter));
                            $arrDataReturn = $this->getSelectWhereByText($arrDataReturn,$module,$tableJoinAs);
                            break;
                        }
                        default:{
                            $this->set('filters',array($filter));
                            $arrDataReturn = $this->getSelectWhereByValue($arrDataReturn,$module,$tableJoinAs);
                            break;
                        }
                    }
                    unset($arrFilters[$keyFilter]);
                }
            }
            
            $this->set('filters',$arrFilters);
                        
            if($this->get('filter_configs.from.search')=='text'){
                $arrDataReturn = $this->getSelectWhereByText($arrDataReturn,$module,$tableJoinAs);
            }
            else{
                $arrDataReturn = $this->getSelectWhereByValue($arrDataReturn);   
            }
        }
        
        
        return $arrDataReturn;
        
    }
    
    private function getSelectDataOptions($arrDataReturn){
        
        if($this->get('filters')){
            $arrDataReturn = $this->getSelectWhereByValue($arrDataReturn);
        }
        
        $strWithSelect = '';
        foreach($this->get('options') as $option){
            
            if(!$option){
                continue;
            }
            
            if($strWithSelect){
                $strWithSelect .= "\n".'UNION' ."\n";
            }
            
            $strWithSelect .= 'SELECT \''.$option['value']. '\'::TEXT as "_value", \''. ($option['text']).'\'::TEXT as "_text"';
        }
        
        $withAlias = '_'.$this->get('id').'_'.random_string();
        
        $arrDataReturn['with'][]= array(
            'alias' =>  $withAlias,
            'query' =>  $strWithSelect,
        );
        
        $tableJoinOn = '"'.$this->get('parent.table_alias').'".'.$this->get('column') .'::TEXT = "'.$withAlias.'"."_value"::TEXT';
        $arrDataReturn['base_select']['join'][] = array(
            'table'     =>  '"'.$withAlias.'"',
            'on'        =>  $tableJoinOn ,
            'type'      =>  'LEFT',
            'escape'    =>  FALSE
        );
        
        $strAs = $this->get('parent.column_alias') ? $this->get('parent.column_alias').'_' : '';
        $strSelectValue = '"'.$withAlias.'"."_value"';
        $arrDataReturn['base_select']['select'][] = array(
            'column'    =>  $strSelectValue,
            'as'        =>  $strAs.$this->getColumnValueName($this->get()),
        );
        
        $strSelectText = '"'.$withAlias.'"."_text"';
        $arrDataReturn['base_select']['select'][] = array(
            'column'    =>  $strSelectText,
            'as'        =>  $strAs.$this->getColumnTextName($this->get()),
        );
        
        $arrDataReturn['base_select']['group_by'][] = '"'.$withAlias.'"._value';
        $arrDataReturn['base_select']['group_by'][] = '"'.$withAlias.'"._text';
        
        
        return $arrDataReturn;
    }
    
    private function getSelectWhereByText($arrDataReturn,$module,$tableJoinAs){
        
        $moduleVariable = $module->variables->get($this->get('from.text')[0])->get();
              
        foreach($this->get('filters') as $filter){
            
           $filter = array_merge(
                $filter,
                array(
                    'column'    =>  $this->getColumnName($moduleVariable),
                    'table'     =>  str_replace('"','',$tableJoinAs),
                )
            );
            
            $clauseName = $filter['clause'].'_clauses_PostgreSql';       
            $tempFilter = new $clauseName($filter);
                             
            $strWhere = $tempFilter->getQuerySelectString();
            if($strWhere){
                $arrDataReturn['base_select']['where'][] = array(
                    'column'    =>  $strWhere
                );    
            }       
        }
        
        return $arrDataReturn;  
        
    }
    
    private function getSelectWhereByValue($arrDataReturn){
        foreach($this->get('filters') as $filter){
            $filter = array_merge(
                $filter,
                array(
                    'column'    =>  $this->getColumnName($this->get()),
                    'table'     =>  $this->get('parent.table_alias')
                )
            );
            
            $clauseName = $filter['clause'].'_clauses_PostgreSql';       
            $tempFilter = new $clauseName($filter);
                             
            $strWhere = $tempFilter->getQuerySelectString();
            if($strWhere){
                $arrDataReturn['base_select']['where'][] = array(
                    'column'    =>  $strWhere
                );    
            }               
        }
    
        return $arrDataReturn;     
    }
}

?>