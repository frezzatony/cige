<?php

/**
 * @author Tony Frezza

 */

$pathTemplate = 'templates/padrao/';

?>

<div id="header-page">
        <div style="height: 26px; border-bottom: 1px solid #d1d4d7; background-color: #F9F9F9; ">
            <div class="col-xs-20 col-md-12 ">
                <?php 
                    echo $breadcrumb; 
                ?>
            </div>
            <div class="col-xs-4 col-md-12">
                <div class="pull-right">
                     <?php       
                        echo $actionButtonsRight ?? NULL;      
                    ?>
                </div>
            </div>
        </div>
        
    </div>
