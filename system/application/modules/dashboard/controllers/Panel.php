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

	public function __construct(){

		parent::__construct();

		if(! $this->logged_in()) redirect('panel/login');
	}


	/*********************************************
	 * DASHBOARD
	 **********************************************/

	function index()
	{

		$this->template->view('dashboard');
	}

}