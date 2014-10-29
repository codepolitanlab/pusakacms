<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
			),
		);

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		
		if(! $this->session->userdata('username')) redirect('panel/login');

		$this->users_path = 'sites/'. SITE_SLUG .'/users/';
	}

	function index()
	{

		$this->template->view('dashboard');
	}

	function dashboard()
	{
		$this->index();
	}

	function pages()
	{
		$this->template->view('pages');
	}

	function posts()
	{
		
		$this->template->view('posts');
	}

	function navigation()
	{
		
		$this->template->view('navigation');
	}

	function media()
	{
		
		$this->template->view('media');
	}

	function settings()
	{
		// get config files
		$config_path = 'sites/'.SITE_SLUG.'/config/';
		$config_file = array_filter(scandir($config_path), function($user){
			return (! in_array($user, array('.','..','index.html')));
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

	function users()
	{
		// get user files
		$users_file = array_filter(scandir($this->users_path), function($user){
			return (! in_array($user, array('.','..','index.html')));
		});

		$users = array();
		foreach ($users_file as $username) {
			$users[substr($username, 0, -5)] = json_decode(file_get_contents($this->users_path.$username), true);
		}

		$this->template
		->set('users', $users)
		->view('users');
	}

	function new_post()
	{

		$this->template->view('form_post', array('type'=>'edit'));
	}

	function edit_post()
	{

		$this->template->view('form_post', array('type'=>'edit'));
	}

	function new_page()
	{

		$this->template->view('form_page');
	}

	function edit_page()
	{

		$this->template->view('form_page');
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
		->view('form_user');
	}

	function edit_user($username = false)
	{
		if(! $username) redirect('panel/users');

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
		->view('form_user');
	}

	// function check_username($username)
	// {
	// 	if(file_exists($this->users_path.$username.'.json')) {
	// 		$this->form_validation->set_message(__FUNCTION__, 'The username has been used. Try another username.');
	// 		return false;
	// 	} else
	// 		return true;
	// }

}