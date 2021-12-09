
    
    function cadastros_pessoaFisica_jsFormGeral(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formGeral = container.find('div#cadastros_formGeral');
         
        //pai desconhecido e nome_pai
        formGeral.find('input#pai_desconhecido').bind('change',function(){
            var form = $(this).closest('div.bsform');
            form.bsform({
                'method'    :   'toggleInputReadOnly',
                'input'     :   '#nome_pai'
            });
        });
        
        //mae desconhecida e nome_mae
        formGeral.find('input#mae_desconhecida').bind('change',function(){
            var form = $(this).closest('div.bsform');
            form.bsform({
                'method'    :   'toggleInputReadOnly',
                'input'     :   '#nome_mae'
            });
        });
        
        //país de origem e data chegada 
        formGeral.find('select#pais_origem').bind('change',function(){
            var form = $(this).closest('div.bsform');
            var paisDefault = $(this).attr('data-pais-default');
            
            if($(this).val() != paisDefault){
                form.bsform({
                    'method'    :   'toggleInputReadOnly',
                    'input'     :   '#data_chegada_pais_origem'
                }); 
            }
        });
        
        //ano grau de instrucao e grau de instrucao
        formGeral.find('input#grau_instrucao').bind('change',function(){
            var form = $(this).closest('div.bsform');
            if($(this).val()==''){
                form.bsform({
                    'method'    :   'toggleInputReadOnly',
                    'input'     :   '#ano_grau_instrucao',
                    'readonly'  :   true,
                });
            }
            else{
                
                form.bsform({
                    'method'    :   'toggleInputReadOnly',
                    'input'     :   '#ano_grau_instrucao',
                    'readonly'  :   false,
                });
            }
            
            
        });
                
    }
    
    cadastros_pessoaFisica_jsFormGeral();