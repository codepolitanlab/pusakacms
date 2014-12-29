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

class Media extends Admin_Controller {

	public $files_path;

	function __construct(){
		parent::__construct();

		if(! $this->logged_in()) redirect('panel/login');

		$this->files_path = SITE_FOLDER. SITE_SLUG .'/content/files';

		if(!is_readable($this->files_path) || !is_writable($this->files_path))
			show_error('Set folder '.$this->files_path.' and its contents readable and writable first.');
	}


	/*********************************************
	 * MEDIA
	 **********************************************/

	function index()
	{
		$this->template->view('media');
	}

	function elfinder_init()
	{
		$this->load->helper('path');
		$opts = array(
    		// 'debug' => true, 
			'roots' => array(
				array( 
					'driver' => 'LocalFileSystem', 
					'path'   => set_realpath($this->files_path), 
					'URL'    => base_url($this->files_path) . '/',
        			'attributes' => array(
					        array(
					            'pattern' => '/index.html/',
					            'hidden'  => true
					        ),
					        array(
					            'pattern' => '/.tmb/',
					            'hidden'  => true
					        )
					    )
					) 
				)
			);
		$this->load->library('elfinder_lib', $opts);
	}
}