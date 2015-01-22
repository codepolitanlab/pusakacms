<?php
require_once COMMONPATH.'core/Core_Controller.php';

class MY_Controller extends Core_Controller{

		var $data = array();

	public function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(false);

		// Set timezone
		date_default_timezone_set('Asia/Jakarta');

		if(! defined('SITE_PATH')) define('SITE_PATH', SITE_FOLDER.SITE_SLUG.'/');

		// load library
		$this->load->library('users/ion_auth');
		
		// check if main config file exist
		if(!file_exists((SITE_PATH.'config/site.json'))){
			show_error('site.json config file for your site is not found. Please create it first.');
		}
		if(!file_exists((SITE_PATH.'config/system.json'))){
			show_error('system.json config file for your site is not found. Please create it first.');
		}

		// get all config file
		$config_file = array_filter(scandir(SITE_PATH.'config'), function($user){
			return (strpos($user, '.json'));
		});

		foreach ($config_file as $confile) {
			$config = json_decode(file_get_contents(SITE_PATH.'config/'.$confile), true);
			foreach ($config as $key => $value) {
				$this->config->set_item($key, $value);
				$this->data[$key] = $value;
			}
		}
		
		if(json_last_error() > 0){
			show_error('config file error: '. json_last_error_msg());
		}

		$this->config->set_item('page_title', $this->config->item('site_name'));

		if(! defined('PAGE_FOLDER')) define('PAGE_FOLDER', SITE_PATH.$this->config->item('page_folder'));
		if(! defined('POST_FOLDER')) define('POST_FOLDER', SITE_PATH.$this->config->item('post_folder'));
		if(! defined('LABEL_FOLDER')) define('LABEL_FOLDER', SITE_PATH.$this->config->item('label_folder'));
		if(! defined('NAV_FOLDER')) define('NAV_FOLDER', SITE_PATH.$this->config->item('nav_folder'));

		if(! defined('POST_TERM')) define('POST_TERM', $this->config->item('post_term'));

		if(! defined('PLUGIN_FOLDER')) define('PLUGIN_FOLDER', APPPATH.'plugins/');

		// support compatibility with php < 5.3
		if(! defined('JSON_PRETTY_PRINT')) define('JSON_PRETTY_PRINT', 128);
	}
	
}