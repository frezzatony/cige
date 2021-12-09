<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_core{

    private $arrData = array();


    function __construct($arrProp = array()){
        
        
        $this->set($arrProp);
    }
    
    
    public function append($name, $data){
        
        $arrData = $this->get($name);
        
        if(is_array($arrData)){
            $arrData[] = $data;
            $this->set($name,$arrData);
            
        }
        else if(is_string($arrData)){
                
             $this->set($name,$arrData.$data);  
        }
        
        else if(sizeof($data)){
            $tempData = array(
                $name => $data
            );
            
            foreach($tempData as $key => $val){
                $temp = $this->get($key);
                
                if(is_array($temp)){
                    $temp[] = $val;
                }
                else if(is_string($val)){
                    $temp .= $val;
                }
                
                $this->set($name,$val);
            }
        }
        
    }
    
    public function prepend($name, $data){
        
        $arrData = $this->get($name);
        
        if(is_array($arrData)){
            array_unshift($arrData,$data);
            $this->set($name,$arrData);
        }
        
        
    }
    
    public function get($data=NULL,$escape = FALSE){
        
        if($data == NULL){
            return $this->arrData;
        }
        
        $data =  explode('.',$data);
        
        if(sizeof($data)==1){
           return $this->getReturn((isset($this->arrData[$data[0]]) ? $this->arrData[$data[0]] : NULL));
        }
        
        $arrDataReturn = (isset($this->arrData[$data[0]]) ? $this->arrData[$data[0]] : NULL);
        
        if(!$arrDataReturn){
            return NULL;
        }
        
        unset($data[0]);
        foreach($data as $node){
            
            if(sizeof($arrDataReturn) && !isset($arrDataReturn[$node])){
                return NULL;
            }
            else if (sizeof($arrDataReturn)){
                $arrDataReturn = $arrDataReturn[$node];
            }
        }
        
        return $escape ? $this->CI->db->escape($this->getReturn($arrDataReturn)) : $this->getReturn($arrDataReturn);
        
    }
    
    public function isset($data=NULL){
       
        if($data == NULL){
            return $this->arrData;
        }
        
        $data =  explode('.',$data);
        
        if(sizeof($data)==1){
           return $this->getReturn((isset($this->arrData[$data[0]]) ? TRUE : FALSE));
        }
        
        $arrDataReturn = (isset($this->arrData[$data[0]]) ? $this->arrData[$data[0]] : FALSE);
        
        if(!$arrDataReturn){
            return FALSE;
        }
        
        unset($data[0]);
        foreach($data as $node){
            
            if(sizeof($arrDataReturn) && !isset($arrDataReturn[$node])){
                return FALSE;
            }
            else if (sizeof($arrDataReturn)){
                $arrDataReturn = $arrDataReturn[$node];
            }
        }
        
        return TRUE;
        
    }
    
    public function set($arrProp = array(),$arrData = array()){
        
        if(is_string($arrProp)){
            
            
            $arrKey =  explode('.',$arrProp);
            
            $tree = &$this->arrData;
            
            foreach($arrKey as $key => $val){
                
                if(array_key_exists($val,$tree)===FALSE){
                    $tree[$val] =array();    
                }
                
                if($key == sizeof($arrKey)-1){
                    
                    /*    
                    if(is_array($tree[$val]) AND is_array($arrData)){
                        $arrData = array_merge($tree[$val],$arrData);    
                    }*/
                    
                    $tree[$val] = $arrData;    
                }
                else{
                    $tree = &$tree[$val];
                }     
                
            }
        }
        else{
            foreach($arrProp as $name => $data){
                $this->arrData[$name] = $data;   
            }    
        }
        
        
    }
    
    public function unset($name = NULL){
        
        
        if(is_null($name)){
            $this->arrData = array();
            return;  
        }
        
        $arrKeys =  explode('.',$name);
                
        $tree = &$this->arrData;
        
        foreach($arrKeys as $key => $val){
            
            if($key == sizeof($arrKeys)-1){
              unset($tree[$val]);
            }
            else if(array_key_exists($val,$tree)){
                $tree = &$tree[$val];
            }
            
           
        }    
    }
    /**
     * PRIVATES
     */
    private function getReturn($value){
        
        if(
            is_array($value) OR 
            is_bool($value) OR 
            is_string($value) OR
            is_numeric($value) OR
            is_null($value)){
                
            return $value;
        }
        
        if(is_callable($value)){
            return $value();
        }
                
        return $value;
    }
}
