<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// use Nyankod\JsonFileDB;

/**
 * Cms
 *
 * Simple tool for making simple sites.
 *
 * @package		Pusaka
 * @author		Toni Haryanto (@toharyan)
 * @copyright	Copyright (c) 2011-2012, Nyankod
 * @license		http://nyankod.com/license
 * @link		http://nyankod.com/pusakacms
 */

class Panel extends Admin_Controller {

	public $page_db;

	var $page_fields = array(
		array(
			'field'   => 'title', 
			'label'   => 'Page Title', 
			'rules'   => 'trim|required'
			),
		array(
			'field'   => 'slug', 
			'label'   => 'Page Slug', 
			'rules'   => 'trim|required'
			),
		array(
			'field'   => 'content', 
			'label'   => 'Page Content', 
			'rules'   => 'required'
			)
		);

	function __construct(){
		parent::__construct();
		
		if(! $this->logged_in()) redirect('panel/login');

		if(!is_readable(PAGE_FOLDER) || !is_writable(PAGE_FOLDER))
			show_error('Set folder '.PAGE_FOLDER.' readable and writable first.');

		// set page index file
		$this->page_db = new Nyankod\JsonFileDB(PAGE_FOLDER);
		$this->page_db->setTable('index');			
	}


	/*********************************************
	 * PAGES
	 **********************************************/

	function coba()
	{
		print_r(directory_map(PAGE_FOLDER));
		print_r($this->pusaka->scan_pages());
	}

	function index()
	{
		// $pages = $this->pusaka->get_pages_tree();
		$pages = $this->page_db->selectAll();
		$pagelist = $this->_page_list($pages);

		$this->template
			->set('pages', $pagelist)
			->view('pages');
	}

	function _page_list($pages)
	{
		return $this->load->view('page_list', array('pages'=>$pages), true);
	}

	function sync($redirect = true)
	{
		$nav = $this->pusaka->sync_page();

		if($redirect){
			$this->session->set_flashdata($nav['status'], $nav['message']);
			redirect('panel/pages');
		}

		return $nav;
	}

	function create()
	{
		$segs = $this->uri->uri_string();
		$seg_array = explode("/", $segs, 4);

		$parent = false;
		if(isset($seg_array[3]))
			$parent = $seg_array[3];

		$this->form_validation->set_rules($this->page_fields);

		if($this->form_validation->run()){
			$page = $this->input->post();
			$file_content = "";

			// set content
			foreach ($page as $key => $value) {
				if($value)
					if($key == 'slug')
						$file_content .= "{: ".$key." :} ".strtolower(url_title($value))."\n";
					else
						$file_content .= "{: ".$key." :} ".$value."\n";
			}

			// if it is placed as subpage
			if(!empty($page['parent'])) { 
				// if parent still as standalone file (not in folder)
				if(file_exists(PAGE_FOLDER.$page['parent'].'.md')) {
					// create folder and move the parent inside
					mkdir(PAGE_FOLDER.$page['parent'], 0775);
					rename(PAGE_FOLDER.$page['parent'].'.md', PAGE_FOLDER.$page['parent'].'/index.md');

					// create index.html file
					copy(PAGE_FOLDER.'index.html', PAGE_FOLDER.$page['parent'].'/index.html');
				}
			}
			
			if(write_file(PAGE_FOLDER.$page['parent'].'/'.$page['slug'].'.md', $file_content)){
				$this->session->set_flashdata('success', 'Page saved.');

				// update page index
				$this->sync(false);

				if($this->input->post('btnSaveExit'))
					redirect('panel/pages');
				else
					redirect('panel/pages/edit/'.$page['parent'].$page['slug']);
			}
			else {
				$this->template->set('error', 'Page failed to save. Make sure the folder '.PAGE_FOLDER.' is writable.');
			}

		}

		$this->template
			->set('type', 'create')
			->set('page', '')
			->set('parent', $parent)
			->set('url', '')
			->set('layouts', $this->pusaka->get_layouts($this->config->item('theme')))
			->set('pagelinks', $this->pusaka->get_flatnav())
			->view('page_form');
	}

