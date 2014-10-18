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

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
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
			$config[substr($confile, 0, -5)] = json_decode(read_file($config_path.$confile));
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
		$users_path = 'sites/'.SITE_SLUG.'/users/';
		$users_file = array_filter(scandir($users_path), function($user){
			return (! in_array($user, array('.','..','index.html')));
		});

		$users = array();
		foreach ($users_file as $username) {
			$user_file = read_file($users_path.$username);
			$users[$username] = explode("\n", trim($user_file));
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

	function login()
	{
		if($this->session->userdata('username')) redirect('panel/dashboard');

		if($postdata = $this->input->post()){
			$users_path = 'sites/'.SITE_SLUG.'/users/';
			if($user_file = read_file($users_path.$postdata['username'])){
				$userdata = explode("\n", trim($user_file));
				if(trim($userdata[1]) === trim($postdata['password'])){
					$this->session->set_userdata('username', $postdata['username']);
					$this->session->set_userdata('group', $userdata[0]);
					redirect('panel/dashboard');
				} else {
					$this->session->set_flashdata('error', 'username and password not match.');
					redirect('panel/login');
				}
			} else {
				$this->session->set_flashdata('error', 'username not found.');
				redirect('panel/login');
			}
		}

		$this->template->set_layout('login')->view('login');
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('panel/login');
	}

}