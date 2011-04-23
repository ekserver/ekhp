$(document).ready(function()
{
	$('#header ul li > a, #header ul li.dropdown > span').each(function()
	{
		$(this).html('<div class="left"></div>' + $(this).html() + '<div class="right"></div>');
	});
});