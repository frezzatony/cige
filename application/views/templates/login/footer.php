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
                DESENVOLVIMENTO
                
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
        
        
        <script>
        
 
         
            
        </script>
    </body>
</html>