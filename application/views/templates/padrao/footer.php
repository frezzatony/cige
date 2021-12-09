<?php

/**
 * @author Tony Frezza

 */



?>  
    
    <div class="loading-insert softhide"></div>  
    <div class="modal" id="modal-template" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="pull-left">
                            
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-primary-outline btn-sm" data-dismiss="modal" href=""><i class="fa fa-times"></i></a>
                        </div>
                        
                        <h4 class="modal-title" id="defModalHead"></h4>
                    </div>
                    <div class="modal-body bg-gray">
                        
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-sm btn-3d btn-primary btn-cancel" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            echo $footerHtml ?? NULL;
        
        ?>
        
        <footer class="footer">
        
            <small class="text-left">
                PRODUÇÃO
                
            </small>
            <small class="pull-right flip">
                <?php
                
                    $html = new Html;
                    foreach(($footer['nodes'] ?? array()) as $key => $footerNode){
                        $html->add($footerNode);
                        
                        if($key < sizeof($footer['nodes'])-1){
                            $html->add(
                                array(
                                    'text'  =>  ' | '
                                )
                            );   
                        }
                    }
                    
                    echo $html->getHtml();
                ?>
                
            </small>
        </footer>
        
        
        <script type='text/javascript' src='<?php echo BASE_URL;?>assets/plugins/loadingoverlay/loadingoverlay.min.js'></script>
        <script type='text/javascript' src='<?php echo BASE_URL;?>assets/plugins/noty/jquery.noty.js'></script>
        <script type='text/javascript' src='<?php echo BASE_URL;?>assets/plugins/noty/layouts/all.js'></script>            
        <script type='text/javascript' src='<?php echo BASE_URL;?>assets/plugins/noty/themes/default.js'></script>    
        
        
        <script>
        //previne seleção via doubleclick
        document.ondblclick = function(evt) {
            if (window.getSelection)
                window.getSelection().removeAllRanges();
            else if (document.selection)
                document.selection.empty();
        }
        
            
var MK_configuration = {
    "theme":"black",
    "hint":true,
    "keyboard_shortcut":true,
    "is_rtl":false,
    "always_on_top":true
};

if( shortcuts_list == undefined ){
    var shortcuts_list = [];
}
var navmenu_shortcut_list = [];
shortcuts_list = $.merge( shortcuts_list, navmenu_shortcut_list );
        </script>
        
        <?php
            
            foreach(($js??array()) as $linkJs){
                if(!isset($linkJs['path'])) continue;
                
                
        ?>
<script type='text/javascript' src='<?php echo $linkJs['path'].'?v='.$system_version; ?>'></script>
        <?php    
            }
        ?>  
        
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/mainmenu.js"></script>       
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/app.js?v=<?php echo random_string('alnum',12);?>"></script>
        
        <script type="text/javascript">
                
            
            jQuery(window).ready(function() { 
            
            <?php
                echo $javascript ?? NULL;
            ?>
            
            
            });
            
        </script>
    </body>
</html>