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

// accordion
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

// collapsable tables
(function($) {
	$.fn.collapsable = function()
	{
		var root = $(this);
		var row = root.find('tr:first-child').next();
		
		root.find('tr:first-child th').click(function()
		{
			if(row.css('display') == 'none' || root.hasClass('collapsed'))
			{
				root.removeClass('collapsed');
				row.show();
			}
			else
			{
				row.hide();
				root.addClass('collapsed');
			}
		});
	};
})(jQuery);

// tooltip
(function($) {
	$.fn.tooltip = function(text)
	{
		var tooltip = $('<div class="tooltip">' + text + '</div>');
		var pos = $(this).position();
		
		tooltip.css('top', pos.top + $(this).height());
		tooltip.css('left', pos.left + $(this).width());
		
		$('body').prepend(tooltip);
		
		$(this).hover(function()
		{
			tooltip.fadeIn();
		},
		function()
		{
			tooltip.hide();
		});
	};
})(jQuery);

// select text on any element (ty: http://wanderwort.de/2009/11/19/select-any-html-text-in-element-with-jquery/)
jQuery.fn.extend({
  selectText: function() {
    var text = $(this)[0];
    if ($.browser.msie) {
      var range = document.body.createTextRange();
      range.moveToElementText(text);
      range.select();
    } else if ($.browser.mozilla || $.browser.opera) {
      var selection = window.getSelection();
      var range = document.createRange();
      range.selectNodeContents(text);
      selection.removeAllRanges();
      selection.addRange(range);
    } else if ($.browser.safari) {
      var selection = window.getSelection();
      selection.setBaseAndExtent(text, 0, text, 1);
    }
    return $(this);
  }
});

// various init routines required on all pages
$(document).ready(function()
{
	// preload images
	var images = ['topmenu-mid.png', 'topmenu-left.png', 'topmenu-right.png', 'topmenu-dropdown-mid.png', 'topmenu-dropdown-left.png', 'topmenu-dropdown-right.png', 'topmenu-dropdown-pane.png', 'account-erstellen-hover.png', 'topmenu-dropdown-pane-input-hover.png', 'anmelden-hover.png', 'accordion-title-hover.png', 'button-bg-hover.png', 'teaserbox/navi-hover.png'];
	
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