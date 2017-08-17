<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Symfony\Component\Yaml\Yaml;

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
	}


	/*********************************************
	* SETTINGS
	**********************************************/

	function index($settings = "settings_site")
	{
		// read all Settings form class
		$form_locations = array();
		foreach ($this->cpformutil->forms_path as $form_path) {
				$path = glob($form_path.'settings_*.php');
				if(! empty($path))
					$form_locations = array_merge($form_locations, $path);
		}

		// generate forms
		$values = array();
		$the_forms = array();
		foreach ($form_locations as $form_location) {
			// load form class
			$pathinfo = pathinfo($form_location);
			$classpath = $pathinfo['dirname'];
			$filename = $pathinfo['filename'];
			$the_forms[$filename] = $this->cpformutil->load($filename, $classpath);

			// set to output
			$data['settings_form'][$filename] = array(
				'title' => $the_forms[$filename]->title,
				'id' => $filename
			);
		}

		// check if url valid
		if(! array_key_exists($settings, $the_forms)) show_404();

		// get saved contents
		if(file_exists($this->config_path.$settings.'.yml'))
			$values[$settings] = Yaml::parse(file_get_contents($this->config_path.$settings.'.yml'));
		else
			$values[$settings] = array();

		// init current form fields
		$the_forms[$settings]->init($values[$settings]);
		$data['settings_form'][$settings]['form'] = $the_forms[$settings]->generate('paragraph');

		// submit if data valid
		if($the_forms[$settings]->validate())
		{
			$post = $this->input->post();

			// save config to file
			if(! write_file($this->config_path.$settings.'.yml', Yaml::dump($post, 1))) {
				$this->session->set_flashdata('error', 'unable to save '.$settings.' settings to '.$settings.'.yml file.');
				redirect(getenv('HTTP_REFERER'));
			}

			// call events
			$this->call_event('Settings', 'after_update', $savefile);

			// update domain
			if(isset($post['site_domain']))
				$this->pusaka->register_domain($post['site_domain'], $values[$settings]['site_domain']);

			$this->session->set_flashdata('success', 'config saved.');
			redirect(getenv('HTTP_REFERER'));
		}

		$this->template
		->set('tab', $settings)
		->view('settings', $data);
	}

}
