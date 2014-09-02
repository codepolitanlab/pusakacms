<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MyHookClass {

	function multisite()
	{
		if($sites = @file_get_contents(FCPATH.'sites/sites.json')) {
			
			$domain = $_SERVER['HTTP_HOST'];
			$arr_sites = (array) json_decode($sites);

			// if it is a local server
			if($domain == 'localhost'){

				$base_url = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';

				$segments = explode('/', $_SERVER['REQUEST_URI']);
				$base = '/'.$segments[1].'/'.$segments[2];
				$base_url .= '://'.$domain.$base;

				$available_site = (array) $arr_sites['local'];
				if($site_slug = array_search($base_url, $available_site))
					define('SITE_SLUG', $site_slug);
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

		// no multisite config, set default
		} else {
			define('SITE_SLUG', 'default');
		}
	}
}