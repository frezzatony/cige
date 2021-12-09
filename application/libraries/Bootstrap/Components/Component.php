<?php

/**
 * @author Tony Frezza
 */


class Component_Bootstrap{
    
    protected $CI;
    protected $arrGridClass = array('xs','md','sm','lg');
    
    function __construct(){
        $this->CI = &get_instance();
    }
    
    protected function getId($node,&$arrData){
        
        
        if(array_key_exists('id',$node) AND (array_key_exists('random_id',$node)===FALSE || $node['random_id']===FALSE)){
            $arrData['id'] = $node['id'];
        }
        
        return $arrData;
    }
}

?>