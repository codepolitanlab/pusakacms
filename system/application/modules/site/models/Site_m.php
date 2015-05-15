<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_m extends MY_Model {

	// List of Sites
	function get_sites()
	{
		// get site folder list
		$folder = directory_map(SITE_FOLDER, 2);

		// filter sites
		$sites = array();
		foreach ($folder as $key => $val) {
			if($key != '_domain'.DIRECTORY_SEPARATOR && is_dir(SITE_FOLDER.$key))
				$sites[$key] = json_decode(file_get_contents(SITE_FOLDER.$key.'config'.DIRECTORY_SEPARATOR.'site.json'), true);
		};

		return $sites;
	}

}