<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MyHookClass {

	function multisite()
	{
		$domain = $_SERVER['HTTP_HOST'];

		if(file_exists(SITE_FOLDER.'_domain/'.$domain.'.conf'))
			define('SITE_SLUG', trim(@file_get_contents(SITE_FOLDER.'_domain/'.$domain.'.conf')));
		else
			show_error('Site with domain '.$domain.' not configured yet.', '404', 'Site Not Found');

		if(! defined('SITE_PATH')) define('SITE_PATH', SITE_FOLDER.SITE_SLUG.DIRECTORY_SEPARATOR);
	}
}