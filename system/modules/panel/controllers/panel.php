<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// use nyankod\JsonDB;

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

	var $users_path;

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
			'field'   => 'label',
			'label'   => 'Labels', 
			'rules'   => 'trim'
			)
		);

	var $user_fields = array(
		array(
			'field'   => 'username', 
			'label'   => 'Username', 
			'rules'   => 'trim|required'
			),
		array(
			'field'   => 'password', 
			'label'   => 'Password', 
			'rules'   => 'required|matches[passconf]'
			),
		array(
			'field'   => 'passconf', 
			'label'   => 'Confirm Password', 
			'rules'   => 'required'
			)
		);

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
		$this->load->library('form_validation');
		
		if(! $this->session->userdata('username')) redirect('panel/login');

		$this->users_path = 'sites/'. SITE_SLUG .'/users/';
	}


	/*********************************************
	 * DASHBOARD
	 **********************************************/

	function index()
	{

		$this->template->view('dashboard');
	}

	function dashboard()
	{
		$this->index();
	}

	/*********************************************
	 * PAGES
	 **********************************************/

	function pages()
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

	function sync_page()
	{
		$this->pusaka->sync_nav();
		redirect('panel/pages');
	}

	function new_page()
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
			->set('type', 'new')
			->set('page', '')
			->set('url', '')
			->set('layouts', $this->template->get_layouts())
			->set('pagelinks', $this->pusaka->get_flatnav())
			->view('page_form');
	}

	function edit_page()
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

	function delete_page()
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

	/*********************************************
	 * POSTS
	 **********************************************/

	function posts($category = 'all', $page = 1)
	{
		$posts = $this->pusaka->get_posts($category, $page);

		$this->template
			->set('posts', $posts)
			->view('posts');
	}

	function new_post()
	{
		$this->form_validation->set_rules($this->post_fields);

		if($this->form_validation->run()){
			$post = $this->input->post();
			$file_content = "";

			// set content
			foreach ($post as $key => $value) {
				if($value)
					if($key == 'slug')
						$file_content .= "{: ".$key." :} ".strtolower(url_title($value))."\n";
					else
						$file_content .= "{: ".$key." :} ".$value."\n";
			}

			$date = date("Y-m-d-");
			
			if(write_file(POST_FOLDER.$date.$post['slug'].'.md', $file_content)){
				$this->session->set_flashdata('success', 'Post saved.');

				// update post index
				$this->pusaka->sync_nav(POST_TERM);
				$this->pusaka->sync_label();

				redirect('panel/posts');
			}
			else {
				$this->template->set('error', 'Post failed to save. Make sure the folder '.POST_FOLDER.' is writable.');
			}

		}

		$this->template
			->set('type', 'new')
			->set('post', '')
			->set('url', '')
			->set('layouts', $this->template->get_layouts())
			->view('post_form');
	}

	function edit_post()
	{
		if(!$prevslug = $this->input->get('post')) show_404();

		$prevpost = $this->pusaka->get_post($prevslug, false);
		$prevpost['labels'] = implode(",", $prevpost['labels']);

		$this->form_validation->set_rules($this->post_fields);

		if($this->form_validation->run()){
			$post = $this->input->post();
			$file_content = "";

			// set content
			foreach ($post as $key => $value) {
				if($value)
					if($key == 'slug')
						$file_content .= "{: ".$key." :} ".strtolower(url_title($value))."\n";
					else
						$file_content .= "{: ".$key." :} ".$value."\n";
			}

			$date = $prevpost['date'].'-';

			// rename post first
			if($prevpost['slug'] != $post['slug'])
				rename(POST_FOLDER.$date.$prevpost['slug'].'.md', POST_FOLDER.$date.$post['slug'].'.md');
			
			if(write_file(POST_FOLDER.$date.$post['slug'].'.md', $file_content)){
				$this->session->set_flashdata('success', 'Post updated.');

				// update post index
				$this->pusaka->sync_nav(POST_TERM);
				$this->pusaka->sync_label();

				redirect('panel/posts');
			}
			else {
				$this->template->set('error', 'Post failed to update. Make sure the folder '.POST_FOLDER.' is writable.');
			}

		}

		$this->template
			->set('type', 'edit')
			->set('url', $prevslug)
			->set('post', $prevpost)
			->view('post_form');
	}

	function delete_post()
	{
		if(!$file = $this->input->get('post')) show_404();

		if(unlink(POST_FOLDER.'/'.$file)){
			$this->session->set_flashdata('success', 'Post '.$file.' deleted.');

			// update post index
			$this->pusaka->sync_nav(POST_TERM);
			$this->pusaka->sync_label();
		}
		else
			$this->session->set_flashdata('error', 'Post failed to delete. Make sure the folder '.PAGE_FOLDER.' is writable.');

		redirect('panel/posts');
	}

	function sync_post()
	{
		$this->pusaka->sync_nav(POST_TERM);
		$this->pusaka->sync_label();
		redirect('panel/posts');
	}

	/*********************************************
	 * NAVIGATION
	 **********************************************/	

	function navigation()
	{
		$files = array_filter(scandir(NAV_FOLDER), function($file){
			return (substr($file, -5) == '.json');
		});

		$db = new JsonDB(NAV_FOLDER);
		$areas = array();

		foreach ($files as $file) {
			$areas[substr($file, 0, -5)] = $db->selectAll(substr($file, 0, -5));
			if($areas[substr($file, 0, -5)][0] === 0)
				$areas[substr($file, 0, -5)] = array();
		}
		
		$this->template
			->set('areas', $areas)
			->view('navigation');
	}

	function new_nav_area()
	{
		$this->form_validation->set_rules($this->nav_area_fields);

		// submit if data valid
		if($this->form_validation->run()) {
			$area = url_title($this->input->post('area-title'));
			if(file_exists(NAV_FOLDER.$area.'.json'))
				$this->session->set_flashdata('error', 'Navigation area "'.$area.'" has been used. Try another term.');
			else {
				$db = new JsonDB(NAV_FOLDER);
				$file = array('empty'=>true);
				if($db->insert($area, $file))
					$this->session->set_flashdata('success', 'Navigation area saved.');
				else
					$this->session->set_flashdata('error', 'Navigation failed to save. Make sure the folder '.NAV_FOLDER.' is writable.');
			}
		} else {
			$this->session->set_flashdata('error', validation_errors());
		}
		redirect('panel/navigation');
	}
	
	function edit_nav_area($slug = false)
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
					$db = new JsonDB(NAV_FOLDER);
					$new_file = $db->selectAll($slug);
					if(write_file(NAV_FOLDER.$area.'.json', json_encode($new_file, JSON_PRETTY_PRINT))){
						$this->session->set_flashdata('success', 'Navigation area updated.');
						unlink(NAV_FOLDER.$slug.'.json');
					} else
					$this->session->set_flashdata('error', 'Navigation failed to save. Make sure the folder '.NAV_FOLDER.' is writable.');
				}
			}
		} else {
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect('panel/navigation');
	}

	function delete_nav_area()
	{

	}

	function tes()
	{
		$db = new JsonDB(NAV_FOLDER);
		// $db->setPrettyOutput('header', true);
		$data = array(
			'title' => 'Docs',
			'url' => 'uri'
			);
		// print_r($db->select('header', 'title', 'Blog'));
		// print_r($db->selectAll('header'));
		// print_r($db->insert('header', $data));
		print_r($db->deleteAll('header'));
	}

	function add_link()
	{
		$this->form_validation->set_rules($this->link_fields);

		// submit if data valid
		if($this->form_validation->run()) {
			$link = $this->input->post();

			if(! file_exists(NAV_FOLDER.$link['link_area'].'.json')){
				$this->session->set_flashdata('error', 'Navigation area "'.$link['link_area'].'" not found. Use only area term you have made.');
				redirect('panel/navigation');
			}

			$db = new JsonDB(NAV_FOLDER);
			$new_link = array(
				'title' => $link['link_title'],
				'source' => $link['link_source'],
				'url' => $link['link_url'],
				'target' => $link['link_target']
				);

			if($db->insert($link['link_area'], $new_link))
				$this->session->set_flashdata('success', 'Link saved.');
			else
				$this->session->set_flashdata('error', 'Link failed to save. Make sure the folder '.NAV_FOLDER.' is writable.');
		
		} else {
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect('panel/navigation');
	}

	function edit_link($oldarea = false, $oldtitle = false)
	{
		if(! $oldarea || ! $oldtitle) show_404();

		$this->form_validation->set_rules($this->link_fields);

		// submit if data valid
		if($this->form_validation->run()) {
			$link = $this->input->post();

			if(! file_exists(NAV_FOLDER.$link['link_area'].'.json')){
				$this->session->set_flashdata('error', 'Navigation area "'.$link['link_area'].'" not found. Use only area term you have made.');
				redirect('panel/navigation');
			}

			$area = file_get_contents(NAV_FOLDER.$link['link_area'].'.json');
			$area_arr = json_decode($area, true);

			print_r($area_arr);
			// if link title changed
			if($oldtitle != $link['link_title'])
				unset($area_arr['links'][$oldtitle]);

			$area_arr['links'][$link['link_title']] = array(
				'source' => $link['link_source'],
				'url' => $link['link_url'],
				'target' => $link['link_target']
				);

			$succ_msg = "";
			$err_msg = "";

			if(write_file(NAV_FOLDER.$link['link_area'].'.json', json_encode($area_arr, JSON_PRETTY_PRINT)))
				$succ_msg = 'Link updated.';
			else
				$err_msg = 'Link failed to update. Make sure the folder '.NAV_FOLDER.' is writable.';

			// if area changed
			if($oldarea != $link['link_area']){
				$old_area = file_get_contents(NAV_FOLDER.$oldarea.'.json');
				$old_area_arr = json_decode($old_area, true);

				// delete old link
				unset($old_area_arr['links'][$oldtitle]);

				if(write_file(NAV_FOLDER.$oldarea.'.json', json_encode($old_area_arr, JSON_PRETTY_PRINT)))
					$succ_msg .= '<br>Link moved to new area.';
				else
					$err_msg = '<br>Link failed to move to new area. Make sure the folder '.NAV_FOLDER.' is writable.';
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

	function delete_link($area = false, $title = false)
	{
		if(! $area || ! $title) show_404();

		if(! file_exists(NAV_FOLDER.$area.'.json')){
			$this->session->set_flashdata('error', 'Navigation area "'.$area.'" not found.');
			redirect('panel/navigation');
		}

		$file = file_get_contents(NAV_FOLDER.$area.'.json');
		$nav = json_decode($file, true);

		unset($nav['links'][urldecode($title)]);

		if(write_file(NAV_FOLDER.$area.'.json', json_encode($nav, JSON_PRETTY_PRINT)))
			$this->session->set_flashdata('success', 'Link "'.$title.'" deleted.');
		else
			$this->session->set_flashdata('error', 'Link failed to delete. Make sure the folder '.NAV_FOLDER.' is writable.');

		redirect('panel/navigation');
	}


	/*********************************************
	 * MEDIA
	 **********************************************/

	function media()
	{
		
		$this->template->view('media');
	}


	/*********************************************
	 * SETTINGS
	 **********************************************/

	function settings()
	{
		// get config files
		$config_path = 'sites/'.SITE_SLUG.'/config/';
		$config_file = array_filter(scandir($config_path), function($user){
			return (substr($user, -5) == '.json');
		});

		$savefile = array();
		$validation_rules = array();
		foreach ($config_file as $confile) {
			$config[substr($confile, 0, -5)] = json_decode(file_get_contents($config_path.$confile), true);
			$savefile[substr($confile, 0, -5)] = array();

			// set validation rules
			foreach ($config[substr($confile, 0, -5)] as $key => $value) {
				$this->form_validation->set_rules(substr($confile, 0, -5).'__'.$key, '<strong>'.substr($confile, 0, -5).'__'.$key.'</strong>', 'trim');
			}
		}

		// submit if data valid
		if($this->form_validation->run()){
			$post = $this->input->post();
			foreach ($post as $postkey => $postval) {
				$field = explode("__", $postkey);
				$savefile[$field[0]] += array($field[1] => $postval);
			}

			// save config to file
			foreach ($savefile as $filekey => $fileval) {
				if(! write_file($config_path.$filekey.'.json', json_encode($fileval, JSON_PRETTY_PRINT))){
					$this->session->set_flashdata('error', 'unable to save '.$filekey.' settings to '.$filekey.'.json file.');
					redirect('panel/settings');	
				}
			}

			$this->session->set_flashdata('success', 'config saved.');
			redirect('panel/settings');
		}

		$this->template
		->set('tab', 'site')
		->set('config', $config)
		->view('settings');
	}


	/*********************************************
	 * USERS
	 **********************************************/	

	function users()
	{
		// get user files
		$users_file = array_filter(scandir($this->users_path), function($user){
			return (substr($user, -5) == '.json');
		});

		$users = array();
		foreach ($users_file as $username) {
			$users[substr($username, 0, -5)] = json_decode(file_get_contents($this->users_path.$username), true);
		}

		$this->template
		->set('users', $users)
		->view('users');
	}

	function new_user()
	{
		$this->form_validation->set_rules($this->user_fields);

		// submit if data valid
		if($this->form_validation->run()){
			$post = $this->input->post();
			$post_json = json_encode($post, JSON_PRETTY_PRINT);

			if(file_exists($this->users_path.$post['username'].'.json')) {
				$this->session->set_flashdata('error', "Username '{$post['username']}' has been used. Try another username.");
				redirect('panel/users/new');
			}

			if(write_file($this->users_path.$post['username'].'.json', $post_json)){
				$this->session->set_flashdata('success', 'New user saved.');
				redirect('panel/users');
			} else {
				$this->session->set_flashdata('error', $this->users_path.' folder is not writtable.');
				redirect('panel/users/new');
			}
		}

		$this->template
		->set('type', 'new')
		->view('user_form');
	}

	function edit_user($username = false)
	{
		if(! $username) show_404();

		$this->form_validation->set_rules($this->user_fields);

		// submit if data valid
		if($this->form_validation->run()){
			$post = $this->input->post();
			$post_json = json_encode($post, JSON_PRETTY_PRINT);

			if(write_file($this->users_path.$username.'.json', $post_json)){
				$this->session->set_flashdata('success', 'User edited.');
	
				// if username changed
				if($username != $post['username'])
					rename($this->users_path.$username.'.json', $this->users_path.$post['username'].'.json');
			} else {
				$this->session->set_flashdata('error', $this->users_path.' folder is not writtable.');
			}

			redirect('panel/users');
		}
		

		if($user = file_get_contents($this->users_path.$username.'.json')) {
			$user_json = json_decode($user, true);
		} else {
			$this->session->set_flashdata("error", "The user is not found so that can't be edited.\nTo create a new one, klick Add New User button.");
			redirect('panel/users');
		}

		$this->template
		->set('type', 'edit')
		->set('username', $username)
		->set('user', $user_json)
		->view('user_form');
	}

	function delete_user($user = false)
	{
		if(! $user) show_404();

		if(unlink($this->users_path.$user.'.json'))
			$this->session->set_flashdata('success', 'User '.$user.' deleted successfuly.');
		else
			$this->session->set_flashdata('error', 'User '.$user.' fail to delete. Make sure the folder '.$this->users_path.' is writable.');

		redirect('panel/users');
	}

}