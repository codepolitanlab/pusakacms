<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPFormUtil {
	
	public function __construct() {
		$this->forms_path = APPPATH."forms/";
	}

	public function load($class_form=''){
		require_once $this->forms_path.$class_form.'.php';
		return new $class_form();
	}

}