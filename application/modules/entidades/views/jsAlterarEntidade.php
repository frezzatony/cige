<?php

/**
 * @author Tony Frezza
 */


?>


    mainmenu.find('.btn-change-entity').off().bind('click',function(){
        
        var url = BASE_URL  + 'entidades/change_user_entity';
        
        _loadModal({
            'url'           :   url, 
            'modal_size'    :   'md' ,
            'body_height'   :   400,
            'done'          : function(container){
                loadCss(BASE_URL+'assets/plugins/jstree/themes/default/style.css',function(){
                    loadScript(BASE_URL+'assets/plugins/jstree/jstree.js',function(){
                        
                        container.find('div#entities_tree').on('select_node.jstree', function (e, data) {
                            
                            if(data.node.data.active != true){
                                _errorMessage('Não há permissões para selecionar esta entidade.')
                                loading('hide')
                                return false;
                            }
                            
                            var url = BASE_URL  + 'entidades/set_user_entity';
                            
                            $.when(
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data:{
                                        modal   :   1,
                                        ajax    :   1,
                                        entity  :   data.node.data.entity 
                                    },
                                    dataType: 'json',
                                })
                            )
                            .done(function(response){
                                if(response.status=='ok'){
                                    _redirect(
                                        BASE_URL,{
                                            "messages":
                                                [
                                                    {
                                                        'type'      :   'success',
                                                        'message'   :   'Entidade selecionada.'
                                                    }
                                                ]
                                        }
                                    )       
                                }
                                else if(response.status=='none'){
                                    _infoMessage(response.message)
                                }
                                else if(response.status=='error'){
                                    _errorMessage();
                                }
                                
                                loading('hide'); 
                            });
                            
                        }).jstree();
                       container.find('div#entities_tree').show()
                       
                    })
                })
            }
              
        });  
    });