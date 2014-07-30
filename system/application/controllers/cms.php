<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cms
 *
 * Simple tool for making simple sites.
 *
 * @package		Pusaka
 * @author		Toni Haryanto (@toharyan)
 * @copyright	Copyright (c) 2011-2012, Nyankod
 * @license		http://nyankod.com/license
 * @link		http://nyankod.com/pusakacms
 */
class CMS extends MY_Controller {

	/**
	 * Main CMS Function
	 *
	 * Routes and processes all page requests
	 *
	 * @access	public
	 * @return	void
	 */
	public function _remap($method, $params = array())
	{
		// run the main method first if available
		if (method_exists($this, $method))
			return call_user_func_array(array($this, $method), $params);

		$segments = $this->uri->segment_array();

		$is_home = FALSE;

		// Blank mean it's the home page, ya hurd?
		if (empty($segments))
		{
			$is_home = TRUE;
			$segments = array('index');
		}

		// reset index to 0
			$segments = array_values($segments);
		
		// if it is blog post
		if($segments[0] == $this->config->item('post_folder') && isset($segments[1]))
		{
			// delete the first index contain 'posts' first
			array_shift($segments);

			$file_path = CONTENT_FOLDER.'/'.$this->config->item('post_folder').'/'.implode("-", $segments);
		}
		// if it is a page
		else 
		{
			$file_path = CONTENT_FOLDER.'/'.implode('/', $segments);
		}

		// check if there is a custom layout for this page
		if($this->template->layout_exists($segments[0]))
			$this->template->set_layout($segments[0]);

		$this->template->view_content($file_path);
	}

	function sync_nav_contents()
	{
		echo "lulus";
	}

}