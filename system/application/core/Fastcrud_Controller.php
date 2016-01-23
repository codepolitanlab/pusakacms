<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Fastcrud Controller

class Fastcrud_Controller extends Admin_Controller
{
	public $crud_conf;
	public $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->library('data/fastcrud');

		// Setting fastcrud
		$this->crud_conf['title_data'] = 'FastCrud';
		$this->crud_conf['path'] = '';
		$this->crud_conf['table_name'] = '';

		$this->crud_conf['table_join'] = array( 
			// 0 => array('table_name' => 'sekolah', 'primary_key' => 'id', 'foreign_key' => 'sekolah_id')
		);
		
		// setting fastcrud data structure
		$this->crud_conf['structure'] = array();

		// set default view folder
		$this->crud_conf['view'] = 'default';

		// call config from class children
		$this->_set_config();

		if(empty($this->crud_conf['path'])) show_error('Crud path is not set yet.');
		if(empty($this->crud_conf['table_name'])) show_error('Crud table_name is not set yet.');

		// then set all crud config
		$this->fastcrud->set_config($this->crud_conf);
	}

	function _set_config(){return true;}

	function index($page = 1)
	{
		$this->data['table'] = $this->fastcrud->data($this->crud_conf['view'].'/index', $page);

		$this->template->view($this->crud_conf['view'].'/index', $this->data);
	}

	function add()
	{
		$this->data['mode'] = 'Tambah';
		$this->data['form'] = $this->fastcrud->add();

		$this->template->view($this->crud_conf['view'].'/form', $this->data);
	}

	function edit($id = false)
	{
		if(!$id) show_404();

		$this->data['mode'] = 'Edit';
		$this->data['form'] = $this->fastcrud->edit($id);

		$this->template->view($this->crud_conf['view'].'/form', $this->data);
	}

	function detail($id = false)
	{
		if(!$id) show_404();

		$this->data['mode'] = 'Detail';
		$this->data['detail'] = $this->fastcrud->detail($id);

		$this->template->view($this->crud_conf['view'].'/detail', $this->data);
	}

	function delete($id = false)
	{
		if(!$id) show_404();

		$this->fastcrud->delete($id);

		redirect($this->crud_conf['path']);
	}
}