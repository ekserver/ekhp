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
		
		$posts = $db->from('topics')->select(array('topics.topic_status AS locked', 'topics.topic_time AS date', 'topics.topic_replies AS replies', 'posts.enable_bbcode', 'posts.post_subject AS headline', 'posts.post_text AS text'))
				  ->where('topics.forum_id', $this->forum_id)
				  ->join('posts', 'topics.topic_first_post_id = posts.post_id')
				  ->offset($start)
				  ->limit($limit)
				  ->order_by('posts.post_time DESC')
				  ->get()
				  ->result();
		
		// parse bbcode
		foreach($posts as &$post)
		{
			$post->text = preg_replace('#\[([^:]+):([a-z]:)?[A-Za-z0-9]{8}\]#', '[$1]', $post->text); // clean bbcode tags
			$post->text = preg_replace('#\[code\](.*)\[/code\]#i', '<div class="bbcode code"><small>Code:</small>$1</div>', $post->text);
			$post->text = preg_replace('#\[quote([^\]]+)?\](.*)\[/quote\]#i', '<div class="bbcode quote"><small>Zitat:</small>$2</div>', $post->text);
			$post->text = preg_replace('#\[b\](.*)\[/b\]#i', '<strong>$1</strong>', $post->text);
			$post->text = preg_replace('#\[i\](.*)\[/i\]#i', '<span style="font-style:italic">$1</span>', $post->text);
			$post->text = preg_replace('#\[u\](.*)\[/u\]#i', '<span style="text-decoration:underline">$1</span>', $post->text);
			$post->text = preg_replace('#\[img\](.*)\[/img\]#i', '<img src="$1" border="0" />', $post->text);
			$post->text = preg_replace('#\[url=([^]]+)\]([^[]+)\[/url\]#i', '<a href="$1">$2</a>', $post->text);
			$post->text = preg_replace('#\[color=\#([A-Fa-f0-9]+)\]([^[]+)\[/color\]#i', '<span style="color:#$1">$2</span>', $post->text);
			$post->text = preg_replace_callback('#\[list](.*)\[/list\]#msUi', array($this, 'handle_bbcode_list_u'), $post->text);
			$post->text = preg_replace_callback('#\[list=1](.*)\[/list\]#msUi', array($this, 'handle_bbcode_list_1'), $post->text);
			$post->text = preg_replace_callback('#\[list=a](.*)\[/list\]#msUi', array($this, 'handle_bbcode_list_a'), $post->text);
			
			$post->text = str_replace("\n", '<br />', $post->text);
		}
		
		return $posts;
	}
	
	private function handle_bbcode_list_u($list)
	{
		return $this->handle_bbcode_list($list, 'u');
	}
	
	private function handle_bbcode_list_1($list)
	{
		return $this->handle_bbcode_list($list, '1');
	}
	
	private function handle_bbcode_list_a($list)
	{
		return $this->handle_bbcode_list($list, 'a');
	}
	
	private function handle_bbcode_list($list, $type)
	{
		$list = $list[1];
		
		$result = '';
		
		if($type == 'u')
		{
			$result .= '<ul>';
		}
		elseif($type == '1')
		{
			$result .= '<ol style="list-style-type:decimal">';
		}
		elseif($type == 'a')
		{
			$result .= '<ol style="list-style-type:lower-alpha">';
		}
		
		$items = explode('[*]', $list);
		
		foreach($items as $item) 
		{
			$item = trim($item);
			$item = str_replace('[/*]', '', $item);
			
			if(empty($item)) continue;
			
			$result .= '<li>'.$item.'</li>';
		}
		
		if($type == 'u')
		{
			$result .= '</ul>';
		}
		elseif($type == '1' OR $type == 'a')
		{
			$result .= '</ol>';
		}
		
		return $result;
	}
}