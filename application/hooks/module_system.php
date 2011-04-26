<?php

class EK_Module extends CI_Controller
{
	protected $data = array();
	
	protected function display($template)
	{
		$this->load->view('modules/'.$template, $this->data);
	}
}

function module_system_dummy() {}
