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

class Pages extends Admin_Controller {

	public $users_path;
	public $nav_db;

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
		
		if(! $this->session->userdata('username')) redirect('panel/login');

		$this->users_path = 'sites/'. SITE_SLUG .'/users/';
	}


	/*********************************************
	 * PAGES
	 **********************************************/

	function index()
	{
		$pages = $this->pusaka->get_pages_tree();
		$pagelist = $this->_page_list($pages);

		$this->template
			->set('pages', $pagelist)
			->view('pages');
	}

	function _page_list($pages)
	{
		return $this->load->view('page_list', array('pages'=>$pages), true);
	}

	function sync()
	{
		$this->pusaka->sync_nav();
		redirect('panel/pages');
	}

	function create()
	{
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
				$this->pusaka->sync_nav();

				redirect('panel/pages');
			}
			else {
				$this->template->set('error', 'Page failed to save. Make sure the folder '.PAGE_FOLDER.' is writable.');
			}

		}

		$this->template
			->set('type', 'create')
			->set('page', '')
			->set('url', '')
			->set('layouts', $this->template->get_layouts())
			->set('pagelinks', $this->pusaka->get_flatnav())
			->view('page_form');
	}

	function edit()
	{
		if(!$prevslug = $this->input->get('page')) show_404();

		$prevpage = $this->pusaka->get_page($prevslug, false);

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

			// page move to another folder
			if($prevpage['parent'] != $page['parent']) {
				// if it is move to subpage
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
			}

			// move to new location
			rename(PAGE_FOLDER.'/'.$prevslug.'.md', PAGE_FOLDER.$page['parent'].'/'.$page['slug'].'.md');
			
			// if file left the empty folder, not from the root
			if(!empty($prevpage['parent']) && $filesleft = glob(PAGE_FOLDER.$prevpage['parent'].'/*')){
				// if there are only index.html, index.md, and index.json
				if(count($filesleft) <= 3){
					// move to upper parent
					$parent_subparent_arr = explode("/", $prevpage['parent']);
					$parent_name = array_pop($parent_subparent_arr);
					$parent_subparent = implode("/", $parent_subparent_arr);
					rename(PAGE_FOLDER.$prevpage['parent'].'/index.md', PAGE_FOLDER.$parent_subparent.'/'.$parent_name.'.md');

					unlink(PAGE_FOLDER.$prevpage['parent'].'/index.html');
					unlink(PAGE_FOLDER.$prevpage['parent'].'/index.json');
					rmdir(PAGE_FOLDER.$prevpage['parent']);
				}
			}

			if(write_file(PAGE_FOLDER.$page['parent'].'/'.$page['slug'].'.md', $file_content, 'w+'))
				$this->session->set_flashdata('success', 'Page updated.');
			else
				$this->session->set_flashdata('error', 'Page failed to update. Make sure the folder '.PAGE_FOLDER.' is writable.');

			// update page index
			$this->pusaka->sync_nav();

			redirect('panel/pages');
		}


		$this->template
			->set('type', 'edit')
			->set('page', $prevpage)
			->set('url', $prevslug)
			->set('layouts', $this->template->get_layouts())
			->set('pagelinks', $this->pusaka->get_flatnav())
			->view('page_form');
	} 

	function delete()
	{
		if(!$prevslug = $this->input->get('page')) show_404();

		if(unlink(PAGE_FOLDER.'/'.$prevslug.'.md')){
			$this->session->set_flashdata('success', 'Page '.$prevslug.' deleted.');
			// update page index
			$this->pusaka->sync_nav();
		}
		else
			$this->session->set_flashdata('error', 'Page failed to delete. Make sure the folder '.PAGE_FOLDER.' is writable.');

		redirect('panel/pages');
	}

}