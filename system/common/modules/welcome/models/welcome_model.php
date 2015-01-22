<?php

class Welcome_model extends Core_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function testdb()
	{
		$result = $this->db->order_by('nombre')->get('paises');
		return $result->result();
	}
}
