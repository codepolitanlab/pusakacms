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
		
		// check if main config file exist
		if(!file_exists(($sitepath.'config/site.json'))){
			show_error('site.json config file for your site is not found. Please create it first.');
		}
		if(!file_exists(($sitepath.'config/system.json'))){
			show_error('system.json config file for your site is not found. Please create it first.');
		}

		// get all config file
		$config_file = array_filter(scandir($sitepath.'config'), function($user){
			return (strpos($user, '.json'));
		});

		foreach ($config_file as $confile) {
			$config = json_decode(file_get_contents($sitepath.'config/'.$confile), true);
			foreach ($config as $key => $value) {
				$this->config->set_item($key, $value);
				$this->data[$key] = $value;
			}
		}
		
		if(json_last_error() > 0){
			show_error('config file error: '. json_last_error_msg());
		}

		$this->config->set_item('page_title', $this->config->item('site_name'));

		if(! defined('PAGE_FOLDER')) define('PAGE_FOLDER', $sitepath.'content/pages/');
		if(! defined('POST_FOLDER')) define('POST_FOLDER', $sitepath.'content/posts/');
		if(! defined('LABEL_FOLDER')) define('LABEL_FOLDER', $sitepath.'content/labels/');
		if(! defined('NAV_FOLDER')) define('NAV_FOLDER', $sitepath.'content/navs/');
		if(! defined('SITE_PATH')) define('SITE_PATH', $sitepath);
		if(! defined('POST_TERM')) define('POST_TERM', $this->config->item('post_term')?$this->config->item('post_term'):'blog');

		if(! defined('JSON_PRETTY_PRINT')) define('JSON_PRETTY_PRINT', 128);
	}

}