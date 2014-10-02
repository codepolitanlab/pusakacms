<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MyHookClass {

	function multisite()
	{	
		$domain = $_SERVER['HTTP_HOST'];

		// if it is a local server
		if($domain == 'localhost'){

			$base_url = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';

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
			$base_url = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';
			$base_url .= '://'.$domain;

			$available_site = (array) $arr_sites['online'];
			if($site_slug = array_search($base_url, $available_site))
				define('SITE_SLUG', $site_slug);
			else
				define('SITE_SLUG', 'default');
		}
	}
}