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

		if(! $this->session->userdata('username')) redirect('panel/login');

		$this->files_path = 'sites/'. SITE_SLUG .'/content/files';
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
					'URL'    => site_url($this->files_path) . '/'
        			// more elFinder options here
					) 
				)
			);
		$this->load->library('elfinder_lib', $opts);
	}

}