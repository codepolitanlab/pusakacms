<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPFormUtil {

	protected $CI;
	public $forms_path;

	public function __construct() {
		$this->CI = &get_instance();

		$this->forms_path = array(
			APPPATH.$this->CI->config->item('blueprint_folder').DIRECTORY_SEPARATOR,
			SITE_PATH.$this->CI->config->item('blueprint_folder').DIRECTORY_SEPARATOR,
		);
	}

	public function load($class_form='', $location = ''){
		// use location if set
		if(!empty($location))
			$this->forms_path = array($location.DIRECTORY_SEPARATOR);

		// check if class exists
		foreach ($this->forms_path as $value) {
			if(file_exists($value.$class_form.'.php')){
				require_once $value.$class_form.'.php';
				return new $class_form();
			}
		}

		show_error($class_form.' class not found.');
	}

	public function create($classname = false)
	{
		// check if class exists
		foreach ($this->forms_path as $value) {
			if(file_exists($value.$class_form.'.php')){
				require_once $value.$class_form.'.php';
				return new $class_form();
			}
		}

		show_error($class_form.' class not found.');
	}

}
