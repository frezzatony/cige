<?php 

/**
 * @author Tony Frezza
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<script type="text/javascript">
jQuery(window).ready(function() {
<?php echo $javascript ?? NULL; ?>
<?php echo $contents ?? NULL; ?>
        
});
</script>