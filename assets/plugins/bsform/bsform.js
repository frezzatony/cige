var BsFormExtensions = {};

(function( $ ){
    
    
    function BsForm(container, options){
        
        this.changeMethod = function(container,options){
            
            
            var plugin = this;
            
            if(options==undefined){
                return;
            }
            
            switch(options.method){
                case    'getValues': {
                    return plugin.getValues(container);        
                    break;
                }
                case    'getSimpleValues': {
                    return plugin.getSimpleValues(container);
                    break;
                }
                case    'setValues': {
                    return plugin.setValues(container,options);
                    break;
                } 
                case    'reset': {
                    return plugin.reset(container);
                    break;
                }
                case    'ajaxUpdateOptions': {
                    return plugin.inputAjaxUpdateOptions(container,options);
                    break;
                }
                case    'removeInputsWarnings': {
                    return plugin.removeInputsWarnings(container);
                    break;
                }
                case    'setInputsError': {
                    return plugin.setInputsError(container,options.errors);
                    break;
                }
                case    'toggleInputReadOnly': {
                    return plugin.toggleInputReadOnly(container,options);
                    break;
                }
                default:{
                    return;
                }
            }
        }
        
        this.initInputs = function(container){
            
            this.initGrid(container);
            this.initIcon(container);
            this.initExternalList(container);
            
            Init();
        }
        
        
        this.initExternalList = function(container){
            
            var plugin = this;
            
            var inputs = container.find("[data-input='externallist']");

            $.each(inputs,function(index,item){
                var input = $(this);
                
                if(input.closest('div.bsform-row-model').length>0){
                    return;
                }
                
                if(input.attr('bsform-input-initialized')=='true'){
                    return;
                }
                
                input.attr('bsform-input-initialized','true');
                
                var externallist = input.find('div.externallist-inputs').eq(0)
                var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
                var inputValue = externallist.find('input.externallist-input-value');
                var inputText = externallist.find('input.externallist-input-text');
                var buttonSearch = externallist.find('a.externallist-button-search');
                
                plugin.setExternalListValueSearch(container,externallist);
                plugin.setExternalListTextSearch(container,externallist);
                plugin.setExternalListButtonSearch(container,externallist);
                plugin.setExternallistHiddenChange(container,externallist);
                plugin.setExternallistChangeReadonly(container,externallist);
            });
            
        } 
        
        this.initGrid = function(container){
            var plugin = this;
            var inputs = container.find("[data-input='grid']");
            
            $.each(inputs,function(index,item){
                
                var grid = $(this);
                
                if(grid.attr('bsform-input-initialized')!=undefined){
                    return;
                }
                grid.attr('bsform-input-initialized',true);
                
                var gridBody = grid.find('div.bsform-grid-body').eq(0);
                
                gridBody.sortable({
                    handle      :   ".grid-button-order-row",
                    cursor      :   "grabbing",
                    start: function(e, ui){
                        ui.placeholder.height(ui.helper[0].scrollHeight);
                    },
                    axis: "y",
                    opacity: 0.6,
                });
                plugin.setGridButtonAddRow(container,grid);
                plugin.setGridButtonRemoveRow(container,grid);

            });
        }
        
        
        this.initIcon = function(container){
            
            var plugin = this;
            var inputs = container.find("[data-input='icon']");
            
            $.each(inputs,function(index){
                var inputIcon = $(this).find('button').eq(0);
                var inputValue = $(this).find('input[type="hidden"]').eq(0);
                options = { 
                    cols                :   4,
                    rows                :   4,
                    footer              :   false,  
                    iconset             :    "fontawesome4",
                    arrowPrevIconClass  : 'fa fa-arrow-left',
                    arrowNextIconClass  : 'fa fa-arrow-right',
                    icon                : inputValue.val()
                };
                
                var iconPicker = inputIcon.iconpicker(options);
                iconPicker.on('change', function (e) {
                    inputValue.val(e.icon);
                });
            });
            
        }
        
        this.setExternalListBoxResultsRowSelected = function(container,externallist,action){
            
            var plugin = this;
            
            var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
            var inputValue = externallist.find('input.externallist-input-value');
            var inputText = externallist.find('input.externallist-input-text');
            var buttonSearch = externallist.find('a.externallist-button-search');
            
            var boxResults = externallist.find('div.externallist-box-results').eq(0);
            var gridResults =  externallist.find('div.bsgrid').eq(0);
            var inputSearchId = boxResults.find('input.externallist-input-id-search').eq(0);
            var loadingDiv = boxResults.find('div.loading-insert').eq(0);
            
            var gridRows = gridResults.bsgrid({
                'method'    :   'getRows'
            });
            
            var gridSelectedRows = gridResults.bsgrid({
                'method'    :   'getSelectedRows'
            });
            
            
            var nextRowSelected = (action=='UP') ? gridSelectedRows.last().index()-2 : gridSelectedRows.last().index()
            
            if(nextRowSelected<0){
                nextRowSelected = gridRows.length-1;
            }
            else if(nextRowSelected >= gridRows.length){
                nextRowSelected = 0;
            }
            
            gridResults.bsgrid({
                'method'                :   'setSelectedRows',
                'rows'                  :   [nextRowSelected],
                'unselectOthersRows'    :   true,
            });
            
            
            var gridSelectedRows = gridResults.bsgrid({
                'method'    :   'getSelectedRows'
            });
            
            if(
                (gridSelectedRows.last().position().top+gridSelectedRows.last().height() > gridResults.find('.bsgrid-body').height())
                ||
                (gridSelectedRows.last().position().top<=0)
            ){
                gridResults.find('.bsgrid-body').scrollTo(gridSelectedRows.last());    
            }
                       
        }
            
        this.setExternalListButtonSearch = function(container,externallist){
            
            var plugin = this;
            
            var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
            var inputValue = externallist.find('input.externallist-input-value');
            var inputText = externallist.find('input.externallist-input-text');
            var buttonSearch = externallist.find('a.externallist-button-search');
            
            buttonSearch.bind('click',function(e){
                
                var modalClone = $("#modal-template").clone();
                
                modalClone.addClass('modal-externallist');
                modalClone.attr('href',externallist.attr('href'));
                modalClone.attr('data-token', externallist.data('token'));
                
                var data = {
                    'token'     :   externallist.data('token'),
                };
                
                var postData = {};
                var filters = [];
                var error = false;
                $.when(
                    inputHiddenValue.trigger('beforeSearch',[plugin,container,postData,filters])
                ).done(function(){
                    
                    if(plugin.options.cancelSearch != undefined  && plugin.options.cancelSearch == true){
                        return false;
                    }
                    
                    
                    _loadModal({
                        'data'      :   data,
                        'method'    :   'POST',
                        'container' :   modalClone,
                        'url'       :   externallist.attr('href'),
                        'onClose'   :   function(_container){
                            if(_container.attr('data-externallist-value')!=undefined){
                                inputValue.val(_container.data('externallist-value'));    
                                plugin.getExternallistSearchByValue(container,externallist);                           
                            }
                            
                        },
                        'done'    : function(container){
                            
                            container.find('div.grid-items-cadastro').bsgrid({
                                'showLoading'   :   true,
                                'post_data'     :   postData,
                                'rowOnClick'    :   function(e,row,_container){
                                    
                                    var dialog = _container.parents('div.modal');
                                    
                                    var data = {
                                        'token'         :   dialog.data('token'),
                                        'pk_value'      :   row.data('pk-value'),
                                        'get_values'    :   true,
                                    }
                                    
                                    _loadAjax({
                                        'url'       :   dialog.attr('href'),
                                        'data'      :   data,
                                        'method'    :   'POST',
                                        'onDone'    :   function(response){
                                            row.parents('div.modal').attr('data-externallist-value',response.value);
                                            row.parents('div.modal').attr('data-externallist-text',response.text);
                                            dialog.modal('hide');     
                                        } 
                                    });
                                },  
                            });
                            
                            
                            $('div.modal-externallist div.filter').off().ci_filter({
                                'showLoading'   :   true,
                                'filters'       :   filters,
                                'recipient'     :   $('div.modal-externallist div.grid-items-cadastro'),
                            });
                            
                        }
                    });
                });       
            });
        }
        
        this.setExternalListTextSearch = function(container,externallist){
            
            var plugin = this;
            
            var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
            var inputValue = externallist.find('input.externallist-input-value');
            var inputText = externallist.find('input.externallist-input-text');
            var inputLastTextValue = externallist.find('input.externallist-last-text-value');
            var buttonSearch = externallist.find('a.externallist-button-search');
            
            var boxResults = $('<div>');  
            boxResults.addClass('softhide').addClass('card').addClass('externallist-box-results');
                       
            externallist.append(boxResults);
            
            
            keys = {
                ESC         :   27,
                TAB         :   9,
                RETURN      :   13,
                LEFT        :   37,
                UP          :   38,
                RIGHT       :   39,
                DOWN        :   40,
                //BACKSPACE   :   8,
                CTRL        :   17,
                SHIFT       :   16,
            }
            
            var loadingDiv = $('<div>')
            loadingDiv.addClass('loading-insert');
            boxResults.append(loadingDiv);
            
            inputText.keypress(function(e){
                if($(this).val().length>1){
                    loadingDiv.show();
                }
            })
            
            inputText.keydown(function(e) {
                
                if(
                    e.keyCode == keys.UP ||
                    e.keyCode == keys.DOWN ||
                    e.keyCode == keys.ESC 
                ){
                    e.preventDefault();
                    return false;
                    
                }
                
                else if(e.keyCode == keys.RETURN){
                    if(boxResults.is(":visible")==true ){
                        plugin.setExternalListValueByRowSelected(container,externallist);
                    }
                }
            });
            
            
            var searchFunction = function(text){
                    
                    var boxResultsPositionFunction  = function(){
                        
                         var display = 'block';
                         
                        //se o input estiver proximo ao fim da tela, exibe o boxResults para cima
                        if(externallist.scrollParent().height()-(externallist.offset().top-externallist.scrollParent().offset().top)<130){
                            
                            if(externallist.scrollParent().height()-(externallist.offset().top-externallist.scrollParent().offset().top)<0){
                                display = 'none';
                            }
                                                       
                            boxResults.css({ 
                                position: "fixed",
                                'z-index': 2,
                                'min-width': externallist.attr('min-width') ? externallist.attr('min-width') : 500,
                                marginLeft: 0, 
                                marginTop: 0,
                                top: (externallist.offset().top-externallist.scrollParent().offset().top)+13, 
                                display: display,
                            });
                        }
                        else{
                            if(externallist.scrollParent().height()-(externallist.offset().top-externallist.scrollParent().offset().top)>externallist.scrollParent().height()){
                                display = 'none';
                            }
                            //exibe acima do input
                            boxResults.css({ 
                                position: "fixed",
                                'z-index': 2,
                                'min-width': externallist.attr('min-width') ? externallist.attr('min-width') : 500,
                                marginLeft: 0, 
                                marginTop: 22, 
                                top: (externallist.offset().top)-30,
                                display: display,
                            });
                        }
                    }
                    
                    boxResultsPositionFunction();
                    
                    externallist.scrollParent().scroll(function(e){
                       boxResultsPositionFunction();
                    });
                                                    
                    loadingDiv.show();
                    boxResults.show();
                    var gridResults =  boxResults.find('div.bsgrid').eq(0);
                    
                    if(gridResults.length == 0){
                        
                        var data = {
                            'token'             :   externallist.data('token'),
                            'is_boxresults'     :   true,
                            'no_filter'         :   true,
                            'grid_footer'       :   0,
                        };
                        
                        
                        window['xhr_externallist'] = $.ajax({
                            url     :   externallist.attr('href'),
                            type    :   'POST',
                            data    :   data,
                            dataType:   'JSON',
                            success    :   function(response){
                                 boxResults.append(response.body);
                                 gridResults =  boxResults.find('div.bsgrid').eq(0);
                                 gridResults.find('.bsgrid-body').scrollTo(0);
                                 gridResults.bsgrid({
                                    'noHeader'      :   true,
                                    'rowOnClick'        :   function(e,row){
                                        inputValue.val(row.data('pk-value'));
                                        plugin.getExternallistSearchByValue(container,externallist,true);
                                        boxResults.hide();
                                    }
                                 });
                                 plugin.getExternallistSearchByText(container,externallist);
                            }
                        });  
                    }
                    else{
                        gridResults =  boxResults.find('div.bsgrid').eq(0);
                        gridResults.removeClass('grid-items-cadastro').addClass('grid-items-cadastro-externallist');
                        gridResults.bsgrid({
                            'method'    :   'cancelSearch',
                        });
                        plugin.getExternallistSearchByText(container,externallist);    
                    }
            }
            
            function delay(callback, ms) {
              var timer = 0;
              return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                  callback.apply(context, args);
                }, ms || 0);
              };
            }
            
            inputText.keyup(delay(function(e){
                
                if(
                    e.keyCode == keys.UP ||
                    e.keyCode == keys.DOWN
                ){
                    return;
                }
                else if(
                    e.keyCode == keys.ESC ||
                    e.keyCode == keys.RETURN  
                ){
                   
                    return false;
                }
                
                if($(this).val().length>2 || $(this).val()=='*'){
                    
                    searchFunction($(this).val())
                }
                
            },700));
            
            inputText.keyup(function(e) {
                
                if(
                    e.keyCode == keys.UP ||
                    e.keyCode == keys.DOWN
                ){
                    action = (e.keyCode==keys.UP) ? 'UP' : 'DOWN';
                    if(boxResults.is(":visible")==true ){
                        plugin.setExternalListBoxResultsRowSelected(container,externallist,action);
                    }
                    e.preventDefault();
                    return;
                    
                }
                else if(
                    e.keyCode == keys.ESC 
                ){
                    e.preventDefault();
                    boxResults.hide();
                    inputText.focusout();
                    return false;
                }
                else if(Object.values(keys).includes(e.keyCode)){
                    return;
                }
            });
            
            inputText.focusout(function(e){
                if(boxResults.is(":visible")==true ){
                    setTimeout(function () {
                        boxResults.hide()
                    },200)
                }
                
                if(inputText.val()==''){
                    inputHiddenValue.val('');
                    inputValue.val('');
                    inputText.val('');
                    inputLastTextValue.val('');
                    inputHiddenValue.trigger('change');
                }
                else if(inputLastTextValue.val() != inputText.val()){
                    inputText.val(inputLastTextValue.val())  
                }
            })
        }
        
        this.setExternalListValueByRowSelected = function(container,externallist){
            
            var plugin = this;
            
            var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
            var inputValue = externallist.find('input.externallist-input-value');
            var inputText = externallist.find('input.externallist-input-text');
            var inputLastTextValue = externallist.find('input.externallist-last-text-value');
            var buttonSearch = externallist.find('a.externallist-button-search');
            
            var boxResults = externallist.find('div.externallist-box-results').eq(0);
            var gridResults =  externallist.find('div.bsgrid').eq(0);
            var inputSearchId = boxResults.find('input.externallist-input-id-search').eq(0);
            var loadingDiv = boxResults.find('div.loading-insert').eq(0);
            
            var gridSelectedRows = gridResults.bsgrid({
                'method'    :   'getSelectedRows'
            });
            
            if(gridSelectedRows.length==0){
                inputHiddenValue.val('');
                inputValue.val('');
                inputText.val('');
                inputLastTextValue.val('');
            }
            
            gridSelectedRows[gridSelectedRows.length-1].click();            
        }
        
        this.setExternalListValueSearch = function(container,externallist){
            
            var plugin = this;
            
            var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
            var inputValue = externallist.find('input.externallist-input-value');
            var inputText = externallist.find('input.externallist-input-text');
            
            
            inputValue.click(function () {
               $(this).select();
            });
            
            inputValue.bind('focusout',function(e){
                plugin.getExternallistSearchByValue(container,externallist);    
            });
             
        }
        
        this.setExternallistHiddenChange = function(container,externallist){
            
            var plugin = this;
            
            var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
            var inputValue = externallist.find('input.externallist-input-value');
            var inputText = externallist.find('input.externallist-input-text');
            
            inputHiddenValue.bind('external_change',async function(){
                
                if($(this).val() != '' && $(this).val()){
                    inputValue.val($(this).val());
                    await plugin.getExternallistSearchByValue(container,externallist,true);
                }
                else{
                    inputHiddenValue.val('');
                    inputValue.val('');
                    inputText.val('');
                }
            });
            
        }
        
        this.setExternallistChangeReadonly = function(container,externallist){
            
            externallist.bind('changeReadonly',function(e){
                
                var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
                var inputValue = externallist.find('input.externallist-input-value');
                var inputText = externallist.find('input.externallist-input-text');
                var buttonSearch = externallist.find('a.externallist-button-search');
                
                inputValue.prop('readonly',function(i,r){
                    
                    if(inputValue.attr('data-readonly-key')){
                        return true;
                    }
                    else{
                        return inputHiddenValue.prop('readonly')    
                    }
                    
                });
                inputValue.prop('disabled',function(i,r){
                    
                    if(inputValue.attr('data-readonly-key')){
                        return true;
                    }
                    else{
                        return inputHiddenValue.prop('readonly')    
                    }
                });
                
                
                inputText.prop('readonly',function(i,r){
                    return inputHiddenValue.prop('readonly')
                });
                inputText.prop('disabled',function(i,r){
                   return inputHiddenValue.prop('readonly')
                });
                
                
                if(inputHiddenValue.prop('readonly')){
                    buttonSearch.closest('div').removeClass('inline-block').addClass('softhide');
                }
                else{
                    buttonSearch.closest('div').removeClass('softhide').addClass('inline-block');
                }
                
                
            });
            
        }
        
        this.getExternallistSearchByText = function(container,externallist){
            
            var plugin = this;
            plugin.options.cancelSearch = false;
                        
            var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
            var inputValue = externallist.find('input.externallist-input-value');
            var inputText = externallist.find('input.externallist-input-text');
            var inputLastTextValue = externallist.find('input.externallist-last-text-value');
            var buttonSearch = externallist.find('a.externallist-button-search');
            
            var boxResults = externallist.find('div.externallist-box-results').eq(0);
            var gridResults =  externallist.find('div.bsgrid').eq(0);
            var inputSearchId = boxResults.find('input.externallist-input-id-search').eq(0);
            var loadingDiv = boxResults.find('div.loading-insert').eq(0);
            
            
            var searchValue = inputText.val()=='*' ? '' : inputText.val();
            loadingDiv.show();
            
            var postData = {};
            
            var filters = [
                {
                    'id'                :   inputSearchId.val(),
                    'input'             :   inputSearchId.val(),
                    'clause'            :   'contains',
                    'value'             :   searchValue,
                }
            ]
            
            $.when(
                inputHiddenValue.trigger('beforeSearch',[plugin,container,postData,filters])
            ).done(function(){
                
                if(plugin.options.cancelSearch != undefined  && plugin.options.cancelSearch == true){
                    boxResults.hide();
                    return false;
                }
                
                var gridResultsHeader = container.find('div.bsgrid-header-base');
                var gridResultsBody = container.find('div.bsgrid-body');
                var gridResultsFooter = container.find('div.bsgrid-footer');
                
                gridResultsBody.height('109px');
                
                gridResults.bsgrid({
                    'filters'           :   filters,
                    'page'              :   1,
                    'method'            :   'updateData',
                    'loadingOverlay'    :   true,
                    'afterUpdateData'   :   function(){
                        loadingDiv.hide();
                        gridResults.bsgrid({
                            'method'    :   'setSelectedRows',
                            'rows'      :   [0],
                        });
                    },
                    'post_data'        :   postData,
                });
                
                loadingDiv.show();
            });
            
        }
        
        this.getExternallistSearchByValue = async function(container,externallist,force){
            
            var plugin = this;
            
            var inputHiddenValue = externallist.find('input[type="hidden"]').eq(0);
            var inputValue = externallist.find('input.externallist-input-value');
            var inputText = externallist.find('input.externallist-input-text');
            var inputLastTextValue = externallist.find('input.externallist-last-text-value');
            var buttonSearch = externallist.find('a.externallist-button-search');
            
            
            if(inputValue.val()==inputHiddenValue.val() && force!=true){
                inputHiddenValue.trigger('change');
                return;
            }
             
            var data = {
                'token'         :   externallist.data('token'),
                'get_values'    :   true,
                'pk_value'      :   inputValue.val(),
                'filters'       :   '',
            };
            
           
            
            var postData = {};
            var filters = [];
            var error = false;     
            $.when(
                inputHiddenValue.trigger('beforeSearch',[plugin,container,postData,filters])
            ).done(async function(){
                
                if(plugin.options.cancelSearch != undefined  && plugin.options.cancelSearch == true){
                    return false;
                }
                               
                data.filters = filters;
                
                await _loadAjax({
                    'url'       :   externallist.attr('href'),
                    'data'      :   data,
                    'method'    :   'POST',
                    'onDone'    :   function(response){
                        $.each(response.data,function(key,val){
                           inputHiddenValue.attr(key,val)     
                        });
                        
                        inputValue.val(response.value);
                        inputText.val(response.text);
                        inputLastTextValue.val(response.text);
                        
                        inputHiddenValue.val(response.value).trigger('change');
                        
                        if(response.value!=''){
                            inputValue.blur();
                            inputText.focus()
                            var e = jQuery.Event("keydown");
                            e.which = 13;
                            inputText.trigger(e);
                        }
                    }
                }); 
                
                await inputHiddenValue.trigger('afterChange',[plugin,container]);
                
                
            })
            .fail(async function(){
                inputValue.val(inputValueValue);
                inputText.val(inputTextValue);
            })
            ;
            
               
            inputHiddenValue.trigger('ready');
        }   
        
        this.getValues = function(container){
            return BsFormExtensions.getValues(container)
        }
        
        this.getSimpleValues = function(container){
            var plugin = this;
            
            var values = BsFormExtensions.getValues(container);
            
            var objReturn = {};
            $.each(values,function(index,item){
                objReturn[item.id] = item.value
            })
            return objReturn;        
        }
        
        //inputajax
        this.inputAjaxUpdateOptions = function(container,options){
            var plugin = this;
            
            _loadAjax({
                'url'       :   BASE_URL+'rest',
                'method'    :   'POST',
                'data'      :   {
                    'token'         :   options.token,
                    'index_value'   :   options.index_value!= undefined ? options.index_value : false,
                    'values'        :   plugin.getSimpleValues(container),
                },
                'onDone'    :   function(response){
                    
                    var input = container.find('#'+options.input_id)
                    input.find('option').remove();
                                   
                    if(response.status == 'ok'){
                        plugin.setInputOptions(container,{
                            'input_id'  :   options.input_id,
                            'options'   :   response.options
                        })
                    }
                } 
            });
        }
        
        this.setGridButtonAddRow = function(container,grid){
            
            var plugin = this;
            
            var gridBody = grid.find('div.bsform-grid-body').eq(0);
            var buttonAddRow = grid.find('a.grid-button-add-row');
            var inputGrid = grid.find('.bsform-grid').eq(0);
            
            buttonAddRow.unbind().off().bind('click',function(e){
                
                var error = false;
                inputGrid.trigger('beforeAdd',[container,plugin,inputGrid]);
                
                if(inputGrid.error != undefined && inputGrid.error){
                    return false;
                }
                
                var rowModel = grid.find('div.bsform-grid-row-model').eq(0).clone();
                rowModel.removeClass('bsform-grid-row-model').removeClass('bsform-row-model').removeClass('softhide');
                plugin.removeInputsWarnings(rowModel);
                rowModel.find('[bsform-input-initialized="true"]').attr('bsform-input-initialized','');
                rowModel.addClass('bsform-grid-row');
                rowModel.find('.no_init').removeClass('no_init');
                
                if(grid.find('.bsform-grid').attr('uuid-rows')){
                    var inputIdRow = rowModel.find('#row_id');
                    inputIdRow.val(uuidv4());
                }

                gridBody.append(rowModel);
                plugin.initInputs(container);
                
                var lastRow = gridBody.find('div.bsform-grid-row').last();
                plugin.setGridButtonRemoveRow(container,grid,lastRow);
                
                var griBodyRows = gridBody.find('div.bsform-grid-row');
                var inputsRadio = lastRow.find('input:radio');
                if(inputsRadio.length && griBodyRows.length == 1){
                    $.each(inputsRadio,function(index){
                          var input = $(this);
                          input.prop('checked', true);
                    });
                }
                
                gridBody.trigger('ready',[container,plugin,gridBody]);
                gridBody.trigger('afterAdd',[container,plugin,gridBody]);
                
            });
        }
        
        this.setGridButtonRemoveRow = function(container,grid,row){
            
            var gridBody = grid.find('div.bsform-grid-body').eq(0);
            
            if(row == undefined){
                var buttonRemoveRow = gridBody.find('a.grid-button-remove-row');        
            }
            else{
                var buttonRemoveRow = row.find('a.grid-button-remove-row');
            }
            
            buttonRemoveRow.unbind().off().bind('click',function(e){
                
                var rowParent = $(this).closest('div.bsform-grid-row');
                var griBodyRows = gridBody.find('div.bsform-grid-row');
                var inputsRadio = rowParent.find('input:radio');
                
                if(inputsRadio.length && griBodyRows.length > 1){
                    $.each(inputsRadio,function(index){
                        var input = $(this);
                        if(input.is(':checked')){
                            rowParent.remove();
                            gridBody.find('div.bsform-grid-row').first().find('input:radio[name="'+input.attr('name')+'"]').prop('checked', true);    
                        }
                        else{
                            rowParent.remove();
                        } 
                    });
                }
                else{
                    rowParent.remove();
                }
                
            });
            
            buttonRemoveRow
                .mouseover(function(e){
                    $(this).closest('div.bsform-grid-row').addClass('active')
                })
                .mouseout(function(){
                    $(this).closest('div.bsform-grid-row').removeClass('active')
                });
        }
        
        this.setInputOptions = function(container,options){
            
            var plugin = this;
            var input = container.find('#'+options.input_id)
            
            input.find('option').remove();
            
            $.each(options.options,function(index,item){
                var option = new Option(item.text ? item.text : '', item.value ? item.value : '');
                
                var arrTags = ['text','value','tag','parent_id','value']
                
                
                $.each(item, function(nameItem, valueItem){
                    if(!arrTags.includes(nameItem)){
                        $(option).attr(nameItem,valueItem)    
                    }
                });
                
               
                input.append(option);        
            }); 
            
            input.val(input.attr('value'));
            input.trigger('change');
        }
        
        this.reset = function(container,classBody){
            
            var plugin = this;
            
            loading('show');
            
            if(classBody == undefined){
                classBody = 'bsform-body'
            }
            
            body = container.find('div.'+classBody);
            
            if(body.length == undefined || body.length == 0){
                body = container;
                
            }
            
            var inputs = body.children('div.bsform-input');
            
            var arrValues = plugin.getSimpleValues(container);
            
            $.each(arrValues,function(index,item){
                arrValues[index] = null;
            });
            
            
            BsFormExtensions.setValues(container,{
                'values'    :   arrValues,
            });            
            
            loading('hide');
        }
        
        this.removeInputsWarnings = function(container){
            container.find('div.form-group').removeClass('has-danger');
        }
        
        this.setInputsError = function(container,errors){
            
            var plugin = this;
            
            $.each(errors,function(index,item){
                var inputId = item.id.split('.');
                
                if(inputId.length == 1){
                    container.find('input[id="'+item.id+'"],select[id="'+item.id+'"],textarea[id="'+item.id+'"],div[id="'+item.id+'"]').closest('div.form-group').addClass('has-danger');
                }
                else{
                    item.id = '';
                    
                    for(i=1;i<inputId.length;i++){
                        if(item.id != ''){
                            item.id += '.';
                        }
                        item.id += inputId[i];
                    }
                    
                    var element = container.find('input[id="'+inputId[0]+'"],select[id="'+inputId[0]+'"],div[id="'+inputId[0]+'"]').eq(0).find('div.bsform-row').not('.bsform-row-model').eq(item.row);
                    var arrErrors = [item]
                     plugin.setInputsError(element,arrErrors);  
                }                
            });
            
        }
        
        
        
        this.setBodyShow = function(body,menu){
            
            var plugin = this;
            
            body.css('overflow','auto');
            body.css('min-height',menu.css('height'));
            body.css('max-height',menu.closest('.bsform').parent('div').height()+'px');
            body.show();             
        }
        
        
        this.setActiveBody = function(element,container,menu){
            
            var plugin = this;
            
            var nodeKeyClass = element.attr("class").match(/bsform-node-[\w-]*\b/)[0];
            var body = container.find('.bsform-body.' + nodeKeyClass);
            var forms = container.find('.bsform-body');
            
            menu.find('a.bsform-node').removeClass('active');
            forms.hide();
            element.addClass('active');            
            plugin.setBodyShow(body,menu);
        }
        
            
        this.setButtonPreviousNOde = function(bsform){
            
            var plugin = this;
            
            var btnPrevious = $('a.bsform-btn-previous-node[data-parent-id*="'+bsform.attr('id')+'"]');
            
            btnPrevious.each(function(index){
                 
                $(this).bind('click',function(e){
                    
                    var bsform = $('#'+$(this).data('parent-id'));
                    var menu = bsform.find('.bsform-menu')
                    var nodes = bsform.find('.bsform-node')
                    var activeNode = bsform.find('.bsform-node.active');
                    
                    nodes.removeClass('active');
                    
                    if(nodes.index(activeNode) == (nodes.eq(0))){    
                        nodes.eq(nodes.length-1).click();
                    }
                    else{
                        nodes.eq(nodes.index(activeNode)-1).click();
                    }
                   
                });
            });
            
        }
        
        this.setButtonNextNode = function(bsform){
            
            var plugin = this;
            
            var btnNext = $('a.bsform-btn-next-node[data-parent-id="'+bsform.attr('id')+'"]');
            btnNext.each(function(index){
                
                if($(this).data('bsform')!=undefined){
                    return false;
                }
                $(this).data('bsform',true);
                
                
                
                $(this).bind('click',function(e){
                    
                    var bsform = $('#'+$(this).data('parent-id'));
                    var menu = bsform.find('.bsform-menu')
                    var nodes = bsform.find('.bsform-node')
                    var activeNode = bsform.find('.bsform-node.active');
                    
                    nodes.removeClass('active');
                    
                    if(nodes.index(activeNode) == (nodes.length-1)){    
                        nodes.eq(0).click();
                    }
                    else{
                        nodes.eq(nodes.index(activeNode)+1).click();
                    }
                   
                   
                });
            });
            
        }
        
        this.setButtonSave = function(bsform,options){
            
            var plugin = this;
            var _options = options;
            
            var btnSave = $('a.bsform-btn-save[data-parent-id="'+bsform.attr('id')+'"]');
            
            btnSave.each(function(index){
                
                if($(this).data('bsform')!=undefined){
                    return false;
                }
                $(this).data('bsform',true);
                
                
                $(this).bind('click',function(e){
                    plugin.save(bsform,_options); 
                });
            });
            
        }
        
        this.setButtonSaveAndClose = function(bsform,options){
            
            var plugin = this;
            var _options = $.extend({},options);
            
            var btnSave = $('a.bsform-btn-save-close[data-parent-id="'+bsform.attr('id')+'"]');
            var dialog = bsform.parents('div.modal');
            
            var oldDoneSave = _options.doneSave;  
            
            _options.doneSave = function(bsform,options,response){
                
                if(oldDoneSave != undefined){
                    oldDoneSave(bsform,options,response);
                }
                dialog.modal('hide');
            }
            
            
            btnSave.each(function(index){
                
                $(this).off().bind('click',function(e){
                    plugin.save(bsform,_options); 
                });
            });
            
            
            
        }
        
        this.setValues = function(container,options){
            
            var plugin = this;
            
            loading('show');
            /*
            if(options.classBody == undefined){
                options.classBody = 'bsform-body'
            }
            
            body = container.find('div.'+options.classBody);
            
            if(body.length == undefined || body.length == 0){
                body = container;
                
            }
            */
            BsFormExtensions.setValues(container,{
                'values'    :   options.values,
            });            
            
            loading('hide');
        }
        
        this.save = function(container,options){
            
            var plugin = this;
            
            loading('show');
            var data = {
                values          :   BsFormExtensions.getValues(container),
                ajax            :   1,
                token           :   container.data('token'),
                action_token    :   container.data('action_token'),
            };
                                   
            $.when(
                $.ajax({
                    url:        container.data('url-save'),
                    type:       'POST',
                    data:       data,
                    dataType:   'json',
                })            
            )
            .done(function(response){
                
                loading('hide');
                plugin.removeInputsWarnings(container);
                 
                if(response.status=='ok' || response.status=='success'){
                    container.find('#pk_id').val(response.id);
                    container.find('#id_item').val(response.id);
                    container.data('token',response.token);
                    
                    if(response.messages != undefined){
                        $.each(response.messages,function(index){
                            _successMessage(response.messages[index]);   
                            
                        });   
                    }
                    else{
                        _successMessage();   
                    }  
                    
                    if(options.doneSave != undefined){
                        options.doneSave(container,options,response);
                    }  
                }
                
                if(response.status=='info'){
                    if(response.messages != undefined){
                        $.each(response.messages,function(index){
                            _infoMessage(response.messages[index]);   
                            
                        });   
                    }
                    else{
                        _infoMessage();   
                    }
                    
                    if(options.doneSave != undefined){
                        options.doneSave(container,options,response);
                    }  
                     
                }
                
                if(response.status=='error'){
                    if(response.messages != undefined){
                        $.each(response.messages,function(index){
                            _errorMessage(response.messages[index]);   
                            
                        });   
                    }
                    else{
                        _errorMessage();   
                    }
                    
                    if(options.errorSave != undefined){
                        options.errorSave(container,options,response);
                    }
                    
                    if(response.errors != undefined){
                        plugin.setInputsError(container,response.errors)    
                    }     
                }
                
            })
            .fail(function(response){
                loading('hide');
                console.log(data)
                _errorMessage();
            });
        }
        
        this.toggleInputReadOnly = function(container,options){
            
            var input = container.find(options.input).eq(0);
            var inputVal = input.val();
            
            if(input.prop('readonly')==undefined || input.prop('readonly')==false || options.readonly==true){
                input.attr('data-last-value',inputVal);
                input.val('');
            } 
            
            
            //readonly por parametro
            if(options.readonly != undefined){
                input.prop('readonly',function(i,r){
                    return options.readonly;
                });
                input.prop('disabled',function(i,r){
                    return options.readonly;
                });
                
                input.trigger('changeReadonly');
                
                
                
            }
            else{
                
                //toggle do readonly
                
                
                if(!input.is("select")){
                    
                    input.prop('readonly',function(i,r){
                        return !r;
                    });
                    
                    input.prop('disabled',function(i,r){
                        return input.prop('readonly');
                    });
                }
                else{
                    input.prop('disabled',function(i,r){
                        return !r;
                    });
                }
                
                
                input.trigger('changeReadonly');
            }

            if(input.prop('readonly')==false){
                input.val(input.attr('data-last-value'));
            }
            
        }
        var plugin = this;
        
        var menu = container.find('.bsform-menu');
            
        if(menu.find('a.bsform-node').length>0){
            menu.find('a.bsform-node').each(function(index){
                
                if($(this).hasClass('active')){
                    plugin.setActiveBody($(this),container,menu);
                }
                
                $(this).bind('click',function(event){
                    plugin.setActiveBody($(this),container,menu);
                });
                
            });    
        } 
       
        this.options = $.extend({'cancelSearch':false},options); 
        
        this.initInputs(container);
        this.setButtonPreviousNOde(container);
        this.setButtonNextNode(container);
        this.setButtonSave(container,options);
        this.setButtonSaveAndClose(container,options);
        
    }
    
    
    $.fn.bsform = function(options){
        
        pluginName = 'bsform';
        var response = '';
        
        $(this).each(function () {
            
            if (!$.data(this, 'plugin_' + pluginName+'_')) {
                $.data(this, 'plugin_' + pluginName+'_',true);
                
                $.data(this, 'plugin_' + pluginName,
                new BsForm($(this),options));
            }
            else if ($.data(this, 'plugin_' + pluginName)){
                response =  $.data(this, 'plugin_' + pluginName).changeMethod($(this),options);
            }
        });
        
        return response; 
        
    };
    
    
    
    
})(jQuery);