
(function( $ ){
    
    
    function Cige_accordion(container, options){
        
        this.container = container;
        
        this.options = {
            icon_position :   'left',
            
        };
        
        this.options = $.extend(this.options,options);
        
        
        this.changeMethod = function(options){
            plugin = this;
            plugin.options = $.extend(plugin.options,options);
            
        }
        
        
        this.init = function(){
            
            var plugin = this;
            var allContents = plugin.container.children('.accordion-content');
            var allNavItems = plugin.container.children('.nav-link').length ? plugin.container.children('.nav-link') : plugin.container.find('.nav-link');
            
                    
            $.each(allNavItems, function(index,item){
                plugin.initNavItem(container,$(item));
            });
            
            if(plugin.container.children('.nav-tabs').find('.active').length==0){
                allNavItems.find('.nav-link,.list-group-item').eq(0).trigger('click');               
            }
        }
        
        this.initNavItem = function(container,node){
            
            var plugin = this;
            var icon = node.find('li.icon,i.icon').eq(0);
            var allNavItems = plugin.container.children('.nav-link');
            
            if(icon.length == 0){
                plugin.setIcon(node);
            }
            
            
            if(node.index() > 0){
                node.prev().addClass('bordered-bottom');
            }
            
            if(node.hasClass('active')){
                plugin.setNode_active(node);
            }
            else{
                plugin.setNode_inactive(node); 
            }
            
            node.bind('click',function(e){
                
                e.preventDefault();
                
                if(!$(this).hasClass('active')){
                    plugin.setNode_active(node);
                }
                else{
                    plugin.setNode_inactive(node);   
                }  
                
                if(!plugin.container.hasClass('accordion-multiple')){
                    allNavItems.each(function(index,item){
                        if(!$(item).is(node)){
                            plugin.setNode_inactive($(item));    
                        }
                    });
                }
                
                
                $(this).blur();
                return false;
            })      
            
        }
        
        
        
        
        this.setIcon = function(node){
            
            var icon = $('<li/>');
            icon.addClass('icon las');
            node.prepend(icon);
        }
        
        this.setNode_active = function(node){
            
            var plugin = this;
            var icon = node.find('li.icon,i.icon').eq(0);
            var iconPosition = plugin.options.icon_position == 'left' ? 'right' : 'left';
            var content = node.next();
            
            icon.removeClass('la-caret-'+iconPosition).addClass('la-caret-down');
            node.addClass(' active');
            
            
            if(!$(content).hasClass('content')){
                return false;
            }
            
            content.show();
        }
        
        this.setNode_inactive = async function(node){
            var plugin = this;
            var icon = node.find('li.icon,i.icon').eq(0);
            var iconPosition = plugin.options.icon_position == 'left' ? 'right' : 'left';
            var content = node.next();
            
            
            icon.removeClass('la-caret-down').addClass('la-caret-'+iconPosition);
            node.removeClass('active');
            
            if(!$(content).hasClass('content')){
                return false;
            }
            
            content.hide();
            
            await node.trigger('close',[plugin]);
        }
        
        var plugin = this;
        
        plugin.init();
        
    }
    
    
    $.fn.cige_accordion = function(options){
        
        pluginName = 'cige_accordion';
        var response = '';
        
        $(this).each(function () {
            
            if (!$.data(this, 'plugin_' + pluginName+'_')) {
                $.data(this, 'plugin_' + pluginName+'_',true);
                
                $.data(this, 'plugin_' + pluginName,
                new Cige_accordion($(this),options));
            }
            else if ($.data(this, 'plugin_' + pluginName)){
                
                response =  $.data(this, 'plugin_' + pluginName).changeMethod($(this),options);
            }
        });
        
        return response; 
        
    };
    
    
    
})(jQuery);