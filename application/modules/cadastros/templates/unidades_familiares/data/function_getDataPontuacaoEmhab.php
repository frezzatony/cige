<?php

/**
 * @author Tony Frezza
 */



$getDataPontuacaoEmhab = function($criteriosEmhab){
    
    if(!$criteriosEmhab){
        return NULL;
    }
       
    $strMoradia = '';
    if(boolValue($criteriosEmhab['vinculo_moradia'])){
        $strMoradia = strtoUCFirst($criteriosEmhab['moradia']['vinculo']['descricao'] ?? NULL);    
    }
    
    if(boolValue($criteriosEmhab['situacao_moradia'])){
        $strMoradia .= ($strMoradia??NULL ?'/':'') . strtoUCFirst($criteriosEmhab['moradia']['situacao']['descricao']??NULL);    
    }
    
    
    $arrReturn = array(
            array(
                array(
                    'text'      =>  'a) Famílias residentes em área de risco ou insalubres ou que tenham sido desabrigadas'
                ),
                array(
                    'text'      =>  $strMoradia ? $strMoradia : 'Não',
                ),
                array(
                    'text'      =>  $criteriosEmhab['pontuacao_situacao_moradia'],
                ),
            ),
            array(
                array(
                    'text'      =>  'b) Titular ou dependentes com deficiência física ou mental'
                ),
                array(
                    'text'      =>  (boolValue($criteriosEmhab['titular_necessidade_especial']) OR boolValue($criteriosEmhab['dependente_necessidade_especial'])) ? 'Sim' : 'Não', 
                ),
                array(
                    'text'      =>  $criteriosEmhab['pontuacao_necessidade_especial']
                ),
            ),
            array(
                array(
                    'text'      =>  'c) Família em que a mulher é a única responsável pela unidade familiar'
                ),
                array(
                    'text'      =>  (boolValue($criteriosEmhab['mulher_unica_responsavel'])) ? 'Sim' : 'Não',
                ),
                array(
                    'text'      =>  $criteriosEmhab['pontuacao_mulher_responsavel'],
                ),
            ),
            array(
                array(
                    'text'      =>  'd) Número de filhos com idade abaixo de 14 anos'
                ),
                array(
                    'text'      =>  $criteriosEmhab['integrante_filho_menor_14_anos'],
                ),
                array(
                    'text'      =>  $criteriosEmhab['pontuacao_integrante_filho_menor_14_anos'],
                ),
            ),
            array(
                array(
                    'text'      =>  'e) Renda Familiar (em salários mínimos SM)'
                ),
                array(
                    'text'      =>  formataFLOATImprime($criteriosEmhab['renda_familiar_salario_minimo']),
                ),
                array(
                    'text'      =>  $criteriosEmhab['pontuacao_renda_unidade_familiar'],
                ),
            ),
            array(
                array(
                    'text'      =>  'f) Titular com idade igual ou superior a 60 anos'
                ),
                array(
                    'text'      =>  (boolValue($criteriosEmhab['titular_maior_igual_60_anos'])) ? 'Sim' : 'Não',
                ),
                array(
                    'text'      =>  $criteriosEmhab['pontuacao_titular_maior_60_anos'],
                ),
            ),
            array(
                array(
                    'text'      =>  '',
                    'class'     =>  array('noborder'),
                ),
                array(
                    'text'      =>  'Soma pontuação',
                    'class'     =>  array('noborder','text-right','bold'),
                ),
                array(
                    'text'      =>   $criteriosEmhab['total_pontos'],
                    'class'     =>  array('noborder','bold'),
                ),
            ),
        );
         
        return $arrReturn;
}  
?>