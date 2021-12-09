(function( $ ){
    
    
    BsFormExtensions.setValues = function(container,options){
        
        this.setBindQueue = function(input){
            var plugin = this;
            var arrActions = input.data('bind').split(',');
            
            $.each(arrActions,function(index,item){
                if(plugin.bindQueue.indexOf(input.attr('id')+'||'+item)!==false){
                   plugin.bindQueue.push(input.attr('id')+'||'+item); 
                }
            });
        }
        
        this.runBindQueue = function(queue){
            
            var plugin = this;
            
            if(!queue){
                queue = plugin.bindQueue;
            }
            
            element = queue[0].split('||');
            input = element[0];
            
            element = element[1].replace(']','').split('[');
            
            bind = element[0];
            selector = element[1].split('.');
            
            var obj = $('#'+input);
            var _lastSelector = ''; 
                       
            $.each(selector,function(selectorIndex,selectorItem){
                
                if(selectorItem==''){
                   _lastSelector = '.';
                   return; 
                }
                
                switch(selectorItem){
                
                    case 'form':{
                        obj = obj.closest('.bsform');
                        break;
                    }
                    default:{
                        obj = obj.find(selectorItem);
                        break;
                    }
                     
                    
                }
                
                _lastSelector = '';
            });
            
            $.when(obj.trigger(bind)).done(function(e){
                
                _afterAllAjax(function(e){
                    
                    if(queue.length-1){
                        var newQueue = [];
                        $.each(queue, function(index,item){
                            if(index>0){
                                newQueue.push(item)    
                            }
                        });
                        
                        plugin.runBindQueue(newQueue)    
                    }
                });
            });
        }
        
        
        this.setCheckboxValue = function(input,values){
            var checkbox = input.find('input[type="checkbox"]').first();
        	var inputId = checkbox.attr('id');
            
            if(values[inputId] != undefined ){
                checkbox.prop('checked',values[inputId] == checkbox.attr('data-value'));    
            }
            
            
        }
        
        this.setDropdownValue = function(input,values){
            
            var plugin = this;
            var dropdown = input.find('select').first();
            var inputId = dropdown.attr('id');
            
            if(dropdown.data('bind')){
                
                dropdown.attr('value',values[inputId])
                plugin.setBindQueue(dropdown);
                return false;
            }
            
        	
            
            if(values[inputId] != undefined){
                dropdown.val(values[inputId])
            }
        }
        
        this.setIconValue = function(input,values){
            
            var hidden = input.find('input[type="hidden"]').last();
        	var inputId = hidden.attr('id');
            
            if(values[inputId] != 'undefined'){
                iconPicker = input.find('button.bsform-icon').eq(0)
                iconPicker.iconpicker('setIcon', (values[inputId] ? values[inputId].replace('fa ','') : 'empty'));
                hidden.val(values[inputId])
            }
        	
        }
        
        this.setTextboxValue = function(input,values){
            var textbox = input.find('input[type="text"]').first();
        	var inputId = textbox.attr('id');
            
            if(values[inputId] != undefined){
                textbox.val(values[inputId])
            }
            
        }
        
                
        /**
        *   RUN
        **/
            
        this.run = function(container,options){
            
            var plugin = this;
            
            var arrReturn = new Array();
            if(options.classBody == undefined){
                options.classBody = 'bsform-body'
            }
            
            body = container.find('div.'+options.classBody);
            
            if(body.length == undefined || body.length == 0){
                body = container; 
            }
            
            var inputs = body.children('div.bsform-input');
            
            $.each(inputs,function(index){
                var input = $(this);
                switch(input.data('input')){
                    case 'checkbox':{                        
                        plugin.setCheckboxValue(input,options.values)
                        break;
                    }
                    case 'dropdown':{                        
                        plugin.setDropdownValue(input,options.values)
                        break;
                    }
                    case 'icon':{                        
                        plugin.setIconValue(input,options.values)
                        break;
                    }
                    default:{
                        plugin.setTextboxValue(input,options.values)
                        break;
                    }   
                }
            });
            
            
            if(plugin.bindQueue.length){
                plugin.runBindQueue();
            }
            
        }    
        
        
        var plugin = this;
        plugin.bindQueue = [];
        //plugin.bindChildrenQueue = [];
        
        return this.run(container,options);
        
    }
    
})(jQuery);