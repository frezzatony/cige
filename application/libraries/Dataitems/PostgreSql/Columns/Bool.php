<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Character.php');
class Bool_Columns_PostgreSql extends Character_Columns_PostgreSql{
    
    
    function __construct($arrProp = array()){
        $arrProp['variable_type'] = 'bool';
        
        parent::__construct($arrProp);
        
    }
      
}

?>