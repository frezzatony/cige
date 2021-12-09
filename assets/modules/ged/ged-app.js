
var gedExtensions = {};

(function( $ ){
    
        
    function ged_app(container, options){
        
        var plugin = this;
        
        this.container = container;
        
        this.options = {
            'initialized':  false,
            'icons'     :   {
                'font'  :   'fa',
                'sort'  :   {
                    'asc'   :   'fa-sort-amount-asc',
                    'desc'  :   'fa-sort-amount-desc'
                },
            },
            'sort'      :   {
                'column':   'name',
                'dir'   :   'asc'
            },
            'show_as'   :   'box',
            'path'      :   '',
            'filesTypes':   false,
            
        }
        $.extend(this.options,container.data());
        $.extend(this.options,options);
        
        
        this.changeMethod = function(options){
                   
        } 
        
        this.addFile = async function(file,path,isNew,method){
           
            var plugin = this;
            var container = plugin.container;
            var filesBody = container.find('div.ged-files-body').eq(0);
            var file = $.extend({},file);
            path = (path == undefined) ? plugin.getPath() : path;
            var pluginFiles = $.extend({},plugin.getFiles(path));
            window['ged_file_action'] = (window['ged_file_action'] == undefined ? false :window['ged_file_action']);
            window['ged_file_action'] = method != undefined ? method : window['ged_file_action'];
            
            var replaceUUID = '';
            var arrAll = ['replace_all','skip_all'];
                    
            var flagCanAdd = true;
            
            var addFileFunction = function(){
                file.is_new = isNew==undefined ? true : isNew;
                pluginFiles[Object.keys(pluginFiles).length] = file;
                plugin.setFiles(pluginFiles,path);
            }
            
            var eachFilesCanAddFunction =  function(pluginFiles){
                
                var strFileName = file.name;
                strFileName += (file.type != 'path') ? '.'+file.type : '';
               
                $.each(pluginFiles,function(index,item){
                    
                    var strStoredName = item.name;
                    strStoredName += (item.type != 'path') ? '.'+item.type : '';
                    
                    if(strStoredName == strFileName){
                        flagCanAdd = false;
                        replaceUUID = item.uuid; 
                        return false;
                    }
                });
                
                return flagCanAdd;
            }
            
            var confirmFileFunction = function(){
                var strPath = 'Home'+path;  
                var strFile = file.name+'.'+file.type;  
                $.confirm({
                    container   :  '#'+filesBody.attr('id'), 
                    title       :   'Conflito de arquivos',
                    animation   :   'none',
                    theme       :   'bootstrap',
                    columnClass : 'col-md-14',
                    content     :   '<p class="size-12">A pasta destino: <strong class="size-11">'+strPath+'</strong> já possui um arquivo chamado <strong>'+strFile+'</strong></p><p class="size-12">O que deseja fazer?</p>', 
                    buttons     : {
                        'replace':  {
                            text        :   'Substituir',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_action'] = 'replace';       
                            }
                        },
                        'replace_all':  {
                            text        :   'Substituir todos',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_action'] = 'replace_all';       
                            }
                        },
                        'skip':  {
                            text        :   'Não mover o arquivo',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_action'] = 'skip';       
                            }
                        },
                        'skip_all':  {
                            text        :   'Não mover todos os conflitos',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                
                                window['ged_file_action'] = 'skip_all';       
                            }
                        },
                    }
                });
            }
            
            var fileActionFunction = async function(action){                              
                await sleep(100);
                if(action===false){
                    await fileActionFunction(window['ged_file_action']);
                }
                return window['ged_file_action'];
            }
            
            flagCanAdd = await eachFilesCanAddFunction(pluginFiles);
            
            if(flagCanAdd){
                await addFileFunction();
            }
            
            //já existe o arquivo informado
            if(!flagCanAdd){
                
                //é uma path e não possui files para efetuar merge
                if(file.type == 'path' && (file.files == undefined || Object.values(file.files).length<=0)){
                   flagCanAdd = true; 
                }
                //é uma path e possui arquivos para mesclar
                else if(file.type == 'path' && file.files != undefined && Object.values(file.files).length>0){
                    
                    var flagCanAdd = true;
                    
                    var mergePathFunction = async function(){
                        for (const [index, item] of file.files.entries()) {
                            var flagFilePathAdd = await plugin.addFile(item,path+'/'+file.name);
                            
                            if(!flagFilePathAdd){
                                flagCanAdd = false;
                            }
                        }
                    }
                    await mergePathFunction();
                }
                //é um arquivo e deve ser selecionada uma acao
                else{
                    if(arrAll.indexOf(window['ged_file_action'])<0){
                        window['ged_file_action'] = false;
                        confirmFileFunction();
                        window['ged_file_action'] = await fileActionFunction(window['ged_file_action']);
                    }
                    
                    switch(window['ged_file_action']){
                        case 'skip':{
                            break;
                        }
                        case 'skip_all':{
                            break;
                        }
                        case 'replace': {
                            await addFileFunction();
                            await plugin.removeFile(replaceUUID);
                            flagCanAdd = true;
                            break;
                        }
                        case 'replace_all':{
                            await addFileFunction();
                            await plugin.removeFile(replaceUUID);
                            flagCanAdd = true;
                            break;
                        }
                    }   
                }
            }

            return flagCanAdd;
        }
        
        this.fileRename = async function(fileUUID,newName,path){
            
            var plugin = this;
            var container = plugin.container;
            var filesBody = container.find('div.ged-files-body').eq(0);
            path = (path == undefined) ? plugin.getPath() : path;
            var files = $.extend({},plugin.getFiles(path));
            var file = {};
            newName = newName.replace(/[\/\\'"]/g,'');
            
            
            $.each(files,function(index,item){
                if(item.uuid == fileUUID){
                    file = item;
                }
            });
            
            var arrNewName = newName.split('.');
            
            if(arrNewName.length>1){
                var newType = arrNewName.pop();    
            }
            
            var tmpNewName = arrNewName.join('.');
            
            if(!tmpNewName.length){
                _errorMessage('Nome de arquivo inválido');
                return file.name + (file.type!='path' ? '.'+file.type : '');
            }
            
            var fileActionFunction = async function(action){                              
                await sleep(100);
                if(action===false){
                    await fileActionFunction(window['ged_file_change_rename']);
                }
                
                return window['ged_file_change_rename'];
            }
            
            var confirmChangeTypeFunction = function(){
                
                $.confirm({
                    container   :  '#'+filesBody.attr('id'), 
                    title       :   'Alteração do tipo de arquivo',
                    animation   :   'none',
                    theme       :   'bootstrap',
                    columnClass : 'col-md-14',
                    content     :   '<p class="size-12">O tipo do arquivo foi alterado. Alterações como estas podem tornar seus dados inacessíveis.</p><p class="size-12">O que deseja fazer?</p>', 
                    buttons     : {
                        'change':  {
                            text        :   'Confirmar alteração',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_change_rename'] = 'change';       
                            }
                        },
                        'not_change_type':  {
                            text        :   'Alterar apenas o nome',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_change_rename'] = 'not_change_type';       
                            }
                        },
                        'skip':  {
                            text        :   'Cancelar alteração',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_change_rename'] = 'skip';       
                            }
                        },
                    }
                });
            }
            
            var confirmPathMerge = async function(){
                
                $.confirm({
                    container   :  '#'+filesBody.attr('id'), 
                    title       :   'Mesclar pastas com mesmo nome',
                    animation   :   'none',
                    theme       :   'bootstrap',
                    columnClass : 'col-md-14',
                    content     :   '<p class="size-12">Já existe uma pasta como  mesmo nome</p><p class="size-12">O que deseja fazer?</p>', 
                    buttons     : {
                        'merge_all':  {
                            text        :   'Mesclar as pastas e substituir todo o conteúdo',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_change_rename'] = 'merge_all';       
                            }
                        },
                        'skip':  {
                            text        :   'Cancelar alteração',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_change_rename'] = 'skip';       
                            }
                        },
                    }
                });
                
                window['ged_file_change_rename'] = false;
                var action = await fileActionFunction(window['ged_file_change_rename']);
                
                switch (action){
                    case 'skip':{
                        return false;
                        break;
                    }
                    case 'merge_all':{
                        return true;
                        break;
                    }
                }
                
            }
            
            var confirmFileSameName = async function(tmpNewName){
                
                $.confirm({
                    container   :  '#'+filesBody.attr('id'), 
                    title       :   'Arquivos iguais',
                    animation   :   'none',
                    theme       :   'bootstrap',
                    columnClass : 'col-md-14',
                    content     :   '<p class="size-12">Já existe um arquivo com o mesmo nome.</p><p class="size-12">Deseja renomear o arquivo como: <strong>'+tmpNewName+'</strong>?</p>', 
                    buttons     : {
                        'rename':  {
                            text        :   'Renomear com nome sugerido',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_change_rename'] = 'rename';       
                            }
                        },
                        'skip':  {
                            text        :   'Cancelar alteração',
                            btnClass    :   'btn-sm btn-default btn-3d nopadding padding-left-4 padding-right-4',
                            action      : function(){
                                window['ged_file_change_rename'] = 'skip';       
                            }
                        },
                    }
                });
                
                window['ged_file_change_rename'] = false;
                var action = await fileActionFunction(window['ged_file_change_rename']);
                
                return action;
            }
            
            
            
            var newType = false;
            //verifica se mudou o tipo do arquivo
            var arrNewName = newName.split('.');
            if(arrNewName.length>=2){
                var newType = arrNewName.pop();    
            }
            
            if(newType && newType!=file.type){
                window['ged_file_change_rename'] = false;
                await confirmChangeTypeFunction();
                await fileActionFunction(window['ged_file_change_rename']);
                
                switch (window['ged_file_change_rename']){
                    case 'skip':{
                        newName =  file.name+'.'+file.type;
                        break;
                    }
                    case 'not_change_type':{
                        var arrNewName = newName.split('.');
                        arrNewName.pop();
                        arrNewName.push(file.type);
                        newName = arrNewName.join('.');
                        break;
                    }
                }
            }  
            
            //verifica se nao há um arquivo com o mesmo nome
            var itemSameName = false;
            $.each(files,function(index,item){
                
                var strName = item.name;
                strName += item.type!='path' ? '.'+item.type : '';
                
                if(newName == strName && item.uuid != fileUUID){
                    itemSameName = item;
                }
            });
            
            //existe um arquivo com o mesmo nome
            if(itemSameName!==false){
                //é uma pasta, pode efetuar o merge
                if(file.type == 'path'){
                    //cancelou a ação
                    if(!await confirmPathMerge()){
                        return file.name;
                    }
                    //mesclando os itens
                    else{
                        var moveFilesFunction = async function(){
                            var flagAllFilesMoved = true;
                            
                            if(file.files != undefined && Object.values(file.files).length){
                                for (const [index, item] of file.files.entries()) {
                                    var flagMoved = await plugin.moveFile(item.uuid,file.path,itemSameName.path,'replace_all');
                                    if(!flagMoved){
                                        flagAllFilesMoved = false;
                                    }  
                                }
                            } 
                        }
                        await moveFilesFunction();                     
                        await plugin.removeFile(file.uuid);
                        
                        return false;
                    }
                    
                }
                //é um arquivo
                else{
                    
                    var arrNewName = newName.split('.');
                    var newType = arrNewName.pop();
                    
                    var count = 1;
                    var tmpNewName = arrNewName.join('.') +'('+count+').' + newType;
                    
                    $.each(files,function(index,item){
                        if(item.name+'.'+item.type == tmpNewName && item.uuid!=file.uuid){
                            count++;
                            tmpNewName = arrNewName.join('.') +'('+count+').' + newType;
                        }
                    });
                    
                    
                    window['ged_file_change_rename'] = false;
                    action = await confirmFileSameName(tmpNewName);
                    
                    switch (action){
                        case 'skip':{
                            return file.name
                            break;
                        }
                        case 'rename':{
                            newName = tmpNewName;
                            break;
                        }
                    }
                    
                    
                }
            }
           
            $.each(files,function(index,item){
                if(item.uuid == fileUUID){
                    if(item.type == 'path'){
                        //remove alguns caracteres não aceitos
                        item.name = newName.replace(/[\/\\'"]/g,'');
                        var arrItemPaths = item.path.split('/');
                        arrItemPaths.pop();
                        arrItemPaths.push(newName);
                        item.path = arrItemPaths.join('/');
                        
                        if(item.files != undefined && item.files.length){
                            item.files = plugin.renamePathTree(item.path,item.files);
                        }   
                    }
                    else{
                        var arrNewName = newName.split('.');
                        item.type = arrNewName.pop();
                        item.name = arrNewName.join('.');
                    }
                }
            });
            
            plugin.setFiles(files,path);
            return newName;
            //plugin.reload();
        }
        
        this.renamePathTree = function(parentPath,files){
            var plugin = this;
            
            $.each(files,function(index,item){
                if(item.type=='path'){
                    item.path = parentPath+'/'+item.name;
                    
                    if(item.files != undefined && item.files.length){
                        plugin.renamePathTree(item.path,item.files);
                    }
                }
            });
            
            return files;
        }
        
        this.getIcon= function(file){
            var fontFamily = 'fiv-viv';
            var fileType = file.type;
            switch(fileType){
                case 'path':{
                    fontFamily = 'fiv-ext';
                    fileType = 'folder'; 
                    break;
                }
            }
            if(plugin.options.fileTypes.indexOf(fileType)<0){
                fileType = 'blank';
            }
            var icon = $('<i />').addClass(fontFamily).addClass('fiv-icon-'+fileType);
            return icon;            
        }
        
        this.getFiles = function(path){
            
            var plugin = this;
            var container = plugin.container;
            
            if(plugin.options.files == undefined){
                plugin.options.files = window['ged_files_'+container.attr('id')];
                               
                var formatFiles = function(files,formatPath){
                    
                    $.each(files,function(index,item){
                        if(item.files != undefined && Object.keys(item.files).length){
                            var itemPath = formatPath +'/'+item.name;   
                            plugin.getFiles(itemPath);
                            formatFiles(item.files,itemPath);
                        } 
                    });
                }
                formatFiles(plugin.options.files,'');
            }
            
            var files = $.extend(plugin.options.files,{});
            var arrPaths = path==undefined ? plugin.options.path.split('/') : path.split('/');
            
            var addressPath = '';
            
            if(arrPaths.length>1){
                $.each(arrPaths,function(index,item){
                    
                    $.each(files,function(indexFile,itemFile){
                        if(item && itemFile.name==item && itemFile.type=='path'){
                            if(itemFile.files == undefined){
                                itemFile.files = $.extend({},{});
                            }
                            files = itemFile.files
                            addressPath += '/'+itemFile.name;
                        }
                    }); 
                });
            }
                      
            
            var arrFiles = [];
            
            $.each(files,function(index,item){   
                
                itemDate = new moment(new Date(item.date)).locale('pt-BR')
                
                if((item.ged_formatted != undefined && item.ged_formatted) || itemDate.format() == 'Invalid date'){
                    return;
                }
                
                if(item.type=='path' && arrPaths.length){
                    item.path = addressPath+'/'+item.name;
                }
                else{
                    item.path = '';
                }
                
                item.date = itemDate.format('DD/MM/YYYY HH:mm');

                item.size = filesize(item.size);
                
                item.uuid = (item.uuid==undefined || !item.uuid) ? uuidv4() : item.uuid; 
                
                item.ged_formatted = true;               
            });
            
            return Object.values(files);
            
        }   
                
        this.getPath = function(){
            var plugin = this;
            return plugin.options.path;
        }
        
        this.moveFile = async function(fileUUID,fromPath,toPath,method){
            
            plugin = this;
            
            var files = plugin.getFiles(fromPath);
            var file = {};
            
            $.each(files,function(index,item){
                if(item!= undefined && item.uuid==fileUUID){
                    file = item;  
                } 
            });
            
            if(Object.keys(file).length==0){
                return false;
            }
            
            
            await plugin.removeFile(fileUUID);
            
            addFile = await plugin.addFile(file,toPath,true,method)
            
            if(file.type != undefined && file.type == 'path'){
                file.path = toPath + '/' + file.name;    
            }
            
            
            if(!addFile){
                await plugin.addFile(file,fromPath,false);
                plugin.reload();
            }
            
            var setChildren = function(file,toPath){
                
                if(file['files'] != undefined && typeof file['files'] == 'object'){
                    file['files'] = Object.values(file['files']);     
                }
                
                file['path'] = toPath;
                
                if(file['files'] != undefined && file['files'].length){ 
                    $.each(file['files'],function(index,item){
                        if(item['type'] == 'path'){
                            item = setChildren(item,file['path']+ '/' + item['name']);
                        } 
                    });
                }
                
                return file;
            }
            
            var pluginFiles = plugin.getFiles('');
            $.each(pluginFiles, function(index,item){
                if(item.type=='path'){
                    item = setChildren(item,'/'+item.name);
                }    
            })
            
            plugin.setFiles(pluginFiles,'');
            return true;
        }
        
        this.removeFile = function(fileUUID){
            
            var plugin = this;
            
            var files = $.extend({},plugin.getFiles(''));
            
            var setFilesFunction = function(files){
                
                $.each(files,function(index,item){
                    if(item != undefined && item.uuid == fileUUID){
                        delete files[index];
                    }
                    else if(item.files != undefined && Object.keys(files).length){
                        item.files = setFilesFunction($.extend({},item.files));
                    }
                });
                
                return files;
            }
            
            files = setFilesFunction(files);
            
            plugin.setFiles(files,'');
            
            return fileUUID; 
        };
        
        this.setBreadcrumb = function(){
            
            var plugin = this;
            var container = plugin.container;
            var breadcrumb = container.find('ol.ged-breacrumb');
            
            var path = plugin.getPath();
            var arrPaths = path.split('/');
            
            breadcrumb.find('li').remove();
            
            var itemPath = '';
            $.each(arrPaths,function(index,item){
                
                var li = $('<li/>').addClass('breadcrumb-item');
                var a = $('<a/>');
                
                if(index==0){
                    a.attr('href','#').html('<i class="fa fa-home"></i>');
                }
                else{
                    itemPath += '/'+item;
                    a.attr('href',itemPath).text(item);
                }
                
                li.append(a);                
                breadcrumb.append(li);
            });
            
            breadcrumb.find('li.breadcrumb-item').children('a').off().bind('click',function(e){
                var href = $(this).attr('href');
                href = href == '#' ?  '' : href;
                plugin.setPath(href);
                return false;
            });
        }
        
        this.setPath = function(path){
            
            var plugin = this;
            
            plugin.options.path = path;
            
            plugin.setBreadcrumb();
            plugin['showAs_'+plugin.options.show_as+'_setFiles']();
        }
        
        this.setFiles = function(files,path,_return){
            
            var plugin = this;
            path = (path == undefined) ? '' : path;
            
            if(path==''){
                plugin.options.files = files;
                return true;
            }          
                     
            var arrPaths = path.split('/').reverse();
            var thisPath = arrPaths.pop();
            
            var searchPaths = path.split('/');
            
            var setFiles = files;
            
            $.each(arrPaths,function(index,item){
                
                var itemFiles = $.extend({},plugin.getFiles(searchPaths.join('/')));
                
                $.each(itemFiles,function(fileIndex,fileItem){
                    if(fileItem.type=='path' && fileItem.name == thisPath){
                        fileItem.files = setFiles;
                        setFiles = itemFiles;
                    }  
                });
                
                thisPath = searchPaths.pop();
            });
            
             
            var itemFiles = plugin.getFiles('');
            
            $.each(itemFiles,function(fileIndex,fileItem){
                if(fileItem.type=='path' && fileItem.name == thisPath){
                    fileItem.files = setFiles;
                }  
            });
            
            plugin.options.files = itemFiles;
        }
        
        this.setRenameInput = function(object){
            
            object.find('.file-name').attr('data-last-name',object.find('.file-name').text());
            
            var tmpName = object.data('name');
            if(object.data('type')!='path'){
                tmpName += '.'+object.data('type');
            }
                           
            var inputRename = $('<input type="text" class="ged-path-rename input-sm form-control height-10 size-11" value="'+tmpName+'"/>')
            
            if(object.find('.file-name').eq(0).hasClass('file-name-box')){
                inputRename.addClass('text-centered');
            }
            else{
                inputRename.addClass('margin-top-2').addClass('padding-left-2').addClass('padding-right-2')
            }
            
            
            object.find('.file-name').text('').append(inputRename);
            
            if(object.attr('data-type')=='path'){
                object.find('.file-name').find('input.ged-path-rename').selectRange(0, inputRename.val().length);    
            }
            else{
                object.find('.file-name').find('input.ged-path-rename').selectRange(0, inputRename.val().lastIndexOf('.'));
                
            }
                        
            object.find('.file-name').find('input.ged-path-rename').blur(async function(){
                var newName = $(this).val();// ? $(this).val() : object.find('.file-name').attr('data-last-name');
                
                if(!newName){
                    _errorMessage('Nome de arquivo inválido');
                    object.find('.file-name').text(object.find('.file-name').attr('data-last-name'));
                    return;
                }
                
                var newName = await plugin.fileRename(object.attr('data-uuid'),newName);
                object.find('.file-name').text(newName);
                plugin.reload();                   
            });
            
            object.find('.file-name').find('input.ged-path-rename').keydown(function(e){
                if (e.keyCode === 13) {
                    $(this).blur();
                }
            });
            
        }
        
        this.setToolBar = function(){
            
            var plugin = this;
            var container = plugin.container;
            var filesBody = container.find('div.ged-files-body').eq(0);
            var toolbar = container.find('div.ged-toolbar'); 
            var sortMenu = plugin.container.find('.ged-sort-menu-button').closest('div.btn-group');
            var buttonMenu = sortMenu.children('.ged-sort-menu-button');
            var menuItems = sortMenu.children('ul').children('li').children('button.dropdown-item');
            
            
            menuItems.off().bind('click',function(){
                
                if(plugin.options.sort != undefined && plugin.options.sort.column == $(this).data('sortColumn')){
                    plugin.setSort({
                       'column' :   $(this).data('sortColumn'),
                       'dir'    :   (plugin.options.sort.dir=='asc' ? 'desc' : 'asc'), 
                    });                    
                }
                else{
                    plugin.setSort({
                       'column' :   $(this).data('sortColumn'),
                       'dir'    :   'asc', 
                    });           
                }
                
                plugin.reload();
                
            });
            
            toolbar.find('button.ged-new-folder').bind('click',async function(e){
                
                var parent = $(this);
                
                var folderUUID = uuidv4();
                var folderName = parent.data('name');
                
                var flagNewName = false;
                var newNameCount = 0;
                while(!flagNewName){
                    
                    flagNewName = true;
                    var files = plugin.getFiles();
                    $.each(files,function(index,item){
                        if(item.name == folderName){
                            flagNewName = false;
                            newNameCount++;
                            folderName = parent.data('name') + '(' + newNameCount + ')';
                        }
                    });    
                }
                
               await plugin.addFile({
                    'type'  :   'path',
                    'date'  :   new Date(),
                    'size'  :   0,
                    'name'  :   folderName,
                    'uuid'  :   folderUUID,
                });
                
                plugin.reload();
                plugin.setRenameInput(filesBody.find('[data-uuid="'+folderUUID+'"]').eq(0));
            });
        }
        
        this.sortFiles = function(key,dir,files,_return){
                     
            var plugin = this;
            var sortMenu = plugin.container.find('.ged-sort-menu-button').closest('div.btn-group');
            var menuItems = sortMenu.children('ul').children('li').children('button.dropdown-item');

            var arrSortTypes = [];
            
            menuItems.each(function(index,item){
               arrSortTypes.push($(item).attr('data-sort-column')); 
            });
            arrSortTypes = arrSortTypes.reverse();
            
            var keySort = arrSortTypes.indexOf(plugin.options.sort.column);
            keySort = keySort <0 ? 0 : keySort;
            
            if(files == undefined){
                files = plugin.getFiles('');
            } 
            
            
            if(key==undefined || key == false){
                arrSortTypes.splice(keySort, 1);
                
                $.each(arrSortTypes,function(index,item){
                   files = plugin.sortFiles(item,'asc',files); 
                });
                
                if(typeof files   == 'object'){
                     var arrConvFiles = Object.values(files);
                    
                     files = arrConvFiles;              
                }
                files.sort(compareValues(plugin.options.sort.column,plugin.options.sort.dir));
                                
                var arrDirs = [];
                var arrFiles = [];
                $.each(files,function(index,item){
                    
                    
                    if(item.files != undefined){
                        item.files = plugin.sortFiles(false,false,item.files,true);   
                    }
                    
                    //pastas primeiro
                    if(item.type=='path'){
                        arrDirs.push(item);
                    }
                    else{
                       arrFiles.push(item) 
                    }
                });
                
                if(_return!=undefined && _return == true){
                    return arrDirs.concat(arrFiles);
                }
                else{
                    plugin.setFiles(arrDirs.concat(arrFiles));    
                }
                
            }
            else if(files.length){
                files.sort(compareValues(key,'asc'));    
            }
            return files;
        }
        
        this.setSort = function(options){
            
            var plugin = this;
            var sortMenu = plugin.container.find('.ged-sort-menu-button').closest('div.btn-group');
            var buttonMenu = sortMenu.children('.ged-sort-menu-button');
            var menuItems = sortMenu.children('ul').children('li').children('button.dropdown-item');
            
            if(options!=undefined && options){
                plugin.options.sort = options;
            }
            
            
            var textSortButton = '';
            menuItems.find('i.icon_left').removeClass(plugin.options.icons.sort.asc).removeClass(plugin.options.icons.sort.desc);
            menuItems.each(function(index,item){
                
                var iLeftIcon = $(this).find('i.icon_left');
                
                if(!iLeftIcon.hasClass(plugin.options.icons.font)){
                    iLeftIcon.addClass(plugin.options.icons.font)
                }
                
                iLeftIcon.removeClass(plugin.options.icons.sort.desc).removeClass(plugin.options.icons.sort.asc);
                
                if($(item).attr('data-sort-column') == plugin.options.sort.column){
                    textSortButton = $(item).find('.xn-text').text();
                    iLeftIcon.addClass(plugin.options.icons.sort[plugin.options.sort.dir])
                }
                
                 
            });

            buttonMenu.children('.sort-title').html('<i class="icon_left '+plugin.options.icons.font+' '+plugin.options.icons.sort[plugin.options.sort.dir]+'"></i>&nbsp;<span class="xn-text">'+textSortButton+'</span>');
                       
        }
        
        this.setContextMenu = function(){
            
            var plugin = this;
            var container = plugin.container;
            var filesBody = container.find('div.ged-files-body').eq(0);
            
            var files = plugin.getFiles('');
            var parentFiles = files;
            var flagFiles = false;
            var moveOptions = {'_':'Home'};
            var lvl = 1;
            var strgTree = '&nbsp;&nbsp;&nbsp';
            
            $.contextMenu('destroy');
            
            var getOptionsFunction = function(files,lvl,moveOptions){
                var options = {};
                
                $.each(files,function(index,item){
                    if(item.type=='path'){
                        options[item.path] = strgTree.repeat(lvl)+item.name.trunc(25);
                        if(item.files != undefined && Object.keys(item.files).length){
                            options = $.extend(options,getOptionsFunction(item.files,(lvl+1),moveOptions));
                        }
                    } 
                    
                }); 
                return options;   
            }
            moveOptions = $.extend(moveOptions,getOptionsFunction(files,lvl,moveOptions));
            
            var moveFunction = async function(_select,options){
                
                var _t = $(options.data.$trigger);               
                
                var toPath = _select.val()=='_' ? '' : _select.val();
                var arrToPath = toPath.split('/');
                if(toPath == plugin.getPath()){
                    options.data.$menu.trigger('contextmenu:hide');
                    return false;
                }
                
                toPath = _select.val()=='_' ? '' : _select.val();
                                
                var allActive = filesBody.find('div.bsgrid-row-selected,div.ged-box-file.active');
                window['ged_file_action'] = false;
                
                options.data.$menu.trigger('contextmenu:hide');
                
                var moveFilesFunciton = async function(){
                    await plugin.moveFile(_t.data('uuid'),plugin.getPath(),toPath);
                    plugin.reload();
                    
                    allActive.each(async function(index,item){
                        
                        if(($(item).data('sortable')!= undefined && !$(item).data('sortable'))){
                            return;
                        }
                        
                        await plugin.moveFile($(item).data('uuid'),plugin.getPath(),toPath);
                        plugin.reload();
                    }); 
                       
                }
                
                await moveFilesFunciton();    
            }
            
            
            //paths
            var pathItems = {
                "open"      :   {name: "Abrir", icon: "fa-folder-open"},
                "rename"    :   {name: "Renomear", icon: "fa-pencil-square-o"},
                "move"      :   {
                    name    :   "Mover para",
                    icon    :   "fa-exchange",
                    items   :   {
                        "moveTo":   {
                            type        :   'select', 
                            options     :   moveOptions,
                            events      :   {
                                change : async function(options){  
                                    await moveFunction($(this),options);
                                    plugin.reload();
                               }
                            }
                        },
                    }
                },
            };
                        
            $.contextMenu({
                selector: '#'+container.attr('id')+' div.ged-box-file[data-type="path"][data-contextmenu!="false"],'+'#'+container.attr('id')+' div.bsgrid-content-row[data-type="path"][data-contextmenu!="false"]', 
                items: pathItems,
                callback: function(key,options) {
                    var parent = options.$trigger;
                     
                    switch(key){
                        case 'open':{
                            parent.trigger('dblclick');
                            break;
                        }
                        case 'rename':{
                            plugin.setRenameInput(parent);
                            break;
                        } 
                    }
                }
            });            
            //fim paths
            
            //files
            var fileItems = {
                //"open"      :   {name: "Abrir", icon: "fa-folder-open"},
                "rename"    :   {name: "Renomear", icon: "fa-pencil-square-o"},
                "move"      :   {
                    name    :   "Mover para",
                    icon    :   "fa-exchange",
                    items   :   {
                        "moveTo":   {
                            type        :   'select', 
                            options     :   moveOptions,
                            events      :   {
                                change : function(options){  
                                    moveFunction($(this),options);
                               }
                            }
                        },
                    }
                },
                'uuid'      :   {}
                    
                }
            $.contextMenu({
                selector    :   '#'+container.attr('id')+' div.ged-box-file[data-type!="path"][data-contextmenu!="false"],'+'#'+container.attr('id')+' div.bsgrid-content-row[data-type!="path"][data-contextmenu!="false"]', 
                items       :   fileItems,
                callback    :   function(key, options,item) {
                    var parent = options.$trigger;
                     
                    switch(key){
                        case 'open':{
                            parent.trigger('dblclick');
                            break;
                        }
                        case 'rename':{
                            plugin.setRenameInput(parent);
                            break;
                        } 
                    }
                },
                build: function($triggerElement, e){
                    console.log($($triggerElement).data('uuid'));
                }
            });
            //fim files
           
        }
        
        this.reload = function(){
            var plugin = this;
            plugin.sortFiles();
            plugin['showAs_'+plugin.options.show_as+'_setFiles'](); 
            plugin.setContextMenu();         
        }
        
        $.extend(this,gedExtensions);
        
        container.LoadingOverlay('show',{
            'image'     :   BASE_URL+'assets/img/wheel.gif',
            'size'      :   6,
            'fade'      :   400,
            'zIndex'    :   container.css('zindex')+100,
            
        });
        
        $.when(
            $.getJSON(BASE_URL+'assets/plugins/file-icon/icons/vivid/catalog.json', function( data ) {
                plugin.options.fileTypes = data;
            })
        )
        .done(function(response){
            
            plugin.setBreadcrumb()
            plugin.sortFiles(); 
            plugin.setToolBar();
            plugin.setShowAs();
            plugin.setSort();
            plugin.options.initialized = true;
            container.LoadingOverlay('hide');    
        });
        
    }
    
    
    $.fn.ged_app = function(options){
        
        pluginName = 'ged_app';
        var response = '';
        
        $(this).each(function () {
            
            if (!$.data(this, 'plugin_' + pluginName+'_')) {
                $.data(this, 'plugin_' + pluginName+'_',true);
                
                $.data(this, 'plugin_' + pluginName,
                new ged_app($(this),options));
            }
            else if ($.data(this, 'plugin_' + pluginName)){
                
                response =  $.data(this, 'plugin_' + pluginName).changeMethod($(this),options);
            }
        });
        
        return response; 
        
    };
})(jQuery);


function filesize(size,type){
    
    var i;
    i = Math.floor(Math.log(size) / Math.log(1024));
    if ((size === 0) || (parseInt(size) === 0)) {
      return "0 kB";
    } else if (isNaN(i) || (!isFinite(size)) || (size === Number.POSITIVE_INFINITY) || (size === Number.NEGATIVE_INFINITY) || (size == null) || (size < 0)) {
      return '';
    } else {
      if (type== undefined || type=='abrev') {
        return (size / Math.pow(1024, i)).toFixed(2) * 1 + " " + ["B", "kB", "MB", "GB", "TB", "PB"][i];
      } else {
        return (size / Math.pow(1024, i)).toFixed(2) * 1 + " " + ["bytes", "kilobytes", "megabytes", "gigabytes", "terabytes", "petabytes"][i];
      }
    }
    
    
}