    
    
    console.log('Carregando modal por solicitação da url...');
        
    var modalClone = $("#modal-template").clone();
    var url = '<?php echo $url;?>';
    var data = {
        
    };
    
    _loadModal({
        'data'      :   data,
        'method'    :   'POST',
        'container' :   modalClone,
        'url'       :   url,
    });   