	function edit()
	{
		$segs = $this->uri->uri_string();
		$seg_array = explode("/", $segs, 4);

		if(isset($seg_array[3]))
			$prevslug = $seg_array[3];
		else
			show_404();

		$prevpage = $this->pusaka->get_page($prevslug, false);
		if(!isset($prevpage['slug']))
			$prevpage['slug'] = $prevslug;

		$this->form_validation->set_rules($this->page_fields);

		if($this->form_validation->run()){
			$page = $this->input->post();
			$file_content = "";

			// set content
			foreach ($page as $key => $value) {
				if($value)
					if($key == 'slug')
						$file_content .= "{: ".$key." :} ".strtolower(url_title($value))."\n";
					else
						$file_content .= "{: ".$key." :} ".$value."\n";
			}

			// move page
			$this->_move_page($prevslug, $page['slug'], $prevpage['parent'], $page['parent']);

			// update page content
			if(write_file(PAGE_FOLDER.$page['parent'].'/'.$page['slug'].'.md', $file_content, 'w+'))
				$this->session->set_flashdata('success', 'Page updated.');
			else
				$this->session->set_flashdata('error', 'Page failed to update. Make sure the folder '.PAGE_FOLDER.' is writable.');

			// update page index
			$this->sync(false);

			if($this->input->post('btnSaveExit'))
				redirect('panel/pages');
			else
				redirect('panel/pages/edit/'.$page['parent'].$page['slug']);
		}


		$this->template
			->enable_parser_body(false)
			->set('type', 'edit')
			->set('page', $prevpage)
			->set('parent', '')
			->set('url', $prevslug)
			->set('layouts', $this->pusaka->get_layouts($this->config->item('theme')))
			->set('pagelinks', $this->pusaka->get_flatnav())
			->view('page_form');
	} 

	function delete()
	{
		$segs = $this->uri->uri_string();
		$seg_array = explode("/", $segs, 4);

		if(isset($seg_array[3]))
			$prevslug = $seg_array[3];
		else
			show_404();

		if(unlink(PAGE_FOLDER.'/'.$prevslug.'.md')){
			$this->session->set_flashdata('success', 'Page '.$prevslug.' deleted.');

			// check to raise parent page
			$slug_array = explode("/", $prevslug);
			if(count($slug_array) >= 2){
				array_pop($slug_array);
				$parent = implode("/", $slug_array);
				$this->pusaka->raise_page($parent);
			}

			// update page index
			$this->sync(false);
		}
		else
			$this->session->set_flashdata('error', 'Page failed to delete. Make sure the folder '.PAGE_FOLDER.' is writable.');

		redirect('panel/pages');
	}

	function move_page()
	{
		if(!is_writable(PAGE_FOLDER.'/index.json')) {
			echo '{"status":"error", "message":"Page failed to move. Make sure '.PAGE_FOLDER.'/index.json file writable."}';
			exit;
		}

		$source_arr = explode("/", $this->input->post('source'));

		$page = array_pop($source_arr);
		$source = implode("/", $source_arr);
		$dest = $this->input->post('dest');

		$this->pusaka->move_page($source.'/'.$page, $page, $source, $dest);
		
		// update page index
		$msg = $this->sync(false);

		echo json_encode(array('page' => $page, 'source' => $source, 'dest' => $dest) + $msg);
	}

	function sort($arr = false)
	{
		if(! $arr)
			$map = json_decode($this->input->post('newmap'), true);
		else
			$map = $arr;

		$newmap = array();
		foreach ($map as $value) {
			$newmap[$value['slug']] = $value;
			
			if(isset($value['children']))
				$newmap[$value['slug']]['children'] = $this->sort($value['children']);

			unset($newmap[$value['slug']]['slug']);
		}

		if($arr){
			return $newmap;
		} else {
			if(! write_file(PAGE_FOLDER.'/index.json', json_encode($newmap, JSON_PRETTY_PRINT)))
				echo '{"status":"error", "message":"Page failed to rearranged. Make sure '.PAGE_FOLDER.'/index.json writable."}';
		}
	}

}