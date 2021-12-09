    
    
    var options = {
        bsgrid  :   [
            <?php echo ($idGridItems??NULL) ? '$(\'#'.$idGridItems.'\'),' : ''; ?>
        ],
        data    :   {
            'token'   :   "<?php echo $token??NULL  ?>",   
        }
    };
    
    
    _cadastros_init(options);