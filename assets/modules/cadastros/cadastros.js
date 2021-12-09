      
    function _cadastros_clone(options){
        
        var modal = $("#modal-template").clone();
        modal.find('div.modal-dialog').removeClass('modal-lg');
        modal.find('div.modal-dialog').css('width','460px');
        modal.find('div.modal-header .pull-left').html('<span class=""><i class="fa fa-copy"></i> Confirmar cópia</span>');
        modal.find('div.modal-footer .btn-cancel').html('<i class="fa fa-times"></i> Cancelar')
        modal.find('div.modal-footer').prepend('<button class="btn btn-secondary btn-3d btn-sm btn-confirm" >&nbsp;<i class="fa fa-copy"></i>&nbsp;&nbsp;Sim&nbsp;&nbsp;</button>')
        modal.find('div.modal-body').removeClass('bg-gray').html('<div class="padding-10 size-12 text-centered">A cópia de um item não inclui os relacionamentos do cadastro selecionado. <br />Após a importação de dados, você deverá salvar o novo item.<br /> Você confira esta ação?</div>');
        modal.modal();
        
        modal.find('button.btn-confirm').bind('click',function(){
            modal.modal('hide');
            
            if(options.before != undefined){
                options.before();
            }
            
            _cadastros_editItem(options)
        }); 
    }
    
    
    function _cadastros_deleteItem(options){
        
        var modal = $("#modal-template").clone();
        modal.find('div.modal-dialog').removeClass('modal-lg');
        modal.find('div.modal-header .pull-left').html('<span class=""><i class="fa fa-exclamation-triangle"></i> Confirmar exclusão</span>');
        modal.find('div.modal-footer .btn-cancel').html('<i class="fa fa-times"></i> Cancelar')
        modal.find('div.modal-footer').prepend('<button class="btn btn-secondary btn-3d btn-sm btn-confirm" >&nbsp;<i class="fa fa-trash"></i>&nbsp;&nbsp;Sim&nbsp;&nbsp;</button>')
        modal.find('div.modal-body').removeClass('bg-gray').html('<div class="padding-10 size-12">Excluir itens os deixará indisponíveis para uso futuro. Você confirma esta ação?</div>');
        modal.modal();
        
        modal.find('button.btn-confirm').bind('click',function(){
            modal.modal('hide');
            
            _loadAjax({
                'url'           :   options.url,
                'data'          :   options.data,
                'method'        :   'POST',
                'onDone'        :   function(response){
                    $('.console').console({
                        'log' : response.console
                    });
                    if(options.onDone){
                        options.onDone(response);
                    }
                },
                'onFail'        :   function(response){
                    $('.console').console({
                        'log' : response.console
                    });
                }    
            });    
        });
    }
    
    function _cadastros_editItem(options){
        
        var modal = $("#modal-template").clone();
        
        var options = $.extend(options,{
                'method'    :   'POST',
                'container' :   modal,
                'done'      :   function(container){
                    if(options.bsgrid != undefined && options.bsgrid.length){
                        window.cadastros_bsgridItems = options.bsgrid;
                    }   
                }
            },
        );
            
        _loadModal(options);
    }
       
    function _cadastros_init(options){
        
        var actionMenuContainer = options.container!=undefined ? options.container.find('div.cadastro-actionmenu') : $('div.cadastro-actionmenu');
        actionMenuContainer.find('.need_selected_items').prop('disabled', true);
        
        //BOTAO EDITAR
        actionMenuContainer.find('button.editar-cadastro').off().bind('click',function(e){
            e.preventDefault();
            
            _cadastros_editItem(
                $.extend(options,
                    {
                        'url'       :   $(this).attr('href'),
                    }
            ));
            
        });
        //FIM BOTAO EDITAR
        
        
        //BOTAO REMOVER
        actionMenuContainer.find('button.excluir-cadastro').off().bind('click',function(e){
            e.preventDefault();
            
            var bsGrid = $('div.grid-items-cadastro').eq(0);
            var btn = $(this);
            var arrPk = [];
            
            $.each(bsGrid.bsgrid({'method':'getSelectedRows'}),function(index,item){
               arrPk.push($(item).data('pk-value'))
            });
            
            if(arrPk.length<=0){
                return false;
            }
            
            var url = btn.attr('href').split('?')[0];
            var tmpUrl = url.split('/');
            if(tmpUrl[tmpUrl.length-1] != 'delete'){
               url+'/delete'
            }
            _cadastros_deleteItem({
                'url'       :   url,
                'data'      :   {
                    'pk'    :   arrPk,
                    'token' :   btn.data('token'),
                },
                'onDone'    :   function(response){
                    
                    if(options.bsgrid.length){
                       $.each(options.bsgrid,function(index,item){
                            //var bsGrid = $('div.grid-items-cadastro');
                            var bsGrid = item;
                            
                            bsGrid.bsgrid({
                                'method'                :   'reload',
                                'preserv_selected_rows' :   false,
                            });    
                       }); 
                    }
                }
            });
            
            
        });
        //FIM BOTAO REMOVER
        
        //BOTAO CLONE
        actionMenuContainer.find('button.clone-cadastro').off().bind('click',function(e){
           
            e.preventDefault();
            
            var bsGrid = $('div.grid-items-cadastro').eq(0);
            var btn = $(this);
            var url = $(bsGrid.bsgrid({'method':'getSelectedRows'})[0]).attr('href');
            
            if(url=='' || url=='undefined'){
                return false;
            }
            
            _cadastros_clone({
                'url'       :   url,
                'data'      :   {
                    'clone' :   1
                }
            });
            
        });
        //FIM BOTAO CLONE
        
    }
   
    function _cadastros_initItem(options){
        
        var container = options.container;
        
        var actionMenuItem = container.find('div.cadastro-item-actionmenu').eq(0);
        var containerItem = container.find('div.cadastro-item-content').eq(0);
        var tabPanes = containerItem.find('div.tab-pane');
        var otherElementsHeight = parseInt(100);
       
         
        container.find('.bsform').bsform();
        
        if(container.find('input.cadastro_item_pk').eq(0).val()==''){
            container.find('a.need-item,button.need-item').attr('disabled',true);
        }
        else{
            container.find('a.need-item,button.need-item').attr('disabled',false);
        }
        
        
        var reloadBsGrid = function(){
                     
            var flagReload = false;
            var bsGridArray = [];
            
            bsGridArray =bsGridArray.concat( (options.bsgrid != undefined && options.bsgrid.length) ? options.bsgrid : []);
            bsGridArray =bsGridArray.concat( (window.cadastros_bsgridItems != undefined && window.cadastros_bsgridItems.length) ? window.cadastros_bsgridItems : []);
            
            if(bsGridArray.length){
                $.each(bsGridArray,function(index,item){
                    
                    //var bsGrid = $('div.grid-items-cadastro');
                    var bsGrid = item;
                    
                    bsGrid.bsgrid({
                        'method'                :   'reload',
                        'preserv_selected_rows' :   false,
                    });    
               }); 
            }            
            else{
                var bsGrid = $('div.grid-items-cadastro').eq(0);
                 bsGrid.bsgrid({
                    'method'                :   'reload',
                    'preserv_selected_rows' :   false,
                }); 
            }         
            
        }
        
        //BTN SAVE
        container.find('a.cadastro-save-item,button.cadastro-save-item').off().bind('click',function(e){
             
             var body = container.find('div.modal-body').eq(0);
             var btn = $(this);
             var bsGridItems = options.bsgrid;
             
             _cadastros_saveCadastro({
                'container' :   container,
                'token'     :   body.find('input.token').val(),
                'url_save'  :   btn.attr('href') ? btn.attr('href') : body.find('input.url_save').val(),
                'doneSave'  :   function(response,options){
                    
                    //reload do grid, se houve alteração
                    reloadBsGrid()
                    
                    $('.console').console({
                        'log' : response.console,
                    });
                },
             });  
        });
        
        //BTN SAVE-CLOSE
        container.find('a.cadastro-save-item-close,button.cadastro-save-item-close').off().bind('click',function(e){
             
             var body = container.find('div.modal-body').eq(0);
             var btn = $(this);
             var bsGridItems = options.bsgrid;
             
             _cadastros_saveCadastro({
                'container' :   container,
                'token'     :   body.find('input.token').val(),
                'url_save'  :   btn.attr('href') ? btn.attr('href') : body.find('input.url_save').val(),
                'doneSave'  :   function(response,options){
                    
                    //reload do grid, se houve alteração
                    if(response.status=='ok'){
                        
                        //reload do grid, se houve alteração
                        reloadBsGrid()
                    }
                    $('.console').console({
                        'log' : response.console
                    });
                    
                    var modal = body.closest('div.modal');
                    modal.modal('hide');
                    
                },
             });  
        });
        
        
        //BTN NOVO ITEM
        container.find('a.cadastro-novo-item,button.cadastro-novo-item,a.editar-cadastro,button.editar-cadastro').off().bind('click',function(e){
             
             e.preventDefault();
             
             container.modal('hide');
             options.url = $(this).attr('href');
             
             _cadastros_editItem(options);
        });
        
        //BTN EXCLUIR ITEM
        container.find('a.cadastro-excluir-item,button.cadastro-excluir-item').off().bind('click',function(e){
            itemPk = parseInt(container.find('input.cadastro_item_pk').val());
            if(itemPk=='' || itemPk=='undefined'){
                return false;
            }
            
            var btn = $(this);
            
            var url = btn.attr('href').split('?')[0];
            var tmpUrl = url.split('/');
            if(tmpUrl[tmpUrl.length-1] != 'delete'){
               url+'/delete'
            }
            
            _cadastros_deleteItem({
                'url'       :   url,
                'data'      :   {
                    'pk'    :   [itemPk],
                    'token' :   btn.data('token')
                },
                'onDone'    :   function(response){
                    container.modal('hide');
                }
            });
        });
        
        //BTN CLONE ITEM
        container.find('a.cadastro-clone-item,button.cadastro-clone-item').off().bind('click',function(e){
            
            itemPk = parseInt(container.find('input.cadastro_item_pk').val());
            if(itemPk=='' || itemPk=='undefined'){
                return false;
            }
            
            response = _cadastros_clone({
                'url'   :   $(this).attr('href').split('?')[0]+'/id/'+itemPk,
                'data'  :   {
                    'clone' :   1,
                },
                'before':   function(response){
                    container.modal('hide');
                }
            });
            
            
        });
        
    }
    
    
    function _cadastros_onToggleGridRow(selectedRows){
        
        var actionMenuContainer = $('div.cadastro-actionmenu');
        
        if(selectedRows.length){
            actionMenuContainer.find('.need_selected_items:disabled').prop('disabled', false); 
        }
        else{
            actionMenuContainer.find('.need_selected_items').prop('disabled', true); 
        }
        
        if(selectedRows.length>1){
            actionMenuContainer.find('.need_selected_items.unique_selected_item').prop('disabled', true); 
        }
        
    }
    
    function _cadastros_saveCadastro(options){
        
        loading('show');
        var body = options.container.find('div.modal-body').eq(0);
        var inputControll = body.find('input.container-cadastro').eq(0);
        
        var dataValues = {};
        
        $.each(body.find('div.bsform:not(.no-save)'),function(index,item){
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
            pk_item         :   body.find('input.cadastro_item_pk').eq(0).val(),
            values          :   dataValues,
            ajax            :   1,
            token           :   options.token,
        };
                
        $.when(
            $.ajax({
                url:        options.url_save,
                type:       'POST',
                data:       data,
                dataType:   'json',
            })            
        )
        .done(function(response){
            
            loading('hide');
            
            $.each(body.find('div.bsform'),function(index,item){
                var _form = $(item);
                _form.bsform({'method':'removeInputsWarnings'})
            });
            
            if(response.status=='ok' || response.status=='success'){
                body.find('input.cadastro_item_pk').val(response.id);
                body.find('input#id_item').val(response.id);
                body.find('input.token').val(response.token);
                
                if(response.messages == undefined || response.messages.length<=0){
                    _successMessage();
                       
                }
                
                
                if(options.doneSave != undefined){
                    options.doneSave(response,options);
                } 
                
                inputControll.trigger('onSave_ok',[response]);
                _cadastros_initItem(options) 
            }
            
            if(response.status=='info'){
                if(response.messages == undefined || response.messages.length<=0){
                    _infoMessage();
                }
                
                _cadastros_initItem(options);
                if(options.doneSave != undefined){
                    options.doneSave(response,options);
                }  
                inputControll.trigger('onSave_info',[response]); 
            }
            
            if(response.status=='error'){
                
                if(response.messages == undefined || response.messages.length<=0){
                    
                    _errorMessage(); 
                       
                }
                
                if(options.errorSave != undefined){
                    options.errorSave(response,[response]);
                }
                
                if(response.errors != undefined){
                     $.each(body.find('div.bsform'),function(index,item){
                        var _form = $(item);
                        _form.bsform({'method':'setInputsError','errors':response.errors })
                    });   
                }
                
                $('.console').console({
                    'log' : response.console
                });     
            }
            
            if(response.messages != undefined && response.messages.length>0){
                
                $.each(response.messages,function(index){
                    var _t = $(this);
                          
                    if(typeof response.messages[index] == 'object'){
                        var type = response.messages[index].type;
                        showMessage(type,response.messages[index].message); 
                    }
                    else{
                        var type = response.messages[index]['type'];
                        showMessage(type,response.messages[index]['message']);
                    } 
                });
            }
            
        })
        .fail(function(response){
            loading('hide');
            console.log(data)
            console.log('fail')
            _errorMessage();
        });
        
    }