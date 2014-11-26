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

class Auth extends Admin_Controller {

	var $users_path;

	function __construct(){
		parent::__construct();
		
		$this->users_path = 'sites/'.SITE_SLUG.'/users/';
	}

	function index()
	{

		$this->login();
	}

	function login()
	{
		if($this->session->userdata('username')) redirect('panel');

		if($postdata = $this->input->post()){
			
			// check user file exist first, for prevent "file_get_contents" file not found.
			if (file_exists($this->users_path.$postdata['username'].'.json')) {	
				if($user_file = file_get_contents($this->users_path.$postdata['username'].'.json')){
					$userdata = json_decode($user_file, true);
					if(trim($userdata['password']) === trim($postdata['password'])){
						$this->session->set_userdata('username', $postdata['username']);
						// $this->session->set_userdata('group', $userdata[0]);
						redirect('panel');
					} else {
						$this->session->set_flashdata('error', 'username and password not match.');
						redirect('panel/login');
					}
				} else {
					$this->session->set_flashdata('error', 'username not found.');
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