<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends Admin_Controller {

	function __construct()
	{
		parent::__construct();

		// check if this site has permission to access this module
		$this->config->load('site');
		if(! in_array(SITE_SLUG, $this->config->item('allowed_sites'))) show_404();

		// check if user has logged in
		if(! $this->logged_in()) redirect('panel/login');
	}

	// List of Sites
	function index()
	{
		// get site folder list
		$sites = directory_map(SITE_FOLDER, 2);

		// filter sites
		$data['sites'] = array();
		foreach ($sites as $key => $val) {
			if($key != '_domain')
				$data['sites'][$key] = json_decode(file_get_contents(SITE_FOLDER.$key.'/config/site.json'), true);
		};

		$this->template->view('index', $data);
	}

	function create()
	{

	}

	function edit()
	{

	}

	function delete()
	{

	}

}