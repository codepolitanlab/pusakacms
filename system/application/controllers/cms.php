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
		
		// if it is STREAM POST
		if($segments[0] == $this->config->item('post_folder'))
		{
			// if it is a single post
			if(isset($segments[1])){	
				// delete the first index 'posts' for smooth implode
				array_shift($segments);

				$file_path = CONTENT_FOLDER.'/'.$this->config->item('post_folder').'/'.implode("-", $segments);

				$this->template->set_layout($this->config->item('post_folder') ? $this->config->item('post_folder') : 'default');
			}
			// otherwise, then it is a post list
			else {
				// delete the first index 'posts'
				array_shift($segments);

				$file_path = CONTENT_FOLDER.'/'.$this->config->item('post_folder').'/'.implode("-", $segments);

				$this->template->set_layout($this->config->item('post_folder').'s' ? $this->config->item('post_folder').'s' : 'default');
			}
		}
		// if it is a PAGE
		else 
		{
			$file_path = CONTENT_FOLDER.'/'.implode('/', $segments);
			
			// check if there is a custom layout for this page
			if($this->template->layout_exists(implode("/",$segments)))
				$this->template->set_layout(implode("/",$segments));
			elseif($this->template->layout_exists($segments[0]))
				$this->template->set_layout($segments[0]);
		}

		// print_r($this->data);

		$this->template->view_content($file_path, $this->data);
	}

	function sync_nav_contents()
	{
		echo "lulus";
	}

	function coba($page = 1)
	{
		$this->output->enable_profiler(TRUE);

		$files = directory_map(CONTENT_FOLDER.'/blog');
		rsort($files);
		print_r($files);

		$perpage = 5;

		$output = array_slice($files, ($page-1)*$perpage, $perpage);
		print_r($output);
	}

}