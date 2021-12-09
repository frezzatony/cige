<?php

/**
 * @author Tony Frezza

 */

class Grid_Bootstrap_Template_1 extends Component_Bootstrap{

    private $node;
    
    function __construct($node){
        parent::__construct();
        $this->node = $node;
    }
    
    
    public function getHtmlData(){
        
        $arrReturn = array(
            'tag'           =>  'div',
            'class'         =>  $this->CI->common->append($this->node['class']??array(),array('bsgrid')),
            'data-autoload' =>  (bool)($this->node['autoload'] ?? FALSE),
            'children'      =>  array(
                
            ),
        );
        foreach($this->node as $tag => $value){
            if(!in_array($tag,array('tag','class','header','body','footer','autoload','columns','data'))){
                $arrReturn[$tag] = $value;
            }
        }
        
        $arrBodyColumns = array();
        
        //HEADER
        $arrHeader = array();
        foreach($this->node['header'] ?? array() as $key => $headColumn){
            //para criacao da content-row-model
            $arrBodyColumns[] = array(
                'tag'       =>  'div',
                'class'     =>  array('bsgrid-content-column','nopadding','padding-left-6','padding-top-2'),
                'text'      =>  $key,
            );
            
            if($headColumn['list-class']??NULL){
                append($arrBodyColumns[sizeof($arrBodyColumns)-1]['class'],$headColumn['list-class']);
            }
            
            
            $arrColumn = array(
                'tag'       =>  'div',
                'class'     =>  $this->CI->common->append($headColumn['class'] ?? array(),array('bsgrid-header-column','nopadding','padding-left-6')),
            );
            
            foreach($headColumn['head-col'] ?? array() as $key => $val){
                 $arrColumn['class'] = $this->CI->common->append($arrColumn['class'],'col-'.$key.'-'.$val);
                 $arrBodyColumns[sizeof($arrBodyColumns)-1]['class'] = $this->CI->common->append($arrBodyColumns[sizeof($arrBodyColumns)-1]['class'] ,'col-'.$key.'-'.$val);     
            }
            
            if($headColumn['head-width']??NULL){
                append($arrColumn['class'],array('inline','float-left'));
                append($arrColumn['style'],'width: ' .$headColumn['head-width'].'%;');
                 
            }
                        
            
            $arrColumn['text'] = $headColumn['text'];
            
            foreach($headColumn as $keyItemColumn => $valItemColumn){
                if(!($arrColumn[$keyItemColumn]??NULL)){
                    $arrColumn[$keyItemColumn] = $valItemColumn;
                }
            }
            
            $arrHeader[] = $arrColumn;        
        } 
        if(sizeof($arrHeader)){
            $arrReturn['children'][] = array(
                'tag'       =>  'div',
                'class'     =>  array('','nopadding','nomargin','bsgrid-header-base'),
                
                'children'  =>  array(
                    array(
                        'tag'       =>  'div',
                        'class'     =>  array('bsgrid-header','card-header','nopadding','height-20','block'),
                        'children'  =>  $arrHeader,
                    )
                )
            );
            
        }
        //FIM HEADER
        
        if(($this->node['columns']??NULL)){
            
            foreach($this->node['columns'] as $key => $column){
                if(($column['class']??NULL)){
                    
                    append($arrBodyColumns[$key]['class'],$column['class']);
                }   
            }
        }
        
        $dataRows = array();
        
        if(($this->node['data']??NULL)){
            $dataRows = array(
                'children'  =>  array(),  
            );
            
            foreach($this->node['data'] as $keyRow => $dataRow){
                
                $dataRows['children'][] = array(
                    'tag'       =>  'div',
                    'class'     =>  array('bsgrid-content-row','row','nomargin'),
                    'children'  =>  array(),
                );
                $newRow = &$dataRows['children'][sizeof($dataRows['children'])-1];
                
                foreach($dataRow as $keyColumn => $dataColumn){
                    if(!($arrBodyColumns[$keyColumn]??NULL)){
                        continue;
                    }
                    
                    $newRow['children'][] = $arrBodyColumns[$keyColumn];
                    $newColumn = &$newRow['children'][sizeof($newRow['children'])-1];
                    
                    $newColumn['text'] = $dataColumn['text']??NULL;
                    $newColumn['class'] = array_merge(string_to_array($newColumn['class']),string_to_array($dataColumn['class']??NULL));
                    
                }
            }
        }
        
        
        //BODY
        $arrReturn['children'][] = array(
            'tag'       =>  'div',
            'class'     =>  array('bsgrid-body','card-block nopadding'),
            'children'  =>  array(
                 array(
                    'tag'       =>  'div',
                    'class'     =>  array('bsgrid-body-content'),
                    'children'  =>  array(
                        array(
                            'tag'       =>  'div',
                            'class'     =>  array('bsgrid-content-row-model','bsgrid-content-row','row','nomargin','softhide'),
                            'children'  =>  $arrBodyColumns
                        ),
                        $dataRows
                    )
                )
            )
        );
        //FIM BODY
        
        //FOOTER
        
        if(($this->node['footer']??TRUE)){
            $arrReturn['children'][] = $this->getFooter();  
        }
        else{
            $arrReturn['data-no-footer'] = TRUE;
        }
        //FIM FOOTER
        
        
        return $arrReturn;
    }
    
