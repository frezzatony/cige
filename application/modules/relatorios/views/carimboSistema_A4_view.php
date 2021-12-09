<?php

/**
 * @author Tony Frezza
 */



?>

    <div class="carimbo_sistema_A4">
        <?php echo $system_name; ?> (<?php echo $system_version;?> ) | 
        <?php echo $empresa; ?> |
        Gerado em: <?php echo formataDataHoraImprime(['data'=>NOW]); ?> |
        Usuário: <?php echo nomePessoa($arrUser['nome']);?>.
    </div>