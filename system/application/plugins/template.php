<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *	Template plugin
 *	contains functions required for templating
 */

class Template extends Plugins {

	function get_partial($name) {
		return get_partial($name);
	}

	function get_snippet($file, $data = array()) {
		return get_snippet($file, $data);
	}

	function get_field($field = false) {
		return get_field($field);
	}

}