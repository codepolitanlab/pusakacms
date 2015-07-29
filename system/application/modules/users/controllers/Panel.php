<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends Admin_Controller
{
	
	function __construct() 
	{
		parent::__construct();
		
		if ($this->config->item('filebased', 'ion_auth') === FALSE) $this->load->database();
		else if (!is_writable(SITE_PATH . 'db/users.json') || !is_writable(SITE_PATH . 'db/groups.json')) show_error('Files users.json and groups.json in folder ' . SITE_PATH . 'db/ must be writable.');
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth') , $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->lang->load('auth');
		$this->load->helper('language');
		
		// get User Account path and load the class
		$blueprint_path = Modules::find('Users_account', 'users', 'blueprint/');
		$this->account_form = $this->cpformutil->load('Users_account', $blueprint_path[0]);
	}
	
	//redirect if needed, otherwise display the user list
	function index() 
	{
		
		if (!$this->logged_in()) 
		{
			
			//redirect them to the login page
			redirect('panel/login', 'refresh');
		} 
		elseif (!$this->ion_auth->is_admin())
		
		//remove this elseif if you want to enable this for non-admins
		
		{
			
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} 
		else
		{
			
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			//list the users
			// check model used, file based or databased
			if ($this->config->item('filebased', 'ion_auth')) 
			{
				$this->data['users'] = $this->ion_auth->users();
				foreach ($this->data['users'] as $k => $user) 
				{
					$this->data['users'][$k]['groups'] = $this->ion_auth->get_users_groups($user['id']);
				}
				$this->data['groups'] = $this->ion_auth->groups();
			} 
			else
			{
				$this->data['users'] = $this->ion_auth->users()->result_array();
				foreach ($this->data['users'] as $k => $user) 
				{
					$this->data['users'][$k]['groups'] = $this->ion_auth->get_users_groups($user['id']);
				}
				
				$this->data['groups'] = $this->ion_auth->groups()->result_array();
			}
			
			$this->_render_page('users/index', $this->data);
		}
	}
	
	//create a new user
	function create_user() 
	{
		$this->data['title'] = "Create User";
		
		if (!$this->logged_in() || !$this->ion_auth->is_admin()) 
		{
			redirect('panel/users', 'refresh');
		}
		
		$tables = $this->config->item('tables', 'ion_auth');
		
		// init account form
		$this->account_form->init();
		
		if ($this->account_form->validate()) 
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email = strtolower($this->input->post('email'));
			$password = $this->input->post('password');
			
			$additional_data = array(
				'first_name' => $this->input->post('first_name') ,
				'last_name' => $this->input->post('last_name')
				);
			
			// get post groups
			$groupData = $this->input->post('groups');
			
			//  Only allow updating groups if user is admin
			if ($this->ion_auth->is_admin() && ! empty($groupData))
				$groups = $groupData;
			else
				// otherwise, make the user as member only
				$groups[] = 2;
			
			//check to see if we are creating the user
			if ($id = $this->ion_auth->register($username, $password, $email, $additional_data, $groups)) 
			{

				//redirect them back to the admin page
				$this->session->set_flashdata('warning', $this->ion_auth->messages());
				redirect("panel/users", 'refresh');
			} 

		} else {

			//display the create user form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['form'] = $this->account_form->generate('paragraph');

		}
		
		$this->_render_page('users/create_user', $this->data);
	}
	
	//edit a user
	function edit_user($id) 
	{
		// reset form config for editing
		$this->account_form->config(array(
			'action' => site_url('panel/users/edit_user/'.$id),
			'method' => 'POST',
		));

		$this->data['title'] = "Edit User";
		
		$tables = $this->config->item('tables', 'ion_auth');
		
		if($this->config->item('filebased', 'ion_auth')) 
		{
			$user = $this->ion_auth->user($id);
			$groups = $this->ion_auth->groups();
			$currentGroups = $this->ion_auth->get_users_groups($id);
		} else {
			$user = $this->ion_auth->user($id)->row_array();
			$groups = $this->ion_auth->groups()->result_array();
			$currentGroups = $this->ion_auth->get_users_groups($id);
		}

		$current_groups = array();
		foreach ($currentGroups as $group) {
			$current_groups[] = $group['id'];
		}
		$user['groups'] = implode(',', $current_groups);
		
		if (!$this->logged_in() || (!$this->ion_auth->is_admin() && !($user['id'] == $id))) 
		{
			redirect('panel/users', 'refresh');
		}
		
		if (isset($_POST) && !empty($_POST)) 
		{
			
			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name')
			);

			//  Only allow updating groups if user is admin
			if ($this->ion_auth->is_admin())
			{
				//Update the groups user belongs to
				$groupData = $this->input->post('groups');

				if($this->config->item('filebased', 'ion_auth'))
				{
					if (!empty($groupData))
						$data['groups'] = $groupData;

				} else {
					if (!empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
					}					
				}
			}
			
			$data = array_merge($user, $data);
			
			// remove password rules if it is not filled
			if (! $this->input->post('password')) 
			{
				unset($this->account_form->password['rules']);
				unset($this->account_form->password_confirm['rules']);

			} else {
				$data['password'] = $this->input->post('password');
			}
			
			// remove email rules if it is not filled
			if ($user['email'] == $this->input->post('email')) 
			{
				unset($this->account_form->email['rules']);

			} else {
				$data['email'] = $this->input->post('email');
			}
			
			// init account form
			$this->account_form->init($user);
			
			//validate
			if ($this->account_form->validate()) 
			{
				$this->ion_auth->update($user['id'], $data);
				
				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('success', "User data updated.");
				if ($this->ion_auth->is_admin()) 
				{
					redirect('panel/users', 'refresh');
				} 
				else
				{
					redirect('/', 'refresh');
				}
			}
		}

		// unset password value
		$user['password'] = '';
		$this->account_form->init($user);
		$this->data['form'] = $this->account_form->generate('paragraph');
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		$this->_render_page('users/edit_user', $this->data);
	}
	
	function delete_user($id) 
	{
		if (!$id) show_404();
		
		if (!$this->logged_in() || !$this->ion_auth->is_admin()) $this->session->set_flashdata('error', "You don't have permission to delete user.");
		elseif ($this->ion_auth->delete_user($id)) $this->session->set_flashdata('success', $this->ion_auth->messages());
		else $this->session->set_flashdata('error', $this->ion_auth->errors());
		
		redirect('panel/users');
	}
	
	// create a new group
	function create_group() 
	{
		$this->data['title'] = $this->lang->line('create_group_title');
		
		if (!$this->logged_in() || !$this->ion_auth->is_admin()) 
		{
			redirect('panel/users', 'refresh');
		}
		
		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label') , 'required|alpha_dash');
		$this->form_validation->set_rules('group_description', $this->lang->line('create_group_validation_desc_label') , 'required');
		
		if ($this->form_validation->run() == TRUE) 
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name') , $this->input->post('group_description'));
			if ($new_group_id) 
			{
				
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('success', $this->ion_auth->messages());
				redirect("panel/users", 'refresh');
			}
		} 
		else
		{
			
			//display the create group form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$this->session->set_flashdata('error', $this->data['message']);
			redirect("panel/users", 'refresh');
		}
	}
	
	//edit a group
	function edit_group($id) 
	{
		
		// bail if no group id given
		if (!$id || empty($id)) 
		{
			redirect('panel/users', 'refresh');
		}
		
		$this->data['title'] = $this->lang->line('edit_group_title');
		
		if (!$this->logged_in() || !$this->ion_auth->is_admin()) 
		{
			redirect('panel/users', 'refresh');
		}
		
		$group = $this->ion_auth->group($id)->row();
		
		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label') , 'required|alpha_dash');
		$this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label') , 'required');
		
		if (isset($_POST) && !empty($_POST)) 
		{
			if ($this->form_validation->run() === TRUE) 
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);
				
				if ($group_update) 
				{
					$this->session->set_flashdata('success', $this->lang->line('edit_group_saved'));
				} 
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
				}
				redirect("panel/users", 'refresh');
			}
		}
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		
		$this->session->set_flashdata('error', $this->data['message']);
		redirect("panel/users", 'refresh');
	}
	
	function delete_group($id) 
	{
		if (!$id) show_404();
		
		if ($id == 1) $this->session->set_flashdata('error', "Sorry, we don't recommend to delete admin group.");
		elseif (!$this->logged_in() || !$this->ion_auth->is_admin()) $this->session->set_flashdata('error', "You don't have permission to delete the group.");
		elseif ($this->ion_auth->delete_group($id)) $this->session->set_flashdata('success', $this->ion_auth->messages());
		else $this->session->set_flashdata('error', $this->ion_auth->errors());
		
		redirect('panel/users');
	}
	
	function _get_csrf_nonce() 
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		
		return array(
			$key => $value
		);
	}
	
	function _valid_csrf_nonce() 
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) 
		{
			return TRUE;
		} 
		else
		{
			return FALSE;
		}
	}
	
	function _render_page($view, $data = null, $render = false) 
	{
		
		$this->viewdata = (empty($data)) ? $this->data : $data;
		
		$view_html = $this->template->view($view, $this->viewdata, $render);
		
		if (!$render) return $view_html;
	}
	
	
}
