<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export extends Admin_Controller {

	var $export_location;

	function __construct(){
		parent::__construct();

		$this->export_location = ($this->config->item('export_location'))
									? $this->config->item('export_location')
									: 'sites/'.SITE_SLUG.'/html_output';
	}

	function index()
	{
		if(!$this->config->item('url_suffix'))
			$this->template->set("info", "Set <span class='code'>\$config['url_suffix']</span> in <em>system/application/config/config.php</em> to <span class='code'>'.html'</span> before you can export content to HTML.");
			
		$this->template->view('export');
	}

	function html()
	{
		if(!file_exists($this->export_location))
			mkdir($this->export_location, 0775);

		$baseurl = array(site_url().'blog/', base_url());

		$file = str_replace($baseurl, '', $this->render_page());
		mkdir($this->export_location.'/blog', 0775);
		write_file($this->export_location.'/blog/index.html', $file);
	}

	function render_page()
	{
		return file_get_contents(site_url('blog'));
	}

}