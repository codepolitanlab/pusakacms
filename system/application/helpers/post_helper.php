<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	* Get js asset from current theme
	* 
	* @param String $file 	filename
	* @param Bool 	$wrap 	false: url only, true: wrap with tag <script>
	* @return String js url or tag
	*/
if ( ! function_exists('get_posts'))
{
	function get_posts(){
		$CI = &get_instance();
		return $CI->pusaka->get_posts();
	}
}