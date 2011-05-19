<?php

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->template['layout'] = 'default';
        $this->template['userid'] = $this->session->userdata('id');
        $this->load->view('template', $this->template);
    }

    function validate()
    {
        if($this->user->login($this->input->post('name_mail'), $this->input->post('password')))
        {
            redirect('welcome');
        }
        else
        {
            $this->template['title'] = $this->lang->line('login_title_failed');
            $this->template['content'] = 'login/failed';
            $this->index();
        }
	}

	function logout()
	{
        $this->user->logout();
        redirect('login/loggedout');
	}

    function loggedout()
    {
        $this->template['title'] = $this->lang->line('login_title_loggedout');
        $this->template['content'] = 'login/loggedout';
		$this->index();
    }
}
