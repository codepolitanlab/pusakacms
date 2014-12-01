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

	function copy_theme()
	{
		$theme = $this->config->item('theme');
		$theme_locations = $this->template->theme_locations();
		$theme_location = false;
		foreach ($theme_locations as $location) {
			if(file_exists($location.$this->config->item('theme'))){
				$theme_location = $location;
			}
		}

		if(!file_exists($theme_location))
			mkdir($this->export_location.'/'.$theme_location, 0777, true);

		copy($theme_location.$theme.'/assets/', $this->export_location.'/'.$theme_location.$theme.'/assets/');

		echo '{"status":"success", "message":"Theme copied."}';
	}

	function export_pages($data = false, $parent = '', $depth = 1)
	{
		$page = ($data)? $data : $this->pusaka->get_pages_tree();

		$uplink = '';
		if($depth > 1)
			for ($i=1; $i < $depth; $i++)
				$uplink .= '../';

		$replacement = array(
			site_url().'blog/p/' => 'blog/',
			site_url() => $uplink,
			base_url() => $uplink,
			);
		$search = array_keys($replacement);
		$replace = array_values($replacement);
		
		if(!$data){
			if(!file_exists($this->export_location))
				mkdir($this->export_location, 0777);

			$this->pusaka->sync_page();
			
			// create index.html from home.html
			$file = str_replace($search, $replace, $this->_render_page(site_url('home')));
			write_file($this->export_location.'/index.html', $file);
		}

		foreach ($pages as $slug => $page) {
			$file = str_replace($search, $replace, $this->_render_page(site_url($page['url'])));
			write_file($this->export_location.'/'.$parent.$slug.'.html', $file);

			if(isset($page['children'])){
				if(!file_exists($this->export_location.'/'.$parent.$slug))
					mkdir($this->export_location.'/'.$parent.$slug, 0777);

				$this->export_pages($page['children'], $parent.$slug.'/', $depth+1);
			}
		}

		if(!$data)
			echo '{"status":"success", "message":"Pages exported."}';
	}

	function export_blog()
	{
		if(!file_exists($this->export_location))
			mkdir($this->export_location, 0777);

		// sync post first
		$this->pusaka->sync_post();
		$this->pusaka->sync_label();

		// get post list
		$postlist = json_decode(file_get_contents(POST_FOLDER.'/index.json'), true);
		$post_count = count($postlist);
		$post_per_page = $this->config->item('post_per_page');
		$page_count = ceil($post_count / $post_per_page);

		$labels = directory_map(LABEL_FOLDER, 1);

		// BLOG LIST PAGE 1 ==============================================================
		$replacement = array(
			site_url().'blog/p/' => '',
			site_url().'blog/' => '',
			site_url() => '../',
			base_url() => '../',
			);
		$search = array_keys($replacement);
		$replace = array_values($replacement);

		if(!file_exists($this->export_location.'/blog'))
			mkdir($this->export_location.'/blog', 0777, true);

		$file = str_replace($search, $replace, $this->_render_page(site_url('blog')));
		write_file($this->export_location.'/blog/index.html', $file);


		// BLOG LIST PAGE 2 > ==============================================================
		$replacement = array(
			site_url().'blog/p/' => '../',
			site_url().'blog/' => '../',
			site_url() => '../../',
			base_url() => '../../',
			);
		$search = array_keys($replacement);
		$replace = array_values($replacement);


		for($i = 2; $i <= $page_count; $i++){
			if(!file_exists($this->export_location.'/blog/'.$i))
				mkdir($this->export_location.'/blog/'.$i, 0777, true);

			$file = str_replace($search, $replace, $this->_render_page(site_url('blog/p/'.$i)));
			write_file($this->export_location.'/blog/'.$i.'/index.html', $file);
		}

		// BLOG LIST LABEL ==============================================================
		if(!file_exists($this->export_location.'/blog/label/'))
			mkdir($this->export_location.'/blog/label/', 0777, true);

		foreach ($labels as $label) {
			if($label == 'index.html' || $label == 'index.md') continue;

			$file = str_replace($search, $replace, $this->_render_page(site_url('blog/label/'.substr($label, 0, -5))));
			write_file($this->export_location.'/blog/label/'.substr($label, 0, -5).'.html', $file);
		}

		// BLOG SINGLE ==============================================================

		$replacement = array(
			site_url().'blog/' => '../../../',
			site_url() => '../../../../',
			base_url() => '../../../../',
			);
		$search = array_keys($replacement);
		$replace = array_values($replacement);

		foreach ($postlist as $post) {
			$date = explode("/", $post['url']);
			$postslug = array_pop($date);
			$date_folder = implode("/", $date);

			if(!file_exists($this->export_location.'/'.$date_folder))
				mkdir($this->export_location.'/'.$date_folder, 0777, true);

			$file = str_replace($search, $replace, $this->_render_page(site_url($post['url'])));
			write_file($this->export_location.'/'.$date_folder.'/'.$postslug.'.html', $file);
		}

	}

	function add_missing_index_folder($data = false, $parent = '', $depth = 1)
	{
		$uplink = '../';
		if($depth > 1)
			for ($i=1; $i < $depth; $i++)
				$uplink .= '../';

		$replacement = array(
			site_url().'blog/p/' => 'blog/',
			site_url() => $uplink,
			base_url() => $uplink,
			);
		$search = array_keys($replacement);
		$replace = array_values($replacement);

		// get page not found content
		$page404 = $this->template
			->set_theme($this->config->item('theme'))
			->set_layout('404')
			->view('export', null, true);

		$file = str_replace($search, $replace, $page404);

		$folder = ($data)? $data : directory_map($this->export_location, 5);

		// print_r($folder);
		foreach ($folder as $subfolder => $content) {
			if(!file_exists($this->export_location.'/'.$parent.$subfolder.'/index.html')){
				write_file($this->export_location.'/'.$parent.$subfolder.'/index.html', $file);
			}

			if(is_array($content))
				$this->add_missing_index_folder($content, $parent.$subfolder.'/', $depth + 1);
		}

		if(!$data)
			echo '{"status":"success", "message":"Missing index files created."}';
	}

	function _render_page($url)
	{
		return file_get_contents($url);
	}

}