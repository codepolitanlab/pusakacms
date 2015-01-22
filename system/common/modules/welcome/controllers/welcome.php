<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public $commonVar = "COMMON TESTVAR";
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('language');
		$this->load->language('welcome');
		// Load profiler logger
		$this->load->helper('profiler_log');
	}
	
	public function index()
	{
		// Enable profiler
		$this->output->enable_profiler(TRUE);
		$this->load->view('welcome_message');
	}
	
	public function test()
	{
		$this->output->enable_profiler(TRUE);
		$this->index();
	}
	
	public function test2()
	{
		echo "<h1>Loaded: core/common/modules/welcome/test2</h1><br>";
		$this->index();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */