<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
	Func plugin
	contains common function required for templating
*/
class Func extends Plugins {

	function site_url($uri = false){
		return site_url($uri);
	}

	function base_url($path = false){
		return base_url($path);
	}
}