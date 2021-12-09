
$(document).ready(function($){
    
    
    $('button.btn-modulo').off().bind('click',function(e){
               
        var container = $("#modal-template").clone();
        container.find('.modal-dialog').removeClass('modal-lg').addClass('modal-sm')
        
        _loadModal({
            'url'       :   BASE_URL+'modulos/alterar',
            'container' :   container,
            'done'      :   function(container){
                
                container.find('button.btn-change-modulo').off().bind('click',function(e){
                    
                    _loadAjax({
                        'url'       :   BASE_URL+'modulos/save-change',
                        'showResponseMessages'  :   false,
                        'method'    :   'POST',
                        'data'      :   {
                            'modulo':   container.find('select#modulo').val(),                            
                        },
                        'onDone'    :   function(response){
                            
                            if(response.status == 'ok'){
                                
                                _redirect(
                                    BASE_URL,
                                    response,
                                    'POST'
                                );
                            }
                            else if(response.status == 'none'){
                                $.each(response.messages,function(index,item){
                                   showMessage('info',item.message);  
                                });
                                container.modal('hide');
                                return false;
                            }
                            
                            
                         } 
                    });
                    
                });
                
            }   
        });        
        
    });
    
    
    
});
