<?php

class Forum_activity extends EK_Module
{
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
