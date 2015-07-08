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

		$this->config_path = SITE_PATH.'db/';

		if(!is_readable($this->config_path) || !is_writable($this->config_path))
		show_error('Set folder '.$this->config_path.' and its contents readable and writable first.');
	}


	/*********************************************
	* SETTINGS
	**********************************************/

	function index($settings = false)
	{
		// read all Settings form class
		$form_locations = array();
		foreach ($this->cpformutil->forms_path as $form_path) {
			$form_locations = array_merge($form_locations, glob($form_path.'Settings_*.php'));
		}

		// generate forms
		$values = array();
		foreach ($form_locations as $form_location) {
			// load form class
			$pathinfo = pathinfo($form_location);
			$classpath = $pathinfo['dirname'];
			$filename = $pathinfo['filename'];
			$setting_form = $this->cpformutil->load($filename, $classpath);

			// get saved contents
			if(file_exists($this->config_path.$filename.'.json'))
			$values[$filename] = json_decode(file_get_contents($this->config_path.$filename.'.json'), true);

			// init form fields
			$setting_form->init($values[$filename]);

			// set to output
			$data['settings_form'][$filename] = array(
				'title' => $setting_form->cpform_title,
				'id' => $filename,
				'form' => $setting_form->generate('paragraph')
			);
		}

		// submit if data valid
		if($post = $this->input->post())
		{
			// save config to file
			if(! write_file($this->config_path.$settings.'.json', json_encode($post, JSON_PRETTY_PRINT))){
				$this->session->set_flashdata('error', 'unable to save '.$settings.' settings to '.$settings.'.json file.');
				redirect('panel/settings');
			}

			// call events
			$this->call_event('Settings', 'after_update', $savefile);

			// update domain
			if(isset($post['site_domain']))
				$this->pusaka->register_domain($post['site_domain'], $values[$settings]['site_domain']);

			$this->session->set_flashdata('success', 'config saved.');
			redirect('panel/settings');
		}

		$this->template
		->set('tab', 'Site')
		->view('settings', $data);
	}

}
