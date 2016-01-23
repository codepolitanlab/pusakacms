<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_level extends Fastcrud_Controller {

	function _set_config()
	{
		$this->crud_conf['title_data'] = 'Level';
		$this->crud_conf['path'] = 'panel/members/level';
		$this->crud_conf['table_name'] = 'level';

		$this->crud_conf['structure'] = array(
			array(
				'name' => 'Kode',
				'field' => 'kode_level',
				'input_type' => 'text',
				'rules' => 'required'
				),
			array(
				'name' => 'Level',
				'field' => 'level',
				'input_type' => 'text',
				'rules' => 'required'
				),
			array(
				'name' => 'Deskripsi',
				'field' => 'deskripsi',
				'input_type' => 'text',
				'show_on_table' => false
				),

			);
	}
}