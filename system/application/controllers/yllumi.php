<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fizl
 *
 * Simple tool for making simple sites.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Yllumi extends CI_Controller {

	public $vars = array();

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');

		// Set the site folder as a constant
		define('CONTENT_FOLDER', $this->config->item('content_folder'));
	}

	/**
	 * Main Fizl Function
	 *
	 * Routes and processes all page requests
	 *
	 * @access	public
	 * @return	void
	 */
	public function _remap()
	{
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

		// check if there is a custom layout for this page
		if($this->template->layout_exists($segments[0]))
			$this->template->set_layout($segments[0]);

		// Turn the URL into a file path
		$file_path = CONTENT_FOLDER;
		if ($segments) $file_path .= '/'.implode('/', $segments);

		$this->template->view_content($file_path);
	}

}