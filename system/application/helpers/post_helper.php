<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_posts'))
{
	function get_posts($category = null, $page = 1, $perpage = false, $sort = 'desc', $parse = true, $site_slug = false)
	{
		$CI = &get_instance();
		return $CI->pusaka->get_posts($category, $page, $perpage, $sort, $parse, $site_slug);
	}
}

if ( ! function_exists('get_labels'))
{
	function get_labels()
	{
		$CI = &get_instance();
		return $CI->pusaka->get_labels();
	}	
}