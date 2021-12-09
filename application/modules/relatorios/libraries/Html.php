<?php

/**
 * @author Tony Frezza
 */


class Html_Relatorios extends Data{
    
    private $html;
    private $idHtml;
    private $idHeader;
    private $idBody;
    
    
    function __construct($arrProp = array()){
        
        parent::__construct($arrProp);
        
        $this->html = new Html();
        
    }
    
    public function print($arrProp = array()){
        
        if($arrProp){
            $this->set($arrProp);
        }
        
        
        $this->setHeader();
        
        $this->setBody();
        
        $this->CI->template->set('html',$this->html->getHtml());
        
        echo $this->CI->template->load('relatorios','relatorios/templates/default/consulta','default_view',$this->get(),TRUE);
    
    }
    
    public function setHeader($arrProp = array()){
        
        if($arrProp){
            $this->set($arrProp);
        }
        $this->set('page_number',1);
        $this->set('total_pages',1);
        
        $html = $this->CI->template->load('blank','relatorios','cabecalhos/'.$this->get('header_type'),$this->get(),TRUE);
        
        $html = $this->CI->parser->parse_string($html,$this->get());
        
        
        
        $this->html->add(
            array(
                'text'      =>  $html,
                'parent_id' =>  $this->idBody,
            )
        );
         
                
    }
    
    /**
     * PRIVATES
     **/
     
    private function setBody(){
        
        if($this->get('body_html')){
            $this->html->add(
                array(
                    'text'  =>  $this->get('body_html')
                )
            );
        }
    }
    
    private function setHtmlPage(){
        
        $this->html->add(
            array(
                'text'      =>  '<!DOCTYPE HTML>'
            )
        );
        
        $this->idHtmlTag = $this->html->add(
            array(
                'tag'       =>  'html'
            )
        );
        
        $this->idHeader = $this->html->add(
            array(
                'tag'       =>  'head',
                'parent_id' =>  $this->idHtmlTag,
            )
        );
        
        $this->html->add(
            array(
                'parent_id' =>  $this->idHeader,
                'children'  =>  array(
                    array(
                        'text'       =>  '<meta http-equiv="content-type" content="text/html" />',
                    ),
                    array(
                        'text'      =>  '<meta name="author" content="Tony Frezza" />',
                    ),
                    array(
                        'tag'       =>  'title',
                        'text'      =>  'Relatório',
                    ),
                    array(
                        'tag'       =>  'style',
                        'type'      =>  'text/css',
                        'text'      =>  $this->CI->template->load('blank','relatorios','css/consultas_view',NULL,TRUE)
                    )
                )
            )
        );
        
        $this->idBody = $this->html->add(
            array(
                'tag'       =>  'body',
                'class'     =>  $this->get('body_class'),
            )
        );
        
        
        
    }
    
}

?>