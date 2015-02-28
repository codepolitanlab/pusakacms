<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_event {

	function before_render_page($segments)
	{
		return true;
	}

}