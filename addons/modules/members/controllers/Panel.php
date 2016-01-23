<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends Fastcrud_Controller {

	function _set_config()
	{
		$this->crud_conf['title_data'] = 'Anggota';
		$this->crud_conf['path'] = 'panel/members';
		$this->crud_conf['table_name'] = 'anggota';

		$this->crud_conf['structure'] = array(
			array(
				'name' => 'Nama',
				'field' => 'nama',
				'input_type' => 'text',
				'rules' => 'required'
				),
			array(
				'name' => 'Email',
				'field' => 'email',
				'input_type' => 'text',
				'rules' => 'required|valid_email'
				),
			array(
				'name' => 'Level',
				'field' => 'level_id',
				'input_type' => 'select',
				'relation' => array(	
					'table' => 'level',
					'relation_key' => 'id',
					'relation_label' => 'level'
					)
				),

			);
	}
}