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
        if( $user_data = $this->user->login($this->input->post('name_mail'), $this->input->post('password')) )
        {
            $this->session->set_userdata($user_data);
            redirect('welcome');
        }
        else
        {
            $this->template['title'] = 'Login failed';
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
        $this->template['title'] = 'Ausgeloggt!';
        $this->template['content'] = 'login/loggedout';
		$this->index();
    }
}