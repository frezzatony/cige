<?php

/**
 * @author Tony Frezza
 */ 

defined('BASEPATH') OR exit('No direct script access allowed');



include APPPATH.'/third_party/vendor/autoload.php';

class Pdf extends TCPDF{
    
    private $data;
    
    function __construct(){
        parent::__construct(); 
        $this->data = new Data;   
        $this->CI = &get_instance();
    
    }    
    
    public function __call($name,$arguments){
        
        if(method_exists($this,$name)){
            return $this->{$name}($arguments[0]??NULL,$arguments[1]??NULL,$arguments[2]??NULL,$arguments[3]??NULL,$arguments[4]??NULL,$arguments[5]??NULL);
        }
        
        return $this->data->{$name}($arguments[0]??NULL,$arguments[1]??NULL);
        
    }
    
    function header(){
                      
                       
        if($this->get('header_html')){
            
            
            $htmlString = $this->CI->parser->parse_string(
                $this->get('header_html'),
                    array(
                        'page_number'   =>  $this->getAliasNumPage(),
                        'total_pages'   =>  $this->getAliasNbPages(),
                    )
                ,TRUE
            );
            
            
            
            $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '4', $htmlString, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
            
            $this->SetTopMargin($this->GetY()+3);   
        }
        
        
    }
    
    
    function footer(){
        
    }
    
    
}
?>