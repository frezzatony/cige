<?php

/**
 * @author Tony Frezza
 */


if(
    
    ($this->cadastro->variables->get('processo_situacao.value')==9)
    AND
    !$this->cadastro->runActionUserPermissions(
        array(
            'action'            =>  113, //Alterar situação de Revisão de Iptu já encerrada
        )
    )
    
    
        
){
    return array(); 
}

return array(
    array(
        'type'          =>  'button',
        'action'        =>  105,
        'class'         =>  'btn btn-secondary btn-3d btn-sm cadastro-save-item',
        'text'          =>  '&nbsp;<i class="fa fa-save"></i>&nbsp;&nbsp;Salvar&nbsp;&nbsp;',
    ),
    array(
        'type'          =>  'button',
        'action'        =>  105,
        'class'         =>  'btn btn-primary btn-3d btn-sm margin-left-8 cadastro-save-item-close',
        'text'          =>  '&nbsp;<i class="fa fa-save"></i>&nbsp;&nbsp;Salvar e fechar&nbsp;&nbsp;',
    ),
)


?>