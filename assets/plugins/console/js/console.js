(function( $ ){
    
    
    function Console(container, options){
        
        this.container = container;
        this.options = $.extend({},options); 
        
        this.changeMethod = function(container, options){
            
            var plugin = this;
            
            if(options.log != undefined){
                plugin.log(options.log)
            } 
                 
        }
        
        this.log = function(log){
            
            var plugin = this;
            var body = plugin.container.find('.console-body');
            
            $.each(log,function(index,item){
                
                body.append('<p>'+item.date_time+' '+item.message+'</p>')
                body.scrollTop(body[0].scrollHeight);
                
            })
        }
        
        this.setElementTrigger = function(){
            
            var plugin = this;
            
            plugin.options.trigger.bind('click',function(e){
               plugin.toggleSoftHide();
            }); 
            
            plugin.container.find('button.btn-minimize').bind('click',function(e){
               plugin.toggleSoftHide(); 
            });
            
            plugin.container.find('.console-header').bind('dblclick',function(e){
               plugin.toggleSoftHide(); 
            });
        }
        
        
        this.init = function(){
            
            var plugin = this;
              
                
        }
        
        
        this.toggleSoftHide = function(){
            var plugin = this;
            plugin.container.toggleClass('softhide')
        }
        
        this.setElementTrigger(); 
        this.init();
    }
    
    $.fn.console = function(options){
        
        pluginName = 'console';
        var response = '';
        
        $(this).each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                new Console($(this), options ));
            }
            else{
                response =  $.data(this, 'plugin_' + pluginName).changeMethod($(this),options);
            }
        });
        
        return response; 
    };
    
    
})(jQuery);