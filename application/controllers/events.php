<?php

class Events extends Ext_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('calendar');
	}
	
	public function index()
	{
		
	}
	
	public function show($event_id)
	{
		$event = $this->calendar->get_event_by_id($event_id);
		
		$event->description = trim($event->description);
		
		if(empty($event->description))
		{
			$event->description = 'Keine Beschreibung vorhanden.';
		}
		
		$this->set_title('Event: '.$event->title);
		
		$this->data['event'] = $event;
		$this->display('events/show');
	}
}