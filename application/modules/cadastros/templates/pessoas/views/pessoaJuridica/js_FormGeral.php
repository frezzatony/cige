
    
    function cadastros_pessoaJuridica_jsFormGeral(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formGeral = container.find('div#cadastros_formGeral');
        
        
        //unidade gestora e codigo unidade gestora
        formGeral.find('select#unidade_gestora').bind('change',function(){
            var form = $(this).closest('div.bsform');
            var _t = $(this);
            form.bsform({
                'method'    :   'toggleInputReadOnly',
                'input'     :   '#codigo_unidade_gestora',
                'readonly'  :   _t.val()=='' ? true : false,
            });
        });         
        //responsavel pelo MEI
        formGeral.find('input#mei').bind('change',function(){
            var form = $(this).closest('div.bsform');
            
            form.bsform({
                'method'    :   'toggleInputReadOnly',
                'input'     :   '#responsavel_mei',
            });
                        
        });        
    }
    
    cadastros_pessoaJuridica_jsFormGeral();