<?php

/**
 * @author Tony Frezza

 */



?>


	<div class="card col-md-24 padding-top-6 padding-bottom-6 margin-top-4 nopadding">
		<div class="col-md-24 ">
            <div class="col-lg-12 nopadding">
                <div class="col-md-6 nopadding ">
                    <?php echo $htmlFormModulos;?>
                </div>
    			<div class="col-md-12 nopadding padding-top-17">
                    <button class="btn btn-primary btn-sm btn-3d btn-select-modulo">Selecionar</button>
                </div>
            </div>
            <div class="col-lg-12 nopadding">
                <div class="pull-right nopadding padding-top-17">
                    <button class="btn btn-success btn-sm btn-3d btn-save-menu"><i class="fa fa-save"></i>&nbsp;&nbsp;Salvar alterações</button>
                </div>
            </div>        
		</div>
	</div>
    
	<div class="col-md-24 padding-top-6 padding-bottom-6 margin-top-4 nopadding">
		<div class="col-md-11 nopadding">
			<div class="card ">
				<div class="card-header nopadding padding-left-6">
                	<i class="fa fa-bars margin-left-6 nomargin">
                	</i>
                	<span class="size-12">Itens do menu </span>
                </div>
				<div class="card-body">
					<ul id="myEditor" class="sortableLists list-group menu-editor">
					</ul>
				</div>
			</div>
		</div>
        <div class="col-md-1 nopadding">
        </div> 
            
			<div class="col-md-12 nopadding">
				<div class="card border-primary ">
					<div class="card-header nopadding padding-left-6 bg-primary">
                    	<i class="fa fa-pencil margin-left-6 nomargin">
                    	</i>
                    	<span class="size-12">Editar item </span>
                    </div>
					<div class="card-body">
                        <div  class="col-md-24 padding-top-10">
                        
                        <?php
                            echo $formEditNodes;
                        ?>
                        </div>
					</div>
					<div class="card-footer">
						<button type="button" id="btnUpdate" class="btn btn-primary btn-sm btn-3d" disabled>
							<i class="fa fa-refresh">
							</i>
							Atualizar nó
						</button>
						<button type="button" id="btnAdd" class="btn btn-success btn-sm btn-3d">
							<i class="fa fa-plus">
							</i>
							Adicionar como um novo nó
						</button>
					</div>
				</div>
			</div>
		
	</div>