<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * AutoCRUD admin panel
 *
 * generate interface for database table
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

		$this->load->library('crud/autocrud');
	}


	/*********************************************
	 * DASHBOARD
	 **********************************************/

	function index()
	{
		$data['crud'] = $this->autocrud->get_cruds();

		$this->template->view('admin/index', $data);
	}

	function list($slug = false)
	{
		if(!$slug) show_404();

		$data['crud'] = $this->autocrud->get_crud($slug);
		$data['data'] = $this->autocrud->get_data($slug);

		print_r($data);
		$this->template->view('admin/list', $data);

		
	}
}