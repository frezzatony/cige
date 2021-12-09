<?php

/**
 * @author Tony Frezza
 * @copyright 2016
 */
    
    $loadedPlugins = $this->input->get('loadedPlugins');
    
    
    $functionsCall = '';
    foreach($plugins as $plugin){
        if(!isset($this->config->item('plugins')[$plugin]['css'])){
            continue;
        }
        $functionsCall .= "\n\t\t\t".$plugin.'();';
        
        $src = '<link rel="stylesheet" href="'.BASE_URL;
        $src .= $this->config->item('plugins')[$plugin]['css'];
        $src .= '">';
        echo "\n\t\t".$src;    
        
    }
    echo "\n";

?>