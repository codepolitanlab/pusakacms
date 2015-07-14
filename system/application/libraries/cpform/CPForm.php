<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CPForm {

	protected $cpform_CI;
	protected $cpform_path;

	public $cpform_title = 'Form';

	protected $cpform_fields = array();
	protected $cpform_output = array();
	protected $cpform_errors = array();
	protected $cpform_is_valid = FALSE;

	protected $cpform_exclude_prefix = array('cpform');

	protected $cpform_config = array();
	protected $cpform_additional = array(
		'submit_class' => 'btn',
		'submit_value' => 'Submit'
	);

	protected function _set_fields(){ return true; }

	// set default config
	protected function _set_config()
	{
		$this->cpform_title = get_class($this);

        // set form config
        $this->cpform_config = array(
            'action' => site_url(),
            'method' => 'POST',
        );
        $this->cpform_additional = array(
            'submit_class' => 'btn',
            'submit_value' => 'Submit'
        );
	}

	function __construct()
	{
		$this->cpform_CI = &get_instance();

		$this->cpform_path = APPPATH."libraries/cpform/";

		// load CodeIgniter form validation library
		$this->cpform_CI->load->library('form_validation');

		// set the config and fields
		$this->_set_config();
		$this->_set_fields();
	}

	public function init($values = array())
	{
		foreach($this as $key => &$value)
		{
			// if it is not cpform property
			if (strposa($key, $this->cpform_exclude_prefix) === false)
			{
				// check if fieldType exists
				if(file_exists($this->cpform_path.'Fields/'.$value['fieldType'].'.php'))
				{
					// load field type class
					require_once $this->cpform_path.'Fields/'.$value['fieldType'].'.php';

					// set values from parameter to config
					if(isset($values[$key])) $value['config']['value'] = $values[$key];

					// create field type object
					$fieldtype = new $value['fieldType']($key, $value['label'], $value['config']);
					$this->cpform_output[$key] = $fieldtype;

					// set validation rules
					if(isset($value['rules']))
						$this->cpform_CI->form_validation->set_rules($key, $value['label'], $value['rules']);

				} else {
					show_error('Field type '.$value['fieldType'].' is not available.');
				}
			}
		}
	}

	public function config($config = array(), $additional = array())
	{
		$this->cpform_config = $config;
		$this->cpform_additional = array_merge($this->cpform_additional, $additional);
	}

	public function validate()
	{
		return $this->cpform_CI->form_validation->run();
	}

	public function get_field($field=''){
		return $this->cpform_fields[$field];
	}

	public function generate($output_type='list'){
		$output = 'as_'.$output_type;

		$form = '<form';

		foreach ($this->cpform_config as $key => $value) {
			$attribute = $key.'='.$value;
			$form .= ' '.$attribute.' ';
		}

		$form .= '>';
		$form .= $this->$output();
		$form .= '<input type="submit" value="'.$this->cpform_additional['submit_value'].'" class="'.$this->cpform_additional['submit_class'].'" />';
		$form .= '</form>';

		return $form;
	}

	public function as_list(){
		$fields = '';
		$fields .= "<ul>";
		foreach($this->cpform_output as $key => $value) {
			$temp_fields = '<li>';
			$temp_fields .= $value->label;
			$temp_fields .= $value->render();
			$temp_fields .= '</li>';
			$this->cpform_fields[$key] = $temp_fields;
			$fields .= $temp_fields;
			$temp_fields = '';
		}
		$fields .= "<ul>";

		return $fields;
	}

	public function as_paragraph(){
		$fields = '';
		foreach($this->cpform_output as $key => $value) {
			$temp_fields = '<p>';
			$temp_fields .= $value->label;
			$temp_fields .= $value->render();
			$temp_fields .= '</p>';
			$this->cpform_fields[$key] = $temp_fields;
			$fields .= $temp_fields;
			$temp_fields = '';
		}

		return $fields;
	}

	public function as_table(){

	}

	public function is_valid(){
		return $this->cpform_is_valid;
	}
}
