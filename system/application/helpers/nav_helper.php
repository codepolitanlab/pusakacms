<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Get nav area
* 
* @param String $area 	nav area
* @return Array links in $area file
*/
if ( ! function_exists('get_nav'))
{
	function get_nav($area){
		$nav_db = new Nyankod\JsonFileDB(NAV_FOLDER);
		$nav_db->setTable($area);

		return $nav_db->selectAll();
	}
}