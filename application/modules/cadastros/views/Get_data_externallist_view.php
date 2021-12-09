
<div class="">
        <?php
            $idContainerInput = random_string();
        ?>
        <input type="hidden" id="<?php echo $idContainerInput; ?>" />
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
        ?>
        
        
        <?php
            if($htmlFiltro ?? FALSE){
        ?>
        <div class="card filter margin-bottom-10">
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
        <div class="card nomargin">
                <?php
                    echo  $htmlGrid;
                ?> 
        </div>
        
         <?php
            }
            
            echo $externallist_input_text_search ?? NULL;
        ?>
</div>

<script type="text/javascript">
    
    jQuery(window).ready(function() { 
        
        
        var idContainerInput = "<?php echo $idContainerInput; ?>";
        var container = $('input#'+idContainerInput).closest('div.modal-externallist');
        
        var bsgridItems = [];
        container.find('div.grid-items-cadastro').each(function(){
           bsgridItems.push($(this)) 
        });
        
        
        var options = {
            'container'     :   container,
            'bsgrid'        :   bsgridItems,
        }
        
        _cadastros_init(options);
        
    });
    
</script>