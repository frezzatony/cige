<?php

/**
 * @author Tony Frezza
 */


$mask = new Mask;
        
    
?>

    <div class="sheet nomargin padding-4mm">
        <table class="size-13 width-100p" >
            
            <tr class="bordered ">
                <td class="" style="width: 10mm; padding: 1px; text-align: center; vertical-align: middle;">
                    
                </td>
                <td class=" text-centered " style="width: 174mm; padding: 1px; vertical-align: middle;">
                    <p class="nomargin size-14">
                        <strong><?php echo $periodo; ?></strong>
                    </p>
                </td>
                <td class="" style="width: 10mm;">
                    
                </td>
            </tr>
        </table>
        
         <div style="height: 2mm;"></div> 
         
        <table class=" width-100p" >
            
            <tr class="bordered ">
                <td class="bordered" style="width: 23mm; font-size: 7pt; text-align: center; font-weight: bold; ">
                    DATA - HORA
                </td>
                <td class="bordered" style="width: 70mm; font-size: 7pt; text-align: center; font-weight: bold;">
                    NOME FALECIDO 
                </td>
                <td class="bordered" style="width: 70mm; font-size: 7pt; text-align: center; font-weight: bold;">
                    NOME FALECIDO 
                </td>
                <td class="bordered" style="width: 70mm; font-size: 7pt; text-align: center; font-weight: bold;">
                    NOME FALECIDO 
                </td>
                <td class="bordered" style="font-size: 6pt; padding: 2px;">
                    
                </td>
            </tr>
            <?php 
                

                array_multisort($data, SORT_DESC, array_column($data,'nome_falecido'));
                
                foreach($data as $row){
            ?>
            <tr class="bordered ">
                <td class="bordered" style="font-size: 7pt; padding: 2px; text-align: center;">
                    <?php echo formataDataHoraImprime(array('data'=>$row['data_falecimento'].' '.$row['hora_falecimento']));?>
                </td>
                <td class="bordered" style="font-size: 6pt; padding: 2px;">
                    NATIMORTO FILHA DE TATYANE BENJAMIN DOS SANTO DE LIMA
                </td>
                <td class="bordered" style="font-size: 6pt; padding: 2px;">
                    <?php echo $row['nome_falecido']; ?>
                </td>
                <td class="bordered" style="font-size: 6pt; padding: 2px;">
                    NATIMORTO FILHA DE TATYANE BENJAMIN DOS SANTO DE LIMA
                </td>
                <td class="bordered" style="font-size: 6pt; padding: 2px;">
                    
                </td>
            </tr>
            
            <?php
                }
            ?>
            
        </table>
    </div>