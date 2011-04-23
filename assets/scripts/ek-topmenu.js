$(document).ready(function()
{
	$('#header ul li > a, #header ul li.dropdown > span').each(function()
	{
		// add stylable element for rounded corner
		$(this).after('<b></b>');
	});
});