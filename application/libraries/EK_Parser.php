<?php

/**
 * Extended Parser
 * Searches for module placeholders and
 * replaces them with module content
 *
 * @author Maximilian Arnicke
 */

class EK_Parser extends CI_Parser
{
	public function parse($template, $data, $return = FALSE)
	{
		$CI =& get_instance();
		$template = $CI->load->view($template, $data, TRUE);
		
		$template = preg_replace_callback('#'.$this->l_delim.'module:([^'.$this->r_delim.']+)'.$this->r_delim.'#', array($this, 'invoke_module'), $template);

		return $this->_parse($template, $data, $return);
	}
	
	/**
	 * Includes the module and invokes the
	 * index() method of the module
	 */
	private function invoke_module($name)
	{
		$name = $name[1];
		
		$path = APPPATH.'modules/'.$name.'.php';
		
		if(!is_file($path))
		{
			show_error("Module '$name' not found.");
		}
		else
		{
			include_once APPPATH.'modules/'.$name.'.php';
			
			$classname = ucfirst($name).'_Module';
			$module = new $classname;
			
			ob_start();
			$module->index();
			
			return ob_get_clean();
		}
	}
}