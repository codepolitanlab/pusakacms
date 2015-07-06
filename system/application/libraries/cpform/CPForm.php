<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPForm {

	protected $cpform_CI;
	protected $cpform_path;

	protected $cpform_fields = [];
	protected $cpform_config = [];
	protected $cpform_values = [];
	protected $cpform_errors = [];
	protected $cpform_is_valid = FALSE;

	public function init()
	{
		$this->cpform_CI = &get_instance();

		$this->cpform_path = APPPATH."libraries/cpform/";

		// load CodeIgniter form validation library
		$this->cpform_CI->load->library('form_validation');

		foreach($this as $key => $value)
		{
			// if it is not cpform property
			if (strrpos($key,"cpform") === false)
			{
				// check if fieldType exists
				if(file_exists($this->cpform_path.'Fields/'.$value['fieldType'].'.php'))
				{
					// load field type class
					require_once $this->cpform_path.'Fields/'.$value['fieldType'].'.php';

					// create field type object
					$fieldtype = new $value['fieldType']($key, $value['initial'], $value['config']);
					$this->cpform_values[$key] = $fieldtype;

				} else {
					show_error('Field type '.$value['fieldType'].' is not available.');
				}
			}
		}

		if ($_POST){
			$form_data = [];
			foreach ($_POST as $key => $value){
				if (! empty($this->cpform_values[$key])){
			}
					$form_data[$key] = $value;
				}
			$this->validate($form_data);
		}
	}

	public function config($config=[]){
		$this->cpform_config = $config;

	}

	protected function validate($form_data=[]){

		$valid = TRUE;

		foreach ($form_data as $key => $value){
			$valid = ($valid && $this->cpform_values[$key]->rules($value));
		}

		$this->cpform_is_valid = $valid;
	}

	public function get_field($field=''){
		return $this->cpform_fields[$field];
	}

	public function generate($output_type='list'){
		$output = 'as_'.$output_type;
		$form = '';
		$form .= '<form';

		foreach ($this->cpform_config as $key => $value) {
			$attribute = $key.'='.$value;
			$form .= ' '.$attribute.' ';
		}

		$form .= '>';
		$form .= $this->$output();
		$form .= '<input type="submit" value="Submit" />';
		$form .= '</form>';

		return $form;
	}

	public function as_list(){
		$fields = '';
		$fields .= "<ul>";
		foreach($this->cpform_values as $key => $value) {
			$temp_fields = '<li>'.$value->render().'</li>';
			$this->cpform_fields[$key] = $temp_fields;
			$fields .= $temp_fields;
			$temp_fields = '';
		}
		$fields .= "<ul>";

		return $fields;
	}

	public function as_paragraph(){
		$fields = '';
		foreach($this->cpform_values as $key => $value) {
			$temp_fields = '<p>'.$value->render().'</p>';
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
