(function( $ ){
    
    
    gedExtensions.setShowAs = function(){
            
        var plugin = this;
        var container = plugin.container;
        var filesBody = container.find('div.ged-files-body').eq(0);
        var boxShowAs = plugin.container.find('div.ged-show-as');
        var showAsButtons = boxShowAs.find('.ged-show-as-button');
        
        showAsButtons.each(function(index,item){
            if(plugin['showAs_'+$(this).data('show')]==undefined){
                $(this).remove();
                return;
            }
            
            $(this).off().bind('click',function(){
                plugin['showAs_'+$(this).data('show')]() 
            });
        });
        
        plugin['showAs_'+plugin.options.show_as](true);
        plugin.setContextMenu();
        
                
    }
    
    gedExtensions.showAs_box = function(reload){                
        var plugin = this;
        
        if(plugin.options.show_as=='box' && reload!=true){
            return false;
        }
        plugin.options.show_as='box';
        
        plugin.showAs_box_setFiles();
    }
    
    gedExtensions.showAs_list = function(reload){
        
        var plugin = this;
        var container = plugin.container;
        
        if(plugin.options.show_as=='list' && reload!=true){
            return false;
        }
        plugin.options.show_as='list';
        
        
        var filesBody = container.find('div.ged-files-body').eq(0);
        var gridDivModel = container.find('div.ged-template-show-as-list').clone();
        
        filesBody.empty();
        
        gridDivModel.removeClass('ged-template-show-as-list').removeClass('softhide').show();
             
        filesBody.append(gridDivModel.html())
        
        var sortMenu = container.find('.ged-sort-menu-button').closest('div.btn-group');
        var menuItems = sortMenu.children('ul').children('li').children('button.dropdown-item');
        var arrSortTypes = [];
        
        menuItems.each(function(index,item){
           arrSortTypes.push($(item).attr('data-sort-column')); 
        });       
        
        var keySortColumn = (arrSortTypes.indexOf(plugin.options.sort.column))+1;
        
        var grid = filesBody.find('div.bsgrid').eq(0)
        grid.height(filesBody.height()) ;
        
        grid.bsgrid({
            'checkbox'              :   true,
            'rows_by_bodyheight'    :   true,
            'loadingOverlay'        :   false,
            'rowOnDoubleClick'      :   function(e,row,container,bsgridPlugin){
                if(row.attr('data-type')=='path'){
                    plugin.setPath(row.attr('data-path')); 
                    plugin.setContextMenu();        
                }
            },
            'sortFunction'          :   function(container,column,bsgridPlugin){
                if(!plugin.options.initialized){
                    return;
                }
                else{
                    plugin.setSort({
                        'column'    :   arrSortTypes[bsgridPlugin.configs.order.column],
                        'dir'       :   bsgridPlugin.configs.order.dir
                        
                    });
                    plugin.reload();
                }
            },
            'order'                 :{
                'column'    :   parseInt(keySortColumn),
                'dir'       :   plugin.options.sort.dir
            }
        });
        
        plugin.showAs_list_setFiles();
    }
    
        
    gedExtensions.showAs_box_setFiles = async function(){
        
        var plugin = this;
        var container = plugin.container;
               
        var filesBody = container.find('div.ged-files-body').eq(0);
        filesBody.empty();
        
        var files = plugin.getFiles();
        
        if(plugin.getPath()){
            
            var boxModel = container.find('div.ged-template-show-as-box').clone();

            var arrPaths = plugin.getPath().split('/');
            var thisPath = arrPaths.pop();
            
            var path = arrPaths.join('/');
            
            var parentFiles = plugin.getFiles(path);
            
            $.each(parentFiles,function(index,item){
                if(item.type=='path' && item.name == thisPath && item.is_new != undefined && item.is_new){
                    boxModel.find('div.ged-box-file').addClass('new');        
                } 
            });
            
            boxModel.find('div.ged-box-file').attr('data-type','path');
            boxModel.find('div.ged-box-file').attr('data-path',arrPaths.join('/'));
            boxModel.find('div.ged-box-file').attr('data-contextmenu','false');
            boxModel.find('div.ged-box-file').attr('data-sortable','false');
            
            
            var boxIcon = boxModel.find('div.ged-box-file-icon');
            boxIcon.html('<span>..</span>');
            
            var boxText = boxModel.find('div.ged-box-file-name').find('span.file-name')
            boxText.text('Um nível acima');
            
            filesBody.append(boxModel.html());
        }
        
        
        $.each(files,function(index,item){
            var boxModel = container.find('div.ged-template-show-as-box').clone();
            
            boxModel.find('div.ged-box-file').attr('data-uuid',item.uuid);
            boxModel.find('div.ged-box-file').attr('data-type',item.type);
            boxModel.find('div.ged-box-file').attr('data-name',item.name);
            
            var boxIcon = boxModel.find('div.ged-box-file-icon');
            boxIcon.append(plugin.getIcon(item));
            
            var boxText = boxModel.find('div.ged-box-file-name .file-name')
            boxText.text(item.name);
            
            if(item.type != 'path'){
                boxText.text(boxText.text()+'.'+item.type);
            }
            else{
                boxModel.find('div.ged-box-file').attr('data-path',item.path);
            }
            
            
            if(item.is_new != undefined && item.is_new){
                boxModel.find('div.ged-box-file').addClass('new');
            }
            
            filesBody.append(boxModel.html());    
        });
         
        var filesBox = filesBody.find('div.ged-box-file');
        filesBox.bind('click',function(event){
            
            if(event.shiftKey || event.ctrlKey){
                $(this).toggleClass('active');
            }
           
            else{
                filesBox.removeClass('active');
                $(this).addClass('active');
            }
        });
        
        filesBox.bind('dblclick',function(event){
            if($(this).attr('data-type')=='path'){
                plugin.setPath($(this).attr('data-path'));
                plugin.setContextMenu();
            }
        });
        
        filesBody.find('div.ged-box-file[data-type="path"]').droppable({
            drop    :  function(event,ui){
                var _t = $(this);
                var allActive = filesBody.find('div.ged-box-file.active');
                window['ged_file_action'] = false;
                
                var moveFilesFunciton = async function(){
                    await plugin.moveFile($(ui.draggable).data('uuid'),plugin.getPath(),_t.data('path'));
                    plugin.reload();
                    
                    allActive.each(async function(index,item){
                        
                        if($(item).data('uuid')== _t.data('uuid') || $(item).data('uuid') == $(ui.draggable).data('uuid') || ($(item).data('sortable')!= undefined && !$(item).data('sortable'))){
                            return;
                        }
                        await plugin.moveFile($(item).data('uuid'),plugin.getPath(),_t.data('path'));
                        plugin.reload();
                    }); 
                       
                }
                
                moveFilesFunciton();
                window['ged_file_action'] = false;
                
            },
            classes : {
                'ui-droppable-hover'    :   'drop',
            },
        })
        
        filesBody.find('div.ged-box-file[data-sortable!="false"]').draggable({
            revert        :   true,
            opacity       :   0.6,
            cursor        :   'grabbing',
        });
        
    }
    
    gedExtensions.showAs_list_setFiles = function(){
        
        var plugin = this;
        var container = plugin.container;
        
        var filesBody = container.find('div.ged-files-body').eq(0);
        var grid = filesBody.find('div.bsgrid').eq(0)
        
        var files = plugin.getFiles();
        
        var items = [];
                 
        if(plugin.getPath()){
            var arrPaths = plugin.getPath().split('/');
            arrPaths.pop();
            items.push({
                'data'  :   {
                    0   :  '..',
                    1   :   '',
                    2   :   '',
                    3   :   ''  
                },
                'data-type' :  'path',
                'data-path' :   arrPaths.join('/'),
                'data-unselectable' :   true,
            });    
        }
        
        $.each(files,function(index,item){
            
            var icon = plugin.getIcon(item);
            icon.addClass('size-16')
            
            var iconSpan = $('<span class="file-icon"/>').css({'width':18}).addClass('text-centered');
            iconSpan.css({'float':'left'});
            iconSpan.append(icon);
            
            var nameSpanText = $('<span class="file-name"/>');
            nameSpanText.height(20);
            nameSpanText.addClass('padding-left-2').css({'float':'left'});
            nameSpanText.append(item.name);
            
            var nameSpan = $('<span class="width-100p"/>');
            nameSpan.append(iconSpan);
            nameSpan.append(nameSpanText);
            
            items.push({
                'data'  :   {
                    0:  nameSpan,
                    1:  item.date,
                    2:  item.size,
                    3:  item.type=='path' ? 'Pasta' : item.type   
                },
                'data-name'     :   item.name,
                'data-type'     :   item.type,
                'data-path'     :   item.path != undefined ? item.path  : '',
                'data-uuid'     :   item.uuid,
                
            })
        });
        
        var sortMenu = container.find('.ged-sort-menu-button').closest('div.btn-group');
        var menuItems = sortMenu.children('ul').children('li').children('button.dropdown-item');
        var arrSortTypes = [];
        
        menuItems.each(function(index,item){
           arrSortTypes.push($(item).attr('data-sort-column')); 
        });
        
        
        var keySortColumn = (arrSortTypes.indexOf(plugin.options.sort.column))+1;
        grid.bsgrid({
            'method'                :   'updateData',
            'items'                 :   items,
            'afterUpdateData'       :   function(container,bsgridPlugin){
                container.find('[data-unselectable="true"]').find('input.bsgrid-checkbox-select').remove();
                bsgridPlugin.setSelectedRows(container,[],true);
            },
        });
        
        grid.find('.file-name').each(function(index,item){ 
           var fileNameWidth = $(this).parents('.bsgrid-content-column').width() - $(this).closest('.bsgrid-content-column').find('.file-icon').eq(0).width();
           $(this).width(fileNameWidth-16)
        });
        
        
        grid.find('div.bsgrid-content-row[data-type="path"]').droppable({
            drop    :   function(event,ui){
                var _t = $(this);
                var allActive = filesBody.find('div.bsgrid-row-selected');
                window['ged_file_action'] = false;
                
                
                var moveFilesFunciton = async function(){
                    await plugin.moveFile($(ui.draggable).data('uuid'),plugin.getPath(),_t.data('path'));
                    plugin.reload();
                    
                    allActive.each(async function(index,item){
                        
                        if($(item).data('uuid')== _t.data('uuid') || $(item).data('uuid') == $(ui.draggable).data('uuid') || ($(item).data('sortable')!= undefined && !$(item).data('sortable'))){
                            return;
                        }
                        await plugin.moveFile($(item).data('uuid'),plugin.getPath(),_t.data('path'));
                        plugin.reload();
                    }); 
                       
                }
                
                moveFilesFunciton();
                window['ged_file_action'] = false;
            },
            classes : {
                'ui-droppable-hover'    :   'drop',
            },
        })
        
        grid.find('div.bsgrid-content-row[data-sortable!="false"]').draggable({
          revert        :   true,
          opacity       :   0.6,
          cursor        :   'grabbing',
        }); 
        
    }
    
})(jQuery);