(function( $ ){
    
    function BsGrid(container, options){
                
        this.configs = {};
        this.options = $.extend({},options);  
        
        this.changeMethod = function(container,options){
            
            var plugin = this;
            
            if(options==undefined){
                return;
            }
            
            switch(options.method){
                case    'updateData': {
                    plugin.updateData(container,options);;        
                    break;
                }
                case    'reload': {
                    plugin.updateData(container,options);
                    break;
                }
                case    'setPage': {
                    plugin.setPage(container,options);
                    break;
                }
                case    'clear': {
                    plugin.init(container,true);
                    break;
                } 
                case    'getOptions': {
                    return plugin.configs;
                    break;
                }
                case    'getOrder': {
                    return plugin.configs.order;
                    break;
                }
                case    'getRows': {
                    return plugin.getRows(container,options.rows);
                    break;
                } 
                case    'getSelectedRows': {
                    return plugin.getSelectedRows(container,options.rows);
                    break;
                } 
                case    'setSelectedRows': {
                    plugin.setSelectedRows(container,options.rows,options.unselectOthersRows);
                    break;
                }
                case    'cancelSearch': {
                    plugin.cancelSearch();
                    break;
                }
                
                default:{
                    return;
                }
            }
            
        }
        
        this.cancelSearch = function(){
            
            if(this.options.ajax){
               this.options.ajax.abort(); 
            }
        }
        this.init = function(container,clear){
            
            var plugin = this;
            
            var flagLoaded = false;
            if(plugin.configs.loaded!=undefined){
                flagLoaded = plugin.configs.loaded;
            }
            
            $.extend(plugin.configs,
            {
                'loaded'        :  false, //possui carga de dados
                'page'          :   '',
                'rows'          :   0,
                'total_pages'   :   0,
                'limit'         :   {
                    'start'         :   0,
                    'length'        :   0,
                },
                'ajax'  :   false,
                'post_data' :   '',
            });
            
            if(flagLoaded == false){
                $.extend(plugin.configs,{
                    'order'         :   {
                        'column'        :   '',
                        'dir'           :   '',
                    }, 
                });
            }
            
            if(plugin.options.order != undefined){
                $.extend(plugin.configs,{
                    'order'         :   plugin.options.order, 
                });
            }
            
            if(plugin.options.post_data != undefined){
                plugin.configs.post_data = plugin.options.post_data; 
            }
            
            var header = container.find('div.bsgrid-header-base');
            var body = container.find('div.bsgrid-body');
            var footer = container.find('div.bsgrid-footer');
            
            header.height(header.find('div.bsgrid-header').height());
            body.height(container.height()-header.height()-footer.height());
            
            
            footer.find('div.bsgrid-total-items').css('display','none');
            
            plugin.setPage(container,1);
            plugin.setUpdateConfigs(container,plugin.configs)
            
            var inputOptionsShowItems = container.find('select.bsgrid-show-items');
            var optionShowItemsSelected = inputOptionsShowItems.prop('selectedIndex');
            optionShowItemsSelected = inputOptionsShowItems.find('option').eq(optionShowItemsSelected);
            
            plugin.configs.limit.length = optionShowItemsSelected.val();
            
            if(clear){
                plugin.updateRows(container,{});
            }
        }
        
        this.getSelectedRows = function(container){
            
            var body = container.find('div.bsgrid-body');
            gridSelectedRows =  body.find('div.bsgrid-row-selected');
            
            $.each(gridSelectedRows, function(index,item){
                $(this).index = $(this).index();
            });
            
            return gridSelectedRows;
        }
        
        this.getRows = function(container,rows){
            
            var body = container.find('div.bsgrid-body');
            gridRows = body.find('div.bsgrid-content-row').not('.bsgrid-content-row-model');
            
            return gridRows;
        } 
        
        this.setButtonLastPage = function(container){
            
            var plugin = this;
            
            var button = container.find('a.bsgrid-btn-last-page')
            
            button.off();
            
            button.bind('click',function(e){
                
                if(plugin.configs.loaded==false || parseInt(plugin.configs.page)==plugin.configs.total_pages){
                    return false;
                }
                
                plugin.setPage(container,plugin.configs.total_pages);
                plugin.updateData(container)
            });
            
            
        }
        
        this.setButtonFirstPage = function(container){
            
            var plugin = this;
            
            var button = container.find('a.bsgrid-btn-first-page')
            
            button.off();
            
            button.bind('click',function(e){
      
                if(plugin.configs.loaded==false || parseInt(plugin.configs.page)==1){
                    return false;
                }
                
                plugin.setPage(container,1);
                plugin.updateData(container)
            });
            
            
        }
        
        this.setButtonNextPage = function(container){
            
            var plugin = this;
            
            var button = container.find('a.bsgrid-btn-next-page')
            
            button.off();
            
            button.bind('click',function(e){
                if(plugin.configs.loaded==false || parseInt(plugin.configs.page)>=plugin.configs.total_pages){
                    return false;
                }
                plugin.setPage(container,parseInt(plugin.configs.page)+1);
                plugin.updateData(container)
            });
            
            
        }
        
        this.setButtonPreviousPage = function(container){
            
            var plugin = this;
            
            var button = container.find('a.bsgrid-btn-previous-page')
            
            button.off();
            
            button.bind('click',function(e){
                if(plugin.configs.loaded==false || parseInt(plugin.configs.page)==1){
                    return false;
                }
                
                plugin.setPage(container,parseInt(plugin.configs.page)-1);
                plugin.updateData(container)
            });
            
            
        }
        
        this.setButtonPrint = function(container){
            
            var plugin = this;
            
            var button = container.find('.bsgrid-btn-print')
            
            button.off();
            
            
            var functionGetColumns = function(){
                
                var columns = {};
                
                var totalWidth = 0;
                
                
                container.find('.bsgrid-header-column').each(function(index,item){
                    
                    var id = $(this).attr('id');
                     
                    if(typeof id !== 'undefined' && id !== false){
                        
                        totalWidth += parseFloat($(this).width());   
                    }
                });
                
                
                container.find('.bsgrid-header-column').each(function(index,item){
                    var id = $(this).attr('id');
                     
                    if(typeof id !== 'undefined' && id !== false){
                        
                        var columnWidth = (parseFloat(parseFloat(($(this).width()).toFixed(2))/totalWidth).toFixed(2))*100;
                        
                        columns[index] = {
                            id      :   id,
                            width   :   columnWidth,
                        }        
                    }
                    
                });
                
                return columns;
            };
            
            var functionPrint = async function(){
                
                
                var columns = await functionGetColumns();
                               
                _loadModal({
                    'url'       :   BASE_URL+'relatorios/default/consulta',
                    'method'    :   'POST',
                    'data'      :   {
                        'token'     :   container.data('token'),
                        'columns'   :   columns,
                        'bsgrid'    :   container.attr('id'),                         
                    }
                });
            }
            
            button.bind('click', async function(e){
                if(plugin.configs.loaded==false){
                    _warningMessage('Não há uma consulta realizada.')
                    return false;
                }
                
                await functionPrint();
                
                
            });
            
        }
        
        this.setCheckbox = function(container){
            
            var plugin = this;
            var tHead = container.find('div.bsgrid-header').eq(0);
            var bodyContent = container.find('div.bsgrid-body-content').eq(0);
            var rowModel = bodyContent.find('div.bsgrid-content-row-model').eq(0);
            
            
            var columnCheck = $('<div>',{'class':'bsgrid-header-column bsgrid-header-select-all nopadding col-sm-1','style':'width:28px;'}).prependTo(tHead);
            $('<input />', { type: 'checkbox', 'class':'bsgrid-checkbox-select align-middle','style':'margin: 3px 3px 3px 8px;' }).appendTo(columnCheck);
            
            plugin.setCheckboxSelection(container,columnCheck,'all');
            
            var rowCheck = $('<div>',{'class':'bsgrid-content-column bsgrid-row-select nopadding col-sm-1','style':'width:28px;'}).prependTo(rowModel);
            $('<input />', { type: 'checkbox', 'class':'bsgrid-checkbox-select align-middle','style':'margin: 3px 3px 3px 7px;' }).appendTo(rowCheck);
            
            
            
            var totalWidth = 0;
            tHead.find('div.bsgrid-header-column').each(function(index,item){
                totalWidth += parseInt($(this).width(), 10);
            });
            
            
            var totalColumns = tHead.find('div.bsgrid-header-column').length;
            var totalSelectAllWidth = 0;               
            
            //largura total de celulas de select-all
            tHead.find('div.bsgrid-header-select-all').each(function(index,item){
                totalColumns -=1;
                totalSelectAllWidth += parseInt($(this).width());
            });
            
            
            var removeWidthPx = parseInt(totalSelectAllWidth/totalColumns);
            
            tHead.find('div.bsgrid-header-column').each(function(index,item){
                
                if($(this).hasClass('bsgrid-header-select-all')){
                    return;
                }
                
                var cellWidth = parseInt($(this).width()-removeWidthPx);
                
                $(this).css('width', cellWidth+'px');
                
                rowModel.find('div.bsgrid-content-column').eq(index).css('width', cellWidth+'px');
                
                if(index==(tHead.find('div.bsgrid-header-column').length-1) && totalSelectAllWidth%totalColumns != 0){
                    
                    var addWidth = totalSelectAllWidth - (removeWidthPx*totalColumns);
                    var cellWidth = parseInt($(this).width()+addWidth);
                    
                    $(this).css('width',parseInt(cellWidth)+' px');
                    rowModel.find('div.bsgrid-content-column').eq(index).css('width',parseInt(cellWidth)+' px'); 
                }       
            });
        }
        
        this.setCheckboxSelection = function(container,row,type){
            
            var plugin = this; 
            var tHead = container.find('div.bsgrid-header').eq(0);
            var bodyContent = container.find('div.bsgrid-body-content').eq(0);
            
            if(type=='all'){
                var input = row.find('input.bsgrid-checkbox-select');
                
                input.bind('change',function(e){
                    if(this.checked) {
                        bodyContent.find('input.bsgrid-checkbox-select').prop("checked", true);
                        plugin.setSelectedRows(container,'all');
                    }
                    else{
                        bodyContent.find('input.bsgrid-checkbox-select').prop("checked", false);
                        plugin.setSelectedRows(container,[],true);
                    }
                    
                    plugin.setOnToglleSelectRow(container,row);
                });
                
                return;
            }
            
            if(type=='row'){
                
                var input = row.find('input.bsgrid-checkbox-select');
                input.off().bind('change',function(e){
                    
                    if(this.checked) {
                        plugin.setSelectedRows(container,[row.index()-1]);
                        
                        if(plugin.getSelectedRows(container).length== plugin.getRows(container).length){
                            tHead.find('input.bsgrid-checkbox-select').prop("checked", true); 
                        }
                    }
                    else{
                        plugin.toggleSelectedRows(container,[row.index()-1]);
                        
                        if(plugin.getSelectedRows(container).length < plugin.getRows(container).length){
                            tHead.find('input.bsgrid-checkbox-select').prop("checked", false); 
                        }
                        
                    }
                    plugin.setOnToglleSelectRow(container,row);
                });
                
                row.off().bind('click',function(e){
                    
                    if($(e.target).hasClass('bsgrid-checkbox-select')){
                        return;
                    }
                    input.trigger('click')
                });
            }                     
        }
        
        this.setFooter = function(container){
            
            var plugin = this;
            var inputPages = container.find('input.bsgrid-input-pages');
            
            var inputOptionsShowItems = container.find('select.bsgrid-show-items');
            var optionShowItemsSelected = inputOptionsShowItems.prop('selectedIndex');
            optionShowItemsSelected = inputOptionsShowItems.find('option').eq(optionShowItemsSelected);
            
            if(plugin.options.rows_by_bodyheight){
                var gridBody = container.find('div.bsgrid-body');
                var columnModel = gridBody.find('div.bsgrid-content-column').eq(0);
                
                var totalRows = Math.floor(gridBody.height() / columnModel.outerHeight()); 
                
                if(plugin.options.rows_by_bodyheight){
                    
                    var gridBody = container.find('div.bsgrid-body');
                    var columnModel = gridBody.find('div.bsgrid-content-column').eq(0);
                    
                    var totalRows = Math.floor(gridBody.height() / columnModel.outerHeight()); 
                    totalRows = totalRows ? totalRows : 1;
                    
                    if(inputOptionsShowItems.find('option[value='+totalRows+']').length <= 0){
                        inputOptionsShowItems.prepend('<option value="'+totalRows+'">'+totalRows+'</option>');
                    }
                    
                    inputOptionsShowItems.val(totalRows);
                    optionShowItemsSelected = inputOptionsShowItems.prop('selectedIndex');
                    optionShowItemsSelected = inputOptionsShowItems.find('option').eq(optionShowItemsSelected);
                }  
                    
            }
            
            inputPages.focusin(function(){
                $(this).attr('last-value',$(this).val())
            });
            
            inputPages.focusout(function(){
                if($(this).val() != $(this).attr('last-value')  && $(this).val()<=plugin.configs.total_pages && $(this).val()>0){
                    plugin.setPage(container,$(this).val())
                    plugin.updateData(container);
                }
                else{
                     $(this).val($(this).attr('last-value'))
                }
            });
            
            inputPages.bind('keydown',function(event){
                if(event.which == 13){
                    $(this).blur();
                    if($(this).val() != $(this).attr('last-value')  && $(this).val()<=plugin.configs.total_pages && $(this).val()>0){
                        plugin.setPage(container,$(this).val());
                        plugin.updateData(container);
                    }
                    else{
                         $(this).val($(this).attr('last-value'));
                    }
                }
            });
            
           
            
            plugin.configs.limit.length = optionShowItemsSelected.val();
            
            inputOptionsShowItems.bind('change',function(){
                plugin.setChangeShowItems(container,$(this));   
            }); 
            
            _mask();
            
            this.setButtonFirstPage(container);
            this.setButtonPreviousPage(container);
            this.setButtonNextPage(container);
            this.setButtonLastPage(container); 
            this.setButtonPrint(container);
             
        }
        
        this.setChangeShowItems = function(container,inputOptionsShowItems){
            
            var plugin = this;
            
            var optionShowItemsSelected = inputOptionsShowItems.prop('selectedIndex');
            optionShowItemsSelected = inputOptionsShowItems.find('option').eq(optionShowItemsSelected);
            
            plugin.setLimit(optionShowItemsSelected.val())
            plugin.setPage(container,1);
            
            
            if(plugin.configs.loaded){
                plugin.updateData(container);    
            }
            
        }
        
        this.setHeader = function(container){
            
            var plugin = this;
            
            var _thead = container.find('div.bsgrid-header').eq(0);
            
            if(plugin.options.checkbox){
                
                plugin.setCheckbox(container);
                
            }
            
            _thead.find('div.bsgrid-header-column').each(function(index,item){
                
                if(plugin.options.checkbox && index==0){
                    return ;
                }
                
                if(options.headerSort != undefined && options.headerSort!=true){
                    return ;
                } 
                            
                if(plugin.configs.loaded==false &&  $(this).find('i.fa').hasClass('ordered-icon')){
                    
                    plugin.configs.order.column = $(this).index();
                    if($(this).find('.ordered-icon').hasClass('order-asc')){
                        plugin.configs.order.dir = 'asc';    
                    }
                    else{
                        plugin.configs.order.dir = 'desc';
                    }
                    return;
                }
                
                $(this).off();
                
                if($(this).find('.order-icon').length==0){
                    $(this).append('<span class="order-icon pull-right padding-right-6"><i class="fa fa-unsorted"></i></span>')    
                }
                else{
                    $(this).find('.order-icon').html('<i class="fa fa-unsorted"></i>');
                }
                
                $(this).off().hover(function(){
                    $(this).find('.order-icon ').css("color", "#CCC");
                },function(){
                   $(this).find('.order-icon ').css("color", "#6F6F6F"); 
                });
                
                
                $(this).off().click(function(e){
                    
                    var columnKey = $(this).index();
                    var columnId = $(this).attr('id');

                    if(plugin.options.checkbox){
                        columnKey--;
                    }
                    
                    _thead.find('div.bsgrid-header-column').find('.order-icon').html('<i class="fa fa-unsorted"></i>')     
                    if(plugin.configs.order.column!= columnKey && plugin.configs.header){
                        plugin.setHeader(container);
                        $(this).children('.order-icon').html('<i class="ordered-icon fa fa-caret-down"></i>')
                        plugin.configs.order.dir = 'asc';
                    }
                    else if(plugin.configs.order.column==columnKey && plugin.configs.order.dir == 'desc'){
                        $(this).children('.order-icon').html('<i class="ordered-icon order-asc fa fa-caret-down"></i>')
                        plugin.configs.order.dir = 'asc';
                    }
                    else{
                        $(this).children('.order-icon').html('<i class="ordered-icon order-desc fa fa-caret-up"></i>')
                        plugin.configs.order.dir = 'desc';
                    }
                    plugin.configs.order.column = columnKey;
                    plugin.configs.order.id = columnId;
                    
                    if(plugin.options.sortFunction != undefined){
                        plugin.options.sortFunction(container,$(this),plugin);
                        return false;
                    }
                    
                    if(plugin.configs.loaded == false){
                        return;    
                    }                  
                    
                    plugin.setPage(container,1)
                    plugin.updateData(container);
                    
                });
                
                if(plugin.options.checkbox){
                    
                    if(plugin.configs.order.column == index){
                        plugin.configs.order.column = plugin.configs.order.column-1;
                        plugin.configs.order.dir = plugin.configs.order.dir=='asc' ? 'desc' : 'asc';
                        $(this).trigger('click');    
                    }
                }
                else{
                    
                    
                    if(plugin.configs.order.column == index && plugin.configs.setOrder != undefined && plugin.configs.setOrder == true){
                        plugin.configs.order.dir = plugin.configs.order.dir=='asc' ? 'desc' : 'asc';
                        $(this).trigger('click');    
                    }
                    
                }
                
                
                
            });
        }
        
        this.setLimit = function(length){
            
            var plugin = this;
            
            if(length!=undefined){
                plugin.configs.limit.length = length    
            }
            plugin.configs.limit.start = (parseInt(plugin.configs.page)-1)*plugin.configs.limit.length;
        }
        
        this.setOnDoubleClickRow = function(container,row){
            
            var plugin = this;
            
            row.bind('dblclick',function(e){
                if(plugin.options.rowOnDoubleClick != undefined){
                    plugin.options.rowOnDoubleClick(e,$(this),container,plugin)
                    return;
                } 
            });
        }
        
                
        this.setOnClickRow = function(container,row){
            
            var plugin = this;
            
            row.bind('click',function(e){
                if(plugin.options.rowOnClick != undefined){
                    plugin.options.rowOnClick(e,$(this),container,plugin)
                    return;
                } 
            });
        }
        
        this.setOnMouseOverCell = function(container,row){
            
            var plugin = this;

            row.find('.bsgrid-content-column').each(function(idex,item){
                
                
                var _t = $(this)
                
                if (_t.hasOverflown()) {
                    _t.popover({ 
                        trigger: "hover",
                            html        :   true,
                            placement   :   'bottom',
                            animation   :   false,
                            delay: { 
                               show: "500", 
                               hide: "0"
                            },
                            content     :   function(){
                                return '<span class="size-10">'+_t.text()+'</span>';
                            },
                    })
                }
                
            });
        }
        
        this.setOnMousepressRow = function(container,row){
            
            var plugin = this;
            
            row.bind('click',function(e){
                if(plugin.options.rowOnClick != undefined){
                    plugin.options.rowOnClick($(this),container)
                    return;
                } 
            });
        }
        
        this.setOnToglleSelectRow = function(container,row){
            
            var plugin = this;
            
            if(plugin.options.rowOnToggleSelect != undefined){
                plugin.options.rowOnToggleSelect(row,container,plugin)
                return;
            } 
        }
        
        this.setPage = function(container,page){
            
            var plugin = this;
            
            plugin.configs.page = parseInt(page);
            plugin.setLimit();
            container.find('input.bsgrid-input-pages').val(parseInt(plugin.configs.page)); 
        }
        
        this.setSelectedRows = function(container,rows,unselectOthersRows){
            
            var plugin = this;
            
            gridRows = plugin.getRows(container);
            
            if(unselectOthersRows==true){
                 gridRows.removeClass('bsgrid-row-selected');
                 gridRows.find('input.bsgrid-checkbox-select').prop("checked", false);
            }
            
            if(rows == 'all'){
                var rows = [];
                $.each(gridRows,function(index,item){
                    
                    if($(gridRows[index]).attr('data-unselectable') != 'true'){
                        rows.push(index);    
                    }
                    
                });
            }
            
            $.each(rows,function(index,item){
                gridRows.eq(item).addClass('bsgrid-row-selected');
            });
        }
        
        this.toggleSelectedRows  = function(container,rows,unselectOthersRows){
            
            var plugin = this;
            
            gridRows = plugin.getRows(container);
            
            
            $.each(rows,function(index,item){
                
                if(!gridRows.eq(item).hasClass('bsgrid-row-selected')){
                    plugin.lastSelectedRow = item;
                }
                
                gridRows.eq(item).toggleClass('bsgrid-row-selected');
            });
            
            
            if(unselectOthersRows==true){
                 $.each(gridRows,function(index,item){
                    if(!rows.includes(index)){
                        $(this).removeClass('bsgrid-row-selected');
                    }  
                 })
                 
            }
            
            
            
        }
        
        this.setUpdateConfigs = function(container,response){
            
            var plugin = this;
            
            plugin.configs.loaded = response.loaded;
            plugin.configs.rows = response.count;
            plugin.configs.total_pages = Math.ceil(plugin.configs.rows/plugin.configs.limit.length);
            
            var showRows = plugin.configs.rows;
            if(showRows != undefined){
                showRows = showRows.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            } 
            container.find('span.bsgrid-total-items').html(showRows);
            
            if(plugin.configs.loaded==true){
                container.find('div.bsgrid-total-items').css('display','inline');    
            }
            
            container.find('span.bsgrid-total-rows').html(plugin.configs.total_pages);  
                      
        }
        
        this.updateRows = function(container,rows){
            
            var plugin = this;
            
            var bodyContent = container.find('div.bsgrid-body-content').eq(0);
            bodyContent.find('div.bsgrid-content-row').not('.bsgrid-content-row-model').remove();
            
            $.each(rows,function(indexRow,itemRow){
                
                var rowModel = bodyContent.find('div.bsgrid-content-row-model').eq(0).clone();
                rowModel.removeClass('bsgrid-content-row-model').removeClass('softhide');
                
                
                var row = rows[indexRow].data;
                
                rowModel.attr('href',rows[indexRow].href ? rows[indexRow].href : '#')
                rowModel.attr('data-pk-value',rows[indexRow].pk_value ? rows[indexRow].pk_value : '')
                
                var arrNotData = ['href','data-pk-value'];
                
                $.each(itemRow,function(index,item){
                    if(index=='data'){
                        return;
                    }  
                    
                    rowModel.attr(index,item);
                });
                
                $.each(row,function(indexColumn,dataColumn){
                    
                    if(dataColumn && typeof dataColumn == 'object'){
                        
                        columnText = (dataColumn.html!= undefined) ?  dataColumn.html() :  dataColumn.text;
                        
                    }
                    else{
                        var columnText = dataColumn;
                    }
                    
                    
                    if(Number.isInteger(parseInt(indexColumn))==false){
                        return;
                    }
                    
                    var rowColumnIndex = parseInt(indexColumn);
                    if(plugin.options.checkbox == true){
                        rowColumnIndex +=1;
                        
                        plugin.setCheckboxSelection(container,rowModel,'row');
                    }
                    
                    if(dataColumn &&  dataColumn.class != undefined){
                        
                        rowModel.find('div.bsgrid-content-column').eq(rowColumnIndex).addClass(dataColumn.class.join(' '));
                    }
                    
                    rowModel.find('div.bsgrid-content-column').eq(rowColumnIndex).html('');
                    
                    if(typeof columnText == 'string'){
                    
                        rowModel.find('div.bsgrid-content-column').eq(rowColumnIndex).html(columnText);
                    }
                    
                });
                
                plugin.setOnMouseOverCell(container,rowModel);
                plugin.setOnClickRow(container,rowModel);
                plugin.setOnDoubleClickRow(container,rowModel);
                
                bodyContent.append(rowModel);
            });
             
        }
        
        this.updateData = async function(container,options){
            
            var plugin = this;
            var containerBody = container.find('div.bsgrid-body').eq(0);
            var selectedRows = plugin.getSelectedRows(container);
            
            if(plugin.options.showLoading != undefined && plugin.options.showLoading == true){
                loading('show');
            }
             
            if(options!=undefined &&  options.page != undefined && parseInt(plugin.configs.page) != options.page){
                plugin.setPage(container,options.page);
            }
            
            
            if(options!=undefined){
                plugin.configs = $.extend(plugin.configs,options);
            } 
            
            plugin.configs.token = container.data('token');
            
            if(plugin.configs.beforeUpdateData != undefined){
                await plugin.configs.beforeUpdateData(container,plugin);
            }
           
            if(plugin.options.loadingOverlay == undefined || plugin.options.loadingOverlay != false){
                containerBody.LoadingOverlay('show',{
                    'image'     :   BASE_URL+'assets/img/wheel.gif',
                    'fade'      :   400,
                    'zIndex'    :   containerBody.css('zindex')+100,
                });    
            }
            
            
            if(plugin.configs.preserv_selected_rows == false || (options != undefined && options.preserv_selected_rows == false)){
                container.find('.bsgrid-header-select-all > input.bsgrid-checkbox-select').prop("checked", false).trigger('change');
            }
            
            if(options != undefined && options.items != undefined){
                
                
                plugin.updateRows(container,options.items);
                containerBody.LoadingOverlay('hide'); 
                
                if(plugin.configs.afterUpdateData != undefined){
                    plugin.configs.afterUpdateData(container,plugin,plugin.configs);
                }
            }
            else if(container.attr('href') != undefined && container.attr('href')!= ''){
                
                
                var setData = function(container,response){
                        
                        response.loaded = true;
                        plugin.setUpdateConfigs(container,response)
                        plugin.updateRows(container,response.items);
                        
                        if(plugin.configs.preserv_selected_rows == true && (options != undefined && options.preserv_selected_rows != false)){
                            $.each(selectedRows,function(index,item){
                               plugin.setSelectedRows(container,[item.index-1])
                            });
                        } 
                        
                        if(plugin.configs.afterUpdateData != undefined){
                            plugin.configs.afterUpdateData(container,plugin);
                        }
                    }
                    
                    
                    var updateDataFunction = async function(container,response){
                        
                        await setData(container,response);
                        containerBody.LoadingOverlay('hide');
                        loading('hide');  
                    } 
                                        
                
                $.when(
                    $.ajax({
                        url     :   container.attr('href'),
                        type    :   'POST',
                        data    :   plugin.configs,
                        dataType:   "json"
                    })
                )
                .done(function(response){
                     updateDataFunction(container,response); 
                    
                })
                .fail(function(response){
                    console.log(response)   
                });
                
            }
            
        }
        
        this.init(container);
        
        if(container.data('no-header')!=true && options.noHeader!=true){
            this.configs.header = false;
            this.setHeader(container);   
        }
        else{
            this.configs.header = false;
        }
        
        
        if(container.data('no-footer')!=true || (options.noFooter!= undefined &&  options.noFooter!=true)){
            this.configs.footer = true;
            this.setFooter(container);    
        }
        else{
            this.configs.footer = false;
            limit = container.data('limit') ? container.data('limit') : 10; 
            limit = this.configs.limit.length ? this.configs.limit.length : limit;
            this.setLimit(limit);
        }
        
        if(options.items != undefined){
            this.updateData(container,options);
        }
        
                       
    }
    
    $.fn.bsgrid = function(options){
        
        pluginName = 'bsgrid';
        var response = '';
        
        $(this).each(function () {
            if (!$.data(this, 'plugin_' + pluginName+'_')) {
                $.data(this, 'plugin_' + pluginName+'_',true);
                
                $.data(this, 'plugin_' + pluginName,
                new BsGrid($(this),options));
            }
            else if ($.data(this, 'plugin_' + pluginName)){
                
                response =  $.data(this, 'plugin_' + pluginName).changeMethod($(this),options);
            }
        });
        
        return response; 
    };
    
    
})(jQuery);