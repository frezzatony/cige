<?php



function append(&$source,$append,$delimiter = ' '){
        
    if(is_null($source)){
        $source = '';
    }
    
    if(is_array($source)){
        if(is_array($append)){
            $source = array_merge($source,$append);    
        }
        else{
            $source[] = $append;
        }
        
    }
    else if(is_string($source) AND is_array($append)){
        $append = implode($delimiter,$append);
        
        $source .= $delimiter .$append;
            
    }
    else{
        
        $source .= $delimiter .$append;
    }
    
    return $source;
}

function colsFromArray(array $array, $keys){
    if (!is_array($keys)) $keys = [$keys];
    return array_map(function ($el) use ($keys) {
        $o = [];
        foreach($keys as $key){
            //  if(isset($el[$key]))$o[$key] = $el[$key]; //you can do it this way if you don't want to set a default for missing keys.
            $o[$key] = isset($el[$key])?$el[$key]:false;
        }
        return $o;
    }, $array);
}

function boolValue($value){
    
    if(!$value OR in_array(clearSpecialChars(strtoMINusculo($value)),array('nao','n','f','false'))){
        return FALSE;
    }
    
    
    return TRUE;
}
function merge(&$source,$merge){
    
    if(is_string($source) AND is_string($merge)){
        $souce += $merge;
    }
    
    if(is_array($source) AND is_array($merge)){
        foreach($merge as $keyMerge => $valMerge){
            if(!($source[$keyMerge]??NULL)  OR !is_array($source[$keyMerge])){
                
                $source[$keyMerge] = $valMerge;
            }
            else{
                merge($souce[$keyMerge],$valMerge);
            }
        }
    }
    
    return $source; 
    
}

function string_to_array($string,$delimiter = ' '){
    
    if(is_array($string)){
        return $string;
    }
    
    return explode($delimiter,$string);
    
}

function meses(int $mes){
    
    return array(
        1   =>  'JANEIRO',  2   =>  'FEVEREIRO',    3   =>  'MARÇO',
        4   =>  'ABRIL',    5   =>  'MAIO',         6   =>  'JUNHO',
        7   =>  'JULHO',    8   =>  'AGOSTO',       9   =>  'SETEMBRO',
        10  =>  'OUTUBRO',  11  =>  'NOVEMBRO',     12  =>  'DEZEMBRO'
        
    
    )[$mes]??NULL;
}

function dataExtenso(){
    
    return strftime('%d de %B de %Y', strtotime('today'));
    
}
?>