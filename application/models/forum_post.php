<?php

class Forum_post extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_posts($limit = 5)
	{
		$this->config->load('phpbb', TRUE);
		$db = $this->load->database($this->config->item('db_group', 'phpbb'), TRUE);
	
		return $db->from('posts')
				  ->select(array('posts.topic_id', 'posts.forum_id', 'posts.post_subject AS subject', 'users.username', 'users.user_id', 'posts.post_time AS date'))
				  ->join('users', 'posts.poster_id = users.user_id')
				  ->order_by('posts.post_time DESC')
				  ->limit($limit)
				  ->get()
				  ->result();
	}
}
