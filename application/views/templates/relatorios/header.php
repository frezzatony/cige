<?php

/**
 * @author Tony Frezza

 */


?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>        
        
        <meta name="author" content="Tony Frezza" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo BASE_URL;?>assets/img/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASE_URL;?>assets/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL;?>assets/img/favicon-16x16.png">
        <link rel="manifest" href="<?php echo BASE_URL;?>assets/img/site.webmanifest">
                        
        <script type="text/javascript">var BASE_URL = '<?= BASE_URL?>';</script>       
        <script type="text/javascript">var plugin_path = '<?= BASE_URL?>assets/plugins/';</script>
        <script type="text/javascript">var css_path = '<?= BASE_URL?>assets/css/';</script>

        <title>CIGE | Relatório</title>
        
        
        <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/reset.css">
        <link rel="stylesheet" href="<?php echo BASE_URL?>assets/plugins/paper-css/paper.css">
        <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/utils.css">
        <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/print.css">
        
        <!-- Set page size here: A5, A4 or A3 -->
        <!-- Set also "landscape" if you need -->
        <style>@page { size: A4 }</style>
        
        <?php
            if(($pdf??NULL) ){
        ?>
            <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/print_pdf.css">
        <?php
        
            }
        ?>
        
                                                      
    </head>
    <style>
        
    </style>
    <body class="A4">
        
                
