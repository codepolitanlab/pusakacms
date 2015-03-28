<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// use Nyankod\JsonFileDB;

/**
 * Cms
 *
 * Simple tool for making simple sites.
 *
 * @package		Pusaka
 * @author		Toni Haryanto (@toharyan)
 * @copyright	Copyright (c) 2011-2012, Nyankod
 * @license		http://nyankod.com/license
 * @link		http://nyankod.com/pusakacms
 */

class Panel extends Admin_Controller {

	public $config_path;

	function __construct(){
		parent::__construct();
		
		if(! $this->logged_in()) redirect('panel/login');

		$this->config_path = SITE_FOLDER.SITE_SLUG.'/config/';

		if(!is_readable($this->config_path) || !is_writable($this->config_path))
			show_error('Set folder '.$this->config_path.' and its contents readable and writable first.');
	}


	/*********************************************
	 * SETTINGS
	 **********************************************/

	function index()
	{
		// get config files
		$config_file = array_filter(scandir($this->config_path), function($user){
			return (substr($user, -5) == '.json');
		});

		$savefile = array();
		$validation_rules = array();
		foreach ($config_file as $confile) {
			$config[substr($confile, 0, -5)] = json_decode(file_get_contents($this->config_path.$confile), true);
			$savefile[substr($confile, 0, -5)] = array();

			// set validation rules
			foreach ($config[substr($confile, 0, -5)] as $key => $value) {
				$this->form_validation->set_rules(substr($confile, 0, -5).'__'.$key, '<strong>'.substr($confile, 0, -5).'__'.$key.'</strong>', 'trim');
			}
		}

		// submit if data valid
		if($this->form_validation->run()){
			$post = $this->input->post();
			foreach ($post as $postkey => $postval) {
				$field = explode("__", $postkey);
				$savefile[$field[0]] += array($field[1] => $postval);
			}

			// save config to file
			foreach ($savefile as $filekey => $fileval) {
				if(! write_file($this->config_path.$filekey.'.json', json_encode($fileval, JSON_PRETTY_PRINT))){
					$this->session->set_flashdata('error', 'unable to save '.$filekey.' settings to '.$filekey.'.json file.');
					redirect('panel/settings');	
				}
			}

			// call events
			$this->call_event('Settings', 'after_update', $savefile);

			// update domain
			if(! empty($savefile['site']['site_domain']))
				$this->pusaka->register_domain($savefile['site']['site_domain'], $config['site']['site_domain']);

			$this->session->set_flashdata('success', 'config saved.');
			redirect('panel/settings');
		}

		$this->template
		->set('tab', 'site')
		->set('config', $config)
		->view('settings');
	}

}