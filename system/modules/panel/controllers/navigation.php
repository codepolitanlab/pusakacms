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

class Navigation extends Admin_Controller {

	public $users_path;
	public $nav_db;

	var $nav_area_fields = array(
			array(
				'field'   => 'area-title', 
				'label'   => 'Area Name', 
				'rules'   => 'trim|required'
				)
			);

	var $link_fields = array(
			array(
				'field'   => 'link_title', 
				'label'   => 'Link Title', 
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_slug', 
				'label'   => 'Link Slug',
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_url', 
				'label'   => 'Link URL', 
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_source', 
				'label'   => 'Link Source', 
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_area', 
				'label'   => 'Navigation Area', 
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_target', 
				'label'   => 'Link Target', 
				'rules'   => 'trim|required'
				)
			);

	function __construct(){
		parent::__construct();

		if(! $this->session->userdata('username')) redirect('panel/login');

		$this->nav_db = new Nyankod\JsonFileDB(NAV_FOLDER);

		$this->users_path = 'sites/'. SITE_SLUG .'/users/';
	}

	/*********************************************
	 * NAVIGATION
	 **********************************************/	

	function index()
	{
		$files = array_filter(scandir(NAV_FOLDER), function($file){
			return (substr($file, -5) == '.json');
		});

		$areas = array();

		if(! empty($files))
			foreach ($files as $file) {
				$this->nav_db->setTable(substr($file, 0, -5));
				$areas[substr($file, 0, -5)] = $this->nav_db->selectAll();

				if(! $areas[substr($file, 0, -5)])
					$areas[substr($file, 0, -5)] = false;
			}

		$this->template
			->set('areas', $areas)
			->view('navigation');
	}

	function navigation_list($area, $links = array(), $root = false)
	{
		return $this->load->view('navigation_list', array('area' => $area, 'links' => $links, 'root' => $root), true);
	}

	function get_flatnav($area = false, $arr = null, $prefix = '', $return = true)
	{
		if(empty($arr))
			$arr = json_decode(file_get_contents(NAV_FOLDER.$area.'.json'), true);

		$flat = array();
		foreach($arr as $link){
			$flat[$link['url']] = $prefix.' '.$link['title'];
			if(isset($link['children']) && ! empty($link['children']))
				$flat += $this->get_flatnav($area, $link['children'], $prefix.'—');
		}

		if($return)
			return $flat;
		else
			echo json_encode($flat);
	}

	function get_nav_parent_option($area = false, $arr = null, $prefix = '', $return = true)
	{
		$data = $this->get_flatnav($area, $arr, $prefix, $return);
		$options = '<option value="">- no parent -</option>';
		foreach ($data as $key => $value) {
			$options .= '<option value="'.$key.'">'.$value.'</option>'."\n";
		}
		echo $options;
	}

	function create_area()
	{
		$this->form_validation->set_rules($this->nav_area_fields);

		// submit if data valid
		if($this->form_validation->run()) {
			$area = url_title($this->input->post('area-title'));
			if(file_exists(NAV_FOLDER.$area.'.json'))
				$this->session->set_flashdata('error', 'Navigation area "'.$area.'" has been used. Try another term.');
			else {
				if($this->nav_db->setTable($area))
					$this->session->set_flashdata('success', 'Navigation area saved.');
				else
					$this->session->set_flashdata('error', 'Navigation failed to save. Make sure the folder '.NAV_FOLDER.' is writable.');
			}
		} else {
			$this->session->set_flashdata('error', validation_errors());
		}
		redirect('panel/navigation');
	}
	
