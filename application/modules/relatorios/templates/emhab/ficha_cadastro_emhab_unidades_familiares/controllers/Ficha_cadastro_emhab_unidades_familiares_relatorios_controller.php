<?php

/**
 * @author Tony Frezza
 */


class Ficha_cadastro_emhab_unidades_familiares_relatorios_controller extends Data{
    
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
                'action'            =>  102,//id da ação pertinente
            )
        )){
            $this->main_model->erroPermissao();
        }
        
        return array(
            'title'         =>  'Relatório | ',
            'body'          =>  '',
            'modal_size'    =>  'md'
        );
        
    }
    
    public function ficha_cadastro_emhab(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->relatorio->runActionUserPermissions(
            array(
                'action'            =>  102,//id da ação pertinente
            )
        )){            
            $this->main_model->erroPermissao();
        }
        
        if(!(int) $this->CI->input->get_post('unidade_familiar')){
            $this->CI->main_model->erro();
        }
        
        $idCadastro = (int) $this->CI->input->get_post('unidade_familiar');
        
        include(APPPATH.'modules/cadastros/templates/unidades_familiares/models/Unidades_familiares_model.php');
        include(APPPATH.'modules/relatorios/templates/emhab/ficha_cadastro_emhab_unidades_familiares/models/Ficha_cadastro_emhab_unidades_familiares_model.php');
        include(APPPATH.'modules/cadastros/templates/unidades_familiares/data/function_getDataPontuacaoEmhab.php');
        
        $unidadesFamiliaresModel = new Unidades_familiares_model;
        $relatorioModel = new Ficha_cadastro_emhab_unidades_familiares_model;
        
        $criteriosPontuacao = $unidadesFamiliaresModel->getPontuacaoEmhab($idCadastro);        
        
        $dataCadastro = $relatorioModel->getDataCadastro_Emhab(
            array(
                'id_cadastro'       =>  $idCadastro
            )
        );
        
        $viewData = array_merge(
            $this->get('view_data'),
            array(
               'pdf'                =>  $this->CI->input->get_post('pdf'),
               'criteriosPontuacao' =>  $getDataPontuacaoEmhab($criteriosPontuacao),
               'dataCadastro'       =>  $dataCadastro,
            )
        );
        
        $viewHtml =  $this->CI->template->load('relatorios','relatorios/templates/emhab/ficha_cadastro_emhab_unidades_familiares','FichaUnidadeFamiliar_Emhab_view',$viewData,TRUE);
        
        if($viewData['pdf']){
            
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
            $pdf->send('ficha-cadastro.pdf');
            
            return;
            
        }
        
        
        echo $viewHtml; 
                
    }
    
    public function ficha_cadastro_santa_fe(){
        
        //valida e retorna mensagem de erro se não tem permissao minima
        $this->CI->auth_model->login();
        if(!$this->relatorio->runActionUserPermissions(
            array(
                'action'            =>  102,//id da ação pertinente
            )
        )){            
            $this->main_model->erroPermissao();
        }
        
        if(!(int) $this->CI->input->get_post('unidade_familiar')){
            $this->CI->main_model->erro();
        }
        
        $idCadastro = (int) $this->CI->input->get_post('unidade_familiar');
        
        include(APPPATH.'modules/cadastros/templates/unidades_familiares/models/Unidades_familiares_model.php');
        include(APPPATH.'modules/relatorios/templates/emhab/ficha_cadastro_emhab_unidades_familiares/models/Ficha_cadastro_emhab_unidades_familiares_model.php');
        include(APPPATH.'modules/cadastros/templates/unidades_familiares/data/function_getDataPontuacaoSantaFe.php');
        
        $unidadesFamiliaresModel = new Unidades_familiares_model;
        $relatorioModel = new Ficha_cadastro_emhab_unidades_familiares_model;
        
        $criteriosPontuacao = $unidadesFamiliaresModel->getPontuacaoLoteamentoSantaFe($idCadastro);        
        
        $dataCadastro = $relatorioModel->getDataCadastro_Emhab(
            array(
                'id_cadastro'       =>  $idCadastro
            )
        );
        
        $sumRemuneracaoOcupacoes = (float) $dataCadastro[0]['titular_remuneracao_ocupacoes'];
        $sumRemuneracaoProgramasSociais = (float) $dataCadastro[0]['titular_remuneracao_programas_sociais'];
        
        
        foreach($dataCadastro as $key => $row){
            $sumRemuneracaoOcupacoes += (float) $row['remuneracao_ocupacoes_integrante'];
            $sumRemuneracaoProgramasSociais += (float) $row['remuneracao_programas_sociais_integrante'];
        }
        
        $viewData = array_merge(
            $this->get('view_data'),
            array(
               'pdf'                                =>  $this->CI->input->get_post('pdf'),
               'criteriosPontuacao'                 =>  $getDataPontuacaoSantaFe($criteriosPontuacao),
               'dataCadastro'                       =>  $dataCadastro,
               'sum_remuneracao_ocupacoes'          =>   $sumRemuneracaoOcupacoes,
               'sum_remuneracao_programas_sociais'  =>  $sumRemuneracaoProgramasSociais,
               
            )
        );
        
        $viewHtml =  $this->CI->template->load('relatorios','relatorios/templates/emhab/ficha_cadastro_emhab_unidades_familiares','FichaUnidadeFamiliar_Santa_Fe_view',$viewData,TRUE);
        
        if($viewData['pdf']){
            
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
            $pdf->send('ficha-cadastro.pdf');
            
            return;
            
        }
        
        
        echo $viewHtml; 
                
    }
    
    /**
     * PRIVATES
     **/
    
}

?>