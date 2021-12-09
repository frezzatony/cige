
    
    function cadastros_pessoaFisica_jsFormDoencasCronicas(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formDoencasCronicas = container.find('div#pessoas_formDoencasCronicas');
        
        var inputDoencasCronicas = formDoencasCronicas.find('#doencas_cronicas');
        
        var setDoencaCID10Function = function(){
            
            inputsDoenca = inputDoencasCronicas.find('div.bsform-grid-row').find('input#doencas_cronicas_doenca');
             
            inputsDoenca.off().bind('change',function(e){
               var _t = $(this);
               var inputCID10 = _t.closest('div.bsform-grid-row').find('input#doencas_cronicas_doenca_cid_10');
               inputCID10.val(_t.attr('data-return-cid_10-value-masked'));
            });    
        }
        
        setDoencaCID10Function();
        
        inputDoencasCronicas.find('.bsform-grid-body').bind('ready',function(){
            setDoencaCID10Function();
        });
        
        
        
        
        
    }
    
    cadastros_pessoaFisica_jsFormDoencasCronicas();