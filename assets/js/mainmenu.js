$(document).ready(function() {
	$('.navbar-mainmenu .nav > li.dropdown').click(function(ev) {
		if ($(ev.target).parent().is(".dropdown-submenu")) {
			return false;
		}
		if (!$(this).is('.open')) { /*alinhamento do MENU*/
			x = $(this).offset().left;
			ul_w = $(this).find('ul:eq(0)').width();
			body_w = $('body').width();
			condition = ((x + ul_w) >= body_w);
			condition = (MK_configuration.is_rtl && !$(this).is(".right")) ? !condition : condition;
			if (condition) {
				$(this).find('ul:eq(0)').css({
					'left': 'inherit',
					'right': '0'
				});
			} else {
				$(this).find('ul:eq(0)').css({
					'left': '0',
					'right': 'inherit'
				});
			} /*fim alinhamento do MENU*/
			$(this).closest('.navbar-mainmenu').addClass('opened');
		}
	});
	$('.navbar-mainmenu .nav > li.dropdown').hover(function() {
		if ($(this).closest('.navbar-mainmenu').hasClass('opened') && !$(this).hasClass('open')) {
			$(this).closest('.navbar-mainmenu').find('.open').removeClass('open');
			$(this).addClass('open');
		}
	});
	$('button[data-toggle="collapse"]').on('click', function() {
		if ($('#collapse-navbar').is(".in")) $('#collapse-navbar').removeClass("in");
		else
		$('#collapse-navbar').addClass("in");
		return false;
	})
	$('.navbar-mainmenu .nav > li li.dropdown-submenu:has(ul)').hover(function() {
		x = $(this).offset().left + $(this).width();
		submenu = $(this).find('ul:eq(0)');
		ww = $(submenu).width();
		body_w = $('body').width();
		if ((x + ww) >= body_w) {
			$(submenu).css('left', -ww);
		}
	}).hover(function() {
		$(this).addClass('open');
	}, function() {
		$(this).removeClass('open');
	});
	jQuery('body').bind('click', function(e) {
		if (jQuery(e.target).closest('.navbar-mainmenu').length == 0) {
			$('.navbar-mainmenu').removeClass('opened');
		}
	});
    
    $('.btn-logout').bind('click',function(e){
        loading()
    })
    
});