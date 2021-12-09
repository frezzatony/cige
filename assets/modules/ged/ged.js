
(function( $ ){
    
    
    function ged(container, options){
        
        
    }
    
    
    $.fn.ged = function(options){
        
        pluginName = 'ged';
        var response = '';
        
        $(this).each(function () {
            
            if (!$.data(this, 'plugin_' + pluginName+'_')) {
                $.data(this, 'plugin_' + pluginName+'_',true);
                
                $.data(this, 'plugin_' + pluginName,
                new ged($(this),options));
            }
            else if ($.data(this, 'plugin_' + pluginName)){
                
                response =  $.data(this, 'plugin_' + pluginName).changeMethod($(this),options);
            }
        });
        
        return response; 
        
    };
})