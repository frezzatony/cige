    
    function cadastros_unidades_familiares_actionMenu(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var actionMenu = container.find('.cadastro-item-actionmenu');
        var inputPk = container.find('input.cadastro_item_pk').eq(0);
        
        var btnFichaCadastroEmhab = actionMenu.find('.btn-ficha-cadastral-emhab');
        var btnFichaCadastroSantaFe = actionMenu.find('.btn-ficha-cadastral-santa-fe');
        
        btnFichaCadastroEmhab.bind('click',async function(e){
            
            if(inputPk.val()==''){
                return false;
            }
            
            var _t = $(this);
            
            _redirect({
                'url'       :   BASE_URL+'relatorios/emhab/ficha_cadastro_emhab_unidades_familiares/method/ficha_cadastro_emhab',
                'values'    :   {
                    'unidade_familiar'  :  inputPk.val(), 
                },
                'method'    :   'GET',
                'target'    :   '_blank'
            });
            
            return false;
        });
        
        btnFichaCadastroSantaFe.bind('click',async function(e){
            
            if(inputPk.val()==''){
                return false;
            }
            
            var _t = $(this);
            
            _redirect({
                'url'       :   BASE_URL+'relatorios/emhab/ficha_cadastro_emhab_unidades_familiares/method/ficha_cadastro_santa_fe',
                'values'    :   {
                    'unidade_familiar'  :  inputPk.val(), 
                },
                'method'    :   'GET',
                'target'    :   '_blank'
            });
            
            return false;
        });
                 
        
    }
    
    function cadastros_unidades_familiares(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formGeral = container.find('div#form_unidadesFamiliares_cadastro');
        var formIntegrantes = container.find('div#form_unidadesFamiliares_integrantes');
        
        var inputPk = container.find('input.cadastro_item_pk').eq(0);
        var inputCPF = formGeral.find('#cpf_titular');
        var inputNIS = formGeral.find('#nis_titular');
        var inputTitular = formGeral.find('#titular');
        var inputIntegrantes = formIntegrantes.find('#integrantes').eq(0);
        var inputIntegrantes_integrante = formIntegrantes.find('input#integrantes_integrante');
        
        inputTitular.bind('change',function(e){
           inputCPF.val(inputTitular.attr('data-return-cpf-value-masked'));
           inputNIS.val(inputTitular.attr('data-return-nis-value-masked') ? inputTitular.attr('data-return-nis-value-masked') : inputTitular.attr('data-return-nis-value'));
        });
        
        
        
        inputTitular.bind('beforeSearch',function(e,plugin,pluginContainer,postData,filters){
            
            var integrantesPks = [];
            
            $.each(formIntegrantes.bsform({'method':'getSimpleValues'}).integrantes,function(index,rowValue){
                $.each(rowValue,function(indexRow,inputValue){
                    
                    if(inputValue.id =='integrantes_integrante'){
                        integrantesPks.push(parseInt(inputValue.value));
                    }
                    
                });
            });
            
            postData = $.extend(postData,{
                'unidade_familiar'              :   inputPk.val(),
                'integrantes'                   :   integrantesPks,
            });
        });
        
        
        
        var inputIntegrantes_integranteSearchFunction = function(inputIntegrante){
            
            inputIntegrante.off().bind('beforeSearch',function(e,plugin,pluginContainer,postData,filters){
                
                var _t = $(this);
                
                var integrantesPks = [];
                if(inputTitular.val()){
                    integrantesPks.push(inputTitular.val());
                }
                
                $.each(formIntegrantes.bsform({'method':'getSimpleValues'}).integrantes,function(index,rowValue){
                    
                    $.each(rowValue,function(indexRow,inputValue){
                            
                        if(inputValue.id =='integrantes_integrante' && _t.val()!=inputValue.value){
                            integrantesPks.push(parseInt(inputValue.value));
                        }
                        
                    });
                });
                
                postData = $.extend(postData,{
                    'unidade_familiar'              :   inputPk.val(),
                    'integrantes'                   :   integrantesPks,
                });
                
            });
            
            inputIntegrante.bind('change',function(e){
                var _t = $(this);
                var inputIntegranteCPF = _t.closest('div.bsform-grid-row').find('input#integrantes_integrante_cpf_cnpj');
                inputIntegranteCPF.val(_t.attr('data-return-cpf-value'));
            });
            
            
        }
        inputIntegrantes_integranteSearchFunction(inputIntegrantes_integrante);
        
        
        inputIntegrantes.bind('afterAdd',function(e,pluginContainer, pluginBsGrid, pluginBody){
            var inputIntegrante = pluginBody.find('input#integrantes_integrante');
            inputIntegrantes_integranteSearchFunction(inputIntegrante);
        });
        
    }
    
    cadastros_unidades_familiares_actionMenu();
    cadastros_unidades_familiares();
    