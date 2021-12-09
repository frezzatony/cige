<?php 

/**
 * @author Tony Frezza
 * @copyright 2015
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo $contents;

?>


<script type="text/javascript">
                
            
    jQuery(window).ready(function() { 
    
    <?php
        echo $javascript ?? NULL;
    ?>
    });
    
</script>