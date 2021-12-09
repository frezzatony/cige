<?php

/**
 * @author Tony Frezza

 */

?>

<div class="navbar-mainmenu navbar-mainmenu-fixed-top ">
	<div class="navbar-mainmenu-inner ">
		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#collapse-navbar">
			<i class="fa fa-bars">
			</i>
		</button>
		<a href="<?php echo BASE_URL;?>" tabindex="-1" class="brand-up" style="width: 100%;">
		<img src="<?php echo BASE_URL;?>assets/img/logo-light.png" alt="CIGE" style="height:26px;">
		<span></span>
		</a>
		<div class="nav-collapse collapse accordion-body" id="collapse-navbar">
			<ul class="nav">
				<li class="dropdown">
					<a href="<?php echo BASE_URL;?>" tabindex="-1" class="brand">
					<img src="<?php echo BASE_URL;?>assets/img/logo-light.png" alt="CIGE" height="92%">
					<span></span>
					</a>
				</li>
				<?php echo $mainMenu ?? NULL; ?>
					<li class="dropdown right sis-notifications" title="Notifications">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
						<i class="fa fa-bell"></i>
						<span class="label-pill label-danger label" style="display: none">1</span>
						</a>
						<ul class="dropdown-menu">
							<li class="text-xs-center text-muted small">
								0 Notificações
							</li>
						</ul>
					</li>
			</ul>
		</div>
		<div style="clear:both;">
		</div>
	</div>
</div>
<div style="clear:both;">
</div>