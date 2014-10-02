<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MyHookClass {

	function multisite()
	{	
		$domain = $_SERVER['HTTP_HOST'];

		// if it is a local server
		if($domain == 'localhost'){
			$segments = explode('/', $_SERVER['REQUEST_URI']);

			if(isset($segments[2]) && ! empty(trim($segments[2]))) {	
				if(is_dir('sites/'.$segments[2]))
					define('SITE_SLUG', $segments[2]);
				else
					show_error('Site not found');
			}
			else
				define('SITE_SLUG', 'default');
		}

		// then it is a online server with real domain
		else {
			if(file_exists('sites/_domain/'.$domain))
				define('SITE_SLUG', trim(@file_get_contents('sites/_domain/'.$domain.'.conf')));
			else
				show_error('Site not configured yet');
		}
	}
}