<?php

class EK_Module
{
	protected $data = array();
	protected $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	function __get($key)
	{
		return $this->CI->$key;
	}
	
	protected function display($template)
	{
		$this->CI->load->view('modules/'.$template, $this->data);
	}
}

function module_system_dummy() {}
