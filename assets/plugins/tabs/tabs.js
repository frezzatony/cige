
(function( $ ){
    
    
    function Tabs(container, options){
        
        
        this.configs = {};
        this.options = $.extend({},options);
        
        
        this.changeMethod = function(container,options){
            plugin = this;
            plugin.options = $.extend(plugin.options,options);
            
        }
        
        
        this.init = function(container,options){
            
            var plugin = this;
            var allTabPanes = container.children('.tab-content,.tab-vertical-content').children('.tab-pane');
            var allNavItems = container.children('.nav-tabs').find('.nav-item');
            
            $.each(allTabPanes, function(index,item){
                if($(this).hasClass('softhide')){
                    $(this).hide();
                }
                else{
                    $(this).show();
                }
            });
            
            $.each(allNavItems, function(index,item){
                plugin.initNavItem(container,$(item));
            });
            
            if(container.children('.nav-tabs').find('.active').length==0){
                allNavItems.find('.nav-link,.list-group-item').eq(0).trigger('click');               
            }
               
        }
        
        this.initNavItem = function(container,node){
            
            var plugin = this;
            var nodeLink = node.children('.nav-link,.list-group-item').eq(0);
            var tabContent = container.children('.tab-content,.tab-vertical-content').eq(0);
            var allTabPanes = container.children('.tab-content,.tab-vertical-content').children('.tab-pane');
            var allNavItems = container.children('.nav-tabs').find('.nav-item, .nav-item');
                                    
            nodeLink.bind('click',function(e){
                
                e.preventDefault();
                
                if($(this).hasClass('active')){
                    return false;
                }
                
                if($(this).hasClass('nav-link')){
                    allNavItems.removeClass('active');
                    $(this).closest('.nav-item').addClass('active');    
                }
                else{
                    allNavItems.find('.list-group-item').removeClass('active');
                    $(this).addClass('active'); 
                }
                
                 
                
                allTabPanes.hide();
                
                var tabPane = tabContent.find('[data-pane="'+nodeLink.data('pane')+'"]').eq(0);
                
                if(nodeLink.attr('href') && nodeLink.attr('href')!='#'){
                    plugin.loadAjaxContent(container,nodeLink.closest('a'),nodeLink);    
                }
                
                tabPane.show();              
                    
                $(this).blur();
                return false;
            })
        }
        
        this.loadAjaxContent = function(container,node,nodeLink){
            var plugin = this;
            
            if(node.data('ajax-loaded')==true){
                return false;
            }
            
            var tabContent = container.find('.tab-content');
            
            var tabPane = tabContent.find('[data-pane="'+nodeLink.data('pane')+'"]').eq(0);
            
            _loadAjax({
                'url'           :   nodeLink.attr('href'),
                'data'          :   {},
                'method'        :   'POST',
                'showLoading'   :   true,
                'dataType'      :   'HTML',
                'onDone'    :   function(response){
                    tabPane.html(response);
                    Init();  
                    node.attr('data-ajax-loaded',true);
                }
            })
        }
        
        
        
        
        var plugin = this;
        
        plugin.init(container,options)
        
    }
    
    
    $.fn.tabs = function(options){
        
        pluginName = 'tabs';
        var response = '';
        
        $(this).each(function () {
            
            if (!$.data(this, 'plugin_' + pluginName+'_')) {
                $.data(this, 'plugin_' + pluginName+'_',true);
                
                $.data(this, 'plugin_' + pluginName,
                new Tabs($(this),options));
            }
            else if ($.data(this, 'plugin_' + pluginName)){
                
                response =  $.data(this, 'plugin_' + pluginName).changeMethod($(this),options);
            }
        });
        
        return response; 
        
    };
    
    
    
    
})(jQuery);