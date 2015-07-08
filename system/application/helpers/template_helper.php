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
if ( ! function_exists('theme_url'))
{
	function theme_url($url = '') {
		$CI = &get_instance();
		$theme_path = $CI->template->get_theme_path();

		$url =  base_url().$theme_path.$url;

		return $url;
	}
}

/**
	* set and get theme url + url of asset in theme
	* 
	* @param String $url 	url of asset in theme
	* @return String url
	*/
if ( ! function_exists('vendor_url'))
{
	function vendor_url($vendor, $url = '') {

		return base_url().'public/vendor/'.$vendor.'/'.$url;
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
	function get_content_image($file = false, $attr = true, $site_slug = false) {
		if(! $site_slug) $site_slug = SITE_SLUG;

		$url =  base_url().'media/'.$site_slug.'/files/'.$file;

		if($attr)
			return '<img src="'.$url.'" '.$attr.' />'."\n";
		
		return $url;
	}
}

if ( ! function_exists('get_content_image_thumb'))
{
	function get_content_image_thumb($file = false, $attr = true, $site_slug = false) {
		if(! $site_slug) $site_slug = SITE_SLUG;

		$url =  base_url().'media/'.$site_slug.'/files/thumb/'.$file;

		if($attr)
			return '<img src="'.$url.'" '.$attr.' />'."\n";
		
		return $url;
	}
}

if ( ! function_exists('get_content_file'))
{
	function get_content_file($file = false) {
		$url =  base_url().'media/'.SITE_SLUG.'/files/'.$file;

		return $url;
	}
}

if ( ! function_exists('module_exist'))
{
	function module_exist($module_name)
	{
		$return = false;
		foreach (Modules::$locations as $location => $rel) {
			if(file_exists($location.$module_name))
				$return = true;
		}
		
		return $return;
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
		return base_url().'system/modules/'.$module.'/assets/'.$file;
	}
}

if ( ! function_exists('get_module_nav_tree'))
{
	function get_module_nav_tree()
	{
		$menus = array();
		foreach (Modules::$locations as $location => $rel) {
			$map = directory_map($location, 1);

			foreach ($map as $folder) {
				if(file_exists($location.$folder.'module.json')){ 
					$module = json_decode(file_get_contents($location.$folder.'module.json'), true);
					
					if(!empty($module['menu'])){
						$menus[$module['menu']['context']][$module['menu']['order']] = array("link" => rtrim($folder, DIRECTORY_SEPARATOR),
																					 		 "caption" => $module['menu']['caption']);
						// add allowed sites
						if(file_exists($location.$folder.'config/permission.php'))
						{
							include $location.$folder.'config/permission.php';
							$menus[$module['menu']['context']][$module['menu']['order']]["allowed_sites"] = $config['allowed_sites'];
							unset($config['allowed_sites']);
						}
					}

				}
			}
		}

		return $menus;
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
	* get the block for templating
	* 
	* @param String $file 	name
	* @return String filename
	*/
if ( ! function_exists('get_block'))
{
	function get_block($file, $data = array()) {
		return file_get_contents(SITE_PATH.'content/blocks/'.$file.'.html');
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
