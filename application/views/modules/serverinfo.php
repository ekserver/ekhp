<table width="100%">
	<tr>
		<th>Realmlist</th>
	</tr>
	<tr>
		<td class="alt">
			<div class="bbcode quote" id="realmlist">set realmlist eternal-knights.net</div>
		</td>
	</tr>
</table>
<br />

<table width="100%" id="lumion-info" class="collapsable collapsed">
	<tr>
		<th>Realminfos: Lumion</th>
	</tr>
	<tr>
		<td class="alt">
			hier könnten die rates usw. stehen.
		</td>
	</tr>
</table>
<br />

<table width="100%" id="psy-info" class="collapsable collapsed">
	<tr>
		<th>Realminfos: Psy</th>
	</tr>
	<tr>
		<td class="alt">
			hier könnten die rates usw. stehen.
		</td>
	</tr>
</table>

<script type="text/javascript">
/* <![CDATA[ */
	
	$(document).ready(function()
	{
		// auto select realmlist on click
		$('#realmlist').click(function()
		{
			$(this).selectText();
		});
		
		// set up collapsable tables
		$('#lumion-info').collapsable();
		$('#psy-info').collapsable();
	});
	
/* ]]> */
</script>