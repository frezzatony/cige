<?php

/**
 * @author Tony Frezza
 */


	

?>

function dispositivos_cadastros(){
    
    var container = $('input.container-cadastro').closest('div.modal-body');
    var actionMenu = container.find('.cadastro-item-actionmenu');
    
    var selectTipo = container.find('select#tipo');

    if(!selectTipo.length){
        return false;
    }
    
    
    var setItemMenu = function(){
        var newItemMenuNode = actionMenu.find('.novo-item').eq(0);
        var arrHrefNewItem = newItemMenuNode.attr('href').split('?');
        
        
        var newItemSameTypeMenuNode = actionMenu.find('.novo-item-mesmo-tipo').eq(0);
        
        newItemSameTypeMenuNode.find('span.xn-text').text(selectTipo.children(':selected').text());
        newItemSameTypeMenuNode.attr('href',arrHrefNewItem[0]+'/tipo/'+selectTipo.children(':selected').val()+'?'+arrHrefNewItem[1]);
    }
    
    setItemMenu();
    
    selectTipo.bind('change',function(e){
       e.preventDefault();
       setItemMenu();
    });
    
    
    selectTipo.popover({ 
                    trigger: "manual",
                    html        :   true,
                    placement   :   'top',
                    animation   :   false,
                    content     :   function(){
                        return 'oi'
                    },
            })
    
}

dispositivos_cadastros();