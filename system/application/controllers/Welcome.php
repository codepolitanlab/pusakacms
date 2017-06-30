<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Symfony\Component\Yaml\Yaml;

class Welcome extends Public_Controller {

	public function index()
	{
		$value = Yaml::parse(file_get_contents(APPPATH.'blueprint/page_blueprint.yml'));
		print_r($value);

		$arr = [
			'type' => 'page',
			'tags' => ['satu','dua','tiga']
		];
		echo $value = Yaml::dump($arr);
		
	}

}
