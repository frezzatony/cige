<?php

/**
 * @author Tony Frezza

 */


class Console extends Data{
    
         
    function __construct($arrProp = array()){
        
        parent::__construct();
        
    }
    
    public function initModule(){
        
        $arrTemplate = $this->CI->common->getTemplate();
        
        if($arrTemplate['template'] != 'padrao'){
            return FALSE;    
        }
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/console/css/console.css');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/console/js/console.js');
        
        $this->setConsoleHtml();
    }
    /**
     * PRIVATES
     */
    
    private function setConsoleHtml(){
        
        //adiciona o botão ao Footer
        $this->CI->data->prepend('footer.nodes',
            array(
                'tag'       =>  'button',
                'class'     =>  array('btn','btn-sm','btn-default','btn-console','nopadding','nomargin','margin-bottom-4','padding-left-6','padding-right-6'),
                'title'     =>  'Console',
                'children'  =>  array(
                    array(
                        'tag'       =>  'i',
                        'class'     =>  array('fa','fa-terminal')
                    )
                )
            )
        );
        
        //add o Console
        $this->CI->data->append('footerHtmlData.children',
            array(
                'tag'       =>  'div',
                'class'     =>  array('console','footer-console','card','softhide'),//softhide
                'children'  =>  array(
                    array(
                        'tag'       =>  'div',
                        'class'     =>  array('card-header','console-header','container-fluid','nopadding','size-12'),
                        'children'  =>  array(
                            array(
                                'tag'       =>  'div',
                                'class'     =>  array('pull-left','padding-left-6'),
                                'children'  =>  array(
                                    array(
                                        'tag'       =>  'i',
                                        'class'     =>  array('fa','fa-terminal','bordered','padding-left-2','padding-right-2')
                                    ),
                                    array(
                                        'text'      =>  'Console'
                                    )
                                )
                            ),
                            array(
                                'tag'       =>  'div',
                                'class'     =>  array('pull-right'),
                                'children'  =>  array(
                                    array(
                                        'tag'       =>  'button',
                                        'class'     =>  array('btn','btn-sm','btn-secondary','btn-minimize','nomargin','size-9'),
                                        'title'     =>  'Ocultar',
                                        'children'  =>  array(
                                            array(
                                                'tag'       =>  'i',
                                                'class'     =>  array('fa','fa-angle-down')
                                            ),
                                        ),
                                    )
                                )
                            ),
                        )
                    ),
                    array(
                        'tag'       =>  'div',
                        'class'     =>  array('container-fluid','console-body','nopadding','padding-left-2','padding-right-2',),
                        'children'  =>  array(
                           /*
                            array(
                                'tag'   =>  'p',
                                'class' =>  '',
                                'text'  =>  date('d/m/Y|H:i:s').' -> Excluído o item'
                            ),
                            */
                        )
                    )
                )
            )
        );
        
        //add o Js ao Template
        $jsConsole = $this->CI->template->load('blank','console','jsConsole_view',array(),TRUE);
        $this->CI->template->append('javascript',$jsConsole);
        
    }
}

?>