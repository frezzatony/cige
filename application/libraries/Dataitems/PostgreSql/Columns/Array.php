<?php

/**
 * @author Tony Frezza
 * @copyright 2020
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Character.php');
class Array_Columns_PostgreSql extends Character_Columns_PostgreSql{
    
    
    function __construct($arrProp = array()){
        
        $arrProp['variable_type'] = 'Array';
        
        parent::__construct($arrProp);
    }
    
    
}

?>