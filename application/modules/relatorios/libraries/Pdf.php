<?php

/**
 * @author Tony Frezza
 */


class PDF_Relatorios extends Data{
    
    private $pdf;
    
    function __construct($arrProp = array()){
        
        parent::__construct($arrProp);
        
        $this->CI->load->library('pdf');
        $this->pdf = new Pdf;
        
        $this->pdf->SetMargins(4,4,4,4);
        $this->set('pdf',TRUE);
        
    }
    
    public function print($arrProp = array()){
        
        if($arrProp){
            $this->set($arrProp);
        }
        
        $this->setHeader();
        $this->pdf->addPage();
        
        $this->pdf->lastPage();
        
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        $this->getBody();
        
        $this->pdf->Output('hello_world.pdf');  
        
    }
    
    public function setHeader($arrProp = array()){
        
        if($arrProp){
            $this->set($arrProp);
        }
        
                
        $this->pdf->set('header_margin_top',($this->get('header_margin_top')??3));
        
        $html = $this->CI->template->load('blank','relatorios','cabecalhos/'.$this->get('header_type'),$this->get(),TRUE);
        $html = $this->CI->parser->parse_string($html,$this->get());
        
          
        $this->pdf->set('header_html',$html);
                
    }
    
    /**
     * PRIVATES
     **/
     
    private function getBody($arrProp = array()){
        
        if($this->get('body_html')){
            
            $this->pdf->writeHTML($this->get('body_html'), true, false, true, false, '');    
        }
        
        return;
    }
    
}

?>