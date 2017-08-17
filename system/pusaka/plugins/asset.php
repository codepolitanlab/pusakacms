<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *	Assets plugin
 *	contains functions required for get assets
 */

class Asset_plugin extends Plugins {

	// THEME ASSETS
	function get_theme_js($file, $wrap = true) {
		return get_theme_js($file, $wrap);
	}

	function get_theme_css($file, $media = 'both') {
		return get_theme_css($file, $media);
	}

	function get_theme_image($file, $attr = true) {
		return get_theme_image($file, $attr);
	}

	function theme_url($url = '') {
		return theme_url($url);
	}

	// CONTENT ASSETS
	function get_content_image($file = false, $attr = '') {
		return get_content_image($file, $attr);
	}

	function get_content_image_thumb($file = false, $attr = '') {
		return get_content_image_thumb($file, $attr);
	}

	function get_content_file($file = false) {
		return get_content_file($file);
	}

	// MODULE ASSETS
	function get_module_js($module, $file, $wrap = true) {
		return get_module_js($module, $file, $wrap);
	}

	function get_module_css($module, $file, $media = 'both') {
		return get_module_css($module, $file, $media);
	}

	function get_module_image($module, $file, $attr = true) {
		return get_module_image($module, $file, $attr);
	}

	function get_module_asset($module, $file) {
		return get_module_asset($module, $file);
	}

}