    
    
    
    function cadastros_controle_notas_almoxarifado(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formGeral = container.find('div#form_controleNotasAlmoxarifado_cadastro');
        
        
        var inputPk = container.find('input.cadastro_item_pk').eq(0);
        var inputCPF_CNPJ = formGeral.find('#cpf_cnpj_fornecedor');
        
        var inputFornecedor = formGeral.find('#fornecedor');
        
        inputFornecedor.bind('change',function(e){
           inputCPF_CNPJ.val(inputFornecedor.attr('data-return-cpf_cnpj-value-masked'));
           
        });
                
        
    }
    
    cadastros_controle_notas_almoxarifado();
    