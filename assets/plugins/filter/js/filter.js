(function( $ ){
    
    function CI_Filter(container, options){
        
        var plugin = this; 
        
        this.options = $.extend({},options);
        
        this.changeMethod = function(container,options){
            
            switch(options.method){
                case    'run': {
                    plugin.runFilter(container,$(_options.recipient));        
                    break;
                }
                case    'getFilters': {
                    
                    return plugin.getFilterValues(container);
                    break;
                }
                default:{
                    return;
                }
            }
        }
        
        this.initRow = function(container,row,recipient){
            
            var plugin = this;
            
            var inputSelector = row.find('select.filter-input-selector').eq(0);
            inputSelector.off();
            inputSelector
                .bind('focus',function(){
                   $(this).attr('data-last-value',$(this).val())
                })
                .bind('change',function(){
                    plugin.runChangeRow(container,row,recipient);   
                }); 
            
            
            var inputClauses = row.find('select.filter-clause-selector').eq(0);
            inputClauses.off();
            inputClauses
                .bind('focus',function(){
                   $(this).attr('data-last-value',$(this).val())
                })
                .bind('change',function(){
                    plugin.runChangeRow(container,row,recipient);   
                });
            
            plugin.setButtonRemove(container,row);
            plugin.setKeyPress(container,row,recipient);
            
            Init();    
        }
        
        this.runChangeRow = function(container,row,recipient){
            
            var plugin = this;
            
            var rowModel = container.find('div.filter-row-inputs-model').eq(0).clone();
            var oldInputForm = row.find('div.bsform-parent').eq(0);
            
            //input column
            var inputColumn = row.find('select.filter-input-selector').eq(0);
            var optionColumnSelected= inputColumn.prop('selectedIndex');
            optionColumnSelected = inputColumn.find('option').eq(optionColumnSelected);
            var mask = optionColumnSelected.data('mask');
            var arrClausesOption = optionColumnSelected.data('operators').split(",");
            //fim input column
            
            //input clause
            var inputClause = row.find('select.filter-clause-selector').eq(0);
            var optionClauseSelected = inputClause.prop('selectedIndex');
            optionClauseSelected = inputClause.find('option').eq(optionClauseSelected);
            var totalValuesColumns = optionClauseSelected.data('num-cols-input')!=undefined ? optionClauseSelected.data('num-cols-input') : 1;
            //fim input clause
            
            var flagChange = false;
            
            if(optionColumnSelected.val() != inputColumn.data('last-value') && inputColumn.data('last-value')){
                
                flagChange = true;
                /*
                var optgroupParent = optionColumnSelected.closest('optgroup');
                var optionLabel = optionColumnSelected.attr('label');
                $.each(optgroupParent,function(e){
                       optionLabel = $(this).attr('label')+' - ' + optionLabel;
                       
                });
                
                optionColumnSelected.text(optionLabel);
                */
                inputColumn.data('last-value',optionColumnSelected.val());
                
                var rowModel = container.find('div.filter-row-inputs-model').eq(0).clone();
                
                var inputClauses = rowModel.find('select.filter-clause-selector').eq(0);
                inputClauses.find('option').each(function(indexOption){
                    var _opt = $(this);
                    
                    if(arrClausesOption.includes(_opt.val())==false){
                        _opt.remove()
                    }
                });
                row.find('select.filter-clause-selector').eq(0).replaceWith(inputClauses);  
            }
            else{
               inputColumn.data('last-value',optionColumnSelected.val()); 
            }
            
            
            
            if(optionClauseSelected.val() != inputClause.data('last-value') || flagChange){
                flagChange = true;
                
                inputClause.data('last-value',optionClauseSelected.val());
                
                row.find('div.filter-typeforms').children().remove();
                
                var columnTypeForm = rowModel.find('div.filter-typeforms').find('div.filter-typeform-column-'+totalValuesColumns).eq(0);
            
                var inputsValues = rowModel.find('div.bsform-parent');
                $.each(inputsValues,function(index){
                    if($(this).hasClass('filter-input-type-'+optionColumnSelected.data('input-type')+'-model')){ //$(this).data('input') == optionColumnSelected.data('input-type')
                        var _input = $(this);
                        
                        var _inputChild = _input.find('select.form-control,input.form-control').eq(0);
                        
                        if(_inputChild.data('input-id')!=undefined && _inputChild.data('input-id') != optionColumnSelected.data('input-id') ){
                            return;
                        }
                        
                        
                        _input.find('input.form-control').eq(0).val(oldInputForm.find('input.form-control').eq(0).val());    
                       
                        _input.find('input.form-control').eq(0).attr('data-mask',mask);
                        columnTypeForm.find('div.filter-typeform-column').append(_input);
                        row.find('div.filter-typeforms').append(columnTypeForm);
                    }
                });
                
                plugin.initRow(container,row,recipient)
            }
            
        }
        
        this.addDynamicFilterRow = function(container,recipient){
            
            var plugin = this;
            
            var rowModel = container.find('div.filter-row-inputs-model').eq(0).clone();
            
            rowModel.removeClass('softhide').removeClass('filter-row-inputs-model');
            rowModel.addClass('block');
            rowModel.find('div.filter-typeforms').children().remove();
            
            var inputSelector = rowModel.find('select.filter-input-selector').eq(0);
            var optionInputSelected = inputSelector.prop('selectedIndex');
            optionInputSelected = inputSelector.find('option').eq(optionInputSelected);
            var arrClausesOption = optionInputSelected.data('operators').split(",");
            
            var inputClauses = rowModel.find('select.filter-clause-selector').eq(0);
            inputClauses.find('option').each(function(indexOption){
                var _opt = $(this);
                
                if(arrClausesOption.includes(_opt.val())==false){
                    _opt.remove()
                }
            });
            
            var inputsValues = rowModel.find('select.form-control, input.form-control').parent('div.bsform-parent');
            
            $.each(inputsValues,function(index){
                if(
                    ($(this).data('input') == optionInputSelected.data('input-type') && optionInputSelected.data('input-id')==undefined)
                    ||
                    (optionInputSelected.data('input-id')!=undefined && $(this).find('select.form-control,input.form-control').data('input-id') == optionInputSelected.data('input-id'))
                ){
                     return;  
                }
                $(this).remove();
 
            });
            
            container.find('div.filter-dinamic-filters > div.filter-column-left').append(rowModel);
            var row = container.find('div.filter-row-inputs').last();
            
            plugin.initRow(container,row,recipient)
            plugin.runChangeRow(container,row,recipient)
        }
        
        this.resetFilters = function(container,recipient){
            
            var plugin = this;
            
            var filterRows = container.find('div.filter-row-inputs');
            
            $.each(filterRows,function(index){
                var row = $(this);
                
                if($(this).hasClass('filter-row-fixed')==true){
                    
                    $(this).removeClass('softhide').removeClass('filter-row-inputs-model');
                                        
                    //input column
                    var inputColumn = row.find('select.filter-input-selector').eq(0);
                    if(inputColumn.data('default-value')  && inputColumn.find('option[value='+inputColumn.data('default-value')+']').length > 0){
                        inputColumn.val(inputColumn.data('default-value'));    
                    }
                    var optionColumnSelected= inputColumn.prop('selectedIndex');
                    optionColumnSelected = inputColumn.find('option').eq(optionColumnSelected);
                    var mask = optionColumnSelected.data('mask');
                    var arrClausesOption = optionColumnSelected.data('operators').split(",");
                    
                    //fim input column
                    
                    var rowModel = container.find('div.filter-row-inputs-model').eq(0).clone();
                
                    var inputClauses = rowModel.find('select.filter-clause-selector').eq(0);
                    inputClauses.find('option').each(function(indexOption){
                        var _opt = $(this);
                        
                        if(arrClausesOption.includes(_opt.val())==false){
                            _opt.remove()
                        }
                    });
                    row.find('select.filter-clause-selector').eq(0).replaceWith(inputClauses);  
                    
                    //input clause
                    var inputClause = row.find('select.filter-clause-selector').eq(0);
                    
                    if(inputColumn.data('default-clause') && inputClause.find('option[value='+inputColumn.data('default-clause')+']').length > 0){
                        inputClause.val(inputColumn.data('default-clause'));  
                    }
                    
                    var optionClauseSelected = inputClause.prop('selectedIndex');
                    optionClauseSelected = inputClause.find('option').eq(optionClauseSelected);
                    var totalValuesColumns = optionClauseSelected.data('num-cols-input')!=undefined ? optionClauseSelected.data('num-cols-input') : 1;
                    //fim input clause
                    
                    row.find('div.filter-typeforms').children().remove();
                
                    var columnTypeForm = rowModel.find('div.filter-typeforms').find('div.filter-typeform-column-'+totalValuesColumns).eq(0);
                
                    var inputsValues = rowModel.find('div.filter-typeforms').find('div.bsform-parent');
                    
                    $.each(inputsValues,function(index){
                        
                        if($(this).hasClass('filter-input-type-'+optionColumnSelected.data('input-type')+'-model')){
                            
                            var _input = $(this);
                            var _inputChild = _input.find('select.form-control,input.form-control').eq(0);
                            
                            if(_inputChild.data('input-id')!=undefined && _inputChild.data('input-id') != optionColumnSelected.data('input-id') ){
                                return;
                            }
                            
                            _input.find('select.form-control,input.form-control').each(function(index){
                                if(optionColumnSelected.attr('data-value')){
                                    value = optionColumnSelected.attr('data-value').split(',')[index];
                                    
                                    if($(this).prop('type') == 'select-one' && $(this).find('option[value='+value+']').length > 0){
                                        $(this).val(value);    
                                    }
                                    else if($(this).prop('type') == 'text'){
                                        $(this).val(value);
                                    }    
                                }
                                    
                            })
                            _input.find('select.form-control,input.form-control').eq(0).val();
                            _input.find('input.form-control').eq(0).attr('data-mask',mask);
                            columnTypeForm.find('div.filter-typeform-column').append(_input);
                            row.find('div.filter-typeforms').append(columnTypeForm);
                        }
                    });
                    
                    plugin.initRow(container,row,recipient);
     
                }
                else if($(this).hasClass('filter-row-inputs-model')==false){
                    $(this).remove();
                }
            });
            
            if(recipient.data('autoload')==true){
                plugin.runFilter(container,recipient);
                return;    
            }
            
            recipient.bsgrid({
                'method'    :   'clear',
            });
            
        }
        
        this.getFilterValues = function(container){
            
            var plugin = this;
            
            var filterRows = container.find('div.filter-row-inputs'); 
            var arrValues = [];
            
            if(plugin.options.filters != undefined){
                arrValues = $.extend(arrValues,plugin.options.filters);
            }
            
            
            $.each(filterRows,function(index){
                if($(this).hasClass('filter-row-inputs-model')==true){
                    return;
                }
                
                var inputOptions = $(this).find('select.filter-input-selector').eq(0);
                var optionInputSelected = inputOptions.prop('selectedIndex');
                optionInputSelected = inputOptions.find('option').eq(optionInputSelected);
                
                var inputClauses = $(this).find('select.filter-clause-selector').eq(0);
                var optionClauseSelected = inputClauses.prop('selectedIndex');
                optionClauseSelected = inputClauses.find('option').eq(optionClauseSelected);
                
                var inputsValue = $(this).find('.filter-input-value');
                
                
                if(inputsValue.length>1){
                    var value = [];
                    $.each(inputsValue,function(index){
                        value.push(inputsValue.eq(index).val());
                    });  
                }
                else{
                    var value = inputsValue.eq(0).val();
                }
                
                arrValues.push({
                    'id'                :   optionInputSelected.val(),
                    'input'             :   optionInputSelected.val(),
                    'clause'            :   optionClauseSelected.val(),
                    'value'             :   value,
                })
            });
            
            return arrValues;
            
        }
        
        this.runFilter = async function(container,recipient){
            
            var plugin = this;
            
            if(plugin.options.showLoading != undefined && plugin.options.showLoading==true){
                loading('show');
            }
            
            
            if(plugin.options.beforeRun != undefined){
                await plugin.options.beforeRun(container,plugin);
            }
             
            var arrValues = plugin.getFilterValues(container);
            
            await recipient.bsgrid({
                'filters'   :   arrValues,
                'page'      :   1,
                'method'    :   'updateData',
            });
            
            if(plugin.options.afterRun != undefined){
                await plugin.options.afterRun(container,plugin);
            }
            
        }
        
        
        this.setButtonAddRow = function(container,recipient){
            
            var plugin = this;
            
            var buttonAddRow = container.find('a.filter-btn-add-filter-row');
            buttonAddRow.bind('click',function(event){
                plugin.addDynamicFilterRow(container,recipient)        
            });   
            
        }
        
        this.setButtonReset = function(container,recipient){
            var plugin = this;
            
            var buttonReset = container.find('a.filter-btn-reset');
            buttonReset.bind('click',function(event){
                loading('show');
                plugin.resetFilters(container,recipient);
                loading('hide');        
            });   
            
        }
        
        this.setButtonRemove = function(container,row){
            
            var plugin = this;
            
            var btnRemove = row.find('a.filter-btn-remove-filter').eq(0);
             
            btnRemove.bind('click',function(e){
                if(row.hasClass('filter-row-fixed')){
                    row.addClass('softhide').addClass('filter-row-inputs-model')
                }
                else{
                    row.remove();    
                }
            });
        }
        
        this.setButtonSearch = function(container,recipient){
            
            var plugin = this;
            
            var buttonSearch = container.find('a.filter-btn-search').eq(0);
            
            buttonSearch.bind('click',async function(e){
                
                buttonSearch.prop("disabled",true);
                plugin.runFilter(container,recipient);
                
            });         

        }
        
        this.setKeyPress = function(container,row,recipient){
            
            var plugin = this;
            
            var inputValue = row.find('.filter-input-value').eq(0);
            if(inputValue.attr('filter-key-press')!=undefined){
                return;
            }
            inputValue.attr('filter-key-press',true);
            inputValue.bind('keypress',function(e){
                if(e.which == 13){
                    plugin.runFilter(container,recipient);
                }
            });

        }
        
        
        this.resetFilters(container,options.recipient);  
        this.setButtonAddRow(container,options.recipient);
        this.setButtonReset(container,options.recipient);
        this.setButtonSearch(container,options.recipient);
    } 
  
    $.fn.ci_filter = function(options){
        
        pluginName = 'CI_Filter';
        var response = '';
        
        $(this).each(function () {
            
            if (!$.data(this, 'plugin_' + pluginName+'_')) {
                $.data(this, 'plugin_' + pluginName+'_',true);
                
                $.data(this, 'plugin_' + pluginName,
                new CI_Filter($(this),options));
            }
            else if ($.data(this, 'plugin_' + pluginName)){
                response =  $.data(this, 'plugin_' + pluginName).changeMethod($(this),options);
            }
        });
        
        return response; 
        
        
         
    };
    
})(jQuery);