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

	function export_blog()
	{
		if(!file_exists($this->export_location))
			mkdir($this->export_location, 0775);

		// page url to fetch
		$replacement = array(
			site_url().'blog/' => '',
			site_url().'blog.html/p/2' => '../',
			site_url().'blog.html/' => '',
			base_url() => '../',
			);
		$search = array_keys($replacement);
		$replace = array_values($replacement);

		$file = str_replace($search, $replace, $this->render_page(site_url('blog')));

		if(!file_exists($this->export_location.'/blog'))
			mkdir($this->export_location.'/blog', 0775);

		write_file($this->export_location.'/blog/index.html', $file);

		// export page 2 blog
		// if(!file_exists($this->export_location.'/blog/2'))
		// 	mkdir($this->export_location.'/blog/2', 0775);
	}

	function render_page($url)
	{
		return file_get_contents($url);
	}

}