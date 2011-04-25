<?php

class Login extends Ext_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function validate()
    {
        if($this->user->login($this->input->post('name_mail'), $this->input->post('password')))
        {
            redirect('welcome');
        }
        else
        {
            $this->set_title('Login fehlgeschlagen');
            $this->display('login/failed');
        }
	}

	function logout()
	{
        $this->user->logout();
        redirect('login/loggedout');
	}

    function loggedout()
    {
        $this->set_title('Ausgeloggt!');
		$this->display('login/loggedout');
    }
}
