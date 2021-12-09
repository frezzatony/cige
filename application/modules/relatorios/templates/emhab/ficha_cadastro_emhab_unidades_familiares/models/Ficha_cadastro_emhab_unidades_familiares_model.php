<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Ficha_cadastro_emhab_unidades_familiares_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function getDataCadastro_Emhab($arrProp = array()){
        
        $sql =  '
            WITH 

                pessoas AS(
                	SELECT TPessoas.*, TNecessidadesEspeciais.descricao AS necessidade_especial_descricao,
                	TTipoSexo.id AS tipo_sexo_id, TTipoSexo.descricao AS tipo_sexo_descricao,
                	TEstadosCivis.id AS estado_civil_id, TEstadosCivis.descricao AS estado_civil_descricao,
                	TEnderecos.logradouro AS logradouro_endereco, TEnderecos.bairro AS bairro_endereco,
                	TEnderecos.numero AS numero_endereco, TEnderecos.cep AS cep_endereco, TEnderecos.complemento AS complemento_endereco,
                	TEnderecos.ponto_referencia AS ponto_referencia_endereco
                	FROM cadastros.pessoas TPessoas
                	LEFT JOIN listas.necessidades_especiais_pessoas TNecessidadesEspeciais ON TNecessidadesEspeciais.id = TPessoas.listas_necessidades_especiais_pessoas_id 
                	LEFT JOIN listas.tipos_sexo TTipoSexo ON TTipoSexo.id = TPessoas.listas_tipo_sexo_id 
                	LEFT JOIN listas.estados_civis TEstadosCivis ON TEstadosCivis.id = TPessoas.listas_estados_civis_id 
                	LEFT JOIN cadastros.pessoas_enderecos TEnderecos ON TEnderecos.cadastros_pessoas_id = TPessoas.id AND TEnderecos.listas_tipos_enderecos_id =1
                ),
                
                sumOcupacoes AS (
                	SELECT cadastros_pessoas_id,sum(remuneracao) AS remuneracao_ocupacoes 
                	FROM cadastros.pessoas_ocupacoes po 
                	WHERE po.inativo = FALSE 
                	GROUP BY po.cadastros_pessoas_id 
                ),
                
                sumProgramasSocias AS (
                	SELECT cadastros_pessoas_id,sum(remuneracao) AS remuneracao_programas_sociais
                	FROM cadastros.pessoas_programas_sociais pps 
                	GROUP BY pps.cadastros_pessoas_id 
                ),
                
                doencasCronicas AS (
                	SELECT TPdc.cadastros_pessoas_id , jsonb_agg(TCid.cid_10) AS cid_10_doenca_cronica, jsonb_agg(TCid.nomenclatura) AS nomenclatura_doenca_cronica, jsonb_agg(Tpdc.incapacitante_trabalho),
                	jsonb_agg(TPdc.incapacitante_trabalho) FILTER (WHERE TPdc.incapacitante_trabalho) AS incapacitante_trabalho
                	FROM cadastros.pessoas_doencas_cronicas TPdc
                	JOIN listas.classificacao_internacional_doencas TCid ON TCid.id = TPdc.listas_classificacao_internacional_doencas_id 
                	GROUP BY TPdc.cadastros_pessoas_id 
                ),
                
                integrantesUnidadeFamiliar AS (
                	SELECT TUFIntegrantes.*, TP.*, TGP.id AS grau_parentesco_id, TGP.descricao AS grau_parentesco_descricao,
                	sumOcupacoes.*,sumProgramasSocias.*,doencasCronicas.*
                	FROM cadastros.unidades_familiares_integrantes TUFIntegrantes
                	JOIN pessoas TP ON TP.id = TUFIntegrantes.cadastros_pessoas_id
                	LEFT JOIN listas.graus_parentesco TGP ON TGP.id = TUFIntegrantes.listas_graus_parentesco_id 
                	LEFT JOIN sumOcupacoes ON sumOcupacoes.cadastros_pessoas_id = TUFIntegrantes.cadastros_pessoas_id
                    LEFT JOIN sumProgramasSocias ON sumProgramasSocias.cadastros_pessoas_id = TUFIntegrantes.cadastros_pessoas_id
                	LEFT JOIN doencasCronicas ON doencasCronicas.cadastros_pessoas_id = TUFIntegrantes.cadastros_pessoas_id 
                )
                
                
                SELECT 
                TUnidadesFamiliares.id, TUnidadesFamiliares.cadunico, TUnidadesFamiliares.data_inicio_residencia,TUnidadesFamiliares.atendido_programa_social_emhab,
                TUnidadesFamiliares.data_atendimento_programa_social_emhab,TUnidadesFamiliares.observacoes,
                TVinculosMoradias.id AS vinculo_moradia_id, TVinculosMoradias.descricao AS vinculo_moradia_descricao,
                TTiposMoradias.id AS tipo_moradia_id, TTiposMoradias.descricao AS tipo_moradia_descricao,
                TTiposSistemasConstrutivos.id AS sistema_construtivo_id, TTiposSistemasConstrutivos.descricao AS sistema_construtivo_moradia_descricao,
                TSituacoesMoradias.id AS situacao_moradia_id, TSituacoesMoradias.descricao AS situacao_moradia_descricao,
                TProgramasSociaisEmhab.id AS programa_interesse_emhab_id, TProgramasSociaisEmhab.descricao AS programa_interesse_emhab_descricao,
                TProgramasSociaisEmhabAtendido.id AS programa_atendido_emhab_id, TProgramasSociaisEmhabAtendido.descricao AS programa_atendido_emhab_descricao,
                
                TTitular.nome AS titular_nome, TTitular.data_nascimento AS titular_data_nascimento, TTitular.tipo_sexo_id AS titular_tipo_sexo_id, TTitular.tipo_sexo_descricao AS titular_tipo_sexo_descricao,
                TTitular.cpf_cnpj AS titular_cpf, TTitular.rg AS titular_rg, TTitular.nis AS titular_nis, TTitular.certidao_nascimento AS titular_certidao_nascimento,
                TTitular.certidao_casamento AS titular_certidao_casamento, TTitular.pis_pasep AS titular_pis_pasep,
                TTitular.ctps AS titular_ctps, TTitular.serie_ctps AS titular_serie_ctps,
                TTitular.titulo_eleitor AS titular_titulo_eleitor, TTitular.zona_titulo_eleitor AS titular_zona_titulo_eleitor,TTitular.secao_titulo_eleitor AS titular_secao_titulo_eleitor,
                TTitular.cartao_sus AS titular_cartao_sus, TTitular.estado_civil_id AS titular_estado_civil_id, TTitular.estado_civil_descricao AS titular_estado_civil_descricao,
                TTitular.necessidade_especial_descricao AS necessidade_especial_descricao_titular, TTitular.observacoes_necessidade_especial AS observacoes_necessidade_especial_titular,
                TTitular.capaz_trabalho,
                sumOcupacoesTitular.remuneracao_ocupacoes AS titular_remuneracao_ocupacoes, sumProgramasSociasTitular.remuneracao_programas_sociais AS titular_remuneracao_programas_sociais,
                doencasCronicasTitular.cid_10_doenca_cronica AS cid_10_doencas_cronicas_titular, doencasCronicasTitular.nomenclatura_doenca_cronica AS nomenclatura_doencas_cronicas_titular, 
                doencasCronicasTitular.incapacitante_trabalho AS incapacitante_trabalho_doencas_cronicas_titular,
                
                TTitular.logradouro_endereco AS logradouro_endereco_titular, TTitular.bairro_endereco AS bairro_endereco_titular, TTitular.numero_endereco AS numero_endereco_titular,
                TTitular.cep_endereco AS cep_endereco_titular, TTitular.complemento_endereco AS complemento_endereco_titular, TTitular.ponto_referencia_endereco AS ponto_referencia_endereco_titular,
                
                integrantesUnidadeFamiliar.nome AS integrante_nome, integrantesUnidadeFamiliar.grau_parentesco_id AS integrante_grau_parentesco_id, 
                integrantesUnidadeFamiliar.grau_parentesco_descricao AS integrante_grau_parentesco_descricao,
                integrantesUnidadeFamiliar.data_nascimento AS integrante_data_nascimento, integrantesUnidadeFamiliar.reponsavel_unidade_familiar AS integrante_reponsavel_unidade_familiar,
                integrantesUnidadeFamiliar.cid_10_doenca_cronica AS cid_10_doencas_cronicas_integrante, integrantesUnidadeFamiliar.nomenclatura_doenca_cronica AS nomenclatura_doencas_cronicas_integrante,
                integrantesUnidadeFamiliar.necessidade_especial_descricao AS necessidade_especial_descricao_integrante, 
                integrantesUnidadeFamiliar.remuneracao_ocupacoes AS remuneracao_ocupacoes_integrante, integrantesUnidadeFamiliar.remuneracao_programas_sociais as remuneracao_programas_sociais_integrante
                
                FROM cadastros.unidades_familiares TUnidadesFamiliares
                LEFT JOIN listas.vinculos_moradias TVinculosMoradias ON TVinculosMoradias.id = TUnidadesFamiliares.listas_vinculos_moradias_id 
                LEFT JOIN listas.tipos_moradias TTiposMoradias ON TTiposMoradias.id = TUnidadesFamiliares.listas_tipos_moradias_id 
                LEFT JOIN listas.situacoes_moradias TSituacoesMoradias ON TSituacoesMoradias.id = TUnidadesFamiliares.listas_situacoes_moradias_id 
                LEFT JOIN listas.tipos_sistemas_construtivos TTiposSistemasConstrutivos ON TTiposSistemasConstrutivos.id = TUnidadesFamiliares.listas_tipos_sistemas_construtivos_id_moradia 
                LEFT JOIN listas.programas_sociais_emhab TProgramasSociaisEmhab ON TProgramasSociaisEmhab.id = TUnidadesFamiliares.listas_programas_sociais_emhab_id
                LEFT JOIN listas.programas_sociais_emhab TProgramasSociaisEmhabAtendido ON TProgramasSociaisEmhabAtendido.id = TUnidadesFamiliares.listas_programas_sociais_emhab_atendido 
                
                INNER JOIN pessoas AS TTitular ON TTitular.id = TUnidadesFamiliares.cadastros_pessoas_id_titular
                
                LEFT JOIN sumOcupacoes AS sumOcupacoesTitular ON sumOcupacoesTitular.cadastros_pessoas_id = TUnidadesFamiliares.cadastros_pessoas_id_titular
                LEFT JOIN sumProgramasSocias AS sumProgramasSociasTitular ON sumProgramasSociasTitular.cadastros_pessoas_id = TUnidadesFamiliares.cadastros_pessoas_id_titular
                LEFT JOIN doencasCronicas AS doencasCronicasTitular ON doencasCronicasTitular.cadastros_pessoas_id = TUnidadesFamiliares.cadastros_pessoas_id_titular
                
                LEFT JOIN integrantesUnidadeFamiliar ON integrantesUnidadeFamiliar.unidades_familiares_id = TUnidadesFamiliares.id
                
                                
                WHERE TUnidadesFamiliares.id = '.$arrProp['id_cadastro'].'
        
        ';  
        
        $data = $this->database->getExecuteSelectQuery($sql);
        
        return $data;
    }
    
    /**
     * PRIVATES
     **/
    
}