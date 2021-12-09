<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Controle_revisoes_iptu_model extends CI_Model{
         
    public function __construct() {
        parent::__construct();
    }
    
    
    public function receberRevisao(Cadastros $cadastro,$arrProp = array()){
        
        $cadastro->variables->set($cadastro->variables->getData());
        $cadastro->variables->set('processo_responsavel',array('value'=>$arrProp['idResponsavel']));
        $cadastro->variables->set('processo_dt_atribuicao_responsavel',
            array(
                'value' =>  date('d/m/Y'),
                'no_db' =>  FALSE,
            )
        );
        
        
        $responseUpdate = $cadastro->update();
        
        if(is_array($responseUpdate)){
            return $responseUpdate;
        }
        
        $varResponsavelData = $cadastro->variables->get('processo_responsavel')->get();
        $varResponsavelDtAtribuicaoData = $cadastro->variables->get('processo_dt_atribuicao_responsavel')->get();
        
        //LOG DE ATIVIDADE DO CADASTRO
        $this->logger->setLog(
            array(
                'schema'        =>  ($cadastro->get('data.schema') ?? $this->config->item('db_log_schema','cadastros')).'_'.$this->config->item('db_log_sufix','cadastros'),
                'table_log'     =>  ($cadastro->get('data.schema') ?? $this->config->item('db_log_schema','cadastros')).'_'.$cadastro->get('data.table'),
                'item_id'       =>  $cadastro->get('item.value'),
                'action'        =>  'UPDATE',
                'user_id'       =>  $this->data->get('user.id'),
                'data'          =>  array(
                    'inputs'        =>  array(
                        array(
                            'id'        =>  $varResponsavelData['id'],
                            'value'     =>  $varResponsavelData['value'] ?? NULL,
                            'old_value' =>  $varResponsavelData['old_value'] ?? NULL,
                            'text'      =>  $varResponsavelData['text'] ?? NULL,
                            'old_text'  =>  $varResponsavelData['old_text'] ?? NULL,
                        ),
                        array(
                            'id'        =>  $varResponsavelDtAtribuicaoData['id'],
                            'value'     =>  $varResponsavelDtAtribuicaoData['value'] ?? NULL,
                            'old_value' =>  $varResponsavelDtAtribuicaoData['old_value'] ?? NULL,
                            'text'      =>  $varResponsavelDtAtribuicaoData['text'] ?? NULL,
                            'old_text'  =>  $varResponsavelDtAtribuicaoData['old_text'] ?? NULL,
                        ),
                    )
                )
            )
        );
        
        return TRUE;  
    }
    
    
    public function setVariables(Cadastros &$cadastro){
        
        if( $cadastro->variables->get('processo_situacao.value')==9 AND
            !$cadastro->variables->get('processo_dt_encerramento.value')
        ){
            
            $cadastro->variables->set('processo_dt_encerramento',array('value'=>NOW));
                
        }
        
    }
    
    
    public function validate(Cadastros $cadastro){
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'pessoa_solicitante',
                'rule'      =>  'notnull',
                'message'   =>  'Não há um solicitante informado.'
            )
        );
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'pessoa_proprietario',
                'rule'      =>  'notnull',
                'message'   =>  'Não há um proprietário informado.'
            )
        );
        
        
        $validation = $cadastro->variables->validate();
        
        
        if(!$cadastro->variables->get('itens_revisar.value')){
            $validation[] = array(
                'id'        =>  'itens_revisar',
                'rule'      =>  'notempty',
                'message'   =>  'Não há itens a revisar selecionados.',
                'key'       =>  random_string(),
            );
        }
        
        
        
        
        return $validation;
        
    }
    
    /**
     * PRIVATES
     **/
    
    
}

?>