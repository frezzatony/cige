<?php

/**
 * @author Tony Frezza
 */


$mask = new Mask;
        
    
?>

    <div class="sheet nomargin padding-8mm">
        
        <table class="size-13 width-100p" >
            
            <tr class="bordered ">
                <td class="bordered" style="width: 10mm; padding: 1px">
                    <img src="<?php echo BASE_URL?>assets/img/logos/brasao_prefeitura.jpg" style="height: 60px;" />
                </td>
                <td class="bordered text-centered " style="width: 174mm; padding: 1px; vertical-align: middle;">
                    <p class="nomargin size-14">
                        <strong>Prefeitura Municipal de São Bento do Sul</strong>
                    </p>
                    <p class="nomargin">
                        <strong>Cadastro Técnico</strong>
                    </p>
                    <p class="nomargin size-12 ">
                        <strong>Solicitação de Revisão de IPTU</strong>
                    </p>
                </td>
                
            </tr>
        </table>
        
        <div class="height-10"></div>        
        
        <table class="size-13 width-100p" >
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="vertical-align: middle;" colspan="7">
                    <div class="h2">
                        Solicitante
                    </div>
                </td>
            </tr>
            <tr class="" style="height: 27px;">
                <td class="bordered">
                    <div class="label ">Nome:</div>
                    <div class="value">
                        <?php
                            echo $cadastro->variables->get('pessoa_solicitante.text');    
                        ?>
                    </div>
                </td> 
                <td class="bordered" style="width: 466px;">
                    <div class="label ">CPF:</div>
                    <div class="value">
                        <?php
                            echo $cadastro->variables->get('pessoa_solicitante')->variables->get('cpf_cnpj.value');    
                        ?>
                    </div>
                </td>               
            </tr>
        </table>
        <table class="size-13 width-100p no-top" >
            <tr class="" style="height: 27px;">
                <td class="bordered">
                    <div class="label ">TELEFONES:</div>
                    <div class="value">
                        <?php
                            $strTelefones = '';
                            
                            foreach($cadastro->variables->get('pessoa_solicitante')->variables->get('contatos.value') as $contato){
                                $keyTipoContato = array_search('contato_tipo',array_column($contato,'id'));
                                $keyValueContato =  array_search('contato_descricao',array_column($contato,'id'));
                                
                                
                                if(
                                    $keyTipoContato===FALSE OR
                                    $keyValueContato===FALSE OR
                                    !in_array($contato[$keyTipoContato]['value'],array(1,2,3))){
                                    continue;
                                }
                                
                                
                                if($strTelefones){
                                    $strTelefones .= ' | ';
                                } 
                                
                                $strTelefones .= $contato[$keyValueContato]['value'];
                            }
                            
                            echo $strTelefones;
                        ?>
                    </div>
                </td>                
            </tr>
        </table>
        
        <div class="height-10"></div>
        
        <table class="size-13 width-100p" >
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="vertical-align: middle;" colspan="7">
                    <div class="h2">
                        Proprietário
                    </div>
                </td>
            </tr>
            <tr class="" style="height: 27px;">
                <td class="bordered">
                    <div class="label ">Nome:</div>
                    <div class="value">
                        <?php
                            echo $cadastro->variables->get('pessoa_proprietario.text');    
                        ?>
                    </div>
                </td> 
                <td class="bordered" style="width: 466px;">
                    <div class="label ">CPF:</div>
                    <div class="value">
                        <?php
                            echo $cadastro->variables->get('pessoa_proprietario')->variables->get('cpf_cnpj.value');    
                        ?>
                    </div>
                </td>               
            </tr>
        </table>
        <table class="size-13 width-100p no-top" >
            <tr class="" style="height: 27px;">
                <td class="bordered">
                    <div class="label ">TELEFONES:</div>
                    <div class="value">
                        <?php
                            $strTelefones = '';
                            
                            foreach($cadastro->variables->get('pessoa_proprietario')->variables->get('contatos.value') as $contato){
                                $keyTipoContato = array_search('contato_tipo',array_column($contato,'id'));
                                $keyValueContato =  array_search('contato_descricao',array_column($contato,'id'));
                                
                                
                                if(
                                    $keyTipoContato===FALSE OR
                                    $keyValueContato===FALSE OR
                                    !in_array($contato[$keyTipoContato]['value'],array(1,2,3))){
                                    continue;
                                }
                                
                                
                                if($strTelefones){
                                    $strTelefones .= ' | ';
                                } 
                                
                                $strTelefones .= $contato[$keyValueContato]['value'];
                            }
                            
                            echo $strTelefones;
                        ?>
                    </div>
                </td>                
            </tr>
        </table>
                
        <div class="height-10"></div>
        
        <table class="size-13 width-100p" >
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="vertical-align: middle;" colspan="7">
                    <div class="h2">
                        Dados da solicitação
                    </div>
                </td>
            </tr>
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 180px;">
                    <div class="label ">Núm. solicitação:</div>
                    <div class="value">
                        <?php
                            echo $cadastro->get('item.value');    
                        ?>
                    </div>
                </td> 
                <td class="bordered" style="width: 180px;">
                    <div class="label ">Cód. Imóvel Sistema:</div>
                    <div class="value">
                        <?php
                            echo $cadastro->variables->get('codigo_imovel_erp.value');    
                        ?>
                    </div>
                </td> 
                 <td class="bordered" style="width: 180px;">
                    <div class="label ">Data solicitação:</div>
                    <div class="value">
                        <?php
                            echo $cadastro->variables->get('dt_abertura_controle.value');    
                        ?>
                    </div>
                </td> 
                <td class="bordered" >
                    <div class="label ">Cód. Imóvel Sistema:</div>
                    <div class="value">
                        <?php
                            echo $cadastro->variables->get('codigo_imovel_erp.value');    
                        ?>
                    </div>
                </td>              
            </tr>
        </table>
        
        <div class="height-20"></div>
        
        <p class="size-13">
            Solicito revisão do lançamento do IPTU dos itens abaixo relacionados:
        </p>
        
        <div class="height-6"></div>
        
        <table class=" width-100p no-top" >
            <tr class="" style="height: 10px; ">
                <td class="bordered size-11 bold text-centered" style="width: 230px; ">
                    Item
                </td>
                <td class="bordered size-11 bold text-centered">
                    Motivo revisão
                </td>
                
            </tr>
            <?php
            
                foreach($cadastro->variables->get('itens_revisar.value') as $itemRevisar){
                    
            ?>
                <tr class="" style="height: 12px; ">
                    <td class="bordered size-12 text-centered padding-2 align-middle">
                        <?php
                            echo $itemRevisar['1']['text'];
                        ?>
                    </td>
                    <td class="bordered size-11 padding-2 align-middle" >
                        <?php
                            echo $itemRevisar['2']['value'];
                        ?>
                    </td>
                    
                </tr>
            <?php
            
                }
                
            ?>
        </table>
        
        <div class="height-20"></div>
        
        <table class=" width-100p no-top" >
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="vertical-align: middle;" colspan="7">
                    <div class="h2">
                        Documentação necessária solicitada
                    </div>
                </td>
            </tr>
            
            <tr class="" style="height: 10px; ">
                <td class="bordered size-11 bold text-centered" style="width: 300px; ">
                    Documento
                </td>
                <td class="bordered size-11 bold text-centered">
                    Observação
                </td>
                
            </tr>
            <?php
            
                foreach($cadastro->variables->get('documentacao_revisao.value') as $itemRevisar){
                    
            ?>
                <tr class="" style="height: 12px; ">
                    <td class="bordered size-12 text-centered padding-2 align-middle">
                        <?php
                            echo $itemRevisar['1']['text'];
                        ?>
                    </td>
                    <td class="bordered size-11 padding-2 align-middle" >
                        <?php
                            echo $itemRevisar['2']['value'];
                        ?>
                    </td>
                    
                </tr>
            <?php
            
                }
                
            ?>
        </table>
        
        <div class="height-10"></div>
        
        <table class="size-13 width-100p" >
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="vertical-align: middle;" colspan="7">
                    <div class="h2">
                        Observações da solicitação
                    </div>
                </td>
            </tr>
            <tr class="">
                <td class="bordered" style="width: 180px;">
                    <p class="size-13 bold padding-2">
                        O processo terá andamento somente quando todos os documentos solicitados estiverem anexados (cópias).
                        <br />
                        Prazo para entrega de documentos é de  15 dias contanto da abertura desta solicitação.
                    </p>
                    <p class="size-12 padding-2">
                        <?php
                            echo $cadastro->variables->get('detalhamento_revisao.value');
                        ?>
                    </p>
                </td>               
            </tr>
        </table>
        
        
        
        <div class="rodape" style="">
            
            <div style="float: right; display: block; width: 100%; margin-bottom: 110px;">
                <div class="size-11" style="float: right; padding-right: 20px;">
                
                    São Bento do Sul, 
                    <?php
                        echo dataExtenso();
                    ?>.
                </div>
            </div>
            
            <div style="float: left; margin-bottom: 25mm; margin-right: 40mm; margin-left: 12mm;   ">
               <div class="assinatura">
                    <div class="linha" style=""></div>
                    <div class="nome">
                       
                        
                        <?php 
                            echo $this->data->get('user.nome');
                        ?> 
                         <div class="height-4"></div>
                        Cadastro Imobiliário
                        
                         
                    </div>
                </div>
            </div>
            
            <div style="float: left;">
               <div class="assinatura">
                    <div class="linha" style=""></div>
                    <div class="nome">
                        <?php 
                            echo $cadastro->variables->get('pessoa_solicitante.text');
                        ?> 
                         <div class="height-4"></div>
                        CPF: 
                        <?php 
                            echo $cadastro->variables->get('pessoa_solicitante')->variables->get('cpf_cnpj.value');
                        ?> 
                    </div>
                </div>
            </div>
                      
                        
        </div>
        <?php echo $carimboSistema_A4; ?>
        
    </div>