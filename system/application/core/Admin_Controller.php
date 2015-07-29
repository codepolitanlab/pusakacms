<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// redirect to login page if user not login
		if($uri = $this->uri->uri_string())
			$uri = '?red='.$uri;
		if(! $this->logged_in()) redirect('users/auth/login/'.$uri);

		// check if database folder writable
		$this->config_path = SITE_PATH.'db/';
		if(!is_readable($this->config_path) || !is_writable($this->config_path))
		show_error('Set folder '.$this->config_path.' and its contents readable and writable first.');

		// set theme
		$this->template->set_theme($this->config->item('admin_theme'));

		if(file_exists(SITE_FOLDER.SITE_SLUG.'/users/admin.json')){
			$admin = json_decode(file_get_contents(SITE_FOLDER.SITE_SLUG.'/users/admin.json'), true);
			if(isset($admin['password']) && $admin['password'] == 'password')
				$this->template->set('warning', 'Change your default admin password to secure one in <a href="'.site_url('panel/users/edit/admin').'"><strong>Users settings</strong></a> page first.');
		}

		// create panel menu tree
		$nav = array(
				'Dashboard' => array(),
				'Content' => array(),
				'Appearance' => array(),
				'Misc' => array(),
				'Settings' => array(),
				'Account' => array(
						5 => array(
								'link' => 'logout', 
						 		'caption' => "Logout"
						 	)
						)
			);

		$nav = array_merge($nav, get_module_nav_tree());
		foreach ($nav as $key => &$value) ksort($value);
		$this->template->set('navs', $nav);
	}

}
