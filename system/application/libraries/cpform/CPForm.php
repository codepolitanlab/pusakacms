<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CPForm {

	protected $CI;
	protected $path;

	public $title = 'Form';
	public $slug = '';
	public $description = '';
	public $table = '';
	public $fields = array();

	protected $output = array();
	protected $errors = array();
	protected $is_valid = FALSE;
	protected $callback = array();

	protected $exclude_prefix = array('cpform');

	protected $config = array();
	protected $additional = array(
		'submit_class' => 'btn',
		'submit_value' => 'Submit'
		);

	protected function _set_fields(){ return true; }

	// set default config
	protected function _set_config()
	{
		$this->title = get_class($this);

		// set form config
		$this->config = array(
			'action' => site_url(),
			'method' => 'POST',
			);
		$this->additional = array(
			'submit_class' => 'btn',
			'submit_value' => 'Submit'
			);
	}

	function __construct()
	{
		$this->CI = &get_instance();

		$this->path = APPPATH."libraries/cpform/";

		// load CodeIgniter form validation library
		$this->CI->load->library('form_validation');

		// set the config and fields
		$this->_set_config();
	}

	public function init($values = array())
	{
		foreach($this->fields as $fieldname => &$field)
		{
			// check if fieldType exists
			if(file_exists($this->path.'Fields/'.$field['fieldType'].'.php'))
			{
				// load field type class
				require_once $this->path.'Fields/'.$field['fieldType'].'.php';

				// set fields from parameter to config
				if(isset($fields[$fieldname])) $field['config']['field'] = htmlentities($fields[$fieldname]);

					// create field type object
				$fieldtype = new $field['fieldType']($fieldname, $field, $values[$fieldname]);
				$this->output[$fieldname] = $fieldtype;
				unset($fieldtype);

					// set validation rules
				if(isset($field['rules']))
					$this->CI->form_validation->set_rules($fieldname, $field['label'], $field['rules'], isset($field['rule_messages']) ? $field['rule_messages'] : array());

			} else {
				show_error('Field type '.$field['fieldType'].' is not available.');
			}
		}
	}

	public function config($config = array(), $additional = array())
	{
		$this->config = $config;
		$this->additional = array_merge($this->additional, $additional);
	}

	public function validate()
	{
		return $this->CI->form_validation->run();
	}


	public function get_field($field=''){
		return $this->fields[$field];
	}

	public function generate($output_type='list'){
		$output = 'as_'.$output_type;

		$form = '<form';
	
			foreach ($this->config as $key => $value) {
				$attribute = $key.'='.$value;
				$form .= ' '.$attribute.' ';
			}
	
			$form .= '>';
			$form .= $this->{$output}();
			$form .= '<input type="submit" value="'.$this->additional['submit_value'].'" class="'.$this->additional['submit_class'].'" />';
		$form .= '</form>';

		return $form;
	}

	public function as_list(){
		$fields = '';
		$fields .= "<ul>";
			foreach($this->output as $key => $value) {
				$temp_fields = '<li>';
					$temp_fields .= '<label for="'.$value->name.'">'.$value->label.'</label>';
					$temp_fields .= $value->render();
				$temp_fields .= '</li>';
				$this->fields[$key] = $temp_fields;
				$fields .= $temp_fields;
				$temp_fields = '';
			}
			$fields .= "<ul>";
		
				return $fields;
			}
		
			public function as_paragraph(){
				$fields = '';
				foreach($this->output as $key => $value) {
					$temp_fields = '<p>';
						$temp_fields .= '<label for="'.$value->name.'">'.$value->label.'</label>';
						$temp_fields .= $value->render();
					$temp_fields .= '</p>';
					$this->fields[$key] = $temp_fields;
					$fields .= $temp_fields;
					$temp_fields = '';
				}
		
				return $fields;
			}
		
			public function as_table(){
		
			}
		
			public function is_valid(){
				return $this->is_valid;
			}
		
			public function set_message($key, $message)
			{
				$this->CI->form_validation->set_message($key, $message);
			}
		}