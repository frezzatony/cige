<?php

/**
 * @author Tony Frezza
 */


    
    
?>

<div id="form-print-consulta" class="card col-md-24 padding-top-10 bsform">

    <div class="bsform-input bsform-parent col-lg-24 col-xs-24 col-md-24 col-sm-24 nopadding padding-bottom-4" data-input="textbox">					
		<div class="col-md-6 nopadding nomargin padding-right-4 text-right">
            <label for="titulo">Título:</label>
        </div>
        <div class="col-md-18 nopadding nomargin">
            <input type="text" id="titulo" class="form-control input-sm padding-3 size-11" value="<?php echo $titulo; ?>" autocomplete="off"  />
        </div>
	</div>
 
    <div class="bsform-input bsform-parent col-lg-24 col-xs-24 col-md-24 col-sm-24 nopadding padding-bottom-4" data-input="dropdown">					
		<div class="col-md-6 nopadding nomargin padding-right-4 text-right">
            <label for="orientacao">Orientação:</label>
        </div>
        <div class="col-md-18 nopadding nomargin">
            <select id="orientacao" value="" class="form-control padding-3 size-11 input-sm">							
				<option value="retrato">Retrato</option>
                <!-- <option value="paisagem">Paisagem</option> -->
			</select>
        </div>
	</div>
 
    <div class="bsform-input bsform-parent col-lg-24 col-xs-24 col-md-24 col-sm-24 nopadding padding-bottom-4" data-input="dropdown">					
		<div class="col-md-6 nopadding nomargin padding-right-4 text-right">
            <label for="cabecalho">Cabeçalho/rodapé:</label>
        </div>
        <div class="col-md-18 nopadding nomargin">
            <select id="cabecalho_rodape" value="" class="form-control padding-3 size-11 input-sm">							
				<option value="padrao">Padrão</option>
			</select>
        </div>
	</div>
    
    <div class="bsform-input bsform-parent col-lg-24 col-xs-24 col-md-24 col-sm-24 nopadding padding-bottom-4" data-input="dropdown">					
		<div class="col-md-6 nopadding nomargin padding-right-4 text-right">
            <label for="cabecalho">Formato:</label>
        </div>
        <div class="col-md-18 nopadding nomargin">
            <select id="formato" name="formato" value="" class="form-control padding-3 size-11 input-sm">							
				<option value="html">Página web</option>
                <option value="PDF">PDF</option>
                <option value="XLS">XLS</option>
                <!-- <option value="CSV">CSV</option> -->
			</select>
        </div>
	</div>
    
    
    
    <div class="bsform-input bsform-parent col-lg-24 col-xs-24 col-md-24 col-sm-24 nopadding padding-bottom-4" data-input="checkbox">
        <div class="col-md-6 nopadding nomargin padding-right-4 margin-top-4 size-11 text-right">
            Imprimir zebrado:
        </div>
        <div class="col-md-18 nopadding nomargin margin-bottom-6">
            <div class="checkbox checkbox-xs">															
				<label>																
					<input id="imprimir_zebrado" type="checkbox" data-value="1" value="" autocomplete="off" class="input-sm form-control" />
					<i class="fa fa-lg icon-checkbox"></i>
            </label>
        </div>
    </div>
    
        
    <?php
        
        $htmlColumns = '';
        
        foreach($colunas as $column){
            
            $widthColumn = ($key<(sizeof($colunas)-1)) ? ($column['width']??NULL) : '';
            
            $columnId = ($column['id']??random_string());
            
            $htmlColumns .= '<th id="'.$columnId.'" width="'.$widthColumn.'%" class="bordered bg-white text-centered" style="font-weight: normal; cursor: pointer; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; ">';
            $htmlColumns .= '<div class="column-label width-100p">'.$column['text'].'</div>';
            $htmlColumns .= '</th>';
            $htmlColumns .= '
                <div class=" softhide painel-propriedades-coluna nopadding " id="tooltip_'.$columnId.'">
                    <div class="col-lg-24 nopadding nomargin padding-top-4 padding-bottom-4">
                        <button data-id-parent="'.$columnId.'" class="btn btn-secondary btn-sm size-9 btn-remove-col">Remover</button>  
                    </div>
                </div>
            ';            
        }  
    ?>
    
    <?php
        $bootstrap = new Bootstrap;
        $bootstrap->accordion(
        array(
            'nodes'     =>  array(
                
                array(
                    'header'    =>  array(
                        'title' =>  'Colunas da consulta - Dimensionar e ordenar',
                        'class' =>  array('size-12','bold'),
                        'active'    =>  TRUE,
                    ),
                    'content'   =>  array(
                        'active'    =>  TRUE,
                        'class'     =>  array('padding-4','','bg-white'),
                        'text'      =>  ' <table class="tableColunasRelatorio" width="100%" border="0" cellpadding="0" cellspacing="0">
                			<tr class="header size-10 text-centered" style="">
                				
                                '.$htmlColumns.'
                			</tr>
                																				
                		</table>',
                            
                        )
                    ),
                   
                )  
            )
        );
    
        echo $bootstrap->getHtml();
    
        
    ?>
        <div class="container-fluid margin-bottom-10"></div>
        
        
        <script>
            
            
    $(document).ready(function() {
        
        
        var tableProps =  function(){
            
            $(".tableColunasRelatorio").colResizable({
                disable: true,
            });
            
            $(".tableColunasRelatorio").colResizable({
                liveDrag:true,   
                resizeMode:'fit'
            });
        
        };
        
        tableProps();
        
        $(".tableColunasRelatorio tr.header").sortable({
            axys: 'x',
            stop: function(evt, ui) {
                
                tableProps();   
            }
        });
                
        $('.tableColunasRelatorio tr.header th .column-label')
            .popover({ 
                trigger: "manual",
                    html        :   true,
                    placement   :   'top',
                    animation   :   false,
                    content     :   function(){
                        var column = $(this).closest('th');
                        
                        return $('#tooltip_'+column.attr('id')).html();
                    },
            })
            .on('shown.bs.popover', function (eventShown) {
                var $popup = $('#' + $(eventShown.target).attr('aria-describedby'));
                                
                $popup.find('button.btn-remove-col').click(function (e) {
                    $(eventShown.target).closest('th').remove();
                    $popup.popover('hide');
                    tableProps();  
                });
                
                
            })
            .on("mouseenter", function () {
                            
                var _this = this;
                $(this).addClass('bg-light-gray');
                $(this).popover("show");
                
                $(".popover").on("mouseleave", function () {
                    $(_this).removeClass('bg-light-gray');
                    $(_this).popover('hide');
                });
                
            })
            .on("mouseleave", function () {
                var _this = this;
                
                $(this).removeClass('bg-light-gray');
                
                setTimeout(function () {
                    if (!$(".popover:hover").length) {
                        $(_this).popover("hide");
                    }
                    else{
                        $(_this).addClass('bg-light-gray');
                    }
                    
                }, 10);
            })
            
        
        $('.btn-print-relatorio').bind('click',async function(e){
           
            e.preventDefault();
            
            
           
            var data = $('#form-print-consulta').eq(0).bsform({'method':'getSimpleValues'});
            data.token = '<?php echo $token ?>';
            data.filters = $('#<?php echo $bsgrid; ?>').bsgrid({'method':'getOptions'}).filters;
            data.order = [$('#<?php echo $bsgrid; ?>').bsgrid({'method':'getOrder'})];
           
           
            var getColumns = function(){
                            
                var columns = $('.tableColunasRelatorio').eq(0).find('tr.header th');
                
                var totalWidth = 0
                
                columns.each(function(index,item){
                    var column = $(this);
                    totalWidth += parseFloat(column.width());
                }); 
                
                var dataReturn = new Array();
                
                columns.each(function(index,item){
                    var column = $(this);
                    dataReturn.push({
                       'id'     :   column.attr('id'),
                       'width'  :   parseFloat(parseFloat(parseFloat(column.width())/totalWidth)*100).toFixed(2), 
                        
                    });
                }); 
                
                
                return dataReturn;
                
            }
           
            data.columns = getColumns();
            
            _redirect({
                url     :   BASE_URL+'relatorios/default/consulta/print',
                method  :   'POST',
                target  :   '_blank',
                values  :   data,
            });
            
            $(this).closest('div.modal').eq(0).modal('hide');
        });
       
        
    });
</script>


    
</div>