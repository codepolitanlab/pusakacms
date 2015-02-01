<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getelements extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->helper('url');
			
		$this->data['pageTitle'] = $this->lang->line('sites_page_title');
	
		if(!$this->ion_auth->logged_in()) {
			
			redirect('panel/login');
		
		}
		
	}

	public function index()
	{
	
		$string = file_get_contents('system/themes/'.$this->config->item('theme')."/elements.json");
		
		header("Content-Type: application/javascript");
		echo $string;
		
	}

	public function get_skeleton($layout = 'builder')
	{
		$this->template->set_layout($layout)->view('index');
	}

	public function get_elements()
	{
		header("Content-Type: application/javascript");
		$this->template->view('elements');
	}
	
}

/* End of file getelements.php */
/* Location: ./application/controllers/getelements.php */