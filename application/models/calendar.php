<?php

class Calendar extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Returns the events for current month.
	 * With realm name, without event description.
	 *
	 * @param int $userlevel	Minimal userlevel (USERLEVEL_* constant)
	 * @return array
	 */
	public function get_month_events($userlevel)
	{
		return $this->db->from('ek_calendar')
				 ->select(array('ek_calendar.id', 'ek_calendar.title', 'ek_calendar.date', 'ek_calendar.realm_id', 'ek_calendar.visibility', 'realmlist.name AS realm'))
				 ->where('ek_calendar.visibility >=', $userlevel)
				 ->where('ek_calendar.date >=', mktime(0, 0, 0, date('n'), 1))
				 ->order_by('ek_calendar.date ASC')
				 ->join('realmlist', 'ek_calendar.realm_id = realmlist.id')
				 ->get()
				 ->result();
	}
}