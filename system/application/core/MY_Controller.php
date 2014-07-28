<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH."third_party/MX/Controller.php";

/*
| Parent class of every controller.
*/

class MY_Controller extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();

		// Set timezone
		date_default_timezone_set('Asia/Jakarta');

		define('CONTENT_FOLDER', $this->config->item('content_folder'));
	}
}