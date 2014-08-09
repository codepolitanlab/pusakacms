<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH."third_party/MX/Controller.php";

/*
| Parent class of every controller.
*/

class MY_Controller extends MX_Controller
{
	var $data = array();

	public function __construct()
	{
		parent::__construct();

		// Set timezone
		date_default_timezone_set('Asia/Jakarta');

		// set site config
		$raw_configs = require_once(FCPATH.'conf.php');
		foreach($config as $key => $var){
			$this->config->set_item($key, $var);
			$this->data[$key] = $var;
		}

		// set theme
		$this->template->set_theme($this->config->item('theme'));

		// set site url
		$this->data['site_url'] = site_url();
		$this->data['current_url'] = current_url();

		define('CONTENT_FOLDER', $this->config->item('content_folder'));
	}
}