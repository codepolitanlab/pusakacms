<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_posts'))
{
	function get_posts($category = null, $page = 1, $sort = 'desc', $parse = true, $site_slug = false)
	{
		$CI = &get_instance();
		return $CI->pusaka->get_posts($category, $page, $sort, $parse, $site_slug);
	}
}