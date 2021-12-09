<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uuid_Variables extends Variables_defaults{
    
    public $inputType = 'uuid';
    private $uuid;
    
    function __construct($arrProp = array()){
        parent::__construct();
        $this->uuid = new UUID();
        
        $this->set($arrProp);
        
    }
    
    protected function formatValue($value){
        
        $value = trim($value);
        
        return $value;
    }

}