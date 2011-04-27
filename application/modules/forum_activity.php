<?php

class Forum_activity_Module extends EK_Module
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->model('forum_post');
		
		$this->data['posts'] = $this->forum_post->get_posts(5);
		
		$this->load->helper('text');
		
		foreach($this->data['posts'] as &$post)
		{
			$post->subject_short = character_limiter($post->subject, 20);
		}
		
		$this->display('forum_activity');
	}
}
