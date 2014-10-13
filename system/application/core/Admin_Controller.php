<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// set theme
		$this->template->set_theme($this->config->item('admin_theme'));
	}

}