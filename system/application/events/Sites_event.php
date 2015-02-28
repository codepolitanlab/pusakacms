<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sites_event {

	function after_insert($data)
	{
		return true;
	}

	function after_update($prevfile, $post)
	{
		return true;
	}

	function after_delete($file)
	{
		return true;
	}

}