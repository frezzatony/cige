    
   
    
    function cadastros_logradouros(){

        var container = $('input.container-cadastro').closest('div.modal-body');
        var formGeral = container.find('div#form_logradouros_cadastro');
        var formBairros = container.find('#form_logradouros_bairrosLocalidades');
        
        
        var inputPk = container.find('input.cadastro_item_pk').eq(0);
        
        var inputEstado = formGeral.find('#estado');
        var inputCidade = formGeral.find('#cidade');
        var inputBairros = formBairros.find('#bairros');
        
        $.data(container, 'valueEstado', inputEstado.val());
        $.data(container, 'valueCidade', inputCidade.val());
        
        
        var validateBairrosValue = function(){
            
            var objValues = formBairros.bsform({'method':'getSimpleValues'});
            
            if(objValues.bairros.length){
                noty({
                    text:       'O cadastro possui bairro(s) informado(s). <br />A alteração não pôde ser efetuada.', 
                    layout:     'topCenter', //'bottomRight',
                    timeout:    4000,
                    type:       'warning'
                });
                
                return false;
            }
            
            return true;
        }
        
        inputEstado.bind('change',function(e){
            
            if(!validateBairrosValue()){
                $(this).val($.data(container, 'valueEstado'));
                return false;
            }
            
            $.data(container, 'valueEstado', $(this).val());
            inputCidade.val('').trigger('external_change');
        });
        
        inputCidade.bind('beforeSearch',function(e,plugin,pluginContainer,postData,filters){
            
            filters.push({
                'id'        :   'estado',
                'clause'    :   'equal_integer',
                'value'     :   inputEstado.val(),
            });
                        
        });
        
        inputCidade.bind('ready',async function(e){
            
            var inputCidadeText = inputCidade.closest('div.form-group').find('input.externallist-input-text').eq(0);
            
            if(inputCidade.val() != $.data(container, 'valueCidade') && !validateBairrosValue()){
                inputCidadeText.val('');
                await inputCidadeText.blur();
                inputCidade.val('');
                inputCidade.val($.data(container, 'valueCidade')).trigger('external_change');
                
                return false;
            }
            
            $.data(container, 'valueCidade', inputCidade.val());
            
        });
        
        
        inputBairros.bind('beforeSearch',function(e,plugin,pluginContainer,postData,filters){
            
            var inputCidadeText = inputCidade.closest('.form-group').find('.externallist-input-text').eq(0);
             
            filters.push({
                'id'        :   'cidade',
                'clause'    :   'equal',
                'value'     :   inputCidadeText.val(),
            });
            console.log(filters);
            
        });
        
        inputBairros.bind('beforeAdd',function(e,container,plugin,inputGrid){
            
            inputGrid.error = false;
            
            if(inputCidade.val()==''){
                noty({
                    text:       'Não há uma cidade informada.', 
                    layout:     'topCenter', //'bottomRight',
                    timeout:    4000,
                    type:       'warning'
                });
                
                inputGrid.error = true;
            }
            
        });
    }
    
    cadastros_logradouros();
    