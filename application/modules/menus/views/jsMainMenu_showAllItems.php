<?php

/**
 * @author Tony Frezza
 */


?>


    mainmenu.find('.btn-mainmenu-show-all-items').off().bind('click',function(){
        
        _loadModal({
            'url'           :   BASE_URL  + 'menus/show-all-items', 
            'modal_size'    :   'md' ,
            'body_height'   :   400,
            'done'          : function(container){
                loadCss(BASE_URL+'assets/plugins/jstree/themes/default/style.css',function(){
                    loadScript(BASE_URL+'assets/plugins/jstree/jstree.js',function(){
                        
                        container.find('div#menus-show-all-items').jstree().bind("after_open.jstree", function (e, data) {
                             
                           container.find('div#menus-show-all-items').find('a.jstree-anchor').off().bind('auxclick',function(e){
                                var node = $(this).closest('li');
                                if(node.data('href') != undefined && node.data('href') != '#'){
                                    
                                    if (e.which === 2) { //middle Click
                                        e.preventDefault();
                                        e.stopPropagation();
                                        e.stopImmediatePropagation();
                                        
                                        window.open(
                                          node.data('href'),
                                          '_blank' // <- This is what makes it open in a new window.
                                        );
                                    }
                                }
                                container.remove();
                                return false;
                            });
                            
                            container.find('div#menus-show-all-items').find('a.jstree-anchor').bind('mousedown',function(e){
                                
                                
                                if (e.which === 2) { //middle Click
                                    e.preventDefault();
                                    e.stopPropagation();
                                    e.stopImmediatePropagation();
                                    
                                    return false;
                                }
                                
                                
                                var node = $(this).closest('li');
                                if(node.data('href') != undefined && node.data('href') != '#'){
                                    
                                    e.preventDefault();
                                    e.stopPropagation();
                                    e.stopImmediatePropagation();
                                    
                                    
                                    var link = $('<a/>');
                                    link.attr('href',node.data('href'));                                        
                                    link.off().address()
                                    link.click();
                                    
                                    container.remove();
                                }
                                
                            })  
                             
                        });
                        
                        container.find('div#menus-show-all-items').show();
                    })
                })
            }
              
        });
    });