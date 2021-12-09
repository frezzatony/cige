<?php

/**
 * @author Tony Frezza
 */


class Falecidos_livro_registro_relatorios_controller extends Data{
    
    private $relatorio;
    
    function __construct(Relatorios $relatorio){
        
        parent::__construct();
        $this->relatorio = $relatorio;
        
    }
    
    
    public function index(){
        
        
        return $this->default();
        
        
    }
    
    public function default(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->relatorio->runActionUserPermissions(
            array(
                'action'            =>  104,//id da ação pertinente
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        $htmlBody = new Html();
        
        
        
        include(dirname(__FILE__).'/../data/formRelatorio.php');
        $formRelatorio = $getFormRelatorio();
        
        $htmlBody->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('padding-10'),
                'children'  =>  array(
                    $formRelatorio['form']
                ) 
            )
        );
        
        
        $htmlFooter = new Html;
        $idFormFooter = $htmlFooter->add(
            array(
                'tag'       =>  'div',
                'class'     =>  'pull-left',
            )
        );
                
        $buttonsHtmlData = $this->relatorio->getButtonsController(
            array(
                'menu'      =>  include(dirname(__FILE__).'/../data/itemFooterButtons.php')
            )
        );
        
        $htmlFooter->add(
            array(
                'children'  =>  $buttonsHtmlData['html'],
                'parent_id' =>  $idFormFooter,
            )
        );
         
        return array(
            'title'         =>  'Relatório | Livro Registro de Falecidos',
            'body'          =>  $htmlBody->getHtml(),
            'footer'        =>  $htmlFooter->getHtml(),
            'modal_size'    =>  'sm'
        );
    }
    
    public function relatorio(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->relatorio->runActionUserPermissions(
            array(
                'action'            =>  104,//id da ação pertinente
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        
               
        include(APPPATH.'modules/relatorios/templates/planejamento_urbanismo/falecidos_livro_registro/models/Falecidos_livro_registro_relatorio_model.php');
        
        $relatorioModel = new Falecidos_livro_registro_relatorio_model;
        
        
        $values = $this->CI->input->get_post('values');
        
        if(!$values){
            $this->CI->main_model->erro();
        }
        
        
        $arrProp = array(
            'data_inicio'   =>  NULL,
            'data_fim'      =>  NULL,
        
        );
        
        foreach($values as $val){
            
            if(in_array(($val['id']??NULL),array('data_inicio','data_fim'))){
                $varDate = new Date_Variables($val);
                $varDate->set('method','database');
                
                $arrProp[$val['id']] = $varDate->getValue();
            }
        }
        
        $dataRelatorio = $relatorioModel->getData($arrProp);
        
        if(!($dataRelatorio)){
            echo "Não há dados para exibir";
            return;
        }
        
        $periodoAnterior = meses(date('m',strtotime($dataRelatorio[0]['data_falecimento']))).'/'.date('Y',strtotime($dataRelatorio[0]['data_falecimento']));
                
        $viewData = array(
            'pdf'   =>  $this->CI->input->get_post('pdf'),
            'data'  =>  array(),
        );
        $dataPeriodo = array();
        $viewHtml = '';
        
        foreach($dataRelatorio as $key => $row){
            $periodoAtual = meses(date('m',strtotime($row['data_falecimento']))).'/'.date('Y',strtotime($row['data_falecimento']));
            
            $dataPeriodo[] = $row;
                        
            if($periodoAtual != $periodoAnterior OR ($key == sizeof($dataRelatorio)-1)){
                
                if($key != sizeof($dataRelatorio)-1){
                    array_pop($dataPeriodo);    
                }
                
                
                $rowsCount = 0;
                $viewData['periodo'] = $periodoAnterior;
                 
                array_multisort(array_column($dataPeriodo,'nome_falecido'), SORT_ASC, $dataPeriodo);
 
                foreach($dataPeriodo as $keyData => $data){
                    $rowsCount++;
                    $viewData['data'][] = $data;
                    
                    if($rowsCount==12 OR $keyData == sizeof($dataPeriodo)-1){
                        
                        $viewData['total_pagina'] =sizeof($viewData['data']);
                        
                        $viewData['iniciais'] = substr($viewData['data'][0]['nome_falecido'],0,1) . ' - ';
                        $viewData['iniciais'] .= substr($viewData['data'][sizeof($viewData['data'])-1]['nome_falecido'],0,1);
                        
                        
                        $viewData = array_merge(
                            $this->get('view_data'),
                            $viewData
                        );
                        
                        $viewHtml .= $this->CI->template->load('relatorios','relatorios/templates/planejamento_urbanismo/falecidos_livro_registro','Livro_registro_view',$viewData,TRUE);
                        $viewData['data'] = array();
                        $rowsCount = 0;
                    }
                }
                
                $periodoAnterior = $periodoAtual;
                
                $dataPeriodo = array();
                $dataPeriodo[] = $row;
            }
        }
        
        if($this->CI->input->get_post('pdf')){
            
            $pdf = new mikehaertl\wkhtmlto\Pdf(
                array(
                    'dpi'           =>  '120',
                    'margin-top'    => 0,
                    'margin-right'  => 0,
                    'margin-bottom' => 0,
                    'margin-left'   => 0,
                    'disable-smart-shrinking',
                    'no-outline',                     
                )
            );
            
            $pdf->addPage($viewHtml);
            $pdf->send('livro-registro-falecidos.pdf');
            
            return;
            
        }
        
        echo $viewHtml;
    }
    
    public function validate(Relatorios $relatorio){
        
               
        if($relatorio->variables->get('data_inicio.value') AND $relatorio->variables->get('data_fim.value')){
            
            $relatorio->variables->addRule(
                array(
                    'id'        =>  'data_fim',
                    'rule'      =>  'date_min',
                    'min'       =>  $this->relatorio->variables->get('data_inicio.value'),
                    'message'   =>  'Data final deve ser maior ou igual a data inicial.',   
                )
            );
            
        }
        
        $validation = $relatorio->variables->validate();
        
        if($validation){
            Common::printJson(
                array(
                    'status'        =>  'error',
                    'messages'      =>  array_column($validation,'message'),
                    'errors'        =>  $validation,
                    'console'       =>  'Relatórios | Erros ao preencher formulário',
                )
            );
            return;
        }
        
        Common::printJson(
            array(
                'status'    =>  'ok',
            )
        );
        
    }
    
    /**
     * PRIVATES
     **/
    
}

?>