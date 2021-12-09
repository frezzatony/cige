<?php

    echo $htmlFooterButtons ?? NULL;

?>



<script>
$(function(e){
    
    $('#bsform-change-password').bsform({
        'doneSave': function(){
            $('.bsform-change-password').parents('.modal').modal('hide');     
        }   
    });
});
</script>