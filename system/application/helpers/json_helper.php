<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('array_intersect_assoc_recursive'))
{
	function array_intersect_assoc_recursive($arr1, $arr2) {
		if (!is_array($arr1) || !is_array($arr2)) {
			// return $arr1 == $arr2; // Original line
			return $arr2;
		}

		$commonkeys = array_intersect(array_keys($arr1), array_keys($arr2));
		$ret = array();
		foreach ($commonkeys as $key) {
			$ret[$key] = array_intersect_assoc_recursive($arr1[$key], $arr2[$key]);
		}
		return $ret;
	}
}

if ( ! function_exists('array_diff_assoc_recursive'))
{
	function array_diff_assoc_recursive($array1, $array2)
	{
		foreach($array1 as $key => $value)
		{
			if(is_array($value))
			{
				if(!isset($array2[$key]))
				{
					$difference[$key] = $value;
				}
				elseif(!is_array($array2[$key]))
				{
					$difference[$key] = $value;
				}
				else
				{
					$new_diff = array_diff_assoc_recursive($value, $array2[$key]);
					if($new_diff != FALSE)
					{
						$difference[$key] = $new_diff;
					}
				}
			}
			elseif(!isset($array2[$key]) || $array2[$key] != $value)
			{
				$difference[$key] = $value;
			}
		}
		return !isset($difference) ? 0 : $difference;
	}
}