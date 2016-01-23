<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings
{
	private $db_path;

	function __construct()
	{
		$this->db_path = SITE_PATH.'db'.DIRECTORY_SEPARATOR;
	}

	public function get_config_path()
	{
		return $this->db_path;
	}

	public function set_config($configname = false, $data = array())
	{
		if(! $configname || empty($data))
			return false;

		$file = $this->db_path.$configname.'.json';
		if(file_exists($file)){
			$old_data = json_decode(file_get_contents($file), true);
			$data = array_merge($old_data, $data);
		}

		$thefile = fopen($file, 'w') or die("Unable to open or create $file file!");
		fwrite($thefile, json_encode($data, JSON_PRETTY_PRINT));
		fclose($thefile);

		return $data;
	}

}
