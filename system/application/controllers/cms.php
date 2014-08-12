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
		if($segments[0] == $this->config->item('post_term'))
		{
			return call_user_func_array(array($this, 'post'), $params);
		}
		// if it is a PAGE
		else 
		{
			$file_path = PAGE_FOLDER.'/'.implode('/', $segments);
			
			// check if there is a custom layout for this page
			if($this->template->layout_exists(implode("/",$segments)))
				$this->template->set_layout(implode("/",$segments));
			elseif($this->template->layout_exists($segments[0]))
				$this->template->set_layout($segments[0]);

			$this->template->view_content($file_path, $this->data);
		}
	}

	function sync_nav()
	{
		$this->pusaka->sync_nav();
	}

	function post()
	{
		$this->template->set_layout(null);

		$segments = $this->uri->segment_array();
		$segments = array_values($segments);

		// it is a post list
		if(! isset($segments[1])){
			$this->data['posts'] = $this->pusaka->get_posts();

			// print_r($this->data['posts']);

			$this->template->view('layouts/posts', $this->data);
		}
		else {
			// if it is a post list with page number
			if($segments[1] == 'p'){
				if(! isset($segments[2]) || ! intval($segments[2])) show_404();

				$this->data['posts'] = $this->pusaka->get_posts(null, $segments[2] ? $segments[2] : 1);
				$this->template->view('layouts/posts', $this->data);
			}

			// if it is a blog label
			elseif($segments[1] == 'label'){
				if(! isset($segments[2])) show_404();

				$this->data['posts'] = $this->pusaka->get_posts($segments[2], $segments[3] ? $segments[3] : 1);
				$this->template->view('layouts/posts', $this->data);
			}
			
			// then it is a detail post
			else {
				array_shift($segments);
				$this->data['posts'] = $this->pusaka->get_post(implode('-', $segments));
				$this->template->view('layouts/post', $this->data);
				
			}
		}
	}

}