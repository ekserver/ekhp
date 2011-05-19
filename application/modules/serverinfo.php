<?php

class Serverinfo_Module extends EK_Module
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->display('serverinfo');
	}
}