<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_event {

	function after_insert($post)
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