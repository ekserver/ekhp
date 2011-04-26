<?php

class Phpbb
{
	public function parse_bbcode(&$text)
	{		
		$text = preg_replace('#\[([^:]+):([a-z]:)?[A-Za-z0-9]{8}\]#', '[$1]', $text); // clean bbcode tags
		$text = preg_replace('#\[code\](.*)\[/code\]#i', '<div class="bbcode code"><small>Code:</small>$1</div>', $text);
		$text = preg_replace('#\[quote([^\]]+)?\](.*)\[/quote\]#i', '<div class="bbcode quote"><small>Zitat:</small>$2</div>', $text);
		$text = preg_replace('#\[b\](.*)\[/b\]#i', '<strong>$1</strong>', $text);
		$text = preg_replace('#\[i\](.*)\[/i\]#i', '<span style="font-style:italic">$1</span>', $text);
		$text = preg_replace('#\[u\](.*)\[/u\]#i', '<span style="text-decoration:underline">$1</span>', $text);
		$text = preg_replace('#\[img\](.*)\[/img\]#i', '<img src="$1" border="0" />', $text);
		$text = preg_replace('#\[url=([^]]+)\]([^[]+)\[/url\]#i', '<a href="$1">$2</a>', $text);
		$text = preg_replace('#\[color=\#([A-Fa-f0-9]+)\]([^[]+)\[/color\]#i', '<span style="color:#$1">$2</span>', $text);
		$text = preg_replace_callback('#\[list](.*)\[/list\]#msUi', array($this, 'handle_bbcode_list_u'), $text);
		$text = preg_replace_callback('#\[list=1](.*)\[/list\]#msUi', array($this, 'handle_bbcode_list_1'), $text);
		$text = preg_replace_callback('#\[list=a](.*)\[/list\]#msUi', array($this, 'handle_bbcode_list_a'), $text);
		
		$text = str_replace("\n", '<br />', $text);
		
		return $text;
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