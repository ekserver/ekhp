<?php

class Controlpanel extends Ext_Controller 
{
	protected $access = USERLEVEL_USER;

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
    	redirect('controlpanel/dashboard');
    }
    
    function dashboard()
    {
        $this->set_title('Accountverwaltung');
        $this->display('controlpanel/dashboard');
    }
}
