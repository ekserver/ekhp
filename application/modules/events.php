<?php

class Events_Module extends EK_Module
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		// fetch events
		if($this->user->is_logged_in())
		{
			$userlevel = $this->session->userdata('userlevel');
		}
		else
		{
			$userlevel = USERLEVEL_USER;
		}
		
		// load calendar model as 'calendar_m' since the calendar library has the same name
		$this->load->model('calendar', 'calendar_m');
		$events = $this->calendar_m->get_month_events($userlevel);
		
		// build an array which can be passed to the calendar generator
		$content = array();
		
		foreach($events as $event)
		{
			$content[date('j', $event->date)] = '<div style="display:none" id="event-title-'.date('j', $event->date).'">'.$event->title.'</div><a href="'.site_url('event/'.$event->id.'-'.url_title($event->title)).'">'.date('j', $event->date).'</a>';
		}
		
		$config = array();
		$config['template'] = '
		   {table_open}<table border="0" cellpadding="0" cellspacing="0" id="event-calendar" class="calendar" width="100%">{/table_open}
		
		   {heading_row_start}<tr>{/heading_row_start}
		
		   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
		
		   {heading_row_end}</tr>{/heading_row_end}
		
		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td class="alt">{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}
		
		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td>{/cal_cell_start}
		
		   {cal_cell_content}<div class="event">{content}</div>{/cal_cell_content}
		   {cal_cell_content_today}<div class="event today">{content}</div>{/cal_cell_content_today}
		
		   {cal_cell_no_content}{day}{/cal_cell_no_content}
		   {cal_cell_no_content_today}<div class="today">{day}</div>{/cal_cell_no_content_today}
		
		   {cal_cell_blank}&nbsp;{/cal_cell_blank}
		
		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}
		
		   {table_close}</table>{/table_close}
		';
		
		$this->load->library('calendar', $config);
				
		$this->data['calendar'] = $this->calendar->generate(date('Y'), date('n'), $content);
		
		$this->display('events');
	}
}