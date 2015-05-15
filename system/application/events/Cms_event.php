<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_event {

	function before_render_page($segments)
	{
		$CI = &get_instance();

		// enter first segment that needs parameters
		$need_parameters = array();

		if(in_array($segments[0], $need_parameters)) {
			$page = $segments[0];
			$file_path = PAGE_FOLDER.$page;

			if(! file_exists($file_path.'.md') && ! file_exists($file_path.'/index.md')) show_404();

			// check if there is a custom layout for this page
			if($CI->template->layout_exists('pages/'.$page))
				$CI->template->set_layout('pages/'.$page);
			
			$CI->template->view_content($file_path);

			return true;
		}
	}

}