<?php

class News extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_news($start, $limit)
	{
		// fetch posts
		$this->config->load('phpbb', TRUE);
		$db = $this->load->database($this->config->item('db_group', 'phpbb'), TRUE);
		
		$posts = $db->from('topics')
				  ->select(array('topics.topic_status AS locked', 'topics.forum_id', 'topics.topic_id', 'topics.topic_time AS date', 'topics.topic_replies AS replies', 'posts.enable_bbcode', 'posts.post_subject AS headline', 'posts.post_text AS text'))
				  ->where('topics.forum_id', $this->config->item('news_forum_id', 'phpbb'))
				  ->join('posts', 'topics.topic_first_post_id = posts.post_id')
				  ->offset($start)
				  ->limit($limit)
				  ->order_by('posts.post_time DESC')
				  ->get()
				  ->result();
		
		// parse bbcode
		$this->load->library('phpbb');
		
		foreach($posts as &$post)
		{
			if($post->enable_bbcode)
			{
				$this->phpbb->parse_bbcode($post->text);
			}
		}
		
		return $posts;
	}
}