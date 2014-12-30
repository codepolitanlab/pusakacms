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
	}

	function logged_in(){
		if($username = $this->session->userdata(SITE_SLUG.'_username')) {
			return true;
		}

		return false;
	}

	protected function _force_login($username){
		if(file_exists(SITE_FOLDER.SITE_SLUG.'/users/'.$username.'.json')){
			$data = json_decode(file_get_contents(SITE_FOLDER.SITE_SLUG.'/users/'.$username.'.json'), true);

			$this->session->set_userdata(SITE_SLUG.'_username', $data['username']);
			$this->session->set_userdata(SITE_SLUG.'_role', $data['role']);

			return true;
		}

		return false;
	}
}