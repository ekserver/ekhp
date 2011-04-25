<?php

class News extends CI_Model
{
	private $forum_id = 3;
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_news($start, $limit)
	{
		// fetch posts
		$db = $this->load->database('phpbb', TRUE);
		
		$posts = $db->from('topics')->select(array('topics.topic_status AS locked', 'topics.topic_time AS date', 'topics.topic_replies AS replies', 'posts.enable_bbcode', 'posts.post_subject AS headline', 'posts.post_text AS text', 'posts.bbcode_bitfield'))
				  ->where('topics.forum_id', $this->forum_id)
				  ->join('posts', 'topics.topic_first_post_id = posts.post_id')
				  ->offset($start)
				  ->limit($limit)
				  ->order_by('posts.post_time DESC')
				  ->get()
				  ->result();
		
		/*
		// parse bbcode
		define('IN_PHPBB', TRUE);
		$phpbb_root_path = './forum/';
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		include($phpbb_root_path.'common.'.$phpEx);
		include($phpbb_root_path.'includes/functions_display.'.$phpEx);
		include($phpbb_root_path.'includes/bbcode.'.$phpEx);
		
		foreach($posts as &$post)
		{
			$bbcode_bitfield = '';
			$bbcode_bitfield = $bbcode_bitfield | base64_decode($post->bbcode_bitfield);
			unset($post->bbcode_bitfield);
			
			
			if($bbcode_bitfield !== '')
			{
				$bbcode = new bbcode(base64_encode($bbcode_bitfield));
			}
			
			$post->text = censor_text($post->text);
			
			if($row['bbcode_bitfield'])
			{
				$bbcode->bbcode_second_pass($post->text, $row['bbcode_uid'], $row['bbcode_bitfield']);
			}
			
			$post->text = str_replace("\n", '<br />', $post->text);
			$post->text = smiley_text($post->text);
		}
		*/
		
		return $posts;
	}
}