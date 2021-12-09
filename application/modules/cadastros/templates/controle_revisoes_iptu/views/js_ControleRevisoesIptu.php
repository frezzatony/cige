        
    function cadastros_controle_revisoes_iptu(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var actionMenu = container.find('.cadastro-item-actionmenu');
        
        
        var formRevisao = container.find('div#formRevisao');
        var formEnderecoRevisao = container.find('div#formEnderecoRevisao');
        var formProcesso = container.find('div#formProcesso');
                
        var inputPk = container.find('input.cadastro_item_pk').eq(0);
        var inputCPFPessoaSolicitante = formRevisao.find('#cpf_pessoa_solicitante');
        var inputPessoaSolicitante = formRevisao.find('#pessoa_solicitante');
        var inputCPFPessoaProprietario = formRevisao.find('#cpf_pessoa_proprietario');
        var inputPessoaProprietario = formRevisao.find('#pessoa_proprietario');
        var inputNomeResponsavel = formProcesso.find('#processo_nome_responsavel');
        var inputDtRecebimentoProcesso = formProcesso.find('#processo_dt_atribuicao_responsavel');
        
        var inputLogradouroEnderecoRevisao = formEnderecoRevisao.find('#revisao_endereco_logradouro').eq(0);
        var btnReceberProcesso = container.find('button.btn-receber-processo');
        
        var inputControll = container.find('input.container-cadastro').eq(0);
        
        
        var btnImprimirFichaAbertura = actionMenu.find('.btn-imprimir-ficha-abertura');
        
        
        inputPessoaSolicitante.bind('change',function(e){
            $(this).val() ? inputCPFPessoaSolicitante.val(inputPessoaSolicitante.attr('data-return-cpf-value-masked')) : inputCPFPessoaSolicitante.val('');
        });
        
        inputPessoaProprietario.bind('change',function(e){
            
            if($(this).val()){
                inputCPFPessoaProprietario.val(inputPessoaProprietario.attr('data-return-cpf-value-masked'))
                var enderecos = JSON.parse(inputPessoaProprietario.attr('data-return-enderecos-value'));
            }
            else{
                inputCPFPessoaProprietario.val('');
                var enderecos = '';
            }
                         
            
            $.each(enderecos,function(index,item){
                if(item.tipo_endereco_value==1 && item.logradouro_endereco_value != ''){
                    
                    
                    var setEndereco = function(){
                        
                        formEnderecoRevisao.find('#revisao_endereco_cep').val(item.cep_endereco_value);
                        formEnderecoRevisao.find('#revisao_endereco_cep').attr('last_value',item.cep_endereco_value);
                        formEnderecoRevisao.find('#revisao_endereco_bairro').val(item.bairro_endereco_value);
                        formEnderecoRevisao.find('#revisao_endereco_logradouro').val(item.logradouro_endereco_value);
                        formEnderecoRevisao.find('#revisao_endereco_numero').val(item.numero_endereco_value);
                        formEnderecoRevisao.find('#revisao_endereco_complemento').val(item.complemento_endereco_value);
                        formEnderecoRevisao.find('#revisao_endereco_ponto_referencia').val(item.ponto_referencia_endereco_value);
                        
                        _successMessage('<i class="fa fa-info-circle"></i> Endereço da revisão foi preenchido.');
                    };
                    
                    
                    
                    if(inputLogradouroEnderecoRevisao.val()!='' && item.logradouro_endereco_value!='' && inputLogradouroEnderecoRevisao.val() != item.logradouro_endereco_value){
                        console.log(inputLogradouroEnderecoRevisao.val()+' - '+item.logradouro_endereco_value)
                        var modal = $("#modal-template").clone();
                        modal.find('div.modal-dialog').removeClass('modal-lg');
                        modal.find('div.modal-dialog').css('width','460px');
                        modal.find('div.modal-header .pull-left').html('<span class=""><i class="fa fa-copy"></i> Confirmar alteração</span>');
                        modal.find('div.modal-footer .btn-cancel').html('<i class="fa fa-times"></i> Cancelar')
                        modal.find('div.modal-footer').prepend('<button class="btn btn-secondary btn-3d btn-sm btn-confirm" >&nbsp;<i class="fa fa-copy"></i>&nbsp;&nbsp;Sim&nbsp;&nbsp;</button>')
                        modal.find('div.modal-body').removeClass('bg-gray').html('<div class="padding-10 size-12 text-centered">Endereço da revisão é diferente do endereço do proprietário informado.<br />Deseja atualizar o endereço de referência da revisão <br />utilizando o endereço do proprietário?</div>');
                        modal.modal();
                        
                        modal.find('button.btn-confirm').bind('click',function(){
                            modal.modal('hide');
                            setEndereco();
                            
                        }); 
                    }
                    else{
                        setEndereco();
                    }
                    
                    return false;
                }
            });
        });
        
        btnReceberProcesso.bind('click',function(e){
            
            if(!inputPk.val()){
                _errorMessage('O controle deve ser salvo para atribuir um responsável pelo processo.');
                return;
            }
            
            loading();
            _loadAjax({
                url                     :   BASE_URL+'cadastros/controle_revisoes_iptu/method/receberRevisao',
                data                    :   {
                    pk_item         :   $(this).data('pk_item'),  
                    id_responsavel  :   $(this).data('id_responsavel'),
                },
                showResponseMessages    :   false,
                method                  :   'POST',
                onDone                  :   function(response){
                    
                    showMessages(response.messages);
                    
                    if(response.nome_responsavel){
                        inputNomeResponsavel.val(response.nome_responsavel);
                        inputDtRecebimentoProcesso.val(response.dt_atribuicao);
                    }
                    btnReceberProcesso.remove();
                    
                    
                    //reload do grid, se houve alteração
                    if(response.status=='ok'){
                        var bsGrid = $('div.grid-items-cadastro');
                        bsGrid.bsgrid({
                            'method'    :   'reload'
                        });    
                    }
                    
                    
                    loading('hide');
                }
            });
        });
        
        formEnderecoRevisao.find('input#revisao_endereco_cep').on('blur',function(){
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
                    
                    await nodeFormParent.find('input#revisao_endereco_bairro').val(response.bairro).trigger('external_change');
                    await nodeFormParent.find('input#revisao_endereco_logradouro').val(response.logradouro).trigger('external_change');
                    
                    nodeFormParent.find('input#revisao_endereco_numero').focus()
                                
                }
            })
            
        });
        
        
        inputControll.bind('onSave_ok',function(e,response){
            if(!inputPk.val()){
                formRevisao.find('input#dt_abertura_controle').val(response.data.dt_abertura_controle);
            }
            
        });
        
        
        btnImprimirFichaAbertura.bind('click',async function(e){
            
            if(inputPk.val()==''){
                return false;
            }
            
            var _t = $(this);
            
            _redirect({
                'url'       :   BASE_URL+'relatorios/planejamento_urbanismo/controle_revisoes_iptu/method/ficha_abertura',
                'values'    :   {
                    'id'    :  inputPk.val(), 
                },
                'method'    :   'GET',
                'target'    :   '_blank'
            });
            
            return false;
        });
         
    }
    
    
    cadastros_controle_revisoes_iptu();
    