<div id="teaserbox">
	<ul>
		<li><a href="#"><img src="<?=base_url()?>assets/images/teaserbox/ekpoints.jpg" border="0" alt="EK-Points" /></a></li>
		<li><a href="#"><img src="<?=base_url()?>assets/images/teaserbox/ekpoints.jpg" border="0" alt="EK-Points" /></a></li>
		<li><a href="#"><img src="<?=base_url()?>assets/images/teaserbox/ekpoints.jpg" border="0" alt="EK-Points" /></a></li>
		<li><a href="#"><img src="<?=base_url()?>assets/images/teaserbox/ekpoints.jpg" border="0" alt="EK-Points" /></a></li>
	</ul>
	<ul id="navigation">
		<li>1</li>
		<li>2</li>
		<li>3</li>
		<li>4</li>
	</ul>
</div>

<script src="<?=base_url()?>assets/scripts/jquery.jcarousel.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
	$('#teaserbox').jcarousel({
		scroll: 1,
		auto: 4,        
		wrap: 'last',
		initCallback: function(carousel)
		{
			$('#teaserbox #navigation li').bind('click', function() {
				carousel.scroll($.jcarousel.intval($(this).text()));
				
				return false;
			});
			
			carousel.clip.hover(function() {
				carousel.stopAuto();
			}, function() {
				carousel.startAuto();
			});
		},
		itemVisibleInCallback: { onBeforeAnimation: function(carousel, li, index) 
		{
			index--;
			$('#teaserbox #navigation li').slice(index, index+1).addClass('selected');
		}},
		itemVisibleOutCallback: { onBeforeAnimation: function(carousel, li, index) 
		{
			index--;
			$('#teaserbox #navigation li').slice(index, index+1).removeClass('selected');
		}},
		buttonNextHTML: null,
		buttonPrevHTML: null
	});
/* ]]> */
</script>

<div id="news" class="accordion-box">
	<?foreach($news as $entry):?>
		<h2><b></b><small><?=date('d.m.y', $entry->date)?></small><?=$entry->headline?></h2>
		<div>
			<?=$entry->text?>
		</div>
	<?endforeach?>
</div>
<div style="clear: both"></div>

<br />
<div style="text-align: right"><a href="#" class="button">Newsarchiv</a></div>

<script type="text/javascript">
/* <![CDATA[ */
	$(document).ready(function()
	{
		$('#news').accordion(true);
	});
/* ]]> */
</script>