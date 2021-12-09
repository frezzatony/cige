    
    
    function _relatorios_init(container){
        
        
        container.find('.relatorio-btn-gerar-relatorio').bind('click',function(e){
            var _t = $(this);
          
            
            var dataValues = {};
        
            $.each(container.find('div.bsform:not(.no-save)'),function(index,item){
                var _form = $(item);
                
                formValues = _form.bsform({'method':'getValues'});
                
                
                $.each(formValues,function(indexInput,inputData){
                    
                    var keyDataValue = false;
                    
                    $.each(dataValues,function(indexDataValues,dataDataValues){
                        if(dataDataValues.id==inputData.id){
                            keyDataValue = indexDataValues;
                        }
                    });
                    
                    if(keyDataValue!==false){
                         $.extend(dataValues.keyDataValue,inputData);
                    }
                    else{
                        
                        dataValues[Object.keys(dataValues).length] = inputData;
                        
                    }
                    
                    keyDataValue = false;
                });
                
            });  
           
            var data = {
                values          :   dataValues,
                validate        :   true,
            };
            
            
            $.when(
                $.ajax({
                    url:        _t.attr('href'),
                    type:       'POST',
                    data:       data,
                    dataType:   'json',
                })            
            )
            .done(function(response){
                
                loading('hide');
                
                $.each(container.find('div.bsform'),function(index,item){
                    var _form = $(item);
                    _form.bsform({'method':'removeInputsWarnings'})
                });
                
                 
                if(response.status=='ok' || response.status=='success'){
                     
                     data.validate = 0;
                     
                     
                     if(_t.attr('load')=='blank'){
                
                
                        _redirect({
                            'url'       :   _t.attr('href'),
                            'values'    :   data,
                            'method'    :   (_t.attr('method') != undefined) ? _t.attr('method') : 'POST',
                            'target'    :   '_blank'
                        });   
                    }
                }
                
                if(response.status=='info'){
                    
                }
                
                if(response.status=='error'){
                    if(response.messages != undefined){
                        $.each(response.messages,function(index){
                            
                            if(typeof response.messages[index] == 'object'){
                               _errorMessage(response.messages[index].message); 
                            }
                            else{
                                _errorMessage(response.messages[index]);    
                            }
                               
                            
                        });   
                    }
                    else{
                        _errorMessage();   
                    }
                    
                    if(response.errors != undefined){
                         $.each(container.find('div.bsform'),function(index,item){
                            var _form = $(item);
                            _form.bsform({'method':'setInputsError','errors':response.errors })
                        });   
                    }
                    
                    $('.console').console({
                        'log' : response.console
                    });     
                }
                
            })
            .fail(function(response){
                loading('hide');
                console.log(data)
                _errorMessage();
            });
            
            return false;
           
        });
        
        
    }