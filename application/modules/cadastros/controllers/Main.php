<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__).'/Main_cadastros.php';

class Main extends Main_cadastros{
        
        function __construct($arrProp = array()){
            
            parent::__construct(
                array(
                    'init'      =>  TRUE
                )
            );
        }
        
}
