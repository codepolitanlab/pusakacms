<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends Admin_Controller {

	function __construct()
	{
		parent::__construct();

		// check if this site has permission to access this module
		$this->config->load('site');
		if(! in_array(SITE_SLUG, $this->config->item('allowed_sites'))) show_404();

		// check if user has logged in
		if(! $this->logged_in()) redirect('panel/login');
	}

	// List of Sites
	function index()
	{
		// get site folder list
		$sites = directory_map(SITE_FOLDER, 2);

		// filter sites
		$data['sites'] = array();
		foreach ($sites as $key => $val) {
			if($key != '_domain')
				$data['sites'][$key] = json_decode(file_get_contents(SITE_FOLDER.$key.'/config/site.json'), true);
		};

		$this->template->view('index', $data);
	}

	function create()
	{
		if(! is_writable(SITE_FOLDER)){
			$this->session->set_flashdata('error', SITE_FOLDER.' folder is not writable. Please make it writable first.');
			redirect("panel/site", 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('site_slug', 'Site Slug', 'trim|trim|required|xss_clean|callback_site_slug_check');
		$this->form_validation->set_rules('site_slogan', 'Site Slogan', 'trim|xss_clean');
		$this->form_validation->set_rules('site_domain', 'Site Domain', 'trim|xss_clean');

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('company', 'Company', 'trim|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[20]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required');

		if ($this->form_validation->run() == true)
		{
			// create site folder
			$site_slug = $this->input->post('site_slug');
			mkdir(SITE_FOLDER.'/'.$site_slug.'/users/', 0775, true);

			// extract template
			$zip = new ZipArchive;
			$res = $zip->open(SITE_FOLDER.'/template.zip');
			if ($res === TRUE) {
				$zip->extractTo(SITE_FOLDER.'/'.$site_slug.'/');
				$zip->close();
			} else {
				$this->session->set_flashdata('error', 'Cannot extract template files.');
				redirect("panel/site", 'refresh');
			}

			// create site.json
			$site_data = array(
				'site_name'		=> $this->input->post('site_name'),
				'site_slogan'	=> $this->input->post('site_slogan'),
				'site_owner'	=> $this->input->post('email'),
				'site_domain'	=> $this->input->post('site_domain'),
				'protocol'		=> "http",
				'meta_description' => '',
				'meta_keywords'	=> ''
				);
			
			if(! write_file(SITE_FOLDER.'/'.$site_slug.'/config/site.json', json_encode($site_data, JSON_PRETTY_PRINT))){
				$this->session->set_flashdata('error', 'Cannot write site settings.');
				redirect("panel/site", 'refresh');
			}

			// create first admin user
			$user_data = array(
				'first_name'=> $this->input->post('first_name'),
				'last_name'	=> $this->input->post('last_name'),
				'username'	=> $this->input->post('username'),
				'email'		=> $this->input->post('email'),
				'company'	=> $this->input->post('company'),
				'phone'		=> $this->input->post('phone'),
				'password'	=> sha1($this->input->post('password')),
				'group'		=> "admin"
				);

			if(! write_file(SITE_FOLDER.'/'.$site_slug.'/users/'.$user_data['email'].'.json', json_encode($user_data, JSON_PRETTY_PRINT))){
				$this->session->set_flashdata('error', 'Cannot write admin user file.');
				redirect("panel/site", 'refresh');
			}

			// delete default user
			unlink(SITE_FOLDER.'/'.$site_slug.'/users/admin@admin.com.json');

			$this->session->set_flashdata('success', 'New site create.');
			redirect("panel/site", 'refresh');
		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			// site fields
			$data['site_data']['site_name'] = array(
				'title'	=> 'Site Name *',
				'name'  => 'site_name',
				'id'    => 'site_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('site_name'),
				'class' => 'form-control',
				);
			$data['site_data']['site_slug'] = array(
				'title'	=> 'Site Slug *',
				'name'  => 'site_slug',
				'id'    => 'site_slug',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('site_slug'),
				'class' => 'form-control',
				);
			$data['site_data']['site_slogan'] = array(
				'title'	=> 'Site Slogan',
				'name'  => 'site_slogan',
				'id'    => 'site_slogan',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('site_slogan'),
				'class' => 'form-control',
				);
			$data['site_data']['site_domain'] = array(
				'title'	=> 'Site Domain',
				'name'  => 'site_domain',
				'id'    => 'site_domain',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('site_domain'),
				'class' => 'form-control',
				);

			// user fields
			$data['user_data']['first_name'] = array(
				'title'	=> 'First Name *',
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
				'class' => 'form-control',
				);
			$data['user_data']['last_name'] = array(
				'title'	=> 'Last Name *',
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
				'class' => 'form-control',
				);
			$data['user_data']['username'] = array(
				'title'	=> 'Username *',
				'name'  => 'username',
				'id'    => 'username',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('username'),
				'class' => 'form-control',
				);
			$data['user_data']['email'] = array(
				'title'	=> 'Email *',
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
				'class' => 'form-control',
				);
			$data['user_data']['company'] = array(
				'title'	=> 'Company',
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company'),
				'class' => 'form-control',
				);
			$data['user_data']['phone'] = array(
				'title'	=> 'Phone',
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone'),
				'class' => 'form-control',
				);
			$data['user_data']['password'] = array(
				'title'	=> 'Password *',
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password'),
				'class' => 'form-control',
				);
			$data['user_data']['password_confirm'] = array(
				'title'	=> 'Confirm Password *',
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
				'class' => 'form-control',
				);

			$data['csrf'] = $this->_get_csrf_nonce();
		}

		$this->template->view('create', $data);
	}

	function delete()
	{

	}

	function site_slug_check($str)
	{
		if(file_exists(SITE_FOLDER.'/'.$str.'/')){
			$this->form_validation->set_message('site_slug_check', 'Site Slug already taken.');
			return false;
		}

		return true;
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}