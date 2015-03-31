<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

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