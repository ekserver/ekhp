<?php

class Login extends CI_Controller {

    public $user_data;

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->template['title'] = 'Login | Jetzt einloggen!';
        $this->template['layout'] = 'default';
        $this->template['userid'] = $this->session->userdata('id');
        $this->template['content'] = 'welcome';
        $this->load->view('template', $this->template);
    }

    function validate()
    {
        if( $user_data = $this->user->login($this->input->post('name_mail'), $this->input->post('password')) )
        {
            $this->session->set_userdata($user_data);
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