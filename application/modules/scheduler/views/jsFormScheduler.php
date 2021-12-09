<?php

/**
 * @author Tony Frezza
 */



?>

    function scheduler_jsFormScheduler(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formScheduler = container.find('div#ID4zVpSOu0NT');
        var inputModulo = container.find('select#modulo');
        
        inputModulo.bind('change',function(){
            loading('show');
            scheduler_jsFormScheduler_setInputMetodo();
        });
                
    }
    
    function scheduler_jsFormScheduler_setInputMetodo(){
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formScheduler = container.find('div#ID4zVpSOu0NT');
        var inputModulo = formScheduler.find('select#modulo');
        var inputMetodo = formScheduler.find('select#metodo');
        
        var selectedIndex = inputMetodo.prop('selectedIndex');
        
        inputMetodo.find('option').each(function(index,item){
            if($(this).attr('data-modulo')!=inputModulo.val()){
                if(index==selectedIndex){
                   selectedIndex = false; 
                }
                $(this).hide();
            }
            else{
                if(selectedIndex===false){
                    selectedIndex = index;
                }
                $(this).show();
            }
        });
        
        inputMetodo.prop('selectedIndex',selectedIndex);
        loading('hide');
    }
    
    function scheduler_jsFormScheduler_setInputPeriodicidade(){
        
        loading('show');
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formScheduler = container.find('div#ID4zVpSOu0NT');
        var divCron = formScheduler.find('div#periodicidade_cron').eq(0);
        var inputPeriodicidade = formScheduler.find('input#periodicidade');
        
        loadCss(BASE_URL+'assets/plugins/cron/jquery-cron.css',function(){
            loadScript(BASE_URL+'assets/plugins/cron/jquery-cron.js',function(){
                divCron.cron({
                    initial: inputPeriodicidade.val(),
                    onChange: function() {
                        inputPeriodicidade.val($(this).cron("value"));
                    }
                });
                loading('hide');
            });
        });
        
    }
    
    
    scheduler_jsFormScheduler();
    scheduler_jsFormScheduler_setInputMetodo();
    scheduler_jsFormScheduler_setInputPeriodicidade();