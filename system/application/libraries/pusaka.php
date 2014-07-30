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
	var $navfile		= "nav.json";
	var $allowed_ext	= array('html','md','textile');

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

	function nav($prefix = null, $depth = 3)
	{
		$folder = CONTENT_FOLDER.'/'.$prefix;

		$new_map = array();

		// sort by newest post for posts entry
		if($prefix == $this->CI->config->item('post_folder')){
			$map = directory_map($folder);
			foreach ($map as $value) {
				if($this->is_valid_ext($value))
					$new_map[$this->remove_extension($value)]['_title'] = $this->guess_name($this->remove_date($value));
			}

			if ($this->remove_index === TRUE AND isset($new_map['index']))
					unset($new_map['index']);

			asort($new_map);
		} else
			$new_map = $this->dig_navfile($folder, $depth);

		// bulid the list
		$list = $this->build_list($new_map, ($prefix)? $prefix.'/' : '');
		
		return $list;
	}

	function dig_navfile($prefix = null, $depth = 3, $level = 1)
	{
		if($level <= $depth){

			if(file_exists($prefix.'/'.$this->navfile)) {
				$new_map = array();

				$map = json_decode(read_file($prefix.'/'.$this->navfile));

				foreach ($map as $key => $value) {
					if(is_dir($prefix.'/'.$key))
						$new_map[$key] = $this->dig_navfile($prefix.'/'.$key, $depth, $level+1);

					$new_map[$key]['_title'] = $value;
				}

				return $new_map;

			} else {
				// get derectory map
				$map = directory_map(FCPATH.$prefix, 1);

				$for_json = array();
				$new_map = array();

				//simpan sebagai nav.json
				foreach ($map as $file) {
					$for_json[$this->remove_extension($file)] = $this->guess_name($file);
				}
				if ($this->remove_index === TRUE AND isset($for_json['index']))
					unset($for_json['index']);

				write_file($prefix.'/'.$this->navfile, str_replace(array("{",",","}"), array("{\n\t",",\n\t","\n}"),json_encode($for_json)));	

				foreach ($for_json as $key => $value) {
					if(is_dir($prefix.'/'.$key))
						$new_map[$key] = $this->dig_navfile($prefix.'/'.$key.'/', $depth, $level+1);

					$new_map[$key]['_title'] = $value;
				}

				return $new_map;
			}
		}

		return false;
	}

	function build_list($tree, $prefix = '')
	{
		$ul = '';

		if($prefix == $this->CI->config->item('post_folder').'/')
		{
			foreach ($tree as $key => $value)
			{
				$li = '';
				$active = false;

				if (is_array($value))
				{

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
						$li .= "<a href='".site_url($prefix.$newkey)."/' ".($active ? "class='".$this->current_class."'" : "").">${value['_title']}</a>";
					} else {
						$li .= "$prefix$newkey/";
					}

					$li .= $this->build_list($value, "$prefix$newkey/");
					$ul .= strlen($li) ? "<li".($active ? " class='".$this->current_class."'" : "").">$li</li>" : '';
				}
			}
		}
		else {

			foreach ($tree as $key => $value)
			{
				$li = '';
				$active = false;

				// echo uri_string().' > '.$prefix.$key."<br>\n\n";

				if (is_array($value))
				{
					// set active for match link
					if(uri_string() == $prefix.$key) $active = true;

					// set active for upper link
					if(strstr(uri_string(), $prefix.$key)) $active = true;

					if (array_key_exists('_title', $value)) {
						// don't use index term
						$newkey = ($key == 'index')? '' : $key.'/';

						$li .= "<a href='".site_url($prefix.$newkey)."' ".($active ? "class='".$this->current_class."'" : "").">${value['_title']}</a>";
					} else {
						$li .= "$prefix$key/";
					}

					$li .= $this->build_list($value, "$prefix$key/");
					$ul .= strlen($li) ? "<li".($active ? " class='".$this->current_class."'" : "").">$li</li>" : '';
				}
			}
		}

		return strlen($ul) ? "<ul class='".$this->ul_class."'>$ul</ul>" : '';
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

		if($prefix == $this->CI->config->item('post_folder')){
			$name = $this->remove_date($name);
		}

		$name = str_replace('-', ' ', $name);
		$name = str_replace('_', ' ', $name);

		// assumes that root folders need uppercase first
		if(! $prefix)
			$name = ucwords($name);

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

	public function is_valid_ext($file)
	{
		$part = pathinfo($file);
		if(in_array($part['extension'], $this->allowed_ext))
			return true;

		return false;
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