<?php
/**
 * CodeIgniter
 *
 * DESENVOLVIDO INTERNAMENTE
 */
defined('BASEPATH') OR exit('No direct script access allowed');
    

function replace_db ($str) {
    
    $arrSource = array(
        '\\','\'','%'
    );
    
    $arrReplace = array(
        '\\\\','\'\'','\\%'
    );
    return str_replace($arrSource,$arrReplace, $str);
}
        
if(!function_exists('formataDataDatabase')){
   
    function formataDataDatabase($data){
        
        if($data == ''){
            return '';
        }
        
        return substr($data,4,4).'-'.substr($data,2,2).'-'.substr($data,0,2);
        if(validate_date($data)){
            return $data;
        }
        
        return implode("-",array_reverse(explode("/",$data)));
    }    
}
        
        
if(!function_exists('formataDataImprime')){
    
    function formataDataImprime($arrProp = array()){
        
        
        if((!isset($arrProp['data'])) || ($arrProp['data'] == "") || (str_replace("-","",$arrProp['data']) == "0"))
            if(is_string($arrProp)){
                $arrProp = array(
                    'data'  =>  $arrProp
                );
            }
            
         if(isset($arrProp['dtAtual']) AND $arrProp['dtAtual'] ){
            $arrProp['data'] = date("Y-m-d");
        }
        
        if(strlen($arrProp['data']) != 10 AND strlen($arrProp['data']) !=8 ){
            return null;
        }
        
        if(strpos($arrProp['data'],'-')==2 || strpos($arrProp['data'],'/')==2){
            return $arrProp['data'];
        }
        
        $dataFIM = substr($arrProp['data'],8,2);
        
        $dataFIM .= (isset($arrProp['delimitador_data']) ? $arrProp['delimitador_data'] : '/') . substr($arrProp['data'],5,2);
        $dataFIM .= (isset($arrProp['delimitador_data']) ? $arrProp['delimitador_data'] : '/') . substr($arrProp['data'],0,4);
        
        return $dataFIM;
    }   
}        
        
if(!function_exists('formataDataHoraImprime')){
    
    function formataDataHoraImprime($arrProp){
        
        if(($arrProp['data'] == "") || (str_replace("-","",$arrProp['data']) == "0"))
            return null;
            
        if(isset($arrProp['now']) AND $arrProp['now']){
            $arrProp['data'] = date("Y-m-d H:i:s");
        }
        $dataFIM = substr($arrProp['data'],8,2);
        $dataFIM .= (isset($arrProp['delimitador_data']) ? $arrProp['delimitador_data'] : '/') . substr($arrProp['data'],5,2);
        $dataFIM .= (isset($arrProp['delimitador_data']) ? $arrProp['delimitador_data'] : '/') . substr($arrProp['data'],0,4);
        $dataFIM .= " -" . substr($arrProp['data'],10,6);
        $dataFIM .= 'h';
        return $dataFIM;
    }
}        

if(!function_exists('formataFLOAT')){
    
    function formataFLOAT($float){
        
        if(is_float(filter_var($float, FILTER_VALIDATE_FLOAT))){
            return $float;
        }
        
        if(!$float){
            return '';
        }
        
        $float = str_replace(".","",$float);
        $float = str_replace(",",".",$float);
        $float = number_format($float,2,'.','');
        
        return $float;
    }
}
        
if(!function_exists('formataFLOATImprime')){
    
    function formataFLOATImprime($float=''){
        
        if(!is_numeric($float) ){
            return $float;
        }
        
        $float =  number_format($float,2,',','.');
        //settype($float,'float');
        return $float;       
    }   
}
       
        
if(!function_exists('formataCamposINSERT')){
    
    function formataCamposINSERT($nomeCampo,$val){
        $val = utf8_decode($val);
        $val = anti_sql_injection($val);
        $Caracteres = new tratamentoCaracteres;            
        
        if($Caracteres->strtoMINusculo(substr($nomeCampo,0,4)) == "data"){ ;
            return formataData($val);
        }
        if($Caracteres->strtoMINusculo(substr($nomeCampo,0,3)) == "flt"){ ;
            return formataFLOAT($val);
        }
        if($Caracteres->strtoMINusculo(substr($nomeCampo,0,3)) == "cep"){ ;
            $val = str_replace('.','',$val);
            $val = str_replace('-','',$val);
            return $val;
        }
        if($Caracteres->strtoMINusculo(substr($nomeCampo,0,3)) == "cpf"){ ;
            $val = str_replace('.','',$val);
            $val = str_replace('-','',$val);
            return $val;
        }
        else
            return $val;
    }   
}
                   
        
if(!function_exists('toUtf8')){
    
    function toUtf8($str){
        return iconv("iso-8859-1","utf-8",$str);
    }    
}
        
if(!function_exists('toIso8859')){
    
    function toIso8859($str){
        return iconv("utf-8","iso-8859-1",$str);
    }   
}

if(!function_exists('validate_date')){
    function validate_date($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d AND $d->format($format) === $date;
}   
}

function isTimestamp($string){
    try {
        new DateTime('@' . $string);
    } catch(Exception $e) {
        return false;
    }
    return true;
}

function pra($array=array(),$exit=false){
    echo '<pre>';
    print_R($array);
    echo '</pre>';
    if($exit){
        exit;
    }
}

function temp($valor,$truncate=FALSE){
    
    $CI = &get_instance();
    
    if($truncate){
        $CI->db->query('TRUNCATE TABLE public.temp RESTART IDENTITY CASCADE;');
    }
    
    
    if(is_array($valor)){
        $valor = json_encode($valor,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    
    
    
    $CI->db->insert('public.temp',array('valor'=>$valor));
}

        