	function edit_area($slug = false)
	{
		if(! $slug) show_404();

		$this->form_validation->set_rules($this->nav_area_fields);

		// submit if data valid
		if($this->form_validation->run()) {
			$area = url_title($this->input->post('area-title'));
			if(file_exists(NAV_FOLDER.$area.'.json'))
				$this->session->set_flashdata('error', 'Navigation area "'.$area.'" has been used. Try another term.');
			else {
				if(! file_exists(NAV_FOLDER.$slug.'.json'))
					$this->session->set_flashdata('error', 'Navigation area "'.$area.'" not found.');
				else {
					if(rename(NAV_FOLDER.$slug.'.json', NAV_FOLDER.$area.'.json')) {
						$this->session->set_flashdata('success', 'Navigation area updated.');
					} else
					$this->session->set_flashdata('error', 'Navigation failed to save. Make sure the folder '.NAV_FOLDER.' is writable.');
				}
			}
		} else {
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect('panel/navigation');
	}

	function delete_area($area = false)
	{
		if(!$area) show_404();

		if(unlink(NAV_FOLDER.$area.'.json'))
			$this->session->set_flashdata('success', 'Navigation area '.$area.' deleted.');
		else
			$this->session->set_flashdata('else', 'Navigation area fail to delete. Make sure the '.NAV_FOLDER.' writable.');

		redirect('panel/navigation');
	}

	function create_link()
	{
		$this->form_validation->set_rules($this->link_fields);

		// submit if data valid
		if($this->form_validation->run()) {
			$link = $this->input->post();

			if(! file_exists(NAV_FOLDER.$link['link_area'].'.json')){
				$this->session->set_flashdata('error', 'Navigation area "'.$link['link_area'].'" not found. Use only area term you have made.');
				redirect('panel/navigation');
			}

			if(! is_writable(NAV_FOLDER.$link['link_area'].'.json')){
				$this->session->set_flashdata('error', 'Navigation area "'.$area.'" file is not writtable. Give it write permision first.');
				redirect('panel/navigation');
			}

			$this->nav_db->setTable($link['link_area']);
			$new_link = array(
				'title' => $link['link_title'],
				'slug' => $link['link_slug'],
				'source' => $link['link_source'],
				'url' => $link['link_url'],
				'target' => $link['link_target']
				);

			if($this->nav_db->insert($new_link))
				$this->session->set_flashdata('success', 'Link saved.');
			else
				$this->session->set_flashdata('error', 'Link failed to save. Make sure the folder '.NAV_FOLDER.' is writable.');
		
		} else {
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect('panel/navigation');
	}

	function edit_link($oldarea = false, $oldslug = false)
	{
		if(! $oldarea || ! $oldslug) show_404();

		$this->form_validation->set_rules($this->link_fields);

		// submit if data valid
		if($this->form_validation->run()) {
			$link = $this->input->post();

			if(! file_exists(NAV_FOLDER.$link['link_area'].'.json')){
				$this->session->set_flashdata('error', 'Navigation area "'.$link['link_area'].'" not found. Use only area term you have made.');
				redirect('panel/navigation');
			}

			if(! is_writable(NAV_FOLDER.$link['link_area'].'.json')){
				$this->session->set_flashdata('error', 'Navigation area "'.$link['link_area'].'" file is not writtable. Give it write permision first.');
				redirect('panel/navigation');
			}

			$succ_msg = "";
			$err_msg = "";
			$this->nav_db->setTable($link['link_area']);

			$area_arr = array(
				'title' => $link['link_title'],
				'slug' => $link['link_slug'],
				'source' => $link['link_source'],
				'url' => $link['link_url'],
				'target' => $link['link_target']
				);

			// if area changed
			if($oldarea == $link['link_area']){
				// update link
				if($this->nav_db->update('slug', $oldslug, $area_arr))
					$succ_msg .= 'Link updated.';
				else
					$err_msg .= 'Link failed to update. Make sure the folder '.NAV_FOLDER.' is writable.';

			} else {
				// insert link to new area
				$this->nav_db->insert($area_arr);

				// delete link from old area
				$this->nav_db->setTable($oldarea);
				if($this->nav_db->delete('slug', $oldslug))
					$succ_msg .= '<br>Link moved to new area.';
				else
					$err_msg .= '<br>Link failed to move to new area. Make sure the folder '.NAV_FOLDER.' is writable.';
			}

			if(!empty($succ_msg))
				$this->session->set_flashdata('success', $succ_msg);
			
			if(!empty($err_msg))
				$this->session->set_flashdata('error', $err_msg);

		} else {
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect('panel/navigation');
	}

	function delete_link($area = false, $slug = false)
	{
		if(! $area || ! $slug) show_404();

		if(! file_exists(NAV_FOLDER.$area.'.json')){
			$this->session->set_flashdata('error', 'Navigation area "'.$area.'" not found.');
			redirect('panel/navigation');
		}

		if(! is_writable(NAV_FOLDER.$area.'.json')){
			$this->session->set_flashdata('error', 'Navigation area "'.$area.'" file is not writtable. Give it write permision first.');
			redirect('panel/navigation');
		}

		$this->nav_db->setTable($area);

		if($this->nav_db->delete('slug', $slug))
			$this->session->set_flashdata('success', 'Link "'.$slug.'" deleted.');
		else
			$this->session->set_flashdata('error', 'Link failed to delete. Make sure the folder '.NAV_FOLDER.' is writable.');

		redirect('panel/navigation');
	}

	function sort($area = false)
	{
		if($area){
			$stringvar = str_replace(array("[[","]]"), array("[","]"), $this->input->post('newmap'));
			$testvar = json_decode($stringvar, true);

			if(write_file(NAV_FOLDER.$area.'.json', json_encode($testvar, JSON_PRETTY_PRINT)))
				echo "menu rearranged.";
			else
				echo "error. file not writable.";
		} else
			echo "error. area not specified.";
	}

}