(function( $ ){
    
    
    BsFormExtensions.getValues = function(container){
        
        this.getCheckboxValue = function(input){
            var checkbox = input.find('input[type="checkbox"]').first();
        	var inputId = checkbox.attr('id');
            
        	var arrReturn = {
        		'id': inputId,
        		'value': checkbox.is(':checked') ? checkbox.data('value') : '',
        	}
        	return arrReturn;
        }
        
        this.getDropdownValue = function(input){
            
            var dropdown = input.find('select').first();
    
        	var inputId = dropdown.attr('id');
        	var arrReturn = {
        		'id': inputId,
        		'value': "",
        		'text': "",
        	}
            
        	arrReturn['value'] = dropdown.find('option:selected').attr('value') ? dropdown.find('option:selected').attr('value') : '';
        	arrReturn['text'] = dropdown.find('option:selected').text() ? dropdown.find('option:selected').text() : '';
            
        	return arrReturn;    
        }
        
        this.getExternalListValue = function(input){
            
            var externallist = input;
        	var inputId = externallist.find('input[type="hidden"]').first().attr('id');
        	var arrReturn = {
        		'id'      :   inputId,
        		'value'   :   externallist.find('input[type="hidden"]').first().val(),
                'text'    :   externallist.find('input.externallist-last-text-value').first().val(),
        	}    
            
        	return arrReturn;
        }
        
        this.getGridValue = function(input){
            
            var plugin = this;
            var inputBody = input.find('.bsform-grid').first(); 
        	var inputId = inputBody.attr('id');
            
            //rows do grid, por tipo de template
            if(inputBody.hasClass('bsform-grid-template-1')){
                var gridRows = input.find('.bsform-grid-body').first().children('.bsform-grid-row').not('.bsform-grid-row-model');    
            }
            else if(inputBody.hasClass('bsform-grid-template-2')){
                var gridRows = input.find('.bsform-grid-body').eq(0).children('.tab-content').children('.tab-pane').children('.bsform-grid-row'); 
            }
        	
            
        	var arrReturn = {
        		'id': inputId,
        		'value': [],
        	}
            
        	gridRows.each(function(indexRow) {
        		var _row = $(this); 
                arrReturn['value'].push(plugin.run(_row,'grid-form:not(.bsform-grid-row-model)'));
            });
            
            return arrReturn;
        }
        
        this.getGroupValue = function(input){
            
            var plugin = this;
            
        	var inputId = input.find('.bsform-group').first().attr('id');
        	var groupRows = input.find('.bsform-group-row');
            
        	var arrReturn = {
        		'id': inputId,
        		'value': [],
        	}
            
        	groupRows.each(function(indexRow) {
        		var _row = $(this); 
                arrReturn['value'].push(plugin.run(_row,'bsform-group-body'));
            });
            
            return arrReturn;
        }
        
        this.getHiddenValue = function(input){
            
            var hidden = input.find('input[type="hidden"]').first();
        	var inputId = hidden.attr('id');
        	var arrReturn = {
        		'id': inputId,
        		'value': hidden.attr('value')
        	}
        
        	return arrReturn;
        }
        
        this.getIconValue = function(input){
            
            var hidden = input.find('input[type="hidden"]').last();
        	var inputId = hidden.attr('id');
        	var arrReturn = {
        		'id': inputId,
        		'value': hidden.attr('value')
        	}
        
        	return arrReturn;
                        
        }
        
        
        this.getPasswordValue = function(input){
            
            var password = input.find('input[type="password"]').first();
        	var inputId = password.attr('id');
            
        	var arrReturn = {
        		'id': inputId,
        		'value': password.val(),
                'mask':  password.attr('data-mask') || '',
        	}
            
        	return arrReturn;
        };
        
        this.getRadioValue = function(input){
            
            var options = input.find('input[type="radio"]');
        	var inputId = options.first().attr('id');
        	var arrReturn = {
        		'id': inputId,
        		'value': '',
                'text' : '',
        	}
        	options.each(function(index) {
        		if ($(this).is(':checked')) {
        			arrReturn['value'] = $(this).val();
                    arrReturn['text'] = $.trim($(this).closest('label').text());
        		}
        	});
            
        	return arrReturn;
        }
        
        this.getSummernoteValue = function(input){
            var textarea = input.find('textarea').first();
        	var inputId = textarea.attr('id');
            
        	var arrReturn = {
        		'id': inputId,
        		'value':  textarea.summernote('isEmpty') ? '' : textarea.summernote('code'),
        	}
            
        	return arrReturn;
        }
        this.getTextareaValue = function(input){
            
            var textarea = input.find('textarea').first();
        	var inputId = textarea.attr('id');
            
        	var arrReturn = {
        		'id': inputId,
        		'value':  $.trim(textarea.val()),
        	}
            
        	return arrReturn;
        }
        
        this.getTinymceValue = function(input){
            
            var textarea = input.find('textarea').first();
        	var inputId = textarea.attr('id');
            
        	var arrReturn = {
        		'id': inputId,
        		'value':  tinymce.get(textarea.data('tinymce_get')).getContent(),
        	}
            
        	return arrReturn;
        }
        
        this.getTextboxValue = function(input){
            var textbox = input.find('input[type="text"]').first();
        	var inputId = textbox.attr('id');
            
        	var arrReturn = {
        		'id': inputId,
        		'value': textbox.val(),
                'mask':  textbox.attr('data-mask') || '',
        	}
        	return arrReturn;
        }
        
        /**
        *   RUN
        **/
            
        this.run = function(container,classBody){
            
            var plugin = this;
            
            var arrReturn = new Array();
            if(classBody == undefined){
                classBody = 'bsform-body:not(.bsform-row)';
            }
            
            body = container.find('div.'+classBody);
            
            if(body.length == undefined || body.length == 0){
                body = container;
            }
            
            var inputs = body.children('div.bsform-input:not(.bsform-input-no-value)');
            
            $.each(inputs,function(index){
                var input = $(this);
                
                switch(input.data('input')){
                    case 'checkbox':{
                        arrReturn.push(plugin.getCheckboxValue(input));
                        break;
                    }
                    case 'dropdown':{
                        arrReturn.push(plugin.getDropdownValue(input));
                        break;
                    }
                    case 'externallist':{
                        arrReturn.push(plugin.getExternalListValue(input));
                        break;
                    }
                    case 'grid':{
                        arrReturn.push(plugin.getGridValue(input));
                        break;
                    }
                    case 'group':{
                        arrReturn.push(plugin.getGroupValue(input));
                        break;
                    }
                    case 'hidden':{
                        arrReturn.push(plugin.getHiddenValue(input));
                        break;
                    }
                    case 'icon':{
                        arrReturn.push(plugin.getIconValue(input));
                        break;
                    }
                    case 'password':{
                        arrReturn.push(plugin.getPasswordValue(input));
                        break;
                    }
                    case 'radio':{
                        arrReturn.push(plugin.getRadioValue(input));
                        break;
                    }
                    case 'summernote':{
                        arrReturn.push(plugin.getSummernoteValue(input));
                        break;
                    }
                    case 'textarea':{
                        arrReturn.push(plugin.getTextareaValue(input));
                        break;
                    }
                    case 'tinymce':{
                        arrReturn.push(plugin.getTinymceValue(input));
                        break;
                    }
                    default:{
                        arrReturn.push(plugin.getTextboxValue(input));
                        break;
                    }   
                }
            });
                        
            return arrReturn;
        }    
        
        
        
        return this.run(container);
        
    }
    
})(jQuery);