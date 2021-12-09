<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH.'/third_party/autoload.php';

class Disposivitos_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function validateTipo(Cadastros $cadastro){
        
        $tipo = (int) $cadastro->variables->get('tipo')->get('value');
                
        $tiposPessoas = new Cadastros(
            array(
                'requests_id'   =>  array('67'),
                'item'
            )
        );
        
        $tiposArmazenados = $tiposPessoas->getItems(
            array(
                'simple_get_items'   =>  TRUE,
                'filters'           =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  $tipo,
                    )
                ),
                'limit' =>  1,
            )
        );
        
        return $tiposArmazenados;
    }
    
    
    
    /**
     * PRIVATES
     **/
     
}