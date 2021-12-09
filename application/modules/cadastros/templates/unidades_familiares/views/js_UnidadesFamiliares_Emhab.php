
    
    function cadastros_unidades_familiares_emhab(){
        
        var container = $('input.container-cadastro').closest('div.modal-body');
        var formEmhab = container.find('div#form_unidadesFamiliares_emhab');
        
        var inputJaAtendido = formEmhab.find('#atendido_programa_social_emhab');
        var inputDataContemplacao = formEmhab.find('#data_atendimento_programa_social_emhab');
        
        container.find('div#grid_pontuacao_emhab').bsgrid({
            'noHeader'  :    true,
        });
        container.find('div#grid_pontuacao_santa_fe').bsgrid({
            'noHeader'  :    true,
        });
        
        inputJaAtendido.bind('change',function(e){
            
            formEmhab.bsform({
                'method'    :   'toggleInputReadOnly',
                'input'     :   '#data_atendimento_programa_social_emhab'
            });
            
            formEmhab.bsform({
                'method'    :   'toggleInputReadOnly',
                'input'     :   '#programas_sociais_emhab_atendido'
            });
            
        });
        
        $('input.container-cadastro').eq(0).on('onSave_ok',async function(e){
            
            var updatePontuacaoEmhab = function(){
                
                container.find('div#grid_pontuacao_emhab').bsgrid({
                    'method'        :   'updateData',
                    'pk_item'       :   container.find('input.cadastro_item_pk').eq(0).val(),
                    'showLoading'   :   true,
                });
            }
            
            var updatePontuacaoSantaFe = function(){
                container.find('div#grid_pontuacao_santa_fe').bsgrid({
                    'method'        :   'updateData',
                    'pk_item'       :   container.find('input.cadastro_item_pk').eq(0).val(),
                    'showLoading'   :   true,
                });
                
            }
            
            
            await updatePontuacaoEmhab();
            await updatePontuacaoSantaFe();
            
             
        });
    }
    
    cadastros_unidades_familiares_emhab();