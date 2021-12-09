    
    var lastObj = false;
    var contents = $('main#contents');
    var mainmenu = $('div.navbar-mainmenu')
    var headerPage = $('div#header-page');
    var footer = $('footer.footer');
    var addressLoadsStarted = false;
    
    var runningAjax = false;
    
    jQuery(window).ready(function() {
        
        FirstInit();
    });
    
    $( document ).ajaxComplete(function() {
        //console.log($.now());
    });
    
    jQuery(window).resize(function() {
        
        loading('show');
        
        loading('hide');
        
    });
    
    $(document).ajaxComplete(function() {
        runningAjax = false;
    });
    
    
    function FirstInit() {  
        
                
        _setWindowScroll();
         
        $.each($('a.load-page,button.load-page'),function(index,item){
            if($(this).attr('_address_loaded') == undefined && $(this).attr('href')!= '#' && $(this).attr('href')+'/'!= BASE_URL){
                $(this).attr('_address_loaded',true);
                $(this).off().address();
            }
        });
        
        $.address.state(BASE_URL).change(function(event){
            
            if(addressLoadsStarted==false || $.address._elementActive == undefined){
                addressLoadsStarted = true;
               return false;  
            }
            
            var _t = $.address._elementActive.clone();
            _t.attr('href',BASE_URL+event.value.substring(1));
            
            if(isMobile()){
                $('.nav-collapse').collapse('hide');    
            }
            
            if(_t.attr('panel-id')==undefined){
                _t.attr('panel-id',randomstring(8));    
            }
           
            var container = $('#contents');
            _loadPage(_t,container);
            _t.closest('.active').removeClass('active');
            _t.dropdown("toggle");
            
            //return false;

        });
        
       
        Init();
                
    }
    
    function Init(){

        $('#collapse-navbar').find('li').removeClass('open');
        
        $.each($('#header-page').find('.load-page'),function(index,item){
            
            if($(this).attr('_address_loaded') == undefined  &&  $(this).attr('href')!= '#' && $(this).attr('href')+'/'!= BASE_URL){
                
                $(this).off().address();
                $(this).attr('_address_loaded',true);
            }
        });
        
        
        //EVITA DRAG DOS ELEMENTOS
        $('a,button').on('dragstart', function(event){ 
            event.preventDefault(); 
        });
        
        //PREVINE SELECAO POR DUPLO CLIQUE
        document.ondblclick = function(evt) {
            if (window.getSelection)
                window.getSelection().removeAllRanges();
            else if (document.selection)
                document.selection.empty();
        }
        
        
        $('a.load-modal,button.load-modal').off().bind('click',function(){
            
            var options = {
                'data'      :   {},
                'method'    :   'POST',
                'container' :   $("#modal-template").clone(),
                'url'       :   $(this).attr('href'),
                
            };
            if($(this).attr('href')!= '#'){
             
                if(isMobile()){
                    $('.nav-collapse').collapse('hide');    
                } 
                lastObj = $(this);
                
                $(this).each(function() {
                  $.each(this.attributes, function() {
                    if(this.specified) {
                        if(this.name.substr(0,15)=='data-form-post-'){
                            options.data[this.name.substr(15)] = this.value;         
                        }
                    }
                  });
                });
                
                _loadModal(options);  
                
                return false;   
            }
            
            return false;
            
        });
               
        
        $('input,select').on('blur', function(event) {
            event.stopPropagation();
            //$(this).parent('.form-group').removeClass('has-warning');
            //$input.not($(this)).parent().removeClass('scale');
        });
        
        $('input,select').on('focus', function(event) {
            event.stopPropagation();
            //$(this).parent('.form-group').addClass('has-warning');
            //$input.not($(this)).parent().removeClass('scale');
        });
        
        //uppercase em select > option
        $("select.uppercase option").each(function() {
            var _t = $(this);
            _t.text(_t.text().toUpperCase());            
        });
        
        _tabs();
        _accordion();
        _bsForm();
        _mask();
        _pickers();
        _popover();
        _select();
        _tabEnter();
        
        _summernote()
        _radio();
        _ged_app();
        loading('hide');
        
    }
    
    function _bsForm(){
        var _container = jQuery('div.bsform');  
    	if(_container.length > 0){
    	    
            _container.each(function() {
                if(_container.hasClass('no-auto-bsform')==false){
                    $(this).bsform();    
                }
            });
        }        
    }
    
    function _accordion(){
        
        var _container = jQuery('.accordion');
		
		if(_container.length > 0) {          			  
    		_container.each(function() {
				
                var _t 		= jQuery(this);
                
                if(_t.data('_accordion')!==undefined){
                    return true; 
                }
                else{
                    _t.data('_accordion',true);  
                }
                
                _t.cige_accordion({});
            });
        }
        
    }
    
    function _ged_app(){
        var _container = jQuery('div.ged-app');  
    	if(_container.length > 0){
    	    
            _container.each(function() {
                if(_container.hasClass('no-auto-ged_app')==false){
                    $(this).ged_app();    
                }
            });
        }        
    }
    
    function _mask(){
       
        var _container = jQuery('input[data-mask]');  
    	if(_container.length > 0) {
            _container.each(function() {   
                _t = $(this);
                
                //previne de aplicar novamente as propriedades
                if(_t.data('_mask')!==undefined){
                    return true; 
                }
                else{
                    _t.data('_mask',true);  
                }
                
                
                //EXCEPTIONS
                if(_t.data('mask')=='cpf_cnpj'){

                    _t.val(_t.val().match(/\d+/g) ? _t.val().match(/\d+/g).join('') : _t.val());
                    
                    _t.inputmask({
                      mask          : ['999.999.999-99', '99.999.999/9999-99'],
                      keepStatic    : true,
                      autoUnmask    : true,
                    });
                    return;
                } 
                else if(_t.data('mask')=='date'){
                    
                    _t.val(_t.val().match(/\d+/g) ? _t.val().match(/\d+/g).join('') : _t.val());
                    
                    _t.inputmask({
                      mask          : '99/99/9999',
                      keepStatic    : true,
                      autoUnmask    : false,
                    });
                    return;
                }
                //FIM EXCEPTIONS
                            
				_format 		= _t.attr('data-mask') || '',
				_placeholder 	= _t.attr('placeholder') 	|| '';
                
    			_t.inputmask(_format, 
                    {
                        placeholder:_placeholder,
                        //clearIfNotMatch: true,
                        'autoUnmask' : true
                    }
                );
    		});
    	}
        

        var _container = jQuery('input.uppercase');
        if(_container.length > 0) {
            _container.each(function(){
               var _t = jQuery(this);
               //previne de aplicar novamente as propriedades
                if(_t.data('_uppercase')!==undefined){
                    return true; 
                }
                else{
                    _t.data('_uppercase',true);  
                }
                
                _t.on('input', function(evt) {
                  var input = $(this);
                  var start = input[0].selectionStart;
                  $(this).val(function (_, val) {
                    return val.toUpperCase();
                  });
                  input[0].selectionStart = input[0].selectionEnd = start;
                });    
            });
        }
        
        var _container = jQuery('input.number');
    	if(_container.length > 0) {
    	   _container.each(function(){
	           var _t = jQuery(this);
               //previne de aplicar novamente as propriedades
                if(_t.data('_number')!==undefined){
                    return true; 
                }
                else{
                    _t.data('_number',true);  
                }
                
                _t.priceFormat({
                    prefix              : '',
                    centsSeparator      : ',',
                    thousandsSeparator  : '.',
                    clearOnEmpty        : true
                }); 
            });
        }
        
        var _container = jQuery('input.integer');
    	if(_container.length > 0) {
    	   _container.each(function(){
    	           
               var _t = jQuery(this);
               //previne de aplicar novamente as propriedades
                if(_t.data('_integer')!==undefined){
                    return true; 
                }
                else{
                    _t.data('_integer',true);  
                }
                
                _t.priceFormat({
                    prefix              : '',
                    centsSeparator      : '',
                    thousandsSeparator  : '',
                    centsLimit          : 0,
                    clearOnEmpty        : true
                });  
                
            });
        }
    }

    function _pickers() {
	   
		var _container = jQuery('input.date');
		
		if(_container.length > 0) {
                         			  
    		_container.each(function() {
				
                var _t 		= jQuery(this);
                
                if(_t.data('_datepicker')!==undefined){
                    return true; 
                }
                else{
                    _t.data('_datepicker',true);  
                }
                
                $.datetimepicker.setLocale('pt-BR');
                _t.datetimepicker({
                    'mask'          :   true,    
                    'timepicker'    :   false,
                    'format'        :   'd/m/Y',
                    'scrollInput'   :   false,
                    
                });
                
                _t.on('click',function(e){
                    //$(this).select();
                });
                _t.on('focus',function(e){
                    _t.selectRange(0);
                })
			});
        
		}


        
         /** Year Picker
		 ******************* **/
        

	}
    
    function _popover(){
        return;
        
        //$("body").tooltip({selector:'[data-toggle="tooltip"]',container:"body"});
//       
//        $("[data-toggle=popover]").popover({trigger: 'hover'});
        //$(".popover-dismiss").popover({trigger: 'focus'});
        
        
    }
    
    function _select(){
        
        _container = $('.chosen');
        
        
        if(_container.length > 0){
            
            _container.each(function(index){
                
                var _t = $(this);
                
                if(_t.data('chosen')!=undefined){
                    return false;
                }                
                _t.data('chosen',true);
                _t.attr('multiple',true);
                _t.chosen({
                    value:   'Algo',
                })              
                 
            });
        }
       
    }
    
    function _tabEnter(){
        
        _container = $('.tab-enter');
        
        
        if(_container.length > 0){
            
            _container.each(function(index){
                
                var _parent = $(this);
                
                if($(this).data('tabenter')!=undefined){
                    return false;
                }                
                $(this).data('tabenter',true);
                
                var strSearch = 'input[type=text]:not([readonly]),select:not([readonly]),input[type=password]:not([readonly])';
                
                _children = $(this).find(strSearch); 
                
                // Obter o número de elemento de entrada de texto em um documento html
                var tot_idx = _children.length;
                            
                _children.each(function(indexChild){
                    $(this).keydown(function(e) {
                        
                        // Entra na tecla no código ASCII
                        if (e.keyCode === 13 && $(this).hasClass('btn')!=true) {
                            
                            // Obter o próximo índice do elemento de entrada de texto
                            var next_idx = indexChild + 1;
 
                            if(e.shiftKey){
                                var next_idx = indexChild-1;
                            }
                            
                            e.preventDefault(e);
                            if (tot_idx === next_idx)
                                // Vá para o primeiro elemento de texto
                                _parent.find(strSearch).eq(0).focus();
                            else{
                                // Vá para o elemento de entrada de texto seguinte
                                _parent.find(strSearch).eq(next_idx).focus();
                            }
                                
                        }  
                    });
                });
            });
        }
        
    }
    
    function _summernote(){
        _container = $('textarea.summernote:not(.no_init)');
        if(_container.length > 0){
            _container.each(function(index){
                var _t = $(this);
                
                if(_t.attr('_summernote')!=undefined){    
                    return true;
                }                
                _t.attr('_summernote',true);
                
                _t.summernote({
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough',]],
                        ['color', ['color']],
                        ['para', ['ul', 'ol',]],
                    ],
                    disableResizeEditor: true,
                    lang:   'pt-BR',
                    height: _t.data('height') ? _t.data('height') : 178,
                });
            });
        }
    }
    function _tinymce(){
        
        _container = $('textarea.tinymce');
        tinymce.remove();
        if(_container.length > 0){
            _container.each(function(index){
                
                var _t = $(this);
                var _tClass = '_tinymce_'+randomstring(8);
                _t.addClass(_tClass);
                
                _t.attr('data-tinymce_get',tinymce.get().length);
                
                tinymce.init({
                    selector: 'textarea.'+_tClass,
                    height: _t.data('height') ? _t.data('height') : 250,
                    menubar: false,
                    plugins: [
                        
                    ],
                    theme:'modern',
                    skin: 'lightgray',
                    toolbar_items_size : 'small',
                    toolbar: 'undo redo | bold italic backcolor | removeformat | code',
                    statusbar: false,
                    language: 'pt_BR',
                    setup : function(ed)
                    {
                        ed.on('init', function() 
                        {
                            this.getDoc().body.style.fontSize = '13px';
                            this.getDoc().body.style.fontFamily = 'Tahoma';
                        });
                    },
                    
                }); 
                
            })
        }
    }
    
    function _radio(){
        
        
        
    }
    
    function _tabs(){
        
        $(".tabs").tabs();
        
    }
    
    function _changeEntity(){
        //loading('show');
                
        
        var container = $("#modal-template").clone();
        
        $.when(
            $.ajax({
                url: url,
                type: 'GET',
                data:{
                    modal   :   1,
                    ajax    :   1
                },
                dataType: 'html',
            })
        )
        .done(function(response){

            container.find('div.modal-dialog').removeClass('modal-lg').addClass('modal-sm');
            container.find('h4.modal-title').html('<i class="fa fa-building-o"></i> Seleção de entidade');
            container.find('div.modal-body')
                .css('height',' 250px')
                .css('overflow-y',' auto')
                .html(response);
            container.modal({
                backdrop: 'static',
                keyboard: true, 
                show: true,
            });  
            
            Init();
            
            container.on('hidden.bs.modal', function () {
              $(this).data('bs.modal', null);
              container.remove()
            });
            
            
        })
        .fail(function (response) {
            loading('hide')
            _errorMessage();
        });    
    }
    
    function _loadAjax(options){
        
        runningAjax = true;
        
        if(options.showLoading ==undefined || options.showLoading!=false){
            loading('show');    
        }
        
        
        var urlFrom = options.url.replace(BASE_URL,'');
        urlFrom = urlFrom ? urlFrom : '/'
        
        
        if(options.data==undefined){
            options.data = {};
        }
        
        if(options.method==undefined){
            options.method = 'GET'
        }
        
        options.data.from = urlFrom;
        options.data.ajax = 1
        
        $.when(
            $.ajax({
                url     :   options.url,
                type    :   options.method,
                data    :   options.data,
                dataType:   options.dataType!='undefined' ? options.dataType : 'JSON',
            })
        )
        .done(function(response){
            loading('hide');
            
            if(response.status=='error_secutiry'){
                _redirect(response.url);
                return;
            }
            
            
            if(
                response.messages !=undefined
                &&
                (options.showResponseMessages==undefined || options.showResponseMessages==true)
            ){
                $.each(response.messages, function(index, value) {
                    showMessage(value.type,value.message)      
                });     
            }
            if(options.onDone != undefined){
                options.onDone(response);
                runningAjax = false;
                return;
            }
            
        })
        .fail(function (response) {
            loading('hide')
            console.log(response.responseText)
            _errorMessage();
            
            if(options.onFail != undefined){
                options.onFail(response);
            }
            runningAjax = false;
        });
        
        
    }
    
    function _loadModal(options){
       
        loading('show');
                
        var urlFrom = options.url.replace(BASE_URL,'');
        urlFrom = urlFrom ? urlFrom : '/'
        var url = options.url;
        
        if(options.data==undefined){
            options.data = {};
        }
        
        if(options.method==undefined){
            options.method = 'GET'
        }
        
        if(options.container == undefined){
            options.container = $("#modal-template").clone();
            
        }
        options.data.from = urlFrom;
        options.data.modal = 1
        options.data.ajax = 1
                
        $.when(
            $.ajax({
                url: url,
                type: options.method,
                data:options.data,
                dataType: 'JSON',
            })
        )
        .done(function(response){
            
            if(response.status=='error_secutiry'){
                _redirect(response.url);
                return;
            }
            
            
            if(response.messages !=undefined){
                $.each(response.messages, function(index, value) {
                    showMessage(value.type,value.message)      
                }); 
             
             loading('hide')
             return false;       
                
            }
            
            options.container.attr('call-url',url);
            options.container.find('h4.modal-title').html(response.title);
            options.container.find('div.modal-body').html(response.body);
            
            if(response.modal_size != undefined){
                options.container.find('.modal-dialog').removeClass('modal-lg');
                options.container.find('.modal-dialog').addClass('modal-'+response.modal_size);
            }
            else if(options.modal_size != undefined){
                options.container.find('.modal-dialog').removeClass('modal-lg');
                options.container.find('.modal-dialog').addClass('modal-'+options.modal_size);
            }
            
            bodyHeight = ($(document).height()*0.55).toFixed(0);
            if(response.body_height != undefined){
                bodyHeight = response.body_height;
                options.container.find('div.modal-body').css('height',bodyHeight+'px');
                
            }
            else if(options.body_height != undefined){
                bodyHeight = options.body_height;
                options.container.find('div.modal-body').css('height',bodyHeight+'px');
                
            }
            
                  
            if(response.footer != undefined){
                options.container.find('div.modal-footer').prepend(response.footer);
            }
            
            if(response.javascript != undefined){
                
                $('<script>')
                    .attr('type', 'text/javascript')
                    .text(response.javascript)
                    .appendTo(options.container.find('div.modal-body'))
            }
            
            options.container.modal({
                backdrop: 'static',
                keyboard: true, 
                show: true,
            });  
                        
            options.container.on('hidden.bs.modal', function (){
                if(options.onClose!= undefined){
                   options.onClose(options.container);
                }
                $(this).data('bs.modal', null);
                options.container.remove()
            });
            
            if(options.done!= undefined){
               options.done(options.container);
            }
            
            Init();
                        
        })
        .fail(function (response) {
            loading('hide')
            console.log(response.responseText)
            _errorMessage();
        });
    }       
    function _loadPage(obj,container,dataPost,refresh){
        
        var containerDataUrl = container.attr('data-url');
        
        if(containerDataUrl != undefined && containerDataUrl == obj.attr('href')){
              /*_infoMessage('O item está aberto.');
              return false;
              */  
        }
        
        loading('show');    
               
        var urlFrom = obj.attr('href').replace(BASE_URL,'');
        urlFrom = urlFrom ? urlFrom : '/' 
             
        $.when(
            
            $.ajax({
                url: obj.attr('href'),
                type: 'GET',
                data:{
                    from:  urlFrom,
                    ajax:  true, 
                },
                dataType: 'html',
            })
        )
        .done(function(response){
            
            try{
                var objResponse = $.parseJSON(response);
                
                if(objResponse.status=='error'){
                    window.location = objResponse.to+'?from='+objResponse.from;
                    return false;
                }
                
                if(objResponse.messages !=undefined){
                    $.each(objResponse.messages, function(index, value) {
                        showMessage(value.type,value.message)      
                    }); 
                 
                 loading('hide')
                 return false;       
                    
                }
            }
            catch(err){
                objResponse = null;
            }    
            
    
            container.empty();               
            container.html(response);
            container.attr('data-url',obj.attr('href'))
                        
            container.on('hidden.bs.modal', function () {
              $(this).data('bs.modal', null);
              container.remove();
            });
                                    
            Init();

        })
        .fail(function (response){
            loading('hide')
            _errorMessage();
            
        });
        
    }
    
    function _redirect(url,values,method,target){
        
        var opts = url;
        
        if (typeof url !== "object") {
              var opts = {
                url: url,
                values: values,
                method: method,
                target: target,
              };
            }
        
        
        loadScript(plugin_path + 'redirect/jquery.redirect.js', function(){
            $.redirect(url,values,method,target)    
        });
        
    }
    function _errorMessage(message){
        if(message==undefined){
            message = '<div style="padding-right: 5px; display:table-cell;"><i class="fa fa-exclamation-circle" style="display:table-cell"></i></div> A requisição não pode ser concluída. <br />Refaça a operação ou contate o administrador';
        }
        else{
           message = '<div style="padding-right: 5px; display:table-cell;"><i class="fa fa-exclamation-circle" style="display:table-cell"></i></div>' + message; 
        }
        
        noty({
            text:       message, 
            layout:     'bottomRight', //'bottomRight',
            timeout:    4000,
            type:       'error'
        });
    }
    function _infoMessage(message){
        if(message==undefined){
            message = 'Status normal.';
        }
        
        
        noty({
            text:       message, 
            layout:     'bottomRight', //'bottomRight',
            timeout:    4000,
            type:       'information'
        });
    }
    function _successMessage(message){
        if(message==undefined){
            message = '<div style="padding-right: 5px; display:table-cell;"><i class="fa fa-check-square-o" style="display:table-cell"></i></div> Operação realizada.';
        }
        else{
           message = '<div style="padding-right: 5px; display:table-cell;"><i class="fa fa-check-square-o" style="display:table-cell"></i></div> ' + message; 
        }
        noty({
            text:       message, 
            layout:     'bottomRight', //'bottomRight',
            timeout:    4000,
            type:       'success'
        });
    }
    function _warningMessage(message){
        if(message==undefined){
            message = 'Houve algum problema.';
        }
        
        
        noty({
            text:       message, 
            layout:     'bottomRight', //'bottomRight',
            timeout:    4000,
            type:       'warning'
        });
    }
    
    function _setWindowScroll(){
        
        $(window).scroll(function () {
            /*
            if ($(this).scrollTop() > mainmenu.height()) {
    		  headerPage.css({
                'top'   : 0, 
              }) 
            }
            else{
              headerPage.css({
                'top'   :  headerPage.scrollTop()- $(this).scrollTop(), 
              })  
            }
            */
    	});        
    }
    
    function _afterAllAjax(func){
       
       setTimeout(function () {
        if(!runningAjax){
            func();
        }
        else{
            _afterAllAjax(func);    
        } 
        
        }, 100);
    }   
    
    
    function showMessage(type,message){
        if(type=='warning'){
            _warningMessage(message);  
        }
        else if(type=='error'){
            _errorMessage(message);  
        }
        else if(type=='info'){
            _infoMessage(message);
        }
        else{
            _successMessage(message);
        }
        
    }
    
    function showMessages(messages){
        
        $.each(messages, function(index, value) {
            showMessage(value.type,value.message)      
        }); 
    }
    
    var _arr 	= {};
	function loadScript(scriptName, callback) {

		if (!_arr[scriptName]) {
			_arr[scriptName] = true;

			var body 		= document.getElementsByTagName('body')[0];
			var script 		= document.createElement('script');
			script.type 	= 'text/javascript';
			script.src 		= scriptName+'?'+randomstring(16);

			// then bind the event to the callback function
			// there are several events for cross browser compatibility
			// script.onreadystatechange = callback;
			script.onload = callback;

			// fire the loading
			body.appendChild(script);

		} else if (callback) {

			callback();

		}

	};
    
    function loadCss(scriptName, callback) {

		if (!_arr[scriptName]) {
			_arr[scriptName] = true;
            
			var head 		= document.getElementsByTagName('head')[0];
			var script 		= document.createElement('link');
			script.rel   	= 'stylesheet';
			script.href 	= scriptName;

			// then bind the event to the callback function
			// there are several events for cross browser compatibility
			// script.onreadystatechange = callback;
			script.onload = callback;

			// fire the loading
			head.appendChild(script);

		} else if (callback) {

			callback();

		}

	};
    
    function randomstring(L){
        var s= '';
        var randomchar=function(){
            var n= Math.floor(Math.random()*62);
            if(n<10) return n; //1-10
            if(n<36) return String.fromCharCode(n+55); //A-Z
            return String.fromCharCode(n+61); //a-z
        }
        while(s.length< L) s+= randomchar();
        return s;
    }
    
    function jsUcfirst(string){
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    function isMobile(){
        
        var isMobile = false; //initiate as false
        // device detection
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
            isMobile = true;
        }
        
        return isMobile;
        
    }
    
    function loading(option){
        
        if(option!='hide'){
            $('#page_loading').show();   
        }
        else{
            $('#page_loading').fadeOut(function(){$(this).hide();});
        }
                
    }
    
    function redirectPost(url, data) {
        var form = document.createElement('form');
        document.body.appendChild(form);
        form.method = 'post';
        form.action = url;
        for (var name in data) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = data[name];
            form.appendChild(input);
        }
        form.submit();
    }
    //funcao para utilzar em ordenacao de objetos/arrays
    function compareValues(key, order = 'asc') {
      return function innerSort(a, b) {
        if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
          // property doesn't exist on either object
          return 0;
        }
    
        const varA = (typeof a[key] === 'string')
          ? a[key].toUpperCase() : a[key];
        const varB = (typeof b[key] === 'string')
          ? b[key].toUpperCase() : b[key];
    
        let comparison = 0;
        /*
        if (varA > varB) {
          comparison = 1;
        } else if (varA < varB) {
          comparison = -1;
        }*/
        
        comparison = (varA.localeCompare(varB, 'pt-br', { numeric: false }));
        
        return (
          (order === 'desc') ? (comparison * -1) : comparison
        );
      };
    } 
    function uuidv4() {
        return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }    
    
    Number.prototype.pad = function(size) {
        var s = String(this);
        while (s.length < (size || 2)) {s = "0" + s;}
        return s;
    }
    
    $.fn.selectRange = function(start, end) {
        $(this).each(function() {
            var el = $(this)[0];
    
            if (el) {
                el.focus();
                
                if (el.setSelectionRange) {
                    el.setSelectionRange(start, end);
                    
                } else if (el.createTextRange) {
                    var range = el.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', end);
                    range.moveStart('character', start);
                    range.select();
                    
                } else if (el.selectionStart) {
                    el.selectionStart = start;
                    el.selectionEnd = end;
                }
            }
        });
    };
    
    String.prototype.trunc = String.prototype.trunc ||
      function(n){
          return (this.length > n) ? this.substr(0, n-1) + '&hellip;' : this;
      };
      
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    
    window['sleep_wait'] = 100;
    
    async function awaitRunning(action){                              
        await sleep(window['sleep_wait']);
        if(action===true){
            await awaitRunning(window['running']);
        }
        return window['running'];
    }
    
    $.fn.isEqual = function($otherSet) {
      if (this === $otherSet) return true;
      if (this.length != $otherSet.length) return false;
      var ret = true;
      this.each(function(idx) { 
        if (this !== $otherSet[idx]) {
           ret = false; return false;
        }
      });
      return ret;
    };
    
    
    jQuery.fn.hasOverflown = function () {
       var res;
       var cont = $('<div>'+this.text()+'</div>').css("display", "table")
       .css("z-index", "-1").css("position", "absolute")
       .css("font-family", this.css("font-family"))
       .css("font-size", this.css("font-size"))
       .css("font-weight", this.css("font-weight")).appendTo('body');
       res = (cont.width()>this.width());
       cont.remove();
       return res;
    }