<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{

    function __construct(){
        
        parent::__construct();
        
                      
        
    }
    
    function index($arrProp = array()){
        
        if($arrProp AND !is_array($arrProp)){
            $arrProp = $this->json->getFullArray($arrProp);
        }
        
        $this->execute($arrProp);
    }
    
    public function execute($arrProp = array()){
        
        if(!$this->validateRun($arrProp)){    
            return;
        }
        
        $action  = 'php '.BASEPATH.'../index.php ';
        $action .= $arrProp['module'].' ';
        $action .= $arrProp['action'].' ';
        $action .= $arrProp['parameters']??NULL;
        
        exec($action . ' 2>&1',$output);  
        
        if($output){
            //ocorreu algum erro LOOOOG
        }
        
        
    }
    
    private function validateRun($arrProp = array()){
        
        if(!($arrProp['module']??NULL)){
            return FALSE;
        }
    
        if(!($arrProp['action']??NULL)){
            return FALSE;
        }
        
        return TRUE;
        
    }
}