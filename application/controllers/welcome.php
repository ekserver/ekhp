<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Ext_Controller 
{     
    function __construct()
    {
        parent::__construct();
    }
     
	function index()
	{
		$this->load->config('phpbb');
		$this->load->model('news');
		
		$this->data['news'] = $this->news->get_news(0, 8);
		
		$this->set_title($this->lang->line('welcome_title'));
		$this->display('welcome');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
