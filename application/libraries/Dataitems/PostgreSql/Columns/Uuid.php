<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/Character.php');

class Uuid_Columns_PostgreSql extends Character_Columns_PostgreSql{
    
    function __construct($arrProp = array()){
        parent::__construct($arrProp);
        
    }
      
}

?>