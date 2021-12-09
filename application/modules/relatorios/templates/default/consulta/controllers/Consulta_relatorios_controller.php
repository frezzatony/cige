<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

ini_set('memory_limit', '2048M');

class Consulta_relatorios_controller extends Data{
    
    private $controller;
    
    function __construct(Relatorios $relatorio){
        
        parent::__construct();        
        $this->relatorio = $relatorio;                
        
            
    }
    
    public function index(){ 
        
        $this->setController();
        
        if($this->CI->uri->getKey('print')!==FALSE){
            $this->printConsulta();
            return;
        }
        
        if($this->CI->uri->get('default')=='consulta'){
            return $this->viewConsulta();
        }
        
        
        $this->CI->main_model->erro(); 
                     
    }
    
    
    
    /**
     * PRIVATES
     **/
    
    public function viewConsulta(){
        
        $this->setController();
        
        $htmlBody = new Html;
        
        $colunasRelatorio = Json::getFullArray($this->CI->input->get_post('columns'));
        $bsgridId = $this->CI->input->get_post('bsgrid');
        
        if(!$colunasRelatorio OR !$bsgridId){
            $this->CI->main_model->erro();
        } 
        
        
        $arrColunas = array();                      
        foreach($colunasRelatorio as $keyColuna => $valColuna){
            
            $keyColunaListItem = array_search($valColuna['id'],array_column($this->controller->get('data.list_items.columns'),'id'));
            
            if($keyColunaListItem !== FALSE){
                $arrColunas[] = $this->controller->get('data.list_items.columns.'.$keyColunaListItem) ?? NULL;
                
                $arrColunas[(sizeof($arrColunas)-1)]['width'] = $valColuna['width'] ?? NULL;
            }        
            
        }
        
        $htmlBody->add(
            array(
                'text'  =>  $this->CI->template->load('blank','relatorios/templates/default/consulta','formPrintConsulta',
                    array(
                        'token'         =>  $this->CI->input->get_post('token'),
                        'titulo'        =>  $this->controllerTitulo,
                        'controller'    =>  $this->controller,
                        'colunas'       =>  $arrColunas,
                        'bsgrid'        =>  $bsgridId,
                    )
                ,TRUE),
            )
        );
        
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
                
        $buttonsHtmlData = $this->controller->getButtonsController(
            array(
                'menu'      =>  include(dirname(__FILE__).'/../data/printFooterButtons.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        );
        
        
        $arrData = array(
            'title'         =>  'Imprimir/Exportar consulta',
            'modal_size'    =>  'md',
            'body'          =>  $htmlBody->getHtml(),
            'footer'        =>  $htmlFooter->getHtml(),
            
        );
        
        return $arrData;
    }
    
        
    private function printConsulta(){
                
        $this->setController();
         
        $arrProp = $this->CI->data->get('post');       
        
                
        $relatorio = new Relatorios();
        $relatorio->set('instituicao',strtoMAIsuculo($this->CI->config->item('sistema')['instituicao']));
        $relatorio->set('title',($arrProp['titulo']??NULL));
        $relatorio->set('subtitle',($arrProp['subtitulo']??NULL));
        
        $strFilters = '';
       
        if($arrProp['filters']??NULL){
            $filter = new Filter(
                array(
                    'variables'         =>  $this->controller->variables,
                    'dynamic_filters'   =>  $arrProp['filters'],
                )
            ); 
            $strFilters = $filter->getAsText();   
        }
        
        $arrProp['strFiltros'] = $strFilters;
                
        switch($arrProp['cabecalho']??NULL){
            
            default:{
                $relatorio->set('header_type','consulta_padrao');
            }
        }
        
        
        switch(strtoMINusculo($arrProp['formato'])){
            case 'pdf'  :   {
                
                $arrProp['body_html'] = $this->getDataHtml($arrProp);              
                $relatorio->printPdf($arrProp);
                break;
                exit;
            }
            case 'xls'  :   {
                
                $arrProp['localPath'] = TRUE;
                $arrProp['excel'] = TRUE;
                
                $arrProp['body_html'] = $this->getDataHtml($arrProp);              
                $relatorio->printXls($arrProp);
                exit;
                break;
            }
            
            default:{
                
                $relatorio->set('template_view','consultas');
                
                $arrProp['body_html'] = $this->getDataHtml($arrProp);
                            
                $relatorio->printHtml($arrProp);
                exit;
            }
        }
        
        $this->main_model->erro();        
        
    }
        
    private function getDataHtml($arrProp = array()){
        
        
        $strHtml = '';
        
        
        $strHtml = '<table nobr="true" cellpadding="2"  border="1" style="width: 200mm; margin-top: 6px; solid 1px #000000" >
            <thead>
                <tr style="background-color: rgb(192, 192, 192);">
        ';
        
        
        foreach($arrProp['columns'] as $column){
            $strHtml .= "\n";
            $strHtml .= '<td style="border: solid 1px #000000; font-size: 8pt; " width="'.(($arrProp['excel']??NULL) ? (($column['width']/100)*100) : ($column['width'].'%')).'" align="center"><b>'.$this->controller->variables->get($column['id'].'.label').'</b></td>';
        }
                
        $strHtml .=' 
                 </tr>
            
            </thead>
        ';

        $arrModelName = explode('/',$this->controller->get('uri_segment'));
        $modelName = strtoMINusculo(clearSpecialChars(end($arrModelName)).'_model');
        
        if(!($arrProp['order']??NULL)){
            $arrProp['order'] = $this->controller->get('data.list_items.order');
        }
        
        
        
        
        if(($arrProp['order']??NULL)){
            $arrProp['order'] =  $this->controller->getOrderBy($arrProp['order']);    
        }
        
        

        if(class_exists($modelName) AND method_exists($this->CI->{$modelName},'getItems')){
            
            $arrData = $this->CI->{$modelName}->getItems($arrProp);
        }        
        else{
            $arrData = $this->controller->getItems(
                $arrProp    
            );
        }
        
        $rowBgColor = (($arrProp['imprimir_zebrado']??NULL) ? '#FFFFFF' : NULL);
        
               
        foreach($arrData['items']??array() as $item){
            $strHtml .= '<tr style="background-color: '.$rowBgColor.';" >';
            
            $this->controller->setItem($item);
            foreach($arrProp['columns'] as $column){
                
                $columnValue = $this->controller->variables->get($column['id'].'.text');
                $columnValue = $columnValue ? $columnValue : $this->controller->variables->get($column['id'].'.value');
                
                
                $strHtml .= '<td  style="border: solid 1px #000000; font-size: 8pt; padding: 1px; background-color: '.$rowBgColor.';"  width="'.(($arrProp['excel']??NULL) ? (($column['width']/100)*100) : ($column['width'].'%')).'">'.$columnValue.'</td>';
            }
            
            $strHtml .= '</tr>';
            
            
            if(($arrProp['imprimir_zebrado']??NULL)){
                $rowBgColor = ($rowBgColor == '#FFFFFF') ? '#F6F4F4' : '#FFFFFF';
            }
            
        }
        
        
        $strHtml .= '</table>';
        
        return $strHtml;
    }
    
    private function setController(){
        
        $this->controller = new Controllers(
            array(
                'item'       =>  $this->relatorio->get('request_id')
            )
        );
        $this->controllerTitulo = $this->controller->variables->get('descricao_plural.value');
        
                
        $this->controller = $this->controller->getControllerObject();
                
        if(!$this->controller){
            $this->CI->main_model->erro();
        }
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->controller->runActionUserPermissions(
            array(
                'action'            =>  $this->controller->get('configs.actions.viewItems'),
                'user_id'           =>  $this->CI->data->get('user.id'),
                'entity_id'         =>  $this->CI->data->get('user.configs.entity'),
            )
        )){
            $this->CI->main_model->erroPermissao();
        }
        
        
        return TRUE;
         
    }
        
}
