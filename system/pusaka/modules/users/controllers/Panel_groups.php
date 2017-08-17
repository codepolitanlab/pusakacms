<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_groups extends Fastcrud_Controller {

	function _set_config()
	{
		// Setting fastcrud
		$this->crud_conf['title_data'] = 'Groups';
		$this->crud_conf['path'] = 'panel/users/groups';
		$this->crud_conf['table_name'] = 'groups';

		$this->crud_conf['structure'] = array(
			array(
				'label' => 'Group Name',
				'name' => 'name',
				'input_type' => 'text',
				'rules' => 'required',
				'extra' => array('class' => 'form-control'),
				),
			array(
				'label' => 'Group Description',
				'name' => 'description',
				'input_type' => 'text',
				'extra' => array('class' => 'form-control'),
				),
			);
	}

}