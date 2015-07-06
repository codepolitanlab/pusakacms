<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPFormUtil {

	protected $CI;

	public function __construct() {
		$this->CI = &get_instance();

		$this->forms_path = array(
			APPPATH.$this->CI->config->item('blueprint_folder').DIRECTORY_SEPARATOR,
			SITE_PATH.$this->CI->config->item('blueprint_folder').DIRECTORY_SEPARATOR,
		);
	}

	public function load($class_form=''){
		foreach ($this->forms_path as $value) {
			if(file_exists($value)){
				require_once $value.$class_form.'.php';
				return new $class_form();
			}
		}
	}

}
