
    
    function cadastros_pessoaFisica_jsFormEnderecos(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formEnderecos = container.find('div#CFMnIw4VOeqS');
        
        formEnderecos.find('input#cep_endereco').on('blur',function(){
            var _t = $(this);
            var nodeFormParent = _t.closest('div.bsform-body');
            
            if(_t.val()=='' || _t.val() == _t.attr('last_value') || _t.val().length < 7){
                return false;
            }
            
            _loadAjax({
                'url'       :   BASE_URL+'rest',
                'data'      :   {
                    'token'     :   _t.attr('token'),
                    'cep'       :   _t.val()
                },
                'onDone'    :   async function(response){
                    _t.attr('last_value',_t.val());
                    
                    if(response.erro){
                        _t.val('');
                        _errorMessage('CEP inválido');
                        return false;
                    }
                    
                    await nodeFormParent.find('input#estado_endereco').val(response.estado_id).trigger('external_change');
                    await nodeFormParent.find('input#cidade_endereco').val(response.cidade_id).trigger('external_change');
                    await nodeFormParent.find('input#bairro_endereco').val(response.bairro).trigger('external_change');
                    await nodeFormParent.find('input#logradouro_endereco').val(response.logradouro).trigger('external_change');
                    
                    nodeFormParent.find('input#numero_endereco').focus()
                                
                }
            })
            
        });
         
    }
    
    cadastros_pessoaFisica_jsFormEnderecos();