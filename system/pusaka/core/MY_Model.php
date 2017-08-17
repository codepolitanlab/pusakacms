<?php
/*
The basic operation of all model :)
*/

class MY_Model extends CI_Model
{
	public $table;

  	public function __construct()
  	{
    	parent::__construct();
  	}

	/*
	Param : array()
	Purpose : insert record to table.
	*/
	public function add($param = null, $table = null)
	{
		if ($table == null)
		{
			$table = $this->table;
		}

		$by_machine = array(
			// 'created_on' => date('Y-m-d H:i:s')
		);

		if ($this->db->insert($table, array_merge($by_machine, $param)))
		{
			return $this->db->insert_id();
		}
	
		return false;
	}

	/*
	Param : array()
	Purpose : update record to table.
	*/
	public function update($param = null, $table = null)
	{
		if ($table == null)
		{
			$table = $this->table;
		}

		$by_machine = array(
			'updated_on' => date('Y-m-d H:i:s')
		);

		// Prepare Condition
		if (!empty($param['condition']))
		{
			foreach ($param['condition'] as $where => $value)
			{
				$this->db->where($where, $value);
			}
		}

		unset($param['condition']);

		$this->db->update($table, array_merge($by_machine, $param['to_update']));

		return $this->db->affected_rows();
	}

	/*
	Param : array()
	Purpose : delete record by field.
	*/
	public function delete($condition = null, $table = null)
	{
		if ($table == null)
		{
			$table = $this->table;
		}

		// Prepare Condition
		if (!empty($condition))
		{
			foreach ($condition as $where => $value)
			{
				$this->db->where($where, $value);
			}
		}

		$this->db->delete($table);

		return $this->db->affected_rows();
	}

	/*
	Param : array('get, array(condition)').
	Purpose : to get more then one field value by any condition.
	*/
	public function get_detail($param = null, $table = null, $join_table = null)
	{	
		if ($table == null)
  		{
  			$table = $this->table;
  		}

		// Select
		$this->db->select($param['get']);

		// Join 
		if (!empty($join_table))
		{
			foreach ($join_table as $value => $item)
			{
				$this->db->join($item['table_name'], $item['table_name'] . '.' . $item['primary_key']  . '=' . $table . '.' . $item['foreign_key']);
			}
		}

		// Prepare Condition
		if (!empty($param['condition']))
		{
			foreach ($param['condition'] as $where => $value)
			{
				$this->db->where($where, $value);
			}
		}

		return $this->db->get($table)->row_array();
	}

	/*
	Param : field to get, by field, by field value
	Purpose : to get single field value by other field. For main table
	*/
  	public function get_single_field($field_name, $by_field, $by_field_value, $table = null)
  	{
  		if ($table == null)
  		{
  			$table = $this->table;
  		}

		$this->db->select($field_name . ' AS result');
		$this->db->where($by_field, $by_field_value);
		$query = $this->db->get($table);
		
		$result = $query->row();

		if (!empty($result))
		{
			return $result->result;
		}
		
		return false;
	}

	/*
	Param : array('get, array(condition), paging, order').
	Purpose : to get loop row/record by some field.
	*/
  	public function get_loop($param = null, $table = null, $join_table = null)
  	{
  		if ($table == null)
  		{
  			$table = $this->table;
  		}

		// Select
		$this->db->select($param['get']);

		// Join 
		if (!empty($join_table))
		{
			foreach ($join_table as $value => $item)
			{
				$this->db->join($item['table_name'], $item['table_name'] . '.' . $item['primary_key']  . '=' . $table . '.' . $item['foreign_key']);
			}
		}

		// Prepare Condition
		if (!empty($param['condition']))
		{
			foreach ($param['condition'] as $where => $value)
			{
				$this->db->where($where, $value);
			}
		}

		// Prepare condition like.
		if (!empty($param['condition_like']))
		{
			foreach ($param['condition_like'] as $where => $value)
			{
				$this->db->like($where, $value);
			}
		}

		// Prepare paging
		if (!empty($param['paging']))
		{
			$paging = explode('/', $param['paging']);
			$this->db->limit($paging[0], $paging[1]);
		}

		// Prepare order
		if (!empty($param['order']))
		{
			$order = explode(',', $param['order']);
			$this->db->order_by($order[0], $order[1]);
		}
		else
		{
			$this->db->order_by('id', 'desc');
		}

		return $this->db->get($table)->result_array();
	}

	/*
	Param : -
	Purpose : to get total by some condition or not.
	*/
	public function get_total($param = null, $table = null, $join_table = null)
	{
		if ($table == null)
  		{
  			$table = $this->table;
  		}

		// Select
		$this->db->select($table . '.id');

		// Join 
		if (!empty($join_table))
		{
			foreach ($join_table as $value => $item)
			{
				$this->db->join($item['table_name'], $item['table_name'] . '.' . $item['primary_key']  . '=' . $table . '.' . $item['foreign_key']);
			}
		}

		// Prepare Condition
		if (!empty($param['condition']))
		{
			foreach ($param['condition'] as $where => $value)
			{
				$this->db->where($where, $value);
			}
		}

		// Prepare Condition Like
		if (!empty($param['condition_like']))
		{
			foreach ($param['condition_like'] as $where => $value)
			{
				$this->db->like($where, $value);
			}
		}

		return $this->db->get($table)->num_rows();
	}

	/*
	Param : -
	Purpose : to decrease field value.
	*/
	public function decrease($by_field, $by_field_val, $field_to_decrease, $total_decrease)
	{
		$this->db->set($field_to_decrease, $field_to_decrease . '-' . (int) $total_decrease, false);
		$this->db->where($by_field, $by_field_val);
    	$this->db->update($this->table); 
    	return true;
	}
}
