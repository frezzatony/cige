<?php 

/**
 * @author Tony Frezza
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pathTemplate = 'templates/padrao/';


$breadcrumbData = array(
    'actionButtonsRight'    =>  $this->menus->getActionButtonsRight()
);

$this->load->view($pathTemplate.'breadcrumb',$breadcrumbData);
$this->load->view($pathTemplate.'abre_contents');
$this->load->view($pathTemplate.'contents');
$this->load->view($pathTemplate.'fecha_contents');



?>

<script type="text/javascript">
                
            
    jQuery(window).ready(function() { 
    
    <?php
        echo $javascript ?? NULL;
    ?>
    
    });
    
</script>