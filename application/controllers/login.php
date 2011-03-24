<?php

class Login extends CI_Controller {

    private $data;

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->template['title'] = 'Login | Jetzt einloggen!';
        $this->template['layout'] = 'default';
        $this->template['content'] = 'welcome';
        $this->load->view('template', $this->template);
    }

    function validate()
    {
        if( $this->user->login($this->input->post('name_mail'), $this->input->post('password')) )
        {
            redirect('controlpanel/dashboard');
        }
        else
        {
            $this->template['title'] = 'Login failed';
            $this->template['content'] = 'login/failed';
        }
        $this->index();
	}

	function logout()
	{
        $this->user->logout();
        redirect('login/loggedout');
	}

    function loggedout()
    {
        $this->template['title'] = 'Ausgeloggt!';
        $this->template['content'] = 'login/loggedout';
		$this->index();
    }
}