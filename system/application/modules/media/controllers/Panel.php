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

	public $files_path;

	function __construct(){
		parent::__construct();

		if(! $this->logged_in()) redirect('panel/login');

		$this->files_path = 'media/'. SITE_SLUG .'/files';
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

}