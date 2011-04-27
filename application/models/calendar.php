<?php

class Calendar extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Returns the events for current month,
	 * without event description.
	 *
	 * @param int $userlevel	Minimal userlevel (USERLEVEL_* constant)
	 * @return array
	 */
	public function get_month_events($userlevel)
	{
		return $this->db->from('ek_calendar')
				 ->select(array('id', 'title', 'date', 'visibility'))
				 ->where('visibility >=', $userlevel)
				 ->where('date >=', mktime(0, 0, 0, date('n'), 1))
				 ->order_by('date ASC')
				 ->get()
				 ->result();
	}
}