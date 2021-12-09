<?php

# html class 
# coded by Tony Aldrin Fernandes Frezza 
# e-mail : frezzatony@gmail.com 
# year: 2017 


if (!defined('BASEPATH')) exit('No direct script access allowed');

class Html{ 
    
    var $nodes = array(); 
    
    function __construct($arrProp = array()){
        
        if($arrProp){
            $this->add($arrProp);
        }
        
    }
    /** 
     * Arrays that can be edited in the class, or when in extended use, use array merge to add more values dynamically 
     */ 
    var $selfClosers = array('area','base','br','col','command','embed','hr','img','input','keygen','link','meta','param','source','track','wbr'); 
    var $arrNoAttribute = array('tag','children','text','random_id','parent_id','no_attribute','options','input_type'); 
    var $arrNoTabulate = array('option','button','label','textarea'); 
    
    
    /** 
     * Add nodes to html context. 
     * 
     * @param array $arrProp 
     * @return integer id 
     */ 
    function add($arrProp = array()){ 

        if(!$arrProp){ 
            return false; 
        } 
        
        if(!isset($arrProp['id']) || !$arrProp['id']){ 
            $arrProp['id'] = self::getRandomId(); 
            $arrProp['random_id'] = true; 
        } 
        
        //adds children to parent node, from id of parent node 
        if(($arrProp['parent_id']??NULL)){
            $this->nodes = $this->buildTree($arrProp); 
        } 
        else{ 
            if(!(isset($arrProp['children']))){ 
                $arrProp['children'] = array(); 
            } 
            array_push($this->nodes,$arrProp); 
        } 
        
        return $arrProp['id']; 
          
    } 
    
    
    /** 
     * Generates the html and returns a string with all the content previously built. 
     * 
     * @return string html 
     */ 
    public function getHtml(){ 
        
        $arrProp = func_get_args(); 
        
        $arrTree = isset($arrProp[0]) ? $arrProp[0] : $this->nodes; 
        $treeLevel = isset($arrProp[1]) ? $arrProp[1] : 0; 
        
        $htmlReturn = ''; 
        
        foreach($arrTree as $node){ 
            
            $htmlReturn .= "\n".str_repeat("\t",$treeLevel); 
            
            if(isset($node['tag'])){ 
                $htmlReturn .= '<'.$node['tag'].' '; 
            } 
            foreach($node as $attribute=>$val){ 
                
                $arrNoAttributes = $this->arrNoAttribute; 
                
                if(isset($node['no_attribute'])){ 
                    $arrNoAttributes = array_merge($arrNoAttributes,$node['no_attribute']); 
                } 
                
                if(!in_array($attribute,$arrNoAttributes)){ 
                    if($attribute!='id' || ($attribute=='id' AND !isset($node['random_id']))){ 
                        $htmlReturn .= $attribute . '=';
                        
                        if(is_array($val)){
                            $val = implode($val,' ');
                        } 
                        
                        $quote = '"';
                        if(strstr($val,'"')!==FALSE){
                            $quote = "'";
                        }
                        
                        $htmlReturn .= $quote.$val.$quote.' ';
                    } 
                     
                } 
            } 
            if(isset($node['tag']) AND !in_array($node['tag'],$this->selfClosers)){ 
                $htmlReturn .= '>'; 
            } 
            
            if(isset($node['text'])){ 
                $htmlReturn .= $node['text']; 
            } 
            
            if(isset($node['children']) AND $node['children']){ 
                $htmlReturn .= str_repeat("\t",$treeLevel); 
                $htmlReturn .= $this->getHtml($node['children'],($treeLevel+1)); 
            } 
                
            $arrNoTabulates = $this->arrNoTabulate; 
            
            if(isset($node['no_tabulate'])){ 
                $arrNoTabulates = array_merge($arrNoTabulates,$node['no_tabulate']); 
            } 
                
            if(isset($node['tag']) AND !in_array($node['tag'],$arrNoTabulates) AND !in_array($node['tag'],$this->selfClosers)){ 
                $htmlReturn .="\n"; 
                $htmlReturn .= str_repeat("\t",$treeLevel); 
            } 
            if(isset($node['tag']) AND !in_array($node['tag'],$this->selfClosers)){ 
                $htmlReturn .='</'.$node['tag'].'>'; 
            } 
            
            if(isset($node['tag']) AND in_array($node['tag'],$this->selfClosers)){ 
                $htmlReturn .= '/>'; 
            } 
            
        } 
        return $htmlReturn; 
    } 
    
    public function getData(){
        return $this->nodes;
    } 
   
    /** 
     * Reset the data. 
     * The instantiated object can be reused to regenerate an html string. 
     */ 
    public function resetHtml(){ 
        unset($this->nodes); 
        $this->nodes = array(); 
    } 
    
    
    /** 
     * PRIVATES, PROTECTEDS 
     */ 
    
    
    
    /** 
     * Generate random ids. 
     * Besides being used by the class, it can be useful when the class is extended 
     * 
     * @param integer $length 
     * @return string random 
     */ 
    protected function getRandomId($length = 8){ 
        
        return substr(md5(rand()), 0, $length); 
        
    } 
    
    /** 
     * Adds child nodes inside parent nodes to generate html 
     * 
     * @return array htmlTree 
     */ 
    private function buildTree($arrProp = array(),$arrTree = array()){ 
        
         
        if(!$arrTree){
            $arrTree = $this->nodes;
        }
        
        foreach($arrTree as &$node){ 
            
            if(isset($node['id']) AND $node['id'] == $arrProp['parent_id']){ 
                if(!isset($node['children'])){ 
                    $node['children'] = array(); 
                } 
                 
                array_push($node['children'],$arrProp); 
                
            } 
            else if(isset($node['children']) AND $node['children']){ 
                $node['children'] = $this->buildTree($arrProp,$node['children']); 
            } 
        } 
        return $arrTree; 
    } 
} 
?>