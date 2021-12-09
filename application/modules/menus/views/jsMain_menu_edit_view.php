<?php

/**
 * @author Tony Frezza

 */



?>
    
    var moduloSelected = $('#moduloMenu').val();
    
    
    $('button.btn-select-modulo').bind('click',async function(e){
        

        if(moduloSelected == $('#moduloMenu').val()){
            //_infoMessage('Módulo atualmente selecionado.')
            //return false;
        }
        
        moduloSelected = $('#moduloMenu').val();
        
        await loadScript(plugin_path+'jquery-menu-editor/jquery-menu-editor.js',function(e){
            initMainMenuEditor(moduloSelected);    
        });
        
    });
    
    $('#controller').bind('change',function(e){
        var _t = $(this);
                
        if(_t.find(":selected").val() == '' || $('#href').val() != ''){
            return false;
        }
        
        
        
        var strUrl = ($('#tipo_controller').find(":selected").attr('data-return-uri-value') ? $('#tipo_controller').find(":selected").attr('data-return-uri-value') : '');
        
        strUrl += (strUrl ? '/' : '') + ($('#controller').find(":selected").attr('data-return-url-value') ? $('#controller').find(":selected").attr('data-return-url-value') : '')
        
        strUrl = '{BASE_URL}'+strUrl;
        
        $('#href').val(strUrl);  
        
        
    });
    
    loadScript(plugin_path+'jquery-menu-editor/jquery-menu-editor.js',function(e){
        initMainMenuEditor(moduloSelected);    
    });                 
    


function initMainMenuEditor(moduloId){
    
    _loadAjax({
        'url'       :   BASE_URL+'menus/main-menu/getitems',
        'method'    :   'POST',
        'data'      :   {
            'token'     :   '<?php echo $token??NULL;?>',
            'modulo'    :   moduloId,
            
        },
        'onDone'        :   function(response){
            
            // menu items
            arrayjson = response.menu_data
            
            if($('.menu-editor').attr('menu-initialized') != 'true'){
                $('.menu-editor').attr('menu-initialized','true');
                
                // sortable list options
                var sortableListOptions = {
                    placeholderCss: {'background-color': "#cccccc"}
                };
                
                editor = new MenuEditor('myEditor', {
                    listOptions: sortableListOptions,
                    textConfirmDelete: 'Confirma a exclusão do nó?'
                });
                editor.setForm($('#YINFWOQRVzUo'));
                editor.setUpdateButton($('#btnUpdate'));
                
                $("#btnUpdate").off().click(function(){
                    editor.update();
                });
                
                $('#btnAdd').off().click(function(){
                    editor.add();
                });
            }

            editor.setData(arrayjson);
            
            $('button.btn-save-menu').off().bind('click',function(e){
                var str = editor.getString();
                saveMainMenu(str);
            });
        }
    });    
}

function saveMainMenu(str){
    
    _loadAjax({
        'url'       :   BASE_URL+'menus/main-menu/save',
        'method'    :   'POST',
        'data'      :   {
            'menu'      :   str,
            'modulo'    :   moduloSelected,
            'token'     :   '<?php echo $token??NULL;?>',
        },
        'onDone'    :   function(response){
            showMessage('success');
            $('.console').console({
                'log' : response.console
            });
        }
    });
    
    
}
