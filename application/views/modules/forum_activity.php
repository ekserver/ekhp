<table width="100%">
<?foreach($posts as $post):?>
		<tr>
			<td width="60%"><img src="<?=base_url()?>assets/images/talk_icon.png" alt="" style="vertical-align:-4px" /> <a href="<?=$this->config->item('url', 'phpbb')?>viewtopic.php?f=<?=$post->forum_id?>&t=<?=$post->topic_id?>" title="<?=$post->subject?>"><?=$post->subject_short?></a></td>
			<td align="right"><?=date('d.m.y - H:i', $post->date)?></td>
		</tr>
		<tr>
			<td colspan="2" class="alt">von <a class="white" href="<?=$this->config->item('url', 'phpbb')?>memberlist.php?mode=viewprofile&u=<?=$post->user_id?>"><?=$post->username?></a></td>
		</tr>
<?endforeach?>
</table>