<?php

/**
 * @author Tony Frezza

 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{
    
    private $logViewer;
    
    function __construct(){
        
        parent::__construct();
                
        $this->logViewer = new CILogViewer();
                
    }
    
    public function index() {
        
        echo $this->logViewer->showLogs();
        return;
    }
    
    
    
}
