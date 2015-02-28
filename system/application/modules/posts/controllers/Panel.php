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

	public $nav_db;

	var $post_fields = array(
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
			),
		array(
			'field'   => 'intro',
			'label'   => 'Introduction', 
			'rules'   => 'trim'
			),
		array(
			'field'   => 'post_image',
			'label'   => 'Featured Image', 
			'rules'   => 'trim'
			),
		array(
			'field'   => 'label',
			'label'   => 'Labels', 
			'rules'   => 'trim'
			)
		);

	function __construct(){
		parent::__construct();
		
		if(! $this->logged_in()) redirect('panel/login');

		if(!is_readable(POST_FOLDER) || !is_writable(POST_FOLDER))
			show_error('Set folder '.POST_FOLDER.' and its contents readable and writable first.');
	}


	/*********************************************
	 * POSTS
	 **********************************************/

	function index($category = 'all', $page = 1)
	{
		$posts = $this->pusaka->get_posts($category, $page);

		$this->template
			->set('posts', $posts)
			->set('label', $category)
			->view('posts');
	}

	function create()
	{
		$this->form_validation->set_rules($this->post_fields);

		if($this->form_validation->run()){
			$post = $this->input->post();
			$file_content = "{: author :} ".$this->session->userdata('username')."\n";

			// set content
			foreach ($post as $key => $value) {
				if($key == 'slug')
					$file_content .= "{: ".$key." :} ".strtolower(url_title($value))."\n";
				else
					$file_content .= "{: ".$key." :} ".$value."\n";
			}

			$date = date("Y-m-d-H-i-");
			
			if(write_file(POST_FOLDER.$date.$post['slug'].'.md', $file_content)){
				$this->session->set_flashdata('success', 'Post saved.');

				// call event after_insert
				$post['filename'] = $date.$post['slug'].'.md';
				$postmeta = $this->pusaka->create_post_attributes($post['filename']);
				$post = array_merge($post, $postmeta);
				$this->call_event('Posts', 'after_insert', $post);

				// update post index
				$this->sync(false);

				if($this->input->post('btnSaveExit'))
					redirect('panel/posts');
				else
					redirect('panel/posts/edit/'.$post['filename']);
			}
			else {
				$this->template->set('error', 'Post failed to save. Make sure the folder '.POST_FOLDER.' is writable.');
			}

		}

		$this->template
			->set('type', 'create')
			->set('post', '')
			->set('filename', null)
			->set('url', '')
			->set('layouts', $this->pusaka->get_layouts($this->config->item('theme')))
			->view('post_form');
	}

	function edit()
	{
		$prevname = $this->uri->segment(4);
		if(! isset($prevname))
			show_404();

		$prevpost = $this->pusaka->get_post($prevname, false, false, true);
		$prevpost['labels'] = (!empty($prevpost['labels']))? implode(",", $prevpost['labels']) : '';
		$prevpost['slug'] = (isset($prevpost['slug']))? $prevpost['slug'] : $prevname;

		$this->form_validation->set_rules($this->post_fields);

		if($this->form_validation->run()){
			$post = $this->input->post();
			$file_content = "{: author :} ";
			$file_content .= isset($prevpost['author']) ? $prevpost['author'] : $this->session->userdata('username');
			$file_content .= "\n";

			// set content
			foreach ($post as $key => $value) {
				if($key == 'slug')
					$file_content .= "{: ".$key." :} ".strtolower(url_title($value))."\n";
				else
					$file_content .= "{: ".$key." :} ".$value."\n";
			}

			$date = date("Y-m-d-H-i", strtotime($prevpost['date'])).'-';
			$redir_date = date("Y/m/d/", strtotime($prevpost['date']));

			// rename post first
			if($prevpost['slug'] != $post['slug'])
				rename(POST_FOLDER.$date.$prevpost['slug'].'.md', POST_FOLDER.$date.$post['slug'].'.md');
			
			if(write_file(POST_FOLDER.$date.$post['slug'].'.md', $file_content)){
				$this->session->set_flashdata('success', 'Post updated.');

				// call event after_update
				$post['filename'] = $date.$post['slug'].'.md';
				$postmeta = $this->pusaka->create_post_attributes($post['filename']);
				$post = array_merge($post, $postmeta);
				$this->call_event('Posts', 'after_update', $date.$prevpost['slug'].'.md', $post);

				// update post index
				$this->sync(false);

				if($this->input->post('btnSaveExit'))
					redirect('panel/posts');
				else
					redirect('panel/posts/edit/'.$date.$post['slug'].'.md');
			}
			else {
				$this->template->set('error', 'Post failed to update. Make sure the folder '.POST_FOLDER.' is writable.');
			}

		}

		$this->template
			->enable_parser_body(false)
			->set('type', 'edit')
			->set('filename', $prevname)
			->set('post', $prevpost)
			->set('layouts', $this->pusaka->get_layouts($this->config->item('theme')))
			->view('post_form');
	}

	function delete()
	{
		$file = $this->uri->segment(4);

		if(! isset($file))
			show_404();

		if(unlink(POST_FOLDER.'/'.$file)){
			$this->session->set_flashdata('success', 'Post '.$file.' deleted.');

			// call event after_update
			$this->call_event('Posts', 'after_delete', $file);

			// update post index
			$this->sync(false);
		}
		else
			$this->session->set_flashdata('error', 'Post failed to delete. Make sure the folder '.PAGE_FOLDER.' is writable.');

		redirect('panel/posts');
	}

	function sync($redirect = true)
	{
		$nav = $this->pusaka->sync_post();
		$label = $this->pusaka->sync_label();

		if($nav['status'] == $label['status'])
			$this->session->set_flashdata($label['status'], $nav['message'] . $label['message']);
		else {
			$this->session->set_flashdata($nav['status'], $nav['message']);
			$this->session->set_flashdata($label['status'], $label['message']);
		}

		if($redirect)
			redirect('panel/posts');
	}

	function coba()
	{
		echo "sadasdas";
		print_r($_SESSION);
	}
}