<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Unidades_familiares_model extends CI_Model{
         
    public function __construct() {
        parent::__construct();
    }

    
    public function getIntegrantesData($arrProp = array()){
        
        
        $arrFilters = $this->getFiltersSearchIntegrante($arrProp);
        
        $sqlWhereIntegrantesUnidadeFamiliar = '';
        if($arrFilters['integrantes']){
            $sqlWhereIntegrantesUnidadeFamiliar = 'AND '.$arrFilters['table_as'].'.id NOT IN('.implode(',',$arrFilters['integrantes']).')';
        }
        
        $sqlWhereUnidadeFamiliar = '';
        if((int)$arrFilters['unidade_familiar']){

            
            if(!($arrProp['full_integrantes']??NULL)){
                $sqlWhereUnidadeFamiliar .= '
                    OR
                ';
            }
            
            $sqlWhereUnidadeFamiliar .= '
                 
                	(
                		(TUnidadesFamiliares.id  = '.(int)$arrFilters['unidade_familiar'].' OR
    	            	TUnidadesFamiliaresIntegrantes.unidades_familiares_id = '.(int)$arrFilters['unidade_familiar'].') AND 
    	                '.$arrFilters['table_as'].'.listas_tipos_pessoas_id  = 1 AND
    	            	'.$arrFilters['table_as'].'.listas_situacoes_cadastros_id = 1 AND 
    	            	'.$arrFilters['table_as'].'.data_falecimento IS NULL
    	            	'.$sqlWhereIntegrantesUnidadeFamiliar.'
                	)
            ';    
        }
        
        $sqlOrderBy = 'ORDER BY '.$arrFilters['table_as'].'.nome ASC';
        if(($arrProp['order']['column']??NULL) != NULL){
           
            $sqlOrderBy = 'ORDER BY ';
           
            $arrColumns = array(
                $arrFilters['table_as'].'.id',
                $arrFilters['table_as'].'.nome',
                $arrFilters['table_as'].'.cpf_cnpj',
                $arrFilters['table_as'].'.nis',
            );
            
            $sqlOrderBy .= $arrColumns[$arrProp['order']['column']];
            $sqlOrderBy .= ' '.($arrProp['order']['dir']??NULL);
        }
        
        $sqlLimit = 'LIMIT 10';
        if($arrProp['limit']??NULL){
            $sqlLimit = 'LIMIT '.$arrProp['limit']['length'];
            $sqlLimit .= ' OFFSET '.$arrProp['limit']['start'];
        }
        
        $sqlWhere = '';
        
        if(!($arrProp['full_integrantes']??NULL)){
            $sqlWhere = '
                (
            		TUnidadesFamiliares.id IS NULL AND
	            	TUnidadesFamiliaresIntegrantes.id IS NULL AND 
	                '.$arrFilters['table_as'].'.listas_tipos_pessoas_id  = 1 AND
	            	'.$arrFilters['table_as'].'.listas_situacoes_cadastros_id = 1 AND 
	            	'.$arrFilters['table_as'].'.data_falecimento IS NULL
                    '.$sqlWhereIntegrantesUnidadeFamiliar.'
            	)
            ';
        }
        
        
        $query = '
            SELECT DISTINCT count(*) OVER() AS full_count, '.$arrFilters['table_as'].'.id, '.$arrFilters['table_as'].'.nome, '.$arrFilters['table_as'].'.cpf_cnpj, '.$arrFilters['table_as'].'.nis, 
            '.$arrFilters['table_as'].'.data_nascimento
            FROM cadastros.pessoas '.$arrFilters['table_as'].' 
            LEFT JOIN cadastros.unidades_familiares TUnidadesFamiliares ON TUnidadesFamiliares.cadastros_pessoas_id_titular = '.$arrFilters['table_as'].'.id
            LEFT JOIN cadastros.unidades_familiares_integrantes TUnidadesFamiliaresIntegrantes ON TUnidadesFamiliaresIntegrantes.cadastros_pessoas_id = '.$arrFilters['table_as'].'.id
            WHERE (
            	
                    '.(($arrFilters['where']??NULL) ? '('.$arrFilters['where'].') AND ' : '').'
                
            	   (
		            	'.$sqlWhere.'
                        
                        '.$sqlWhereUnidadeFamiliar.'
	            	)
                
            )
            '.$sqlOrderBy.'
            '.$sqlLimit.'
        ';
        
        $returnData = $this->database->getExecuteQuery($query);
            
        return $returnData;
    }
    
    public function getPontuacaoEmhab(int $idCadastro){
        
        $arrSituacoesMoradia = array(1,3); //área de risco ou insalubres
        $arrVinculosMoradia = array(4); //tenham sido desabrigadas:
        $arrNecessidadesEspeciais = array(2,4); //Titular ou dependentes com deficiência física ou mental
        $sexoFeminino = 1; //listas.tipos_sexo
        $arrGrausParentescoFilho = array(5);
                      
        $query = '
                    
            WITH 
                renda_unidade_familiar AS(
                	SELECT COALESCE(SUM(remunecarao),0)::float AS remuneracao FROM (
            			SELECT COALESCE(SUM(TPessoasOcupacoes.remuneracao),0) AS remunecarao
            			FROM cadastros.unidades_familiares TUniFamiliar 
            			JOIN cadastros.pessoas TPessoas ON TPessoas.id = TUniFamiliar.cadastros_pessoas_id_titular
            			JOIN cadastros.pessoas_ocupacoes TPessoasOcupacoes ON TPessoasOcupacoes.cadastros_pessoas_id  = TPessoas.id
            			WHERE TUniFamiliar.id  = '.$idCadastro.' AND TPessoasOcupacoes.inativo <> TRUE
            		UNION
            			SELECT COALESCE(SUM(TPessoasOcupacoes.remuneracao),0)::float AS remunecarao
            			FROM cadastros.unidades_familiares TUniFamiliar
            			JOIN cadastros.unidades_familiares_integrantes TUniFamiliarIntegrantes ON TUniFamiliarIntegrantes.unidades_familiares_id = TUniFamiliar.id
            			JOIN cadastros.pessoas_ocupacoes TPessoasOcupacoes ON TPessoasOcupacoes.cadastros_pessoas_id  = TUniFamiliarIntegrantes.cadastros_pessoas_id
            			WHERE TUniFamiliar.id = '.$idCadastro.' AND TPessoasOcupacoes.inativo <> TRUE
            		) x
                ),
                
                integrantes AS(
                	SELECT COUNT(*),
                	COUNT(*) FILTER (WHERE TUniFamiliarIntegrantes.listas_graus_parentesco_id IN('.implode(',',$arrGrausParentescoFilho).') AND date_part(\'year\',age(TIntegrantes.data_nascimento))::int < 14) AS integrante_filho_menor_14_anos,
                	COUNT(*) FILTER (WHERE TIntegrantes.listas_necessidades_especiais_pessoas_id IN('.implode(',',$arrNecessidadesEspeciais).') AND TUniFamiliarIntegrantes.reponsavel_unidade_familiar <> TRUE) AS dependente_necessidade_especial
                	
                	FROM cadastros.unidades_familiares_integrantes TUniFamiliarIntegrantes 
                 	LEFT JOIN cadastros.pessoas TIntegrantes ON TIntegrantes.id = TUniFamiliarIntegrantes.cadastros_pessoas_id
                 	WHERE TUniFamiliarIntegrantes.unidades_familiares_id  = '.$idCadastro.'
                ),
                
                criterios AS(
                	SELECT 
                		TUniFamiliar.id,
                		(CASE WHEN TUniFamiliar.listas_situacoes_moradias_id IN('.implode(',',$arrSituacoesMoradia).') THEN TRUE ELSE FALSE END) as situacao_moradia,
                		(CASE WHEN TUniFamiliar.listas_vinculos_moradias_id IN('.implode(',',$arrVinculosMoradia).') THEN TRUE ELSE FALSE END) as vinculo_moradia,
                		
                		json_build_object(
                    		\'vinculo\',
                    			json_build_object(\'id\',TVinculosMoradias.id,\'descricao\',TVinculosMoradias.descricao),
                    		\'situacao\',
                    			json_build_object(\'id\',TSituacoesMoradias.id,\'descricao\',TSituacoesMoradias.descricao)
                    	) AS moradia,    	
                	(CASE WHEN TPessoas.listas_necessidades_especiais_pessoas_id IN('.implode(',',$arrNecessidadesEspeciais).') THEN TRUE ELSE FALSE END) as titular_necessidade_especial,
                    (CASE WHEN integrantes.dependente_necessidade_especial > 0 THEN TRUE ELSE FALSE END) AS dependente_necessidade_especial,
                	(CASE WHEN (
                			(CASE WHEN TPessoas.listas_tipo_sexo_id = '.$sexoFeminino.' THEN TRUE ELSE FALSE END) = TRUE 
            			    	AND 
            	    		(CASE WHEN COUNT(*) FILTER (WHERE TUniFamiliarIntegrantes.reponsavel_unidade_familiar = TRUE) > 0 THEN TRUE ELSE FALSE END) = FALSE
                		) THEN TRUE
                	ELSE FALSE
            	    	
            	    END ) AS mulher_unica_responsavel,
            	    integrantes.integrante_filho_menor_14_anos,
            	    (CASE WHEN remuneracao <= (1*(SELECT valor::float FROM sistema.parametros WHERE id = 1 LIMIT 1))::float THEN TRUE ELSE FALSE END) AS renda_unidade_familiar_ate_1_sm,
            		(CASE WHEN remuneracao > (1*(SELECT valor::float FROM sistema.parametros WHERE id = 1 LIMIT 1))::float AND remuneracao <= (2*(SELECT valor::float FROM sistema.parametros WHERE id = 1 LIMIT 1))::float THEN TRUE ELSE FALSE END) AS renda_unidade_familiar_1_a_2_sm, 
            		(CASE WHEN remuneracao > (2*(SELECT valor::float FROM sistema.parametros WHERE id = 1 LIMIT 1))::float AND remuneracao <= (3*(SELECT valor::float FROM sistema.parametros WHERE id = 1 LIMIT 1))::float THEN TRUE ELSE FALSE END) AS renda_unidade_familiar_2_a_3_sm, 
            		(CASE WHEN remuneracao > (3*(SELECT valor::float FROM sistema.parametros WHERE id = 1 LIMIT 1))::float THEN TRUE ELSE FALSE END) AS renda_unidade_familiar_maior_3_sm, 
            		renda_unidade_familiar.remuneracao::float AS renda_unidade_familiar,
            		(CASE WHEN date_part(\'year\',age(TPessoas.data_nascimento))::int >= 60 THEN TRUE ELSE FALSE END) titular_maior_igual_60_anos
                	
                	
                	FROM cadastros.unidades_familiares TUniFamiliar
                	JOIN cadastros.pessoas TPessoas ON TPessoas.id = tunifamiliar.cadastros_pessoas_id_titular
                	LEFT JOIN cadastros.unidades_familiares_integrantes TUniFamiliarIntegrantes ON TUniFamiliarIntegrantes.unidades_familiares_id = TUniFamiliar.id
                 	LEFT JOIN cadastros.pessoas TIntegrantes ON TIntegrantes.id = TUniFamiliarIntegrantes.cadastros_pessoas_id
                	LEFT JOIN listas.situacoes_moradias TSituacoesMoradias ON TSituacoesMoradias.id = TUniFamiliar.listas_situacoes_moradias_id
               	    LEFT JOIN listas.vinculos_moradias TVinculosMoradias ON TVinculosMoradias.id = TUniFamiliar.listas_vinculos_moradias_id
                    CROSS JOIN integrantes
                	CROSS JOIN renda_unidade_familiar
                	
                	WHERE TUniFamiliar.id = '.$idCadastro.'
                	
                	GROUP BY TUniFamiliar.id,situacao_moradia,vinculo_moradia,
                	TVinculosMoradias.id,TVinculosMoradias.descricao,TSituacoesMoradias.id,TSituacoesMoradias.descricao,
                	titular_necessidade_especial,dependente_necessidade_especial,TPessoas.listas_tipo_sexo_id,remuneracao,TPessoas.data_nascimento,
                    integrantes.integrante_filho_menor_14_anos
                ),
                
                pontuacao AS (
                	SELECT 
                		id,
                		situacao_moradia,vinculo_moradia,
                		moradia,
                		(CASE WHEN situacao_moradia=TRUE OR vinculo_moradia=TRUE THEN 10 ELSE 0 END) AS pontuacao_situacao_moradia,
                		titular_necessidade_especial,dependente_necessidade_especial,
                		(CASE WHEN titular_necessidade_especial=TRUE OR dependente_necessidade_especial=TRUE THEN 10 ELSE 0 END) AS pontuacao_necessidade_especial,
                		mulher_unica_responsavel,
                		(CASE WHEN mulher_unica_responsavel = TRUE THEN 10 ELSE 0 END) AS pontuacao_mulher_responsavel,
                		integrante_filho_menor_14_anos,
                		(CASE 
                			WHEN integrante_filho_menor_14_anos > 5 THEN 10 
                    		WHEN integrante_filho_menor_14_anos BETWEEN 4 AND 5 THEN 8
                    		WHEN integrante_filho_menor_14_anos BETWEEN 2 AND 3 THEN 6
                    		WHEN integrante_filho_menor_14_anos = 1 THEN 4
                    		ELSE 0
                    		END
                		) pontuacao_integrante_filho_menor_14_anos,
                		renda_unidade_familiar::float,
                        (renda_unidade_familiar::float / (
                            SELECT valor::float
                            FROM sistema.parametros
                            WHERE id = 1
                        )) as renda_familiar_salario_minimo,
                		(CASE 
                    		WHEN renda_unidade_familiar_ate_1_sm = TRUE THEN 10 
                    		WHEN renda_unidade_familiar_1_a_2_sm = TRUE THEN 8
                    		WHEN renda_unidade_familiar_2_a_3_sm = TRUE THEN 6
                    		ELSE 4 
                    	END) AS pontuacao_renda_unidade_familiar,
                    	titular_maior_igual_60_anos,
                    	(CASE WHEN titular_maior_igual_60_anos = TRUE THEN 6 ELSE 0 END) pontuacao_titular_maior_60_anos
                		
                	FROM criterios
                )
                
                SELECT * 
                FROM pontuacao
        ';
        
        
       // temp($query.TRUE);
        $data = $this->database->getExecuteQuery($query);
        
        
        if(!($data[0]??NULL)){
            return NULL;
        }
        
        $dataPontuacaoEmhab = $data[0];
        
        
        $dataPontuacaoEmhab['total_pontos'] = 
            (int)$dataPontuacaoEmhab['pontuacao_situacao_moradia'] +
            (int)$dataPontuacaoEmhab['pontuacao_necessidade_especial'] +
            (int)$dataPontuacaoEmhab['pontuacao_mulher_responsavel'] +
            (int)$dataPontuacaoEmhab['pontuacao_integrante_filho_menor_14_anos'] +
            (int)$dataPontuacaoEmhab['pontuacao_renda_unidade_familiar'] +
            (int)$dataPontuacaoEmhab['pontuacao_titular_maior_60_anos'];
        
       return Json::getFullArray($dataPontuacaoEmhab);
    }
    
    
    public function getPontuacaoLoteamentoSantaFe(int $idCadastro){
        
        $arrVinculosMoradia = array(4); //tenham sido desabrigadas:
        $arrSituacoesMoradia = array(1,3); //área de risco ou insalubres
        
        $sexoFeminino = array(1); //listas.tipos_sexo
        $arrGrausParentescoFilho = array(5);
        $arrProgramasSociais = array(7,48); //bolsa familia, BPC
        
        $query = '
        
        
            WITH 

                integrantes AS(
                	SELECT
                	--filho menor de 18 anos
                	COUNT(*) FILTER (WHERE TUniFamiliarIntegrantes.listas_graus_parentesco_id IN('.implode(',',$arrGrausParentescoFilho).') AND date_part(\'year\',age(TIntegrantes.data_nascimento))::int < 18) AS integrante_filho_menor_18_anos,
                	--mulher responsavel
                	COUNT(*) FILTER (WHERE TIntegrantes.listas_tipo_sexo_id IN('.implode(',',$sexoFeminino).') AND TUniFamiliarIntegrantes.reponsavel_unidade_familiar ) AS integrante_mulher_responsavel,
                	--necessidades especiais
                	COUNT(*) FILTER (WHERE TIntegrantes.listas_necessidades_especiais_pessoas_id NOT IN(1) AND TIntegrantes.listas_necessidades_especiais_pessoas_id NOTNULL) AS integrante_necessidade_especial,
                	--programas sociais
                	COUNT(*) FILTER (WHERE TIntegrantesProgramasSocias.listas_programas_sociais_id IN('.implode(',',$arrProgramasSociais).')) AS integrante_programas_sociais,
                	--doenca cronica incapacitante para trabalho
                	COUNT(*) FILTER (WHERE TIntegrantesDoencasCronicas.incapacitante_trabalho) AS integrante_doenca_cronica_incapacitante_trabalho
                	
                	FROM cadastros.unidades_familiares_integrantes TUniFamiliarIntegrantes 
                 	LEFT JOIN cadastros.pessoas TIntegrantes ON TIntegrantes.id = TUniFamiliarIntegrantes.cadastros_pessoas_id
                 	LEFT JOIN cadastros.pessoas_programas_sociais TIntegrantesProgramasSocias ON TIntegrantesProgramasSocias.cadastros_pessoas_id = TIntegrantes.id
                 	LEFT JOIN cadastros.pessoas_doencas_cronicas TIntegrantesDoencasCronicas ON TIntegrantesDoencasCronicas.cadastros_pessoas_id = TIntegrantes.id
                 	WHERE TUniFamiliarIntegrantes.unidades_familiares_id  = '.$idCadastro.'
                ),
                
                criterios AS(
                	SELECT TUniFamiliar.id, 
                	
                	--vinculo e situacao moradia
                	(CASE WHEN TUniFamiliar.listas_vinculos_moradias_id IN ('.implode(',',$arrVinculosMoradia).') THEN 1 ELSE 0 END) AS vinculo_moradia,
                	(CASE WHEN TUniFamiliar.listas_situacoes_moradias_id IN('.implode(',',$arrSituacoesMoradia).') THEN 1 ELSE 0 END) AS situacao_moradia,
                	
                	--filho menor de 18 anos
                	(CASE WHEN integrantes.integrante_filho_menor_18_anos > 0 THEN 1 ELSE 0 END) AS integrante_filho_menor_18_anos,
                	
                	--mulher responsavel
                	(CASE WHEN TPessoas.listas_tipo_sexo_id  IN('.implode(',',$sexoFeminino).') AND TUniFamiliar.titular_responsavel THEN 1 ELSE 0 END) AS titular_mulher_responsavel,
                	(CASE WHEN integrantes.integrante_mulher_responsavel > 0 THEN 1 ELSE 0 END) integrante_mulher_responsavel,
                	
                	--necessidades especiais
                	(CASE WHEN TPessoas.listas_necessidades_especiais_pessoas_id NOT IN(1) AND TPessoas.listas_necessidades_especiais_pessoas_id NOTNULL THEN 1 ELSE 0 END) AS titular_necessidade_especial,
                	(CASE WHEN integrantes.integrante_necessidade_especial > 0 THEN 1 ELSE 0 END) AS integrante_necessidade_especial,
                	
                	--programas sociais 
                	(CASE WHEN (
                		SELECT COUNT(*)
                		FROM cadastros.pessoas_programas_sociais TTitularProgramasSociais
                		WHERE TTitularProgramasSociais.cadastros_pessoas_id = TUniFamiliar.cadastros_pessoas_id_titular
                		AND TTitularProgramasSociais.listas_programas_sociais_id IN('.implode(',',$arrProgramasSociais).')
                	) > 0 THEN 1 ELSE 0 END) AS titular_programas_sociais,
                	(CASE WHEN integrantes.integrante_programas_sociais > 0 THEN 1 ELSE 0 END) AS integrante_programas_sociais,
                	
                	--doenca cronica incapacitante para trabalho
                	(CASE WHEN (
                		SELECT COUNT(*)
                		FROM cadastros.pessoas_doencas_cronicas TTitularDoencasCronicas
                		WHERE TTitularDoencasCronicas.cadastros_pessoas_id = TUniFamiliar.cadastros_pessoas_id_titular
                		AND TTitularDoencasCronicas.incapacitante_trabalho
                	) > 0 THEN 1 ELSE 0 END) AS titular_doenca_cronica_incapacitante_trabalho,
                	(CASE WHEN integrantes.integrante_doenca_cronica_incapacitante_trabalho > 0 THEN 1 ELSE 0 END) AS integrante_doenca_cronica_incapacitante_trabalho
                	
                	FROM cadastros.unidades_familiares TUniFamiliar
                	JOIN cadastros.pessoas TPessoas ON TPessoas.id = TUniFamiliar.cadastros_pessoas_id_titular
                	CROSS JOIN integrantes
                	WHERE TUniFamiliar.id = '.$idCadastro.'
                )
                
                SELECT *
                FROM criterios
        
        ';
        
        $data = $this->database->getExecuteQuery($query);
        
        
        if(!($data[0]??NULL)){
            return NULL;
        }
        
        $dataPontuacao = $data[0];
        
        
        $dataPontuacao['total_pontos'] = 
        (($dataPontuacao['vinculo_moradia'] OR $dataPontuacao['situacao_moradia']) ? 1 : 0) +
        (($dataPontuacao['integrante_filho_menor_18_anos']) ? 1 : 0) +
        (($dataPontuacao['titular_mulher_responsavel'] OR $dataPontuacao['integrante_mulher_responsavel']) ? 1 : 0) +
        (($dataPontuacao['titular_necessidade_especial'] OR $dataPontuacao['integrante_necessidade_especial']) ? 1 : 0) +
        (($dataPontuacao['titular_programas_sociais'] OR $dataPontuacao['integrante_programas_sociais']) ? 1 : 0) +
        (($dataPontuacao['titular_doenca_cronica_incapacitante_trabalho'] OR $dataPontuacao['integrante_doenca_cronica_incapacitante_trabalho']) ? 1 : 0);
        
       return Json::getFullArray($dataPontuacao);
        
    }
    
    
    public function validate(Cadastros $cadastro){
        
        $cadastro->variables->addRule(
            array(
                'id'        =>  'titular',
                'rule'      =>  'notnull',
                'message'   =>  'Não há um responsável informado.'
            )
        );
        
        if($cadastro->variables->get('titular.value')){
            $cadastro->variables->addRule(
                array(
                    'id'        =>  'titular',
                    'rule'      =>  'unique',
                    'query'     =>  $this->getQueryValidateIntegrante($cadastro,$cadastro->variables->get('titular.value')),
                    'message'   =>  'O responsável selecionado já se inclui em outra Unidade Familiar.'
                )
            );    
        }
        
        if($cadastro->variables->get('integrantes.value')){
            $cadastro->variables->addRule(
                array(
                    'id'        =>  'integrantes.integrantes_integrante',
                    'rule'      =>  'notempty',
                    'message'   =>  'Integrante é campo requerido.',   
                )
            );
        }
        
        
        if($cadastro->variables->get('integrantes.value')){
            
            $arrIdsIntegrantes = array();
            foreach($cadastro->variables->get('integrantes.value') as $rowValue){
                $keyIntegrante = array_search('integrantes_integrante',array_column($rowValue,'id'));
                array_push($arrIdsIntegrantes,(int)$rowValue[$keyIntegrante]['value']);
            }
            
            if($arrIdsIntegrantes){
                
                $cadastro->variables->addRule(
                    array(
                        'id'        =>  'integrantes.integrantes_integrante',
                        'rule'      =>  'unique',
                        'query'     =>  $this->getQueryValidateIntegrante($cadastro,$arrIdsIntegrantes),
                        'message'   =>  'Há integrante(s) selecionado(s) que já se inclui(em) em outra Unidade Familiar.'
                    )
                );     
            }
            
        }
        
        if(boolValue($cadastro->variables->get('atendido_programa_social_emhab.value'))){
            
            $cadastro->variables->addRule(
                array(
                    'id'        =>  'data_atendimento_programa_social_emhab',
                    'rule'      =>  'date',
                    'message'   =>  'Deve ser informada uma data de atendimento em Programa Social da Emhab.',   
                )
            );
        }
        
        if($cadastro->variables->get('acompanhamentos_retorno.value')){
            
            $cadastro->variables->addRule(
                array(
                    'id'        =>  'acompanhamentos_retorno.dt_acompanhamento',
                    'rule'      =>  'date',
                    'message'   =>  'Deve ser informada uma data de presença no acompanhamento de retorno.',   
                )
            );
            
            $cadastro->variables->addRule(
                array(
                    'id'        =>  'acompanhamentos_retorno.descricao_acompanhamento_retorno',
                    'rule'      =>  'notempty',
                    'message'   =>  'Deve ser informada uma descrição para acompanhamento de retorno.',   
                )
            );
        }
        
        $validation = $cadastro->variables->validate();
        
        
        return $validation;
        
    }
    
    public function getEnderecosRepetidos($arrProp = array()){
        
        $query = '
        
            WITH 

                enderecosPessoas AS(
                	SELECT 
                	TUnidadesFamilares.id,
                	to_tsvector(\'simple\',TRIM(unaccent(TEnderecosPessoas.bairro))) AS search_bairro, 
                	to_tsvector(\'simple\',TRIM(unaccent(TEnderecosPessoas.logradouro))) AS search_logradouro,
                	to_tsvector(\'simple\',TRIM(unaccent(TEnderecosPessoas.numero))) AS search_numero,
                	TRIM(unaccent(TEnderecosPessoas.bairro)) AS bairro, 
                	TRIM(unaccent(TEnderecosPessoas.logradouro)) AS logradouro,
                	TRIM(unaccent(TEnderecosPessoas.numero)) AS numero
                	FROM cadastros.unidades_familiares TUnidadesFamilares 
                	JOIN cadastros.pessoas TPessoas ON TPessoas.id = TUnidadesFamilares.cadastros_pessoas_id_titular
                	JOIN cadastros.pessoas_enderecos TEnderecosPessoas ON TEnderecosPessoas.cadastros_pessoas_id = TPessoas.id
                	WHERE NULLIF(TEnderecosPessoas.logradouro,\'\') NOTNULL	
                ),
                
                unidadeFamiliar AS(
                	SELECT 
                	TUnidadesFamilares.id,
                	unaccent(TEnderecosPessoas.bairro) AS bairro, 
                	unaccent(TEnderecosPessoas.logradouro) AS logradouro,
                	unaccent(TEnderecosPessoas.numero) AS numero
                	FROM cadastros.unidades_familiares TUnidadesFamilares 
                	JOIN cadastros.pessoas TPessoas ON TPessoas.id = TUnidadesFamilares.cadastros_pessoas_id_titular
                	JOIN cadastros.pessoas_enderecos TEnderecosPessoas ON TEnderecosPessoas.cadastros_pessoas_id = TPessoas.id
                	WHERE NULLIF(TEnderecosPessoas.logradouro,\'\') NOTNULL
                    AND TUnidadesFamilares.id = '.(int)($arrProp['id_cadastro']??NULL).'
                ),
                
                pesquisa AS(
                	SELECT *
                		
                	FROM unidadeFamiliar
                	JOIN enderecosPessoas ON 
                		enderecosPessoas.search_logradouro @@ to_tsquery(\'simple\',REPLACE(TRIM(regexp_replace(unidadeFamiliar.logradouro, \'[^\w]+\',\' \',\'g\')),\' \',\' & \'))
                		AND enderecosPessoas.search_bairro @@ to_tsquery(\'simple\',REPLACE(TRIM(regexp_replace(unidadeFamiliar.bairro, \'[^\w]+\',\' \',\'g\')),\' \',\' & \'))
                		AND enderecosPessoas.search_numero @@ to_tsquery(\'simple\',REPLACE(TRIM(regexp_replace(unidadeFamiliar.numero, \'[^\w]+\',\' \',\'g\')),\' \',\' & \'))
                		AND enderecosPessoas.id <> unidadeFamiliar.id
                
                )
                
                SELECT pesquisa.*
                FROM pesquisa
        ';
        
        $dataReturn = $this->database->getExecuteSelectQuery($query);
        
        return $dataReturn;
        
        
    }
    /**
     * PRIVATES
     **/
     
    private function getFiltersSearchIntegrante($arrProp = array()){
        
        $arrReturn = array(
            'integrantes'   =>  array(),
        );
        
        $cadastroPessoas = new Cadastros(
            array(
                'requests_id'   =>  array(44)
            )
        );
        $dataItemsPessoas = new DataItems($cadastroPessoas->get());
        $dataItemsPessoas->set('filters',($arrProp['filters']??array()));
        $dataItemsPessoas->set('limit',10);
        $dataItemsPessoas->set('group_by_id',TRUE);
        
        $arrDataSelect = $dataItemsPessoas->getDataSelect();
        
        $arrReturn['table_as'] = '"'.$arrDataSelect['from']['as'].'"';
        
        $arrReturn['where'] = '';
        
        foreach($arrDataSelect['where']??array() as $where){
            $arrReturn['where'] .= $arrReturn['where'] ? ' AND ' : '';
            $arrReturn['where'].=  $where['column'];
        }
        
        
        if($arrProp['data']->get('integrantes')){
            foreach($arrProp['data']->get('integrantes') as $integrantePk){
                if((int)$integrantePk){
                    $arrReturn['integrantes'][] = (int) $integrantePk;    
                }
            }
        }
        
        $arrReturn['unidade_familiar'] = (int) $arrProp['data']->get('unidade_familiar');
        return $arrReturn;
    }
    
    private function getQueryValidateIntegrante(Cadastros $cadastro,$ids){
        
        $ids = string_to_array($ids);
        
        $sqlWhereUnidadeFamiliar = '
            TUnidadesFamiliares.cadastros_pessoas_id_titular NOTNULL
        ';
        
        $sqlWhereUnidadeFamiliarIntregrante = '
            TUnidadesFamiliaresIntegrantes.cadastros_pessoas_id NOTNULL
        ';
        
        if((int)$cadastro->get('item.value')){
            $sqlWhereUnidadeFamiliar .= ' AND TUnidadesFamiliares.id <> \''.$cadastro->get('item.value').'\'';
            $sqlWhereUnidadeFamiliarIntregrante .= ' AND TUnidadesFamiliaresIntegrantes.unidades_familiares_id <> \''.$cadastro->get('item.value').'\'';
        }
        
        $query = '
        
            SELECT TPessoas.id
            FROM cadastros.pessoas TPessoas 
            LEFT JOIN cadastros.unidades_familiares TUnidadesFamiliares ON TUnidadesFamiliares.cadastros_pessoas_id_titular = TPessoas.id
            LEFT JOIN cadastros.unidades_familiares_integrantes TUnidadesFamiliaresIntegrantes ON TUnidadesFamiliaresIntegrantes.cadastros_pessoas_id = TPessoas.id
            WHERE TPessoas.id IN ('.implode(',',$ids).')
            AND (
            	('.$sqlWhereUnidadeFamiliar.')
            		OR
            	('.$sqlWhereUnidadeFamiliarIntregrante.' )
            	)
            
        ';
        
        return $query;
    }
    
}

?>