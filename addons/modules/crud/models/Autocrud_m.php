<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocrud_m extends MY_Model {

	public function __construct(){
		parent::__construct();
	}

	function get_cruds()
	{
		$data = $this->db->get('autocrud');
		if($data->num_rows() <= 0)
			return false;

		return $data->result();
	}

	function get_crud($slug)
	{
		$autocrud = $this->db->where('slug', $slug)->get('autocrud');

		if($autocrud->num_rows() <= 0)
			return false;

		$crud = $autocrud->row();

		// check if table exist
		if($this->db->table_exists($crud->main_table)){
			$fields = $this->db->list_fields($crud->main_table);

			$metafields = $this->db->field_data($crud->main_table);

			foreach ($fields as $field) {
				// foreign key
				$foreign = array();
				if($pos = strrpos($field, '_id'))
					$foreign[] = substr($field, 0, $pos);
			}

			$crud->show_fields = explode(',', $crud->show_fields);
			$crud->foreign = $foreign;
			$crud->metafields = $metafields;

			return $crud;
		}

		false;
	}

	function get_data($slug)
	{
		if($autocrud = $this->get_crud($slug))
		{
			$this->db->select('*, '.$autocrud->main_table.'.id ID');
			$this->db->from($autocrud->main_table);

			foreach ($autocrud->foreign as $foreign) {
				$this->db->join($foreign, $foreign.'.id = '.$autocrud->main_table.'.'.$foreign.'_id');
			}
			
			$data = $this->db->get();

			if($data->num_rows() <= 0)
				return false;

			return $data->result();
		}

		return false;
	}
}