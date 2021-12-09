<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Falecidos_livro_registro_relatorio_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function getData($arrProp = array()){
        
        
        $sqlWhere = '';
        
        
        if($arrProp['data_inicio']??NULL){
            $sqlWhere .= $sqlWhere ? ' AND ' : '';
            $sqlWhere .= 'TFalecidos.data_falecimento >= \''.$arrProp['data_inicio'].'\''; 
        }
        if($arrProp['data_fim']??NULL){
            $sqlWhere .= $sqlWhere ? ' AND ' : '';
            $sqlWhere .= 'TFalecidos.data_falecimento <= \''.$arrProp['data_fim'].'\''; 
        }
        
        
        $sql =  '
            
            SELECT TFalecidos.data_falecimento, TFalecidos.hora_falecimento, TFalecidos.nome_falecido, TFalecidos.idade_falecido,
            TCemiterios.nome AS cemiterio, TFalecidos.quadra, TFalecidos.fileira, TFalecidos.sepultura, 
            (CASE WHEN TFalecidos.lado = 1 THEN \'Direito\' WHEN TFalecidos.lado = 2 THEN \'Esquerdo\' END) AS lado,
            TFalecidos.nome_mae_falecido, TFalecidos.nome_pai_falecido, 
            TFalecidos.termo_certidao_obito, TFalecidos.folhas, TFalecidos.livro, TFalecidos.caixa_arquivo, 
            TSituacoesCemiterio.descricao as situcao_tumulo
            
            FROM cadastros.falecidos TFalecidos
            
            LEFT JOIN cadastros.cemiterios TCemiterios ON TCemiterios.id = TFalecidos.cadastros_cemiterios_id
            LEFT JOIN listas.situacoes_terrenos_cemiterios TSituacoesCemiterio ON TSituacoesCemiterio.id = TFalecidos.listas_situacoes_terrenos_cemiterios_id
            
            '.( $sqlWhere ? ('WHERE '.$sqlWhere) : '').'
            ORDER BY data_falecimento ASC, hora_falecimento ASC
        
        ';  
        
        $data = $this->database->getExecuteSelectQuery($sql);
        
        return $data;
    }
    
    /**
     * PRIVATES
     **/
    
}