<?php

/**
 * @author Tony Frezza
 */


class XLS_Relatorios extends Data{
    
    private $html;
        
    function __construct($arrProp = array()){
        
        parent::__construct($arrProp);
        $this->html = new Html;
        
        
    }
    
    public function print($arrProp = array()){
        
        $this->setHeader();
        
        $htmlString = $this->html->getHtml();
        $htmlString .= $this->get('body_html');       
        
                
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($htmlString);
        //$workSheet = $spreadsheet->getActiveSheet();
                
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        //$writer->save('/var/www/write.xls');
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode('consulta.xls').'"');
        $writer->save('php://output'); 
        
    }
    
    public function setHeader($arrProp = array()){
        
        if($arrProp){
            $this->set($arrProp);
        }
            
                
        $html = $this->CI->template->load('blank','relatorios','cabecalhos/'.$this->get('header_type'),$this->get(),TRUE);
        $html = $this->CI->parser->parse_string($html,$this->get());
        
        $this->html->add(
            array(
                'text'      =>  $html,
            )
        );
                
        
                
    }
    
    /**
     * PRIVATES
     **/
     
    
}

?>