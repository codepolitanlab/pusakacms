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
			return '<script src="'.$url.'"></script>'."\n";
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
			return '<link rel="stylesheet" type="text/css" href="'.$url.'"'.(($media != 'both')? ' media="'.$media.'"': '').' />'."\n";
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
			return '<img src="'.$url.'" '.$attr.' />'."\n";
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
	* Get image asset from current theme
	* 
	* @param String $file 	filename
	* @param Bool 	$attr 	img attribute. fill it or set true to make it wrapper, false to get only url
	* @return String css url or tag
	*/
if ( ! function_exists('get_content_image'))
{
	function get_content_image($file = false, $attr = '') {
		$url =  base_url().'media/'.SITE_SLUG.'/files/'.$file;

		return '<img src="'.$url.'" '.$attr.' />'."\n";
	}
}

if ( ! function_exists('get_content_file'))
{
	function get_content_file($file = false) {
		$url =  base_url().'media/'.SITE_SLUG.'/files/'.$file;

		return $url;
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

		$url = base_url().'system/modules/'.$module.'/assets/js/'.$file;

		if(!$wrap)
			return $url;
		else
			return '<script src="'.$url.'"></script>'."\n";
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

		$url = base_url().'system/modules/'.$module.'/assets/css/'.$file;

		if(!$media)
			return $url;
		else
			return '<link rel="stylesheet" type="text/css" href="'.$url.'"'.(($media != 'both')? ' media="'.$media.'"': '').' />'."\n";
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

		$url = base_url().'system/modules/'.$module.'/assets/img/'.$file;

		if(!$attr)
			return $url;
		else
			return '<img src="'.$url.'" '.$attr.' />'."\n";
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
		return base_url().'system/modules/'.$module.'/assets/'.$file;
	}
}

/**
	* get the partial for templating
	* 
	* @param String $file 	name
	* @return String filename
	*/
if ( ! function_exists('get_partial'))
{
	function get_partial($name) {
		$CI = &get_instance();
		echo $CI->template->load_view('partials/'.$name);
	}
}

/**
	* get the snippet for templating
	* 
	* @param String $file 	name
	* @return String filename
	*/
if ( ! function_exists('get_snippet'))
{
	function get_snippet($file, $data = array()) {
		$CI = &get_instance();

		$base = array(
				'show_title' => true,
				'title' => false
			);

		$data = array_merge($base, $data);

		echo $CI->template->load_view('snippets/'.$file, $data);
	}
}

/**
	* get the page field
	* 
	* @param String $file 	name
	* @return String filename
	*/
if ( ! function_exists('get_field'))
{
	function get_field($field = false) {
		$CI = &get_instance();
		return $CI->template->get_fields($field);
	}
}


/**
	* set and get plugin url + url of asset in theme
	* 
	* @param String $url 	url of asset in theme
	* @return String url
	*/
if ( ! function_exists('get_plugin_url'))
{
	function get_plugin_url($plugin = '') {
		return base_url().'system/plugins/'.$plugin.'/';		
	}
}

/**
	* get site config item, similarly to $this->config->item()
	* 
	* @param String $key 	config key
	* @return String config value
	*/
if ( ! function_exists('site_config'))
{
	function site_config($key) {
		$CI =& get_instance();
		return $CI->config->item($key);
	}
}

/**
	* check if value in array is set
	* 
	* @param String $arr 	array to check
	* @param String $key 	array key
	* @return String array value, empty if not set
	*/
if ( ! function_exists('validate_value'))
{
	function validate_value($arr, $key) {
		$res = '';
		if(isset($arr[$key]))
			$res = $arr[$key];
		
		return $res;
	}
}
