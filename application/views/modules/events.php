<?=$calendar?>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#event-calendar td > div').each(function()
		{
			if($(this).hasClass('event'))
			{
				$(this).tooltip($(this).children('div').html());
			}
			else if($(this).hasClass('today'))
			{
				$(this).tooltip('Heute (keine Events)');
			}
		});
	});
</script>