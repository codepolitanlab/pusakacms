<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Nyankod\JsonFileDB;

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
			'rules'   => 'trim|required'
			)
		);

	function __construct(){
		parent::__construct();
		
		if(! $this->logged_in()) redirect('panel/login');

		if(!is_readable(PAGE_FOLDER) || !is_writable(PAGE_FOLDER))
			show_error('Set folder '.PAGE_FOLDER.' readable and writable first.');

		// set page index file
		$this->page_db = new JsonFileDB(PAGE_FOLDER);
		$this->page_db->setTable('index');

		$this->load->model('pages_m');
	}

	/*********************************************
	 * PAGES
	 **********************************************/
	function index()
	{
		// $pages = $this->pusaka->get_pages_tree();
		$pages = $this->page_db->selectAll();
		$pagelist = $this->_page_list($pages);

		$this->template
			->set('pages', $pagelist)
			->view('admin/pages');
	}

	function _page_list($pages)
	{
		return $this->load->view('admin/page_list', array('pages'=>$pages), true);
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

			// prepend and append brackets for array type field
			$page['role'] = '['.trim($page['role']).']';
			$page['meta_keywords'] = '['.trim($page['meta_keywords']).']';
			
			if($this->pages_m->save_page($page)){
				$this->session->set_flashdata('success', 'Page saved.');

				if($this->input->post('btnSaveExit'))
					redirect('panel/pages');
				else
					redirect('panel/pages/edit/'.$page['slug']);
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
			->view('admin/page_form');
	}

	function edit()
	{
		$segs = $this->uri->uri_string();
		// explode to get page slug
		$seg_array = explode("/", $segs, 4);

		if(isset($seg_array[3])){
			$parent = explode("/", $seg_array[3]);
			$prevslug = array_pop($parent);
			$parent = implode("/", $parent);
		}
		else
			show_404();

		$prevpage = $this->pusaka->get_page($seg_array[3], false);
		if(!isset($prevpage['slug']))
			$prevpage['slug'] = $prevslug;

		$this->form_validation->set_rules($this->page_fields);

		if($this->form_validation->run()){
			$page = $this->input->post();

			$page['parent'] = $prevpage['parent'] = $parent;

			// prepend and append brackets for array type field
			$page['role'] = preg_split('/[\ \n\,]+/', $page['role']);
			$page['meta_keywords'] = preg_split('/[\ \n\,]+/', $page['meta_keywords']);
			
			// update page content
			if($this->pages_m->update_page($page, $prevpage))
				$this->session->set_flashdata('success', 'Page updated.');
			else
				$this->session->set_flashdata('error', 'Page failed to update. Make sure the folder '.PAGE_FOLDER.' is writable.');

			if($this->input->post('btnSaveExit'))
				redirect('panel/pages');
			else
				redirect('panel/pages/edit/'.$parent.'/'.$page['slug']);
		}


		$this->template
			->enable_parser_body(false)
			->set('type', 'edit')
			->set('page', $prevpage)
			->set('parent', $parent)
			->set('url', $parent.'/'.$prevpage['slug'])
			->set('layouts', $this->pusaka->get_layouts($this->config->item('theme')))
			->set('pagelinks', $this->pusaka->get_flatnav())
			->view('admin/page_form');
	} 

	function delete()
	{
		$segs = $this->uri->uri_string();
		$seg_array = explode("/", $segs, 4);

		if(isset($seg_array[3]))
			$prevslug = $seg_array[3];
		else
			show_404();

		$source_arr = explode("/", $prevslug);
		$page = array_pop($source_arr);
		$source = implode("/", $source_arr);

		if($this->pusaka->move_page($page, $page, $source, '_trash')){
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

		$this->pusaka->move_page($page, $page, $source, $dest);
		
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

		echo json_encode($map);

		$newmap = array();
		foreach ($map as $value) {
			$newmap[$value['slug']] = $value;
			
			if(isset($value['children']))
				$newmap[$value['slug']]['children'] = $this->sort($value['children']);

			unset($newmap[$value['slug']]['slug']);
		}

		if($arr){
			echo json_encode($newmap);
			return $newmap;
		} else {
			if(! write_file(PAGE_FOLDER.'/index.json', json_encode($newmap, JSON_PRETTY_PRINT)))
				echo '{"status":"error", "message":"Page failed to rearranged. Make sure '.PAGE_FOLDER.'/index.json writable."}';
		}
	}

}