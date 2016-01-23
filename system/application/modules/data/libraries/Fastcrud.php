<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fastcrud {

	public $fast_data;

	public function __construct()
	{
		// Load fast crud model
		$this->load->model('data/fastcrud_m');

		// Restriction by session.
		$this->fast_data['allowed_session'] = array();

		// Load library
		$this->load->library('pagination');
		$this->load->library('form_validation');

		// Default template
		$this->fast_data['fast_template_data'] = 'data/data'; // data is module form
		$this->fast_data['fast_template_form'] = 'data/form';
		$this->fast_data['fast_template_detail'] = 'data/detail';

		$this->fast_data['per_page'] = 10;
	}

	function set_config($params = array())
	{
		// default message
		$this->fast_data['alert_success_add'] = '<div class="alert alert-success">Successfully added.</div>';
		$this->fast_data['alert_success_update'] = '<div class="alert alert-success">Successfully updated.</div>';
		$this->fast_data['alert_success_delete'] = '<div class="alert alert-success">Successfully deleted.</div>';

		$this->fast_data['alert_failed_add'] = '<div class="alert alert-success">Adding data failed.</div>';
		$this->fast_data['alert_failed_update'] = '<div class="alert alert-success">Updating failed.</div>';
		$this->fast_data['alert_failed_delete'] = '<div class="alert alert-success">Deleting failed.</div>';

		// Setting
		$this->fast_data = array_merge($this->fast_data, $params);

		// important uri
		// we placed here because it needs slug from config
		$this->fast_data['path'] = site_url($this->fast_data['path']);

		if(!isset($this->fast_data['add_url']))
		 $this->fast_data['add_url'] = $this->fast_data['path'] . '/add';

		if(!isset($this->fast_data['edit_url']))
			$this->fast_data['edit_url'] = $this->fast_data['path'].'/edit';

		if(!isset($this->fast_data['detail_url']))
			$this->fast_data['detail_url'] = $this->fast_data['path'].'/detail';

		if(!isset($this->fast_data['delete_url']))
			$this->fast_data['delete_url'] = $this->fast_data['path'].'/delete';

		// run init
		$this->_init();
	}

	/**
	* __get
	*
	* Enables the use of CI super-global without having to define an extra variable.
	*
	* I can't remember where I first saw this, so thank you if you are the original author. -Militis
	*
		* @access	public
		* @param	$var
		* @return	mixed
	*/
	public function __get($var)
	{
		return get_instance()->$var;
	}

	// Show the data
	public function data($base_url, $page = 1)
	{			
		if ($this->fast_data['fast_ability']['read'] == false)
			exit('Not allowed');

		$this->fast_data['page'] = $page;
		
		// set parameters
		$params = array(
			'get' => $this->fast_data['table_name'] . '.id,' . $this->_get_selected_fields(),
			'paging' => $this->fast_data['per_page'] . '/' . ($this->fast_data['per_page'] * ($page-1))
			);

		// get filter if exist
		$condition = array();
		if($filter = $this->input->post()){
			$condition = array();
			foreach ($filter as $field => $value) {
				if(!empty($value))
					$condition[$field] = $value;
			}
			$params['condition_like'] = $condition;
		}

		$this->fast_data['total_data'] = $this->fastcrud_m->get_total(array('condition_like' => $condition), $this->fast_data['table_name'], $this->fast_data['table_join']);
		
		// Paging
		$this->fast_data['pagination'] = $this->_paging_init($base_url, $this->fast_data['total_data'], $this->fast_data['per_page'], 4);

		// Get current data
		$this->fast_data['contents'] = $this->fastcrud_m->get_loop(
			$params, 
			$this->fast_data['table_name'], 
			$this->fast_data['table_join']);


		return $this->load->view($this->fast_data['fast_template_data'], $this->fast_data, true);
	}

	// Add the data (insert) end point
	public function add($mode = null)
	{	
		// Permission.
		if ($this->fast_data['fast_ability']['create'] == false)
			exit('Not allowed');

		// Get post and setup validation
		$fields_to_insert = array();

		// for count how many rules are set
		$count_rules = 0;

		// setting rules for each fields
		foreach ($this->fast_data['structure'] as $field)
		{
			// Just update that updatable is true
			if (! isset($field['disable_update']) || $field['disable_update'] === false)
			{
				if(!isset($field['form_only']))
					$fields_to_insert[$field['field']] = $this->input->post($field['field']);

				// set rules hanya bila diset
				if (isset($field['rules'])) {
					$this->form_validation->set_rules($field['field'], $field['name'], $field['rules']);
					$count_rules++;

				// khusus buat relation wajib diisi
				} else if (isset($field['relation'])){
					$this->form_validation->set_rules($field['field'], $field['name'], 'required');
					$count_rules++;
				}
			}
		}

		if($this->input->post())
		{
			// If validation true or no any rule are set
			if($this->form_validation->run() === true || $count_rules == 0) {
	      		// Insert
				if($inserted_id = $this->fastcrud_m->add($fields_to_insert, $this->fast_data['table_name'])){
					$this->session->set_flashdata('message', $this->fast_data['alert_success_add']);

					redirect($this->fast_data['edit_url'].'/'.$inserted_id);

				} else {

					$this->session->set_flashdata('message', $this->fast_data['alert_failed_add']);
				}

			} else {

				$this->session->set_flashdata('message', validation_errors('<div class="alert alert-danger">', '</div>'));
			}
		}
	
		$this->fast_data['title'] = 'Add'; 
		$this->fast_data['button_name'] = 'Add';
		$this->fast_data['type'] = 'add';

		return $this->load->view($this->fast_data['fast_template_form'], $this->fast_data, true);
	}

	// Update the data end point
	public function edit($id)
	{
		if ($this->fast_data['fast_ability']['update'] == false)
			exit('Not allowed');

		$fields_to_update = array();

		$count_rules = 0;

		foreach ($this->fast_data['structure'] as $field)
		{
			// Just update that updatable is true
			if (! isset($field['disable_update']) || $field['disable_update'] === false)
			{
				if(!isset($field['form_only']))
					$fields_to_update[$field['field']] = $this->input->post($field['field']);
				
				// set rules hanya bila diset
				if (isset($field['rules'])) {
					$this->form_validation->set_rules($field['field'], $field['name'], $field['rules']);
					$count_rules++;

				// khusus buat relation wajib diisi
				} else if (isset($field['relation'])){
					$this->form_validation->set_rules($field['field'], $field['name'], 'required');
					$count_rules++;
				}
			}
		}

		if($this->input->post())
		{
			// If validation true or no any rule are set
			if($this->form_validation->run() === true || $count_rules == 0) {

				if($update = $this->fastcrud_m->update(array(
					'to_update' => $fields_to_update,
					'condition' => array('id' => $id)
					), $this->fast_data['table_name'])) {

					$this->session->set_flashdata('message', $this->fast_data['alert_success_update']);
				} else {
					$this->session->set_flashdata('message', $this->fast_data['alert_failed_update']);
				}


				redirect($this->fast_data['edit_url'].'/'.$id);

			} else {
				$this->session->set_flashdata('message', validation_errors('<div class="alert alert-danger">', '</div>'));
			}
		}

		$this->fast_data['title'] = 'Edit';
		$this->fast_data['button_name'] = 'Update';
		$this->fast_data['type'] = 'edit';
		
		// Get current data
		$this->fast_data['current_data'] = $this->fastcrud_m->get_detail(array(
			'get' => $this->fast_data['table_name'] . '.id,' . $this->_get_selected_fields(),
			'condition' => array($this->fast_data['table_name'] . '.id' => $id)
			), 
		$this->fast_data['table_name'], 
		$this->fast_data['table_join']);

		if(empty($this->fast_data['current_data'])) show_404();
		
		return $this->load->view($this->fast_data['fast_template_form'], $this->fast_data, true);
	}

	// Update the data end point
	public function detail($id)
	{
		$this->fast_data['title'] = 'Detail';
		$this->fast_data['type'] = 'detail';
		
		// Get current data
		$this->fast_data['current_data'] = $this->fastcrud_m->get_detail(array(
			'get' => $this->fast_data['table_name'] . '.id,' . $this->_get_selected_fields(),
			'condition' => array($this->fast_data['table_name'] . '.id' => $id)
			), 
		$this->fast_data['table_name'], 
		$this->fast_data['table_join']);

		if(empty($this->fast_data['current_data'])) show_404();
		
		return $this->load->view($this->fast_data['fast_template_detail'], $this->fast_data, true);
	}

	// Delete the data
	public function delete($id)
	{
		if ($this->fast_data['fast_ability']['delete'] == false)
			exit('Not allowed');
		
		if($result = $this->fastcrud_m->delete(array('id' => $id), $this->fast_data['table_name'])){
			$this->session->set_flashdata('message', $this->fast_data['alert_success_delete']);
		} else {
			$this->session->set_flashdata('message', $this->fast_data['alert_failed_delete']);
		}


		return $result;
	}

	// Generate data field with comma separated format, from data structure
	private function _get_selected_fields()
	{
		$result = '';

		foreach ($this->fast_data['structure'] as $value)
		{
			if (isset($value['relation']['relation_label']))
				$result .= $value['relation']['table'].'.'.$value['relation']['relation_label'] . ',';
			
			if(!isset($value['form_only']))
				$result .= $value['field'] . ',';
		}

		return trim($result, ',');
	}

	private function _paging_init($base_url, $total_data, $per_page, $uri_segment)
	{
		$config['base_url'] = $base_url;
		$config['uri_segment'] = $uri_segment;
		$config['total_rows'] = $total_data;
		$config['per_page'] = $per_page;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<div><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = '<i class="icon-long-arrow-left"></i> First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last <i class="icon-long-arrow-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		return $this->pagination->create_links();
	}

	private function _init()
	{
		// Restriction checker
		foreach ($this->fast_data['allowed_session'] as $row => $item)
		{
			if ($this->session->userdata($item['session_name']) != $item['session_value'])
				exit('Not allowed.');
		}

		// Default template
		if (!isset($this->fast_data['fast_template_data']))
			 $this->fast_data['fast_template_data'] = 'fastcrud/data';

		if (!isset($this->fast_data['fast_template_form']))
			 $this->fast_data['fast_template_form'] = 'fastcrud/form';
		
		// Join default is null
		if (!isset($this->fast_data['table_join']))
			$this->fast_data['table_join'] = null;
			
		// CRUD default ability
		if (!isset($this->fast_data['fast_ability']['create']))
			$this->fast_data['fast_ability']['create'] = true;

		if (!isset($this->fast_data['fast_ability']['update']))
			$this->fast_data['fast_ability']['update'] = true;

		if (!isset($this->fast_data['fast_ability']['delete']))
			$this->fast_data['fast_ability']['delete'] = true;

		if (!isset($this->fast_data['fast_ability']['read']))
			$this->fast_data['fast_ability']['read'] = true;

		// if structure not set, get minimum field data from database
		if(empty($this->fast_data['structure'])){
			$base_structure = $this->db->field_data($this->fast_data['table_name']);
			foreach ($base_structure as $base_field) {
				if(!in_array($base_field->name, array('id','created_on','updated_on')))
					$this->fast_data['structure'][] = array(
							'name' => ucwords(str_replace('_', ' ', $base_field->name)),
							'field' => $this->fast_data['table_name'].'.'.$base_field->name,
							'input_type' => 'text'
						);
			}
		}

		$i = 0;
		foreach ($this->fast_data['structure'] as &$value)
		{
			$value['show_on_table'] = isset($value['show_on_table']) ? $value['show_on_table'] : true;

			// set text as default input type
			if (! isset($value['input_type'])) {
				$value['input_type'] = 'text';
			}
			else
			{
				// Jika jenis input nya select, maka masukan juga item pilihannya
				if ($value['input_type'] == 'select')
				{
					// Jika ada unsur ambil item option dari record table lain
					if (isset($value['relation']))
					{	
						// Get the item from selected table and refill select options
						$this->db->select($value['relation']['relation_key'] . ' AS options_value, ' . $value['relation']['relation_label'] . ' AS options_label');
						$value['select_options'] = $this->db->get($value['relation']['table'])->result_array();

						// set table join
						$this->fast_data['table_join'] = array(
							array('table_name' => $value['relation']['table'], 'primary_key' => $value['relation']['relation_key'], 'foreign_key' => $value['field'])
						);
					}
					else
					{
						// Langsung olah dari penentuan pilihan sendiri
						$fixed_options = array();
						$j = 0;

						foreach ($value['select_options'] as $options)
						{
							$fixed_options[$j]['options_value'] = $options;
							$fixed_options[$j]['options_label'] = $options;
							$j++;
						}

						$value['select_options'] = $fixed_options;
					}
				}
			}

			$i++;
		}

	}

	public function check_ability($ability)
	{
		return $this->fast_data['fast_ability'][$ability];
	}

}

