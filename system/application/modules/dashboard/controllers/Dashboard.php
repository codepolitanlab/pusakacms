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
class Dashboard extends Public_Controller {

	/**
	 * Main CMS Function
	 *
	 * Routes and processes all page requests
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		$segments = $this->uri->segment_array();

		$is_home = FALSE;

		// Blank mean it's the home page, ya hurd?
		if (empty($segments))
		{
			$is_home = TRUE;
			$segments = array('home');

			if($this->config->item('post_as_home'))
				return call_user_func_array(array($this, 'post'), $params);
		}

		// reset index to 0
		$params = $segments = array_values($segments);
		array_shift($params);
		
		// if it is STREAM POST
		if($segments[0] == POST_TERM)
		{
			return call_user_func_array(array($this, 'post'), $params);
		}
		// if it is a PAGE
		else 
		{
			$this->page($segments);
		}
	}

	function page($segments)
	{
		$strseg = "";

		for ($i = count($segments); $i > 0; $i--) 
		{	
			$file_path = PAGE_FOLDER.implode('/', $segments);

			if(file_exists($file_path.'.md') || file_exists($file_path.'/index.md'))
			{
				$strseg = $file_path;
				break;
			}

			array_pop($segments);
		}

		// if content file not found, show 404
		if(empty($strseg)) show_404();

		// set default layout
		$this->template->set_layout('page');

		// check if there is a custom layout for this page
		if($this->template->layout_exists('pages/'.implode("/",$segments)))
			$this->template->set_layout('pages/'.implode("/",$segments));

		$this->template->view_content($file_path, $this->data);
	}

	function sync_page($prefix = null)
	{
		header("Content-Type:text/plain");
		$report = $this->pusaka->sync_page($prefix);
		echo "Sync ".$report['status'].":\n";
		echo $report['message']."\n";
	}

	function sync_post()
	{
		header("Content-Type:text/plain");

		$nav = $this->pusaka->sync_page(POST_TERM);
		echo "Sync ".$nav['status'].":\n";
		echo $nav['message']."\n";

		$label = $this->pusaka->sync_label();
		echo "Sync ".$label['status'].":\n";
		echo $label['message']."\n";
	}

	function post()
	{
		$this->template->set_layout(null);
		$this->data['label'] = false;

		$segments = $this->uri->segment_array();
		$segments = array_values($segments);

		// it is a post list
		if(! isset($segments[1])){
			$this->config->set_item('page_title', $this->config->item('post_term').' - '.$this->config->item('page_title'));

			$this->data['posts'] = $this->pusaka->get_posts();

			$this->template->view('layouts/post-loop', $this->data);
		}
		else {
			// if it is a post list with page number
			if($segments[1] == 'p'){
				$this->config->set_item('page_title', $this->config->item('post_term').' - '.$this->config->item('page_title'));

				$this->data['posts'] = $this->pusaka->get_posts(null, isset($segments[2]) ? $segments[2] : 1);
				$this->template->view('layouts/post-loop', $this->data);
			}

			// if it is a blog label
			elseif($segments[1] == 'label'){
				if(! isset($segments[2])) show_404();

				$this->config->set_item('page_title', $segments[2].' - '.$this->config->item('page_title'));

				$this->data['label'] = $segments[2];
				$this->data['posts'] = $this->pusaka->get_posts($segments[2], isset($segments[3]) ? $segments[3] : 1);
				$this->template->view('layouts/post-loop', $this->data);
			}
			
			// then it is a detail post
			else {
				$uri = $this->uri->uri_string();
				$this->data['post'] = $this->pusaka->get_post($uri);
				if(! $this->data['post']) show_404();

				// set meta
				$this->config->set_item('page_title', $this->data['post']['title'].' - '.$this->config->item('page_title'));

				if(isset($this->data['post']['meta_description']) && !empty($this->data['post']['meta_description']))
					$this->config->set_item('meta_description', $this->data['post']['meta_description']);
				
				if(isset($this->data['post']['meta_keywords']) && !empty($this->data['post']['meta_keywords']))
					$this->config->set_item('meta_keywords', $this->data['post']['meta_keywords'].', '.$this->config->item('meta_keywords'));

				$this->template->view('layouts/post', $this->data);
				
			}
		}
	}

	/*
	 * param string $site 	site_slug
	 */
	function update_domain($site = null)
	{
		if(!$site) show_error('which site domain must be update?');

		if(file_exists(SITE_FOLDER.$site.'/config/site.json')){
			$settings = json_decode(@file_get_contents(SITE_FOLDER.$site.'/CNAME'), true);

			// check if site_domain not set
			if(!isset($settings['site_domain']) || empty($settings['site_domain']))
				show_error('site_domain configuration in config/site.json must be set first.');
				
			// create .conf file for site domain
			if(write_file(SITE_FOLDER.'_domain/'.$settings['site_domain'].'.conf', $site)){
				header("Content-Type:text/plain");
				echo "Domain setting for site $site updated.";
			}
			else
				show_error('Writing domain configuration file failed. '.SITE_FOLDER.'_domain/ folder must be writable.');
		} else
			show_error('config/site.json file not found');
	}

}