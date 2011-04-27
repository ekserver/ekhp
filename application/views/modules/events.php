<?=$calendar?><br />
<div style="text-align:right"><a href="<?=site_url('events')?>" class="button">Mehr</a></div>

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