<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fizl Library
 *
 * Allows you to easily define a nav list.
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Pusaka {

	var $CI;
	var $level 			= 0;
	var $ul_class 		= 'nav';
	var $current_class 	= 'active';
	var $start 			= '/';
	var $depth 			= 2;
	var $remove_index	= true;
	var $stack			= array();

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		if (count($params) > 0)
		{
			$this->initialize($params);
		}

		log_message('debug', "Fizl Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}

	function nav($start = null, $depth = 2)
	{
		// get derectory map
		$map = directory_map(FCPATH.$this->CI->config->item('content_folder').'/'.$start, $depth);

		// parse map in order to compatible with build_list()
		$new_map = $this->_parse_map($map, $start);

		// bulid the list
		$list = $this->build_list($new_map, $start);

		return $list;
	}

	function build_list($tree, $prefix = '')
	{
		$ul = '';

		if($prefix == 'posts')
		{
			$prefix .= '/';

			foreach ($tree as $key => $value)
			{
				$li = '';
				$active = false;

				// change dash in date to slash
				$segs = explode("-", $key, 4);
				if(count($segs) > 3)
					$newkey = implode("/", $segs);
				else
					$newkey = $key;
				
				// set active for match link
				if(uri_string() == $prefix.$newkey) $active = true;

				// set active for upper link
				if(strstr(uri_string(), $prefix.$newkey)) $active = true;

				if (array_key_exists('_title', $value)) {

					$li .= "<a href='".site_url($prefix.$newkey)."' ".($active ? "class='".$this->current_class."'" : "").">${value['_title']}</a>";
				} else {
					$li .= "$prefix$newkey/";
				}

				$li .= $this->build_list($value, "$prefix$newkey");
				$ul .= strlen($li) ? "<li".($active ? " class='".$this->current_class."'" : "").">$li</li>" : '';
				
			}
		}

		else {
			
			$prefix .= '/';

			foreach ($tree as $key => $value)
			{
				$li = '';
				$active = false;

				if (is_array($value))
				{
					// set active for match link
					if(uri_string() == $prefix.$key) $active = true;

					// set active for upper link
					if(strstr(uri_string(), $prefix.$key)) $active = true;

					if (array_key_exists('_title', $value)) {

						$li .= "<a href='".site_url($prefix.$key)."' ".($active ? "class='".$this->current_class."'" : "").">${value['_title']}</a>";
					} else {
						$li .= "$prefix$key/";
					}

					$li .= $this->build_list($value, "$prefix$key");
					$ul .= strlen($li) ? "<li".($active ? " class='".$this->current_class."'" : "").">$li</li>" : '';
				}
			}
		}

		return strlen($ul) ? "<ul class='".$this->ul_class."'>$ul</ul>" : '';
	}

	
	/**
	 * Parse Map
	 *
	 * Parse a directory map row into
	 * a tree structure for the UL function.
	 *
	 * @access	private
	 * @param	array - directory map
	 * @return	array
	 */
	private function _parse_map($map, $prefix = null)
	{
		$new_map = array();
		$order = FALSE;
		$stack = array();
		
		foreach($map as $key => $file)
		{
			if (is_array($file))
			{
				$stack[] = $key;

				$new_map[$key] = array_merge(array('_title' => $this->guess_name($key, $prefix)), $this->_parse_map($map[$key]));

				array_pop($stack);
			}
			else
			{
				$new_map[$this->remove_extension($file)]['_title'] = $this->guess_name($file, $prefix);
			}
		}

		if ($this->remove_index === TRUE AND isset($new_map['index']))
		{
			unset($new_map['index']);
		}
		
		return $new_map;
	}

	// --------------------------------------------------------------------------

	/**
	 * Guess Name
	 *
	 * Takes a file name and attempts to generate
	 * a human-readble name from it.
	 *
	 * @access	public
	 * @param	string - file name
	 * @retrun 	string
	 */
	public function guess_name($name, $prefix = null)
	{
		$name = $this->remove_extension($name);

		if($prefix == 'posts'){
			$name = $this->remove_date($name);
		}

		$name = str_replace('-', ' ', $name);
		$name = str_replace('_', ' ', $name);

		return $name;
	}

	// --------------------------------------------------------------------------

	/**
	 * Remove the extension from a file
	 *
	 * @access	public
	 * @param	string - file name
	 * @return	string- the extension
	 */
	public function remove_extension($file)
	{
		$segs = explode('.', $file, 2);

		if(count($segs) > 1)
		{
			array_pop($segs);
			$file = implode('.', $segs);
		}

		return $file;
	}

	// --------------------------------------------------------------------------

	/**
	 * Remove the date from a file name
	 *
	 * @access	public
	 * @param	string - file name
	 * @return	string- the extension
	 */
	public function remove_date($filename)
	{
		$segs = explode('-', $filename, 4);

		if(count($segs) > 3)
		{
			$filename = $segs[3];
		}

		return $filename;
	}

}