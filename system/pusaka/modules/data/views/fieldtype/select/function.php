<?php

if ( ! function_exists('select'))
{
	function select($value)
	{
		$CI = &get_instance();

		// Jika ada unsur ambil item option dari record table lain
		if (isset($value['relation']))
		{	
			// Get the item from selected table and refill select options
			$CI->db->select($value['relation']['relation_key'] . ' AS options_value, ' . $value['relation']['relation_label'] . ' AS options_label');
			$value['select_options'] = $CI->db->get($value['relation']['table'])->result_array();

			// set table join
			$CI->fast_data['table_join'][] = array('table_name' => $value['relation']['table'], 'primary_key' => $value['relation']['relation_key'], 'foreign_key' => $value['name']
				);
		}
		else
		{
			// Langsung olah dari penentuan pilihan sendiri
			$fixed_options = array();

			foreach ($value['select_options'] as $optvalue => $options)
			{
				$fixed_options[$optvalue]['options_value'] = $optvalue;
				$fixed_options[$optvalue]['options_label'] = $options;
			}

			$value['select_options'] = $fixed_options;
		}

		return $value;
	}
}