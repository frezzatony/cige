    
    
    
    
    function _cadastros_controllers(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var forms = container.find('div.form-controller');
        
        var formTipo_Controller = container.find('div#formTipo_Controller');
        var formTipo_Relatorio = container.find('div#formTipo_Relatorio');
        
        var inputTipoController = forms.find('select#tipo');
        
        //var tipoValue = inputTipoController.eq(0).children("option:selected").val();
        
        inputTipoController.bind('change',async function(e){
            var _t = $(this);
            
            loading();
            
            var switchForm = async function(){
                
                var valueFormTipo_Relatorio = '4';
                var activeForm = container.find('div.form-controller:not(.softhide)');
                
                var arrValues =  activeForm.bsform({'method':'getSimpleValues'});
                
                formTipo_Controller.addClass('no-save softhide');
                formTipo_Relatorio.addClass('no-save softhide');
                
                if(_t.val() == valueFormTipo_Relatorio){
                    formTipo_Relatorio.bsform({
                            'method'    :   'setValues',
                            'values'    :   arrValues,
                    });
                    formTipo_Relatorio.removeClass('no-save softhide');
                }
                else{
                    
                    formTipo_Controller.bsform({
                            'method'    :   'setValues',
                            'values'    :   arrValues,
                    });
                    formTipo_Controller.removeClass('no-save softhide');
                }
                
                
                
                 
            }
            
            await switchForm();
            
            loading('hide');
            
            
            
            
        });
        
    }
    
    _cadastros_controllers();