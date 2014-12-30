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

class Users extends Admin_Controller {

	public $users_path;

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

	function __construct(){
		parent::__construct();

		if(! $this->logged_in()) redirect('panel/login');

		$this->users_path = SITE_FOLDER. SITE_SLUG .'/users/';

		if(!is_readable($this->users_path) || !is_writable($this->users_path))
			show_error('Set folder '.$this->users_path.' and its contents readable and writable first.');
	}


	/*********************************************
	 * USERS
	 **********************************************/	

	function index()
	{
		// get user files
		$users_file = array_filter(scandir($this->users_path), function($user){
			return (substr($user, -5) == '.json' && $user != '_blueprint.json');
		});

		$users = array();
		foreach ($users_file as $username) {
			$users[substr($username, 0, -5)] = json_decode(file_get_contents($this->users_path.$username), true);
		}

		$this->template
		->set('users', $users)
		->view('users');
	}

	function create()
	{
		$this->form_validation->set_rules($this->user_fields);

		// submit if data valid
		if($this->form_validation->run()){
			$post = $this->input->post();

			// encrypt password
			$post['password'] = sha1($post['password']);
			$post['role'] = 'admin';

			// unset passconf
			unset($post['passconf']);

			$post_json = json_encode($post, JSON_PRETTY_PRINT);

			if(file_exists($this->users_path.$post['username'].'.json')) {
				$this->session->set_flashdata('error', "Username '{$post['username']}' has been used. Try another username.");
				redirect('panel/users/create');
			}

			if(write_file($this->users_path.$post['username'].'.json', $post_json)){
				$this->session->set_flashdata('success', 'New user saved.');
				redirect('panel/users');
			} else {
				$this->session->set_flashdata('error', $this->users_path.' folder is not writtable.');
				redirect('panel/users/create');
			}
		}

		$this->template
		->set('type', 'create')
		->view('user_form');
	}

	function edit($username = false)
	{
		if(! $username) show_404();

		$this->form_validation->set_rules($this->user_fields);

		// submit if data valid
		if($this->form_validation->run()){
			$post = $this->input->post();

			// encrypt password
			$post['password'] = sha1($post['password']);
			$post['role'] = 'admin';

			// unset passconf
			unset($post['passconf']);

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

	function delete($user = false)
	{
		if(! $user) show_404();

		if(unlink($this->users_path.$user.'.json'))
			$this->session->set_flashdata('success', 'User '.$user.' deleted successfuly.');
		else
			$this->session->set_flashdata('error', 'User '.$user.' fail to delete. Make sure the folder '.$this->users_path.' is writable.');

		redirect('panel/users');
	}

}