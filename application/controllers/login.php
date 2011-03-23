<?php

class Login extends CI_Controller {

    private $data;

    function __construct()
    {
        parent::__construct();
    }
    
	function index()
	{
        $this->data['main_content'] = 'start';
		$this->load->view('includes/template', $this->data);
	}

    function validate()
	{
		if( $this->user->login($this->input->post('name_mail'), $this->input->post('password')) )
        {
            redirect('controlpanel/dashboard');
        }
        else
        {
            $this->data['sitetitle'] = 'Login failed';
            $this->data['main_content'] = 'login/failed';
        }
        $this->index();
	}

    
	function logout()
	{
        $this->user_model->logout();
        redirect('login/loggedout');
	}

    function loggedout() {
        $this->data['sitetitle'] = 'Logout';
        $this->data['main_content'] = 'login/loggedout';
		$this->index();
    }
}