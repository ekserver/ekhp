// custom fadeIn/Out for IE (fixes cleartype glitch)
(function($) {
	$.fn.customFadeIn = function(speed, callback) {
		$(this).fadeIn(speed, function() {
			if(jQuery.browser.msie)
				$(this).get(0).style.removeAttribute('filter');
			if(callback != undefined)
				callback();
		});
	};
	$.fn.customFadeOut = function(speed, callback) {
		$(this).fadeOut(speed, function() {
			if(jQuery.browser.msie)
				$(this).get(0).style.removeAttribute('filter');
			if(callback != undefined)
				callback();
		});
	};
})(jQuery);


// maffis accordion :):)
(function($) {
	$.fn.accordion = function(first) 
	{
		var obj = $(this);
		
		obj.children('h2').click(function() 
		{
			obj.children('h2').removeClass('active');
			obj.children('h2 + div').slideUp('normal');
			
			if($(this).next().is(':hidden') == true) 
			{
				$(this).addClass('active');
				$(this).next().slideDown('normal');
			} 
			
		});
		
		obj.children('h2 + div').hide();
		
		if(first == true || typeof first == 'undefined')
		{
			obj.children('h2:first-child').addClass('active').next('div').show();
		}
	};
})(jQuery);

// various init routines required on all pages
$(document).ready(function()
{
	// preload images
	var images = ['topmenu-mid.png', 'topmenu-left.png', 'topmenu-right.png', 'topmenu-dropdown-mid.png', 'topmenu-dropdown-left.png', 'topmenu-dropdown-right.png', 'topmenu-dropdown-pane.png', 'account-erstellen-hover.png', 'topmenu-dropdown-pane-input-hover.png', 'anmelden-hover.png'];
	
	for(i=0; i < images.length; i++)
	{
		$('<img src="/media/images/' + images[i] + '" />');
	}
	
	// add stylable element for rounded corner (main menu)
	$('#header ul li > a, #header ul li.dropdown > span').each(function()
	{
		$(this).after('<b></b>');
	});
	
	// serverstatus slider
	$('#server-status > div').hide();
	$('#server-status > div:first-child').show();
	
	function slideNext()
	{
		$('#server-status > div:visible').animate({ 'margin-top': '-15', opacity: 0.0 }, 500, function()
		{
			$('#server-status > div:hidden').customFadeIn(500);
			
			$(this).hide();
			$(this).css({ 'margin-top': 0, opacity: 1 });
		});
		
		window.setTimeout(slideNext, 6000);
	}
	
	window.setTimeout(slideNext, 6000);
});