<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	* Get js asset from current theme
	* 
	* @param String $file 	filename
	* @param Bool 	$wrap 	false: url only, true: wrap with tag <script>
	* @return String js url or tag
	*/
if ( ! function_exists('get_theme_js'))
{
	function get_theme_js($file, $wrap = true) {
		$CI = &get_instance();
		$theme_path = $CI->template->get_theme_path();

		$url =  base_url().$theme_path.'assets/js/'.$file;

		if(!$wrap)
			return $url;
		else
			return '<script src="'.$url.'"></script>';


	}
}

/**
	* Get css asset from current theme
	* 
	* @param String $file 	filename
	* @param Bool 	$media 	screen, print, both. choose false to get only url
	* @param Bool 	$wrap 	false: url only, true: wrap with tag <style>
	* @return String css url or tag
	*/
if ( ! function_exists('get_theme_css'))
{
	function get_theme_css($file, $media = 'both') {
		$CI = &get_instance();
		$theme_path = $CI->template->get_theme_path();

		$url =  base_url().$theme_path.'assets/css/'.$file;

		if(!$media)
			return $url;
		else
			return '<link rel="stylesheet" type="text/css" href="'.$url.'"'.(($media != 'both')? ' media="'.$media.'"': '').' />';


	}
}

/**
	* Get image asset from current theme
	* 
	* @param String $file 	filename
	* @param Bool 	$attr 	img attribute. fill it or set true to make it wrapper, false to get only url
	* @return String css url or tag
	*/
if ( ! function_exists('get_theme_image'))
{
	function get_theme_image($file, $attr = true) {
		$CI = &get_instance();
		$theme_path = $CI->template->get_theme_path();

		$url =  base_url().$theme_path.'assets/img/'.$file;

		if(!$attr)
			return $url;
		else
			return '<img src="'.$url.'" '.$attr.' />';


	}
}

/**
	* Get js asset from spesific module
	* 
	* @param String $file 	filename
	* @param Bool 	$wrap 	false: url only, true: wrap with tag <script>
	* @return String js url or tag
	*/
if ( ! function_exists('get_module_js'))
{
	function get_module_js($module, $file, $wrap = true) {
		$CI = &get_instance();

		$url = base_url().$CI->module->module_asset_location($module, 'assets/js/'.$file);

		if(!$wrap)
			return $url;
		else
			return '<script src="'.$url.'"></script>';


	}
}

/**
	* Get css asset from spesific module
	* 
	* @param String $file 	filename
	* @param Bool 	$media 	screen, print, both. choose false to get only url
	* @param Bool 	$wrap 	false: url only, true: wrap with tag <style>
	* @return String css url or tag
	*/
if ( ! function_exists('get_module_css'))
{
	function get_module_css($module, $file, $media = 'both') {
		$CI = &get_instance();

		$url = base_url().$CI->module->module_asset_location($module, 'assets/css/'.$file);

		if(!$media)
			return $url;
		else
			return '<link rel="stylesheet" type="text/css" href="'.$url.'"'.(($media != 'both')? ' media="'.$media.'"': '').' />';


	}
}

/**
	* Get image asset from spesific module
	* 
	* @param String $file 	filename
	* @param Bool 	$attr 	img attribute. fill it or set true to make it wrapper, false to get only url
	* @return String css url or tag
	*/
if ( ! function_exists('get_module_image'))
{
	function get_module_image($module, $file, $attr = true) {
		$CI = &get_instance();

		$url = base_url().$CI->module->module_asset_location($module, 'assets/img/'.$file);

		if(!$attr)
			return $url;
		else
			return '<img src="'.$url.'" '.$attr.' />';


	}
}

/**
	* Get image asset from spesific module
	* 
	* @param String $file 	filename
	* @param Bool 	$attr 	img attribute. fill it or set true to make it wrapper, false to get only url
	* @return String css url or tag
	*/
if ( ! function_exists('get_module_asset'))
{
	function get_module_asset($module, $file) {
		$CI = &get_instance();
		return base_url().$CI->module->module_asset_location($module, 'assets/img/'.$file);
	}
}

/**
	* set and get the partial for templating
	* 
	* @param String $file 	name
	* @return String css url or tag
	*/
if ( ! function_exists('get_partial'))
{
	function get_partial($name) {
		$CI = &get_instance();
		echo $CI->template->load_view('partials/'.$name);
	}
}

/**
	* set and get theme url + url of asset in theme
	* 
	* @param String $url 	url of asset in theme
	* @return String url
	*/
if ( ! function_exists('get_theme_url'))
{
	function get_theme_url($url = '') {
		$CI = &get_instance();
		$theme_path = $CI->template->get_theme_path();

		$url =  base_url().$theme_path.$url;

		return $url;
		
	}
}

/**
	* set and get theme url + url of asset in theme
	* 
	* @param String $url 	url of asset
	* @param String $source 'theme', or 'jooglo', 'dev' and any asset location set in template config
	* @return String url
	*/
if ( ! function_exists('get_asset_url'))
{
	function get_asset_url($url = false, $source = 'jooglo') {
		$CI = &get_instance();
		
		if($source == 'theme'){
			$theme_path = $CI->template->get_theme_path();
			$location = base_url().$theme_path.'assets/'.$url;
		} else {
			$asset_locations = $CI->template->get_asset_locations();
			$location = base_url().$asset_locations[$source].$url;
		}
		return $location;
	}
}

/**
	* set and get theme url + url of asset in theme
	* 
	* @param String $url 	url of asset
	* @param String $source 'theme', or 'jooglo', 'dev' and any asset location set in template config
	* @return String url
	*/
if ( ! function_exists('get_source_url'))
{
	function get_source_url($url = false) {
		$CI = &get_instance();

		return base_url(SOURCEPATH.$url);
	}
}

/**
	* set and get theme url + url of asset in theme
	* 
	* @param String $url 	url of asset
	* @param String $source 'theme', or 'jooglo', 'dev' and any asset location set in template config
	* @return String url
	*/
if ( ! function_exists('get_source_path'))
{
	function get_source_path($url = false) {

		return SOURCEPATH.$url;
	}
}