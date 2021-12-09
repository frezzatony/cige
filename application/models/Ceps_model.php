<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ceps_model extends CI_Model{
       
    function __construct(){
        parent::__construct(); 
    }
    
    
    public function getEndereco($arrProp = array()){
        
        include_once APPPATH.'/third_party/Requests/Requests.php';
        Requests::register_autoloader();
        
        $request = Requests::get('https://viacep.com.br/ws/'.$this->db->escape_str($arrProp['cep']??NULL).'/json/');
        
        $data = JSON::getFullArray($request->body);
        
        if(($data['erro']??NULL) OR $request->status_code!= 200){
            
            return array(
                'erro'      =>  TRUE
            );
        }
        
        if(!$this->validateCidade($data)){
            $this->insertCidade($data);
        }
        
        $dataEndereco = $this->getCidade($data);
        
        $dataEndereco = array_pop($dataEndereco);
        $dataEndereco = $this->common->append($dataEndereco,$data);
        $dataEndereco['cep'] = preg_replace("/[^0-9]/", "",$dataEndereco['cep']);
        $dataEndereco['erro'] = FALSE;
        
        return $dataEndereco;
        
    }
    
    /**
     * PRIVATES
     **/
    
    private function getCidade($arrProp = array()){
        
        $sql = '
            SELECT TCidades.id as cidade_id, TCidades.nome as cidade_nome, TEstados.id as estado_id, TEstados.nome as estado_nome, TEstados.abreviatura as estado_uf
            FROM cadastros.cidades TCidades
            JOIN cadastros.estados TEstados ON TEstados.id = TCidades.cadastros_estados_id 
            WHERE unaccent(TCidades.nome)::citext = unaccent(\''.$this->db->escape_str($arrProp['localidade']).'\')::citext
            AND TEstados.abreviatura::citext = \''.$this->db->escape_str($arrProp['uf']).'\'::citext
            LIMIT 1
        ';
        
        
        $data = $this->database->getExecuteQuery($sql);
        
        return $data;
            
    }
    
    private function validateCidade($arrProp = array()){
        
        
        return count($this->getCidade($arrProp));     
    }
    
    private function insertCidade($arrProp = array()){
        
        //determina qual estado pertence
        $sql = '
            SELECT *
            FROM cadastros.estados TEstados
            WHERE abreviatura::citext = \''.$this->db->escape_str($arrProp['uf']).'\'::citext
            LIMIT 1
        ';
        
        $dataEstado = $this->database->getExecuteQuery($sql);
        
        if(!count($dataEstado)){
            $this->main_model->erro();
        }
        $dataEstado = array_pop($dataEstado);
        
        
        
        //insert nova cidade        
        $cadastroCidades = new Cadastros(
            array(
                'requests_id'   =>  array(16)
            )
        );
                
        $cadastroCidades->mergeValues(
            array(
                'method'        =>  'database',
                'values'        =>  array(
                    array(
                        'id'        =>  'nome',
                        'value'     =>  strtoMAIsuculo($this->db->escape_str($arrProp['localidade'])),
                    ),
                    array(
                        'id'        =>  'estado',
                        'value'     =>  $dataEstado['id'],  
                    ),
                    array(
                        'id'        =>  'situacao',
                        'value'     =>  1
                    )
                ),
            )
        );  
        
        $responseUpdate = $cadastroCidades->update();
        
        return $responseUpdate;
    }
}
