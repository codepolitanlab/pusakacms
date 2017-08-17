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
class Post extends Public_Controller {

	function index()
	{
		$this->data['label'] = false;

		$segments = $this->uri->segment_array();
		$segments = array_values($segments);

		// it is a post list
		if(! isset($segments[1])){
			$this->config->set_item('page_title', $this->config->item('post_term').' - '.$this->config->item('page_title'));

			$this->data['posts'] = $this->pusaka->get_posts();

			$this->template->view('posts', $this->data);
		}
		else {
			// if it is a post list with page number
			if($segments[1] == 'p'){
				$this->config->set_item('page_title', $this->config->item('post_term').' - '.$this->config->item('page_title'));

				$this->data['posts'] = $this->pusaka->get_posts(null, isset($segments[2]) ? $segments[2] : 1);
				$this->template->view('posts', $this->data);
			}

			// if it is a blog label
			elseif($segments[1] == 'label'){
				if(! isset($segments[2])) show_404();

				$this->config->set_item('page_title', $segments[2].' - '.$this->config->item('page_title'));

				$this->data['label'] = $segments[2];
				$this->data['posts'] = $this->pusaka->get_posts($segments[2], isset($segments[3]) ? $segments[3] : 1);
				$this->template->view('posts', $this->data);
			}
			
			// then it is a detail post
			else {
				$segments = $this->uri->segment_array();
				array_shift($segments);
				$uri = implode('/', $segments);
				$this->data['post'] = $this->pusaka->get_post($uri);
				if(! $this->data['post']) show_404();

				// set meta
				$this->config->set_item('page_title', $this->data['post']['title'].' - '.$this->config->item('page_title'));

				if(isset($this->data['post']['meta_description']) && !empty($this->data['post']['meta_description']))
					$this->config->set_item('meta_description', $this->data['post']['meta_description']);
				
				if(isset($this->data['post']['meta_keywords']) && !empty($this->data['post']['meta_keywords']))
					$this->config->set_item('meta_keywords', $this->data['post']['meta_keywords'].', '.$this->config->item('meta_keywords'));

				$this->template->view('single', $this->data);
				
			}
		}
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

}