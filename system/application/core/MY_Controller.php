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

		$sitepath = 'sites/'.SITE_SLUG.'/';

		// set site config
		$raw_configs = require_once(FCPATH.$sitepath.'conf.php');
		foreach($config as $key => $var){
			$this->config->set_item($key, $var);
			$this->data[$key] = $var;
		}

		$this->config->set_item('page_title', $this->config->item('site_name'));

		// set theme
		$this->template->set_theme($this->config->item('theme'));
		
		// set site url
		$this->data['site_url'] = site_url();
		$this->data['current_url'] = current_url();

		define('PAGE_FOLDER', $sitepath.'content/'.$this->config->item('page_folder'));
		define('POST_FOLDER', $sitepath.'content/'.$this->config->item('post_folder'));
		define('LABEL_FOLDER', $sitepath.'content/'.$this->config->item('label_folder'));
		define('POST_TERM', $this->config->item('post_term'));
	}

}