<?php

/**
 * @author Tony Frezza
 */



$getDataPontuacaoSantaFe = function($criterios){
    
    if(!$criterios){
        return NULL;
    }
       
        
    $arrReturn = array(
            array(
                array(
                    'text'      =>  'a) Famílias residentes em área de risco, ou insalubres, ou que tenham sido desabrigadas'
                ),
                array(
                    'text'      =>  (($criterios['vinculo_moradia'] OR $criterios['situacao_moradia']) ? 'Sim' : 'Não'),
                ),
            ),
            array(
                array(
                    'text'      =>  'b) Famílias com mulher responsável pela unidade familiar'
                ),
                array(
                    'text'      =>  (($criterios['titular_mulher_responsavel'] OR $criterios['integrante_mulher_responsavel']) ? 'Sim' : 'Não'),
                ),
            ),
            array(
                array(
                    'text'      =>  'c) Famílias com integrante com deficiência (PCD)',
                ),
                array(
                    'text'      =>  (($criterios['titular_necessidade_especial'] OR $criterios['integrante_necessidade_especial']) ? 'Sim' : 'Não'),
                ),
            ),
            array(
                array(
                    'text'      =>  'd) Famílias beneficiadas por Benefício de Prestação Continuada (BPC) ou Bolsa Família',
                ),
                array(
                    'text'      =>  (($criterios['titular_programas_sociais'] OR $criterios['integrante_programas_sociais']) ? 'Sim' : 'Não'),
                ),
            ),
            array(
                array(
                    'text'      =>  'e) Famílias com filhos em idade inferior a 18 anos',
                ),
                array(
                    'text'      =>  (($criterios['integrante_filho_menor_18_anos']) ? 'Sim' : 'Não'),
                ),
            ),
            array(
                array(
                    'text'      =>  'f) Famílias com integrante que possua Doença Crônica Incapacitante para o Trabalho',
                ),
                array(
                    'text'      =>  (($criterios['titular_doenca_cronica_incapacitante_trabalho'] OR $criterios['integrante_doenca_cronica_incapacitante_trabalho']) ? 'Sim' : 'Não'),
                ),
            ),
            
            array(
                
                array(
                    'text'      =>  'Total de critérios',
                    'class'     =>  array('noborder','text-right','bold'),
                ),
                array(
                    'text'      =>   $criterios['total_pontos'],
                    'class'     =>  array('noborder','bold'),
                ),
            ),
        );
         
        return $arrReturn;
}  
?>