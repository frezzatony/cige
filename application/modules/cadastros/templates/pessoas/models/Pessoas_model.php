<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH.'/third_party/autoload.php';

class Pessoas_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function validateTipoPessoa(Cadastros $cadastro){
        
        $tipo = (int) $cadastro->variables->get('tipo')->get('value');
                
        $tiposPessoas = new Cadastros(
            array(
                'requests_id'   =>  array('38'),
                'item'
            )
        );
        
        $tiposArmazenados = $tiposPessoas->getItems(
            array(
                'simple_get_items'   =>  TRUE,
                'filters'           =>  array(
                    array(
                        'id'        =>  'id',
                        'clause'    =>  'equal_integer',
                        'value'     =>  $tipo,
                    )
                ),
                'limit' =>  1,
            )
        );
        
        return $tiposArmazenados;
    }
    
    public function validatePessoaFisica(Cadastros $cadastro){
        
        $cadastro->variables->addRule(
            array(
                'id'    =>  'nome',
                'rule'  =>  'length',
                'min'   =>  3,
                'message'   =>  'Nome é campo requerido.'
            )
        );
        $cadastro->variables->addRule(
            array(
                'id'        =>  'cpf_cnpj',
                'rule'      =>  'cpf',
                'message'   =>  'O CPF informádo é inválido.',   
            )
        );
        
        if($cadastro->variables->get('cpf_cnpj.value')){
            
            $cadastro->variables->addRule(
                array(
                    'id'        =>  'cpf_cnpj',
                    'rule'      =>  'unique',
                    'query'     =>  $this->getQueryCPFCNPJUnique($cadastro),
                    'message'   =>  'O CPF informádo já está em uso.',   
                )
            );
                
        }
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'sexo',
                'rule'      =>  'contains',
                'compare'   =>  array(1,2), //feminino,masculino
                'message'   =>  'Sexo deve ser selecionado.',   
            )
        );
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'contatos.contato_descricao',
                'rule'      =>  'notempty',
                'message'   =>  'Descrição de contato é campo requerido.',   
            )
        );
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'ocupacoes.ocupacao_ocupacoes',
                'rule'      =>  'notempty',
                'message'   =>  'Ocupação é campo requerido.',   
            )
        );
        
        if(!boolValue($cadastro->variables->get('aposentado.value'))){
            $cadastro->variables->addRule(
                array(
                    'id'        =>  'ocupacoes.local_trabalho_ocupacoes',
                    'rule'      =>  'notempty',
                    'message'   =>  'Local de trabalho é campo requerido.',   
                )
            );
        }
        
                
        $cadastro->variables->addRule(
            array(
                'id'        =>  'doencas_cronicas.doencas_cronicas_doenca',
                'rule'      =>  'notempty',
                'message'   =>  'Doença crônica é campo requerido.',   
            )
        );
        
        
        $validation = $cadastro->variables->validate();
        
        
        return $validation;
    }
    
    public function validatePessoaJuridica(Cadastros $cadastro){
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'nome',
                'rule'      =>  'notempty',
                'message'   =>  'Razão Social é campo requerido.'
            )
        );
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'cpf_cnpj',
                'rule'      =>  'cnpj',
                'message'   =>  'O CNPJ informádo é inválido.',   
            )
        );
        
        if(boolValue($cadastro->variables->get('mei.value'))){
            $cadastro->variables->addRule(
                array(
                    'id'        =>  'responsavel_mei',
                    'rule'      =>  'notempty',
                    'message'   =>  'Responsável pelo MEI é requerido.',   
                )
            );
            
            if(boolValue($cadastro->variables->get('responsavel_mei.value'))){
                $cadastro->variables->addRule(
                    array(
                        'id'        =>  'responsavel_mei',
                        'rule'      =>  'integer',
                        'message'   =>  'Responsável pelo MEI possui dados inválidos.',   
                    )
                );
                
            }
        }
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'contatos.contato_descricao',
                'rule'      =>  'notempty',
                'message'   =>  'Descrição de contato é campo requerido.',   
            )
        );
        
        $validation = $cadastro->variables->validate();
        
        
        return $validation;
    }
    
    /**
     * PRIVATES
     **/
     
    private function getQueryCPFCNPJUnique(Cadastros $cadastro){
        
        
         if((int)$cadastro->get('item.value')){
            $strWherePessoa = ' AND TPessoas.id::int <> '.(int)$cadastro->get('item.value') .'::int ';
         }
        
        $query = '
        
            SELECT id
            FROM cadastros.pessoas TPessoas
            WHERE cpf_cnpj = \''.$cadastro->variables->get('cpf_cnpj.value').'\'
            '.($strWherePessoa ?? NULL).' 
        
        ';
        
        return $query;
    }
}