<?php

/**
 * @author Tony Frezza

 */

class Datagroup
{

    private $count = 0;
    
    function getData($arrProp = array()){
        
        $arrDataReturn = array();
        
        foreach($arrProp['data'] as $row){
            
            
            $keyPk = array_search($row[$arrProp['column_pk']],array_column($arrDataReturn,$arrProp['column_pk']));
            
            if($keyPk===FALSE){
                
                $arrDataReturn[] = $this->_getNewRow(
                    array(
                        'new_row'   =>  $row,
                        'structure' =>  $arrProp['structure'],
                    )
                );  
            }
            else{
                $arrDataReturn[$keyPk] = $this->_getMergeRow(
                    array(
                        'new_row'   =>  $this->_getNewRow(
                            array(
                                'new_row'   =>  $row,
                                'structure' =>  $arrProp['structure'],
                            )
                        ),
                        'last_row'  =>  array($arrDataReturn[$keyPk]),
                        'column_pk' =>  $arrProp['column_pk'],
                        'structure' =>  $arrProp['structure']
                    )
                );
            }
            
        } 
        
        return $arrDataReturn;
    }
    
    public function getRemoveParentName($arrProp = array()){
        
        $arrDataReturn = array();
        
        if(array_key_exists('data',$arrProp)===FALSE || !is_array($arrProp['data']) || !($arrProp['data'])){
            return array();
        }
        
            
        foreach($arrProp['data'] as $key => $rowData){
            
            unset($arrProp['data'][$key]);
            
            if(is_array($rowData)){
                $arrDataReturn[str_replace($arrProp['parent_name'].'_','',$key)] = self::getRemoveParentName(
                    array(
                        'parent_name'   =>  $arrProp['parent_name'],
                        'data'          =>  $rowData
                    )
                );     
            }
            else{
                $arrDataReturn[str_replace($arrProp['parent_name'].'_','',$key)] = $rowData;
            }
            
        }
        
        return $arrDataReturn;
    }
    
    
    /**
     * PRIVATES
     **/
    
    
    private function _getMergeRow($arrProp = array()){
        
        $arrDataNewRow = array();
        $arrDataNewRowParent = array();
        $flagAdd = false;
                        
        foreach($arrProp['last_row'] as $rowValue){
            
            foreach($arrProp['structure'] as $key=>$input){
                if(is_array($input)){
                    
                    $arrDataNewRowParent[$key] = $this->_getMergeRow(
                        array(
                            'last_row'  =>  $rowValue[$key],
                            'new_row'   =>  $arrProp['new_row'][$key][0] ?? $arrProp['new_row'][$key], 
                            'structure' =>  $input,
                            'parent'    =>  TRUE,
                        )
                    );        
                     
                }    
                else if (isset($arrProp['new_row'][$input])){
                    $arrDataNewRow[$input] = $arrProp['new_row'][$input];
                }        
            } 
            
            
            $arrDataLastRow = array();
        
            foreach($arrDataNewRow as $key => $input){
                $arrDataLastRow[$key] = $rowValue[$key];
            }
            
            
            if($arrDataLastRow!=$arrDataNewRow){
                $arrProp['last_row'][] = $arrDataNewRow;
                break;
            }
            else{
                foreach($arrDataNewRowParent as $key => $input){
                    if($rowValue[$key]!=$input){
                        $arrProp['last_row'][0][$key] = $input;
                        $flagAdd = true;
                        break;
                    }       
                }
            }
            
        }
        
        if(isset($arrProp['parent'])){
            return $arrProp['last_row'];
        }

        return $arrProp['last_row'][0];
    }
    
    
    private function _getNewRow($arrProp = array()){
        
        $arrData = array();
        
         $this->count++;
         
        foreach($arrProp['structure'] as $key=>$input){
            
            if(is_array($input)){
                
                if(array_key_exists($key,$arrProp['new_row'])===TRUE){
                    $arrData[$key] = $arrProp['new_row'][$key];      
                }
                else{
                    $arrData[$key] = array();
                }
                
                foreach($input as $keyChild => $inputChild){
                    if(is_array($inputChild)){
                        
                        foreach($arrData[$key] as &$rowInput){
                            $rowInput[$keyChild] = $arrProp['new_row'][$keyChild] ?? NULL;
                        }   
                    }
                }    
            }
            else{
                $arrData[$input] = $arrProp['new_row'][$input] ?? NULL;
            }
        }
        
        return $arrData;
    }
    
    /*
    private function _getNewRow($arrProp = array()){
        
        $arrData = array();
        
        foreach($arrProp['structure'] as $key=>$input){
            if(is_array($input)){
                if(array_key_exists($key,$arrProp['new_row'])!==FALSE){
                    $arrData[$key] = $arrProp['new_row'][$key];    
                }
                else{
                    $arrData[$key] = array();
                }
                        
                $arrDataInput = $this->_getNewRow(
                    array(
                        'new_row'   =>  $arrProp['new_row'],
                        'structure' =>  $input
                    )                    
                );
                if($arrDataInput!==FALSE){
                    $arrData[$key][] = $arrDataInput;
                        
                }
                 
            }
            else if(isset($arrProp['new_row'][$input])){
                $arrData[$input] = $arrProp['new_row'][$input];
                
            }
        }
        
        $flagHasValue = FALSE;
        foreach($arrData as $keyData => $valData){
            if($valData!==NULL){
                $flagHasValue = TRUE;
                break;
            }
            
        }
        
        return (!$flagHasValue ? FALSE : $arrData);
        
    }*/ 
}


?>