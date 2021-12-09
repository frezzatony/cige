<?php

/**
 * @author Tony Frezza
 */


$mask = new Mask;  
    
?>

    <div class="sheet nomargin padding-8mm" style="">
        <table class="size-13 width-100p" >
            
            <tr class="bordered ">
                <td class="" style="width: 20mm; padding: 1px; text-align: center; vertical-align: middle;">
                    <?php //echo $total_pagina??NULL; ?>
                </td>
                <td class=" text-centered " style="width: 174mm; padding: 1px; vertical-align: middle;">
                    <p class="nomargin size-14">
                        <strong><?php echo $periodo; ?></strong>
                    </p>
                </td>
                <td class="size-14 text-right" style="width: 20mm; padding-right: 4px;">
                    <?php echo $iniciais??NULL;?>
                </td>
            </tr>
        </table>
        
        <div style="height: 2mm;"></div>
        <?php 
              
            foreach($data as $key => $row){
                $bgClass = ($key%2 == 0) ? '' : 'bg-light-gray';
        ?>
         
        <table class="size-13 width-100p <?php echo $bgClass; ?>" >
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 30mm;">
                    <div class="label ">Data-Hora</div>
                    <div class="value text-right ">
                        <?php
                            echo formataDataHoraImprime(array('data'=>$row['data_falecimento'].' '.$row['hora_falecimento']));
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 110mm;">
                    <div class="label ">Nome falecido</div>
                    <div class="value bold">
                        <?php
                            echo strtoMAIsuculo($row['nome_falecido']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 10mm;">
                    <div class="label ">Idade</div>
                    <div class="value ">
                        <?php
                            echo ($row['idade_falecido']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: ;">
                    <div class="label ">Situação</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($row['situcao_tumulo']);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        <table class="size-13 width-100p no-top <?php echo $bgClass; ?>">
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 50%;">
                    <div class="label ">Nome mãe falecido</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($row['nome_mae_falecido']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: ">
                    <div class="label ">Nome pai falecido</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($row['nome_pai_falecido']);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        <table class="size-13 width-100p no-top <?php echo $bgClass; ?>">
            <tr class="" style="height: 27px;">
                <td class="bordered" style="width: 40mm;">
                    <div class="label ">Cemitério</div>
                    <div class="value ">
                        <?php
                            echo strtoMAIsuculo($row['cemiterio']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 18mm; ">
                    <div class="label ">Quadra</div>
                    <div class="value text-right">
                        <?php
                            echo strtoMAIsuculo($row['quadra']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 18mm; ">
                    <div class="label ">Fileira</div>
                    <div class="value text-right">
                        <?php
                            echo strtoMAIsuculo($row['fileira']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 18mm; ">
                    <div class="label ">Sepultura</div>
                    <div class="value text-right">
                        <?php
                            echo strtoMAIsuculo($row['sepultura']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 24mm; ">
                    <div class="label ">Termo Cert. Óbito</div>
                    <div class="value text-right">
                        <?php
                            echo strtoMAIsuculo($row['termo_certidao_obito']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 25mm; ">
                    <div class="label ">Folhas Cert. Óbito</div>
                    <div class="value text-right">
                        <?php
                            echo strtoMAIsuculo($row['folhas']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: 25mm; ">
                    <div class="label ">Livro Cert. Óbito</div>
                    <div class="value text-right">
                        <?php
                            echo strtoMAIsuculo($row['livro']);
                        ?>
                    </div>
                </td>
                <td class="bordered" style="width: ; ">
                    <div class="label ">Caixa Arquivo</div>
                    <div class="value text-right">
                        <?php
                            echo strtoMAIsuculo($row['caixa_arquivo']);
                        ?>
                    </div>
                </td>
                
            </tr>
        </table>
        <div style="height: 1mm;"></div>
        <?php
            }
        ?>
        
        
        </table>
        
        <?php echo $carimboSistema_A4; ?>
    </div>