<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH."libraries/MX/Controller.php";

/*
| Parent class of every controller.
*/

class MY_Controller extends MX_Controller
{
	var $data = array();

	public function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(false);
		// Set timezone
		date_default_timezone_set('Asia/Jakarta');

		$sitepath = 'sites/'.SITE_SLUG.'/';
		
		// set site config
		if(!file_exists(($sitepath.'config/site.json'))){
			show_error('site.json config file for your site is not found. Please create it first.');
		}
		if(!file_exists(($sitepath.'config/system.json'))){
			show_error('system.json config file for your site is not found. Please create it first.');
		}
		
		if(json_last_error() > 0){
			show_error('confif file error: '. json_last_error_msg());
		}

		$config_file = scandir($sitepath.'config');
		$config_file = array_diff($config_file, array('.', '..'));

		foreach ($config_file as $confile) {
			$config = json_decode(read_file($sitepath.'config/'.$confile));
			foreach ($config as $key => $value) {
				$this->config->set_item($key, $value);
				$this->data[$key] = $value;
			}
		}

		$this->config->set_item('page_title', $this->config->item('site_name'));

		// set theme
		$this->template->set_theme($this->config->item('theme'));

		define('PAGE_FOLDER', $sitepath.'content/'.($this->config->item('page_folder')?$this->config->item('page_folder'):'pages'));
		define('POST_FOLDER', $sitepath.'content/'.($this->config->item('post_folder')?$this->config->item('post_folder'):'posts'));
		define('LABEL_FOLDER', $sitepath.'content/'.($this->config->item('label_folder')?$this->config->item('label_folder'):'labels'));
		define('POST_TERM', $this->config->item('post_term')?$this->config->item('post_term'):'blog');
	}

}