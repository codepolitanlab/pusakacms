<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *	Template plugin
 *	contains functions required for templating
 */

class Widget_plugin extends Plugins {

	function instance($slug = false, $area = "nonarea") {
		return render_instance($slug, $area);
	}

	function area($area = "nonarea") {
		return render_area($area);
	}

}