    private function getFooter(){
        
        return array(
            'tag'       =>  'div',
            'class'     =>  array('bsgrid-footer','form-inline','bordered'),
            'children'  =>  array(
                 array(
                    'tag'       =>  'div',
                    'class'     =>  array('inline'),
                    'children'  =>  array(
                        array(
                            'tag'       =>  'a',
                            'title'     =>  'Primeira página',
                            'class'     =>  array('btn','btn-primary-outline','btn-sm','bsgrid-btn-first-page','margin-left-3','margin-top-3','margin-bottom-3','width-30','nomargin'),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'i',
                                    'class'     =>  'fa fa-angle-double-left',
                                )
                            )
                        ),
                        array(
                            'tag'       =>  'a',
                            'title'     =>  'Página anterior',
                            'class'     =>  array('btn','btn-primary-outline','btn-sm','bsgrid-btn-previous-page','margin-top-3','margin-bottom-3','width-30','nomargin'),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'i',
                                    'class'     =>  'fa fa-angle-left',
                                )
                            )
                        ),
                        array(
                            'tag'       =>  'span',
                            'class'     =>  array('size-11','margin-left-10'),
                            'text'      =>  'Página:',
                        ),
                        array(
                            'tag'       =>  'input',
                            'type'      =>  'text',
                            'class'     =>  array('input-sm','form-control','text-right','integer','bsgrid-input-pages','margin-bottom-4','size-10','width-50','height-20'),
                        ),
                        array(
                            'tag'       =>  'span',
                            'class'     =>  array('bsgrid-total-pages','size-10'),
                            'style'     =>  'position: relative; display: inline-table; min-width: 20px;',
                            'text'      =>  'de',
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'span',
                                    'class'     =>  array('bsgrid-total-rows','size-11'),
                                ),
                            ),
                        ),
                        array(
                            'tag'       =>  'a',
                            'title'     =>  'Próxima página',
                            'class'     =>  array('btn','btn-primary-outline','btn-sm','bsgrid-btn-next-page','margin-left-3','margin-top-3','margin-bottom-3','width-30','nomargin'),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'i',
                                    'class'     =>  'fa fa-angle-right',
                                )
                            )
                        ),
                        array(
                            'tag'       =>  'a',
                            'title'     =>  'Última página',
                            'class'     =>  array('btn','btn-primary-outline','btn-sm','bsgrid-btn-last-page','margin-top-3','margin-bottom-3','width-30','nomargin'),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'i',
                                    'class'     =>  'fa fa-angle-double-right',
                                )
                            )
                        ),
                        array(
                            'tag'           =>  'a',
                            'title'         =>  'Imprimir / Exportar a consulta',
                            'class'         =>  array('btn','btn-primary-outline','btn-sm','bsgrid-btn-print','margin-top-3','margin-bottom-3','width-30','nomargin'),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'i',
                                    'class'     =>  array('fa fa-print'),
                                )
                            )
                        ),
                    )
                ),
                array(
                    'tag'       =>  'div',
                    'class'     =>  array('inline','pull-right'),
                    'children'  =>  array(
                        array(
                            'tag'       =>  'div',
                            'class'     =>  array('bsgrid-total-items','margin-right-6','hidden-sm-down'),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'small',
                                    'text'      =>  'Itens localizados:',
                                ),
                                array(
                                    'tag'       =>  'small',
                                    'children'  =>  array(
                                        array(
                                            'tag'       =>  'strong',
                                            'children'  =>  array(
                                                array(
                                                    'tag'       =>  'span',
                                                    'class'     =>  array('bsgrid-total-items'),    
                                                )
                                            )
                                        )
                                    )
                                ),
                            )
                        ),
                        array(
                            'tag'       =>  'div',
                            'class'     =>  array('inline','margin-right-6','hidden-sm-down'),
                            'children'  =>  array(
                                array(
                                    'tag'       =>  'small',
                                    'text'      =>  'Itens por página: &nbsp;',
                                ), 
                                array(
                                    'tag'       =>  'select',
                                    'class'     =>  array('form-control','input-sm','bsgrid-show-items','size-9','width-60','height-25'),
                                    'children'  =>  array(
                                        array(
                                            'tag'       =>  'option',
                                            'value'     =>  10,
                                            'text'      =>  10
                                        ),
                                        array(
                                            'tag'       =>  'option',
                                            'value'     =>  20,
                                            'text'      =>  20
                                        ),
                                        array(
                                            'tag'       =>  'option',
                                            'value'     =>  100,
                                            'text'      =>  100
                                        ),
                                    )
                                )  
                            ),
                        ),                        
                    )
                )
            )
        );
        
    }
}

?>