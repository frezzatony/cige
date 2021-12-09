    
    jQuery(window).ready(function(){
        
        var inputContainer = <?php echo ($idInputContainer??NULL) ? '$(\'input#'.$idInputContainer.'\').eq(0)' : '$(\'input.container-cadastro\').eq(0)'; ?>;
        var modalParent = inputContainer.closest('div.modal').eq(0);
        
        var options = {
            'container'   :   modalParent,
            data          : {
                'token' :   '<?php echo $token??NULL; ?>',
                
            }
        };
        
        _cadastros_initItem(options);
        
    }); 