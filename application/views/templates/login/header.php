<?php

/**
 * @author Tony Frezza

 */



?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>        
        
        <title><?php echo $system_alias.' - Gestão Digital' ?></title>            
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
              
        
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/style.css?v=<?php echo random_string(); ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/utils.css?v=<?php echo random_string(); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/assets/css/login.css?v=<?php echo random_string(); ?>">       
        
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/plugins/bootstrap/bootstrap.min.js"></script>
        
        
        <?php
            
            foreach(($css??array()) as $linkCss){
                if(!isset($linkCss['path'])) continue;
        ?>
<link rel="<?php echo $linkCss['rel'] ?? 'stylesheet';?>" type="<?php echo $linkCss['type'] ?? 'text/css'; ?>" id="<?php echo $linkCss['id'] ?? NULL; ?>" href="<?php echo $linkCss['path'] ?? 'text/css'; ?>"/>
        <?php    
            }
        ?>
        
        
                                                      
    </head>
    <body dir="ltr">

     
