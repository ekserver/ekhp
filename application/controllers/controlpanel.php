<?php

class Controlpanel extends User_Controller {

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->template['title'] = 'Account-Verwaltung';
        $this->template['layout'] = 'default';
        $this->load->view('template', $this->template);
    }
    
    function dashboard()
    {
        $this->template['content'] = 'controlpanel/dashboard';
        $this->index();
    }

}