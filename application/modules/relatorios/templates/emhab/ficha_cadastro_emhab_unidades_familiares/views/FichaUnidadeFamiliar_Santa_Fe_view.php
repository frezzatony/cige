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
                        <strong>Empresa Municipal de Habitação - Emhab</strong>
                    </p>
                    <p class="nomargin size-12 ">
                        <strong>Ficha cadastral - Loteamento Santa Fé</strong>
                    </p>
                </td>
                <td class="bordered" style="width: 10mm;">
                    <img src="<?php echo BASE_URL?>assets/img/logos/emhab.jpg" style="height: 60px; padding: 1px;" />
                </td>
            </tr>
        </table>
        
        <div class="height-10"></div>        
        
        <table class="size-13 width-100p" >
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="vertical-align: middle;" colspan="7">
                    <div class="h2">
                        Unidade Familiar
                    </div>
                </td>
            </tr>
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 15mm;">
                    <div class="label ">Código</div>
                    <div class="value text-right ">
                        <?php
                            echo $dataCadastro[0]['id'];
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 20mm;">
                    <div class="label">CadÚnico</div>
                    <div class="value ">
                        <?php
                            echo $dataCadastro[0]['cadunico'];
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 40mm;">
                    <div class="label">RESIDÊNCIA NO LOCAL DESDE</div>
                    <div class="value text-right">
                        <?php
                            echo formataDataImprime($dataCadastro[0]['data_inicio_residencia']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 25mm;">
                    <div class="label">VÍNCULO COM A MORADIA</div>
                    <div class="value ">
                       <?php
                            echo strtoMAIsuculo($dataCadastro[0]['vinculo_moradia_descricao']);
                       ?>
                    </div>
                </td>
                <td class="bordered" style="width: 26mm;">
                    <div class="label">TIPO DE MORADIA</div>
                    <div class="value ">
                       <?php
                            echo strtoMAIsuculo($dataCadastro[0]['tipo_moradia_descricao']);
                       ?>
                    </div>
                </td>
                <td class="bordered" style="width: 40mm;">
                    <div class="label">MATERIAL CONSTRUTIVO DA MORADIA</div>
                    <div class="value ">
                       <?php
                            echo strtoMAIsuculo($dataCadastro[0]['sistema_construtivo_moradia_descricao']);
                       ?>
                    </div>
                </td>
                
                <td class="bordered"  style="">
                    <div class="label">SITUAÇÃO DA MORADIA</div>
                    <div class="value ">
                       <?php
                            echo strtoMAIsuculo($dataCadastro[0]['situacao_moradia_descricao']);
                       ?>
                    </div>
                </td>
                
            </tr>
        </table>
        
        <table class="size-13 width-100p no-top" >
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 140px;">
                    <div class="label ">PROGRAMA DE INTERESSE</div>
                    <div class="value">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['programa_interesse_emhab_descricao']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 166px;">
                    <div class="label ">JÁ ATENDIDO EM PROGRAMA SOCIAL (EMHAB)</div>
                    <div class="value">
                        <?php
                            echo boolValue($dataCadastro[0]['atendido_programa_social_emhab']) ? 'SIM' : 'NÃO';
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 184px;">
                    <div class="label ">DATA CONTEMPLAÇÃO PROGRAMA SOCIAL (EMHAB)</div>
                    <div class="value text-right">
                        <?php
                            echo formataDataImprime($dataCadastro[0]['data_atendimento_programa_social_emhab']);
                        ?>
                    </div>
                </td>
                <td class="bordered">
                    <div class="label ">PROGRAMA SOCIAL CONTEMPLADO (EMHAB)</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['programa_atendido_emhab_descricao']);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        <table class="size-13 width-100p no-top" >
            <tr>
                <td class="bordered" style="width: 50%;">
                    <div class="label">REMUNERAÇÃO FAMILIAR POR OCUPAÇÕES (R$)</div>
                    <div class="value text-right">
                        <?php
                            echo formataFLOATImprime($sum_remuneracao_ocupacoes);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 50%;">
                    <div class="label">REMUNERAÇÃO FAMILIAR POR programas sociais (R$)</div>
                    <div class="value text-right">
                        <?php
                            echo formataFLOATImprime($sum_remuneracao_programas_sociais);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        <table class="size-13 width-100p no-top" >
            <tr class="" style="height: 50px;">
                <td class="bordered">
                    <div class="label ">OBSERVAÇÕES</div>
                    <div class="value line-clmap-3" style="font-size: 6pt; word-break: break;">
                           <?php
                            echo strip_tags($dataCadastro[0]['observacoes']);
                        ?> 
                    </div>
                </td>
            </tr>
        </table>
        
        <div class="height-10"></div>
        
        <table class=" width-100p" >
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="width: 190px; vertical-align: middle;" colspan="6">
                    <div class="h2">
                        Titularidade do cadastro
                    </div>
                </td>
            </tr>
            
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 330px;">
                    <div class="label ">NOME</div>
                    <div class="value">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_nome']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 80px;">
                    <div class="label ">DATA NASCIMENTO</div>
                    <div class="value text-right">
                        <?php
                            echo formataDataImprime($dataCadastro[0]['titular_data_nascimento']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 60px;">
                    <div class="label ">SEXO</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_tipo_sexo_descricao']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 80px;">
                    <div class="label ">CPF</div>
                    <div class="value ">
                        <?php
                            echo $mask->mask($dataCadastro[0]['titular_cpf'],'cpf_cnpj');
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 80px;">
                    <div class="label ">RG</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_rg']);
                        ?>
                    </div>
                </td>
                <td class="bordered">
                    <div class="label ">NIS</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_nis']);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        
        <table class=" width-100p no-top" >
            
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 100px;">
                    <div class="label ">CERTIDÃO NASCIMENTO</div>
                    <div class="value">
                       <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_certidao_nascimento']);
                        ?> 
                    </div>
                </td>
                <td class="bordered" style="width: 100px;">
                    <div class="label ">CERTIDÃO CASAMENTO</div>
                    <div class="value">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_certidao_casamento']);
                        ?> 
                    </div>
                </td>
                <td class="bordered" style="width: 130px;">
                    <div class="label ">PIS/PASEP</div>
                    <div class="value">
                        <?php
                            echo $dataCadastro[0]['titular_pis_pasep'];
                        ?> 
                    </div>
                </td>
                <td class="bordered" style="width: 130px;">
                    <div class="label ">CARTEIRA DE TRABALHO/SÉRIE</div>
                    <div class="value">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_ctps']);
                        ?>
                        /
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_serie_ctps']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 130px;">
                    <div class="label ">TÍTULO DE ELEITOR / ZONA /SEÇÃO</div>
                    <div class="value">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_titulo_eleitor']);
                        ?>
                        /
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_zona_titulo_eleitor']);
                        ?>
                        /
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_secao_titulo_eleitor']);
                        ?>
                    </div>
                </td>
                <td class="bordered">
                    <div class="label ">CARTÃO SUS</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_cartao_sus']);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        
        <table class=" width-100p no-top" >
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 100px;">
                    <div class="label ">ESTADO CIVIL</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['titular_estado_civil_descricao']);
                        ?>
                    </div>
                </td>

                <td class="bordered" style="width: 150px;">
                    <div class="label ">REMUNERAÇÃO POR OCUPAÇÕES (R$) </div>
                    <div class="value text-right">
                       <?php echo formataFLOATImprime($dataCadastro[0]['titular_remuneracao_ocupacoes']); ?> 
                    </div>
                </td>
                
                <td class="bordered" style="width: 180px;">
                    <div class="label ">REMUNERAÇÃO POR PROGRAMAS SOCIAIS (R$) </div>
                    <div class="value text-right">
                       <?php echo formataFLOATImprime($dataCadastro[0]['titular_remuneracao_programas_sociais'] ?? 0); ?> 
                    </div>
                </td>
            </tr>
        </table>
        
        <table class=" width-100p no-top" >
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 330px;">
                    <div class="label ">ENDEREÇO PRINCIPAL</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['logradouro_endereco_titular']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 60px;">
                    <div class="label ">NÚMERO</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['numero_endereco_titular']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 150px;">
                    <div class="label ">BAIRRO</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['bairro_endereco_titular']);
                        ?>
                    </div>
                </td>
                <td class="bordered" >
                    <div class="label ">CEP</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['cep_endereco_titular']);
                        ?>
                    </div>
                </td>
            </tr>           
        </table>
        
        <table class=" width-100p no-top" >
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 50%;">
                    <div class="label ">COMPLEMENTO ENDEREÇO PRINCIPAL</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['complemento_endereco_titular']);
                        ?>
                    </div>
                </td>
                
                <td class="bordered" >
                    <div class="label ">PONTO DE REFERÊNCIA ENDEREÇO PRINCIPAL</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['ponto_referencia_endereco_titular']);
                        ?>
                    </div>
                </td>
            </tr>           
        </table>
        
        <table class=" width-100p no-top" >
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 90px;">
                    <div class="label ">CAPAZ PARA TRABALHAR </div>
                    <div class="value ">
                        <?php
                            
                            if(
                                boolValue($dataCadastro[0]['capaz_trabalho'])
                                AND
                                !((Json::getFullArray($dataCadastro[0]['incapacitante_trabalho_doencas_cronicas_titular'])))
                            ){
                                echo 'SIM';
                            }
                            else{
                                echo 'NÃO';
                            }
                            
                                
                       
                        ?> 
                    </div>
                </td>
                <td class="bordered" >
                    <div class="label ">DEFICIÊNCIA FÍSICA</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($dataCadastro[0]['necessidade_especial_descricao_titular']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 400px;">
                    <div class="label ">OBSERVAÇÕES DEFICIÊNCIA FÍSICA </div>
                    <div class="value " >
                       <?php
                            echo strtoMAIsuculo($dataCadastro[0]['observacoes_necessidade_especial_titular']);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        
        
        <table class=" width-100p no-top" >
            <tr class="" style="height: 40px;">
                <td class="bordered " >
                    <div class="label ">DOENÇAS CRÔNICAS</div>
                    <div class="value line-clmap-3" style="font-size: 6pt; word-break: break;">
                    <?php
                        foreach(JSON::getFullArray($dataCadastro[0]['cid_10_doencas_cronicas_titular'] ?? array()) as $key => $cid10){
                    ?>
                        
                        <span style="margin-right: 2px;">
                            &#8226;
                            <?php
                            
                                echo $mask->mask($cid10,'A99.9999');
                                echo '-';
                                echo JSON::getFullArray($dataCadastro[0]['nomenclatura_doencas_cronicas_titular'])[$key];
                            ?>;
                        </span>
                   
                    
                    <?php
                    
                        }
                        
                    ?>
                     </div>
                </td>
            </tr>           
        </table>
        
        <div class="height-10"></div>
        
        <table class=" width-100p">
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="width: 190px; vertical-align: middle;" colspan="6">
                    <div class="h2">
                        Demais integrantes
                    </div>
                </td>
            </tr>
        </table>
        
        <table class=" width-100p no-top" >
            <tr class="" style="height: 10px; ">
                <td class="bordered size-7 bold text-centered" style="width: 220px; ">
                    NOME
                </td>
                <td class="bordered size-7 bold text-centered" style="width: 100px; ">
                    GRAU PARENTESCO
                </td>
                <td class="bordered size-7 bold text-centered" style="width: 74px; ">
                    DATA NASCIMENTO
                </td>
                <td class="bordered size-7 bold text-centered" style="width: 74px;">
                    RESP. UNI. FAMILIAR
                </td>
                <td class="bordered size-7 bold text-centered" style="width: 74px;">
                    DEFICIÊNCIA FÍSICA
                </td>
                <td class="bordered size-7 bold text-centered" style="width: 74px;">
                    DOENÇA CRÔNICA
                </td>
                <td class="bordered size-7 bold text-centered" style="">
                    RENDA OCUPAÇÃO (R$)
                </td>
            </tr>
            <?php
            
                foreach($dataCadastro as $row){
                    if(!$row['integrante_nome']){
                        continue;
                    }
            ?>
                <tr class="" style="height: 12px; ">
                    <td class="bordered size-8" style="width: 240px; padding-left: 2px;">
                        <?php
                            echo strtoMAIsuculo($row['integrante_nome']);
                        ?>
                    </td>
                    <td class="bordered size-8 text-centered" style="width: 80px; ">
                        <?php
                            echo strtoMAIsuculo($row['integrante_grau_parentesco_descricao']);
                        ?>
                    </td>
                    <td class="bordered size-8 text-centered" style="width: 74px; ">
                        <?php
                            echo formataDataImprime($row['integrante_data_nascimento']);
                        ?>
                    </td>
                    <td class="bordered size-8 text-centered" style="width: 74px;">
                        <?php
                            echo boolValue($row['integrante_reponsavel_unidade_familiar']) ? 'SIM' : 'NÃO';
                        ?>
                    </td>
                    <td class="bordered size-8 text-centered" style="width: 74px;">
                        <?php
                            echo strtoMAIsuculo($row['necessidade_especial_descricao_integrante']);
                        ?>
                    </td>
                    <td class="bordered size-8 text-centered" style="width: 74px;">
                        <?php
                            echo ($row['cid_10_doencas_cronicas_integrante']) ? 'SIM' : 'NENHUMA'; 
                        ?>
                    </td>
                    <td class="bordered size-8  text-right" style="padding-right: 2px;">
                        <?php
                            echo formataFLOATImprime($row['remuneracao_ocupacoes_integrante'] ?? 0);
                        ?>
                    </td>
                </tr>
            <?php
            
                }
                
            ?>
        </table>
        
        <div class="height-10"></div>
        
        <table class=" width-100p">
            <tr class=" " style="height: 16px;">
                <td class="bordered bg-gray" style="width: 190px; vertical-align: middle;" colspan="6">
                    <div class="h2">
                        Critérios de pontuação para Loteamento Santa Fé
                    </div>
                </td>
            </tr>
        </table>
        <table class=" width-100p no-top" >
            <tr class="" style="height: 10px; ">
                <td class="bordered size-7 bold text-centered" style="width: 620px; ">
                    CRITÉRIO
                </td>
                <td class="bordered size-7 bold text-centered" style="">
                    ENQUADRAMENTO
                </td>
                
            </tr>
                <?php
                    
                    foreach($criteriosPontuacao as $key => $criterio){
                       if($key == sizeof($criteriosPontuacao)-1){
                        continue;
                       } 
                ?>
                <tr class="" style="height: 12px; ">
                    <td class="bordered size-8" style="padding-left: 2px;">
                        <?php echo ($criterio[0]['text']); ?>
                    </td>
                    <td class="bordered size-8 text-centered" >
                        <?php echo($criterio[1]['text']); ?>
                    </td> 
                </tr>
                <?php
                    }
                    
                ?>
                
                <tr class="" style="height: 12px; ">
                    
                    <td class="bordered size-8 text-right bold" style="padding-right: 2px;">
                        <?php echo $criterio[0]['text']; ?>
                    </td> 
                    <td class="bordered size-8 text-centered bold">
                        <?php echo $criterio[1]['text']; ?>
                    </td>  
                </tr>
        </table>
        
        <div class="rodape" style="">
            <div style="float:right; margin-right: 20mm; margin-bottom: 25mm;">
                <?php echo $assinaturaUsuario ?>
            </div>
        </div>
        <?php echo $carimboSistema_A4; ?>
    </div>