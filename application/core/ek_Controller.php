<?php

/**
 * Extended Controller
 * 
 * Soll das Gründgerüst für alle weiteren Controller
 * darstellen.
 * Stellt Grundfunktionen zur Handhabung von
 * Layouts uvm. bereit.
 *
 * @author Maximilian Arnicke
 * @date 25.04.11
 */

class Ext_Controller extends CI_Controller
{
	private $layout = 'default';
	private $title = '';
	protected $data = array();
	protected $access = -1;

	/**
	 * Der Konstruktor überprüft ob die Child-Klasse
	 * die $access Variable überschrieben hat und
	 * schützt die Seite automatisch für das angegebene
	 * Userlevel.
	 */
	function __construct()
	{
		parent::__construct();
		
		if($this->access >= 0)
		{
			$this->protect($this->access);
		}
	}
	
	/**
	 * Protect a controller from visiting
	 *
	 * @param int $level			User/GM-Level value (USERLEVEL_* constant)
	 * @param string $redirection	Redirection target, if user has no access
	 */
	protected function protect($level, $message = 'Du hast kein Recht, diese Seite einzusehen.', $headline = 'Fehler')
	{
		if(!$this->user->is_logged_in() OR $this->session->userdata('userlevel') < $level)
		{
			$this->show_error($message, $headline);
		}
	}
	
	/**
	 * Set layout
	 *
	 * @param string $name	Name of file located in views/layout/
	 * @return bool
	 */
	protected function set_layout($name)
	{
		if(substr($name, -4) == '.php')
		{
			$name = substr($name, 0, strlen($name) - 4);
		} 
		
		if(!is_file(APPPATH."views/layout/$name.php"))
		{
			return FALSE;
		}
		
		$this->layout = $name;
		return TRUE;
	}
	
	/**
	 * Set title of page
	 *
	 * @param string $title
	 */
	protected function set_title($title)
	{
		$this->title = $title;
	}
	
	/**
	 * Assemble & display final template
	 *
	 * @param string $content_partial	Name of file located in views/partials/controller/
	 * @param bool	 $return			Return output
	 */
	protected function display($content_partial, $return = FALSE)
	{
		// use name of class as title, if title not specified
		if(empty($this->title))
		{
			$this->data['title'] = get_class($this);
		}
		else
		{
			$this->data['title'] = $this->title;
		}
		
		$this->load->library('parser');
		$this->data['head:head'] = $this->load->view('partials/head', $this->data, TRUE);
		$this->data['header:header'] = $this->load->view('partials/header', $this->data, TRUE);
		$this->data['serverstatus:serverstatus'] = $this->load->view('partials/serverstatus', $this->data, TRUE);
		$this->data['content:content'] = $this->load->view('controller/'. $content_partial, $this->data, TRUE);
		$this->data['footer:footer'] = $this->load->view('partials/footer', $this->data, TRUE);
		
		return $this->parser->parse('layout/'.$this->layout, $this->data, $return);
	}
	
	/**
	 * Display a error and skips following code
	 *
	 * @param string $message	The error message to show
	 * @param string $headline	Optional; Headline / Title
	 */
	protected function show_error($message, $headline = 'Fehler')
	{
		$this->set_title($headline);
		$this->data['message'] = $message;
		$this->data['headline'] = $headline;
		
		$this->output->set_output($this->display('error', TRUE));
		$this->output->_display();
		exit;
	}
}
