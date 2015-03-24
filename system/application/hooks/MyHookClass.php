<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MyHookClass {

	function multisite()
	{
		include APPPATH.'config/pusaka.php';

		$domain = $_SERVER['HTTP_HOST'];

		// if it is a local server
		if($domain == $config['localhost_domain'] || $domain == $config['subsite_domain']){
			$uri = ($domain == $config['localhost_domain']) 
					? substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['SCRIPT_NAME'].'/')))
					: $uri = $_SERVER['REQUEST_URI'];

			$segments = explode('/', $uri);

			if(isset($segments[1]) && !empty($segments[1])) {
				if(is_dir(SITE_FOLDER.$segments[1]))
					define('SITE_SLUG', $segments[1]);
				else
					show_error('Site with slug \''.$segments[1].'\' not found.', '404', 'Site Not Found');
			}
			else
				define('SITE_SLUG', 'default');
		}

		// then it is a online server with real domain
		else {
			if(file_exists(SITE_FOLDER.'_domain/'.$domain.'.conf'))
				define('SITE_SLUG', trim(@file_get_contents(SITE_FOLDER.'_domain/'.$domain.'.conf')));
			else
				show_error('Site with domain '.$domain.' not configured yet.', '404', 'Site Not Found');
		}
	}
}