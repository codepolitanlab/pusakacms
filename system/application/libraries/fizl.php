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
class Fizl {

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
		if($start) $start .= '/';

		// get derectory map
		$map = directory_map(FCPATH.$this->CI->config->item('content_folder').'/'.$start, $depth);

		// parse map in order to compatible with build_list()
		$new_map = $this->_parse_map($map);

		// bulid the list
		$list = $this->build_list($new_map, $start);

		return $list;
	}

	function build_list($tree, $prefix = '')
	{
		$ul = '';

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

					$li .= "<a href='".site_url($prefix.$key)."/' ".($active ? "class='".$this->current_class."'" : "").">${value['_title']}</a>";
				} else {
					$li .= "$prefix$key/";
				}

				$li .= $this->build_list($value, "$prefix$key/");
				$ul .= strlen($li) ? "<li".($active ? " class='".$this->current_class."'" : "").">$li</li>" : '';
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
	private function _parse_map($map)
	{
		$new_map = array();
		$order = FALSE;
		$stack = array();
		
		foreach($map as $key => $file)
		{
			if (is_array($file))
			{
				$stack[] = $key;

				$new_map[$key] = array_merge(array('_title' => $this->guess_name($key)), $this->_parse_map($map[$key]));

				array_pop($stack);
			}
			else
			{
				$new_map[$this->remove_extension($file)]['_title'] = $this->guess_name($file);
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
	 * Create HTML UL from tree array
	 *
	 * @access	public
	 * @param	array - special tree array
	 * @return	void
	 */
	public function create_ul($tree, $ul_class = 'nav', $current_class = false)
	{
		$this->depth++;

		$this->html .= '<ul class="depth_'.$this->depth.' '.$this->ul_class.'">'."\n";

		foreach($tree as $key => $item)
		{
			if ($key == '_title') continue;

			if (is_array($item))
			{
				$this->stack[] = $key;

				$this->html .= '<li><a href="'.site_url(implode('/', $this->stack)).'">'.$item['_title']."</a>\n";

				$this->create_ul($item);

				$this->html .= '</li>';

				array_pop($this->stack);
			}
			else
			{
				$this->stack[] = $key;

				// Check if we have segments (are not on home)
				if ($this->CI->uri->segment_array()) {

					// Write segments array
					$segments = $this->CI->uri->segment_array();

					// Fix the array keys (start at 0)
					$segments = array_values($segments);

					// Check if we are in a folder's home
					$total_segments = $this->CI->uri->total_segments();
					$array_segments = count($this->stack);

					if ($array_segments == $total_segments + 1) {

						// Fix the array...
						array_push($segments, 'index');

					}

				} else {

					// So we are on home, fix some errors
					$array_segments = 1;
					$segments = array('index');

				}

				// compare the arrays to see if it's the current
				if ($this->stack[$array_segments - 1] == $segments[$array_segments - 1]) {

					$this->html .= "\t".'<li class="'. $this->current_class .'"><a href="'.site_url(implode('/', $this->stack)).'">'.$item.'</a></li>'."\n";

				} else {

					$this->html .= "\t".'<li><a href="'.site_url(implode('/', $this->stack)).'">'.$item.'</a></li>'."\n";

				}

				array_pop($this->stack);
			}
		}

		$this->html .= '</ul>'."\n\n";

		$this->depth--;
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
	public function guess_name($name)
	{
		$name = $this->remove_extension($name);

		$name = str_replace('-', ' ', $name);
		$name = str_replace('_', ' ', $name);

		return ucwords($name);
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

}