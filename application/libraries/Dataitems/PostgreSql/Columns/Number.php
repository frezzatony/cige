<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/Character.php');

class Number_Columns_PostgreSql extends Character_Columns_PostgreSql{
    
    
    function __construct($arrProp = array()){
        $arrProp['variable_type'] = 'number';
        
        parent::__construct($arrProp);
        
        if($this->get('filters')){
            
            $arrFilters = $this->get('filters');
            
            foreach($arrFilters as &$filter){
                $variables = new Variables(
                    array(
                        'id'        =>  'tempNumber',
                        'type'      =>  'number',
                        'value'     =>  $filter['value'] ?? NULL,
                        'method'    =>  'database',
                    )
                );
                $filter['value'] = $variables->get('tempNumber')->get('value');
            }
            
            $this->set('filters',$arrFilters);            
        }
    }
      
}

?>