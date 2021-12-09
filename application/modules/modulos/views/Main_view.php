    
    <?php
        if($actionMenu ?? FALSE){
    ?>
    <div class="card col-md-24 padding-top-6 padding-bottom-6 margin-top-4 nopadding cadastro-actionmenu">
        <?php
            echo $actionMenu;
        ?>
    </div>
    <?php
        }
        else{
            $htmlFiltroClass = 'margin-top-6';
        }
    ?>
    
    <?php
        if($htmlFiltro ?? FALSE){
    ?>
    <div class="card filter cadastro-filter <?php echo $htmlFiltroClass??NULL;?>">
        <?php
            echo $htmlFiltro;
        ?>          
    </div>
    <?php
        }
    ?>
    
    <?php
        if($htmlGrid ?? FALSE){
    ?>
    <div class="margin-top-10 card cadastro-griditems">
            <?php
                echo  $htmlGrid;
            ?> 
    </div>
    
     <?php
        }
    ?>