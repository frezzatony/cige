<?php

/**
 * @author Tony Frezza
 */


	

?>
<div class="container-fluid bordered margin-2 bg-white padding-bottom-10">
    <form>
        <label>Escolha um template:</label>
        <select id="changeTemplate" class="form-control input-sm padding-3 size-11 height-24 ">							
			<option value="0" >Em branco</option>
            <option value="1" >Smartphone</option>
		</select>
    </form>
</div>

<script type="text/javascript">
    
    jQuery(window).ready(function(){
        
        $('button.btn-change-template').bind('click',function(e){
            var _t = $(this);
            var container = _t.closest('div.modal').eq(0);
            var selectTipo = container.find('select#changeTemplate');
            
            loading();
            container.modal('hide');
            _cadastros_editItem({
                url:    '<?php echo $url_new_item; ?>'+'/tipo/'+selectTipo.val(),
            })
                
        });
        
    });

</script>