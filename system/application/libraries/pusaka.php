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
	var $depth 			= 3;
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

	function nav($prefix = null, $depth = 2)
	{
		$start = ($prefix) ? $prefix.'/' : '';

		$folder = CONTENT_FOLDER;

		// if prefix set
		if($prefix){
			$segs = explode("/", $prefix);

			// tambahin satu di awal sebagai root kalo prefix cuma satu segment
			if(count($segs) < 2)
				array_unshift($segs, "/");

			// get nav.json for checking the pseudo path
			$json = $this->object_to_array(json_decode(read_file($folder.$segs[0].'/nav.json')));

			foreach ($json as $key => $value) {
				if($key == $segs[1]){
					$map = directory_map(FCPATH.$folder.'/'.$value['_file'], $depth);
					break;
				}
			}
		}
		// if prefix is root content
		else
			$map = directory_map(FCPATH.$folder, $depth);

		// parse map in order to compatible with build_list()
		$new_map = $this->_parse_map($map, $prefix);

		// bulid the list
		$list = $this->build_list($new_map, $start);

		return $list;
	}

	function sync_nav($prefix = null)
	{
		$start = ($prefix) ? $prefix.'/' : '';

		// get derectory map
		$map = directory_map(FCPATH.CONTENT_FOLDER.'/'.$start, 1);

		foreach ($map as $file) {
			if(is_dir(CONTENT_FOLDER.'/'.$start.$file))
				$this->sync_nav($start.$file);
		}

		// parse map in order to compatible with _build_list()
		$new_map = $this->_parse_map($map, $prefix, true);

		// generate json
		$list = json_encode($new_map);


		// save to file
		if ( ! write_file(FCPATH.CONTENT_FOLDER.'/'.$start.'nav.json', $list))
			echo $prefix." failed<br><br>";
		else
			echo $prefix." success<br><br>";
	}

	function build_list($tree, $prefix = '')
	{
		$ul = '';

		if($this->is_posts_prefix($prefix))
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
		}

		return strlen($ul) ? "<ul class='".$this->ul_class."'>$ul</ul>" : '';
	}

	function object_to_array($obj) {
		if(is_object($obj)) $obj = (array) $obj;
		if(is_array($obj)) {
			$new = array();
			foreach($obj as $key => $val) {
				$new[$key] = $this->object_to_array($val);
			}
		}
		else $new = $obj;
		return $new;       
	}

	function _build_list($tree, $prefix = '')
	{
		$ul = '';

		if($this->is_posts_prefix($prefix))
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

					$li .= $this->_build_list($value, "$prefix$newkey/");
					$ul .= strlen($li) ? "<li".($active ? " class='".$this->current_class."'" : "").">$li</li>" : '';
				}
			}
		}
		else {

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

					$li .= $this->_build_list($value, "$prefix$key/");
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
	private function _parse_map($map, $prefix = null, $add_folder_name = false)
	{
		$new_map = array();
		
		foreach($map as $key => $file)
		{
			if (is_array($file))
			{
				// show on menu only numbered files/folders
				if(strpos($key, ':')){	
					// add _title field
					$new_map[$key] = array_merge(array('_title' => $key), $this->_parse_map($map[$key], $prefix, $add_folder_name));
				}
			}
			else
			{
				// show on menu only numbered files/folders
				if (strpos($file, ':')){
					$new_map[$this->remove_extension($file)]['_title'] = $file;
				
				// add _folder field
				// if($add_folder_name)
					$new_map[$this->remove_extension($file)]['_file'] = $file;
				}
			}
		}

		if ($this->remove_index === TRUE AND isset($new_map['index']))
		{
			unset($new_map['index']);
		}
		
		// sort by newest post for posts entry
		if($this->is_posts_prefix($prefix)) 
			arsort($new_map);
		else{
			// sort the content
			asort($new_map);

			// sort the key
			ksort($new_map);
		}

		// clean the name from number
		$new_map = $this->clean_name($new_map, $prefix);

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

		if($this->is_posts_prefix($prefix)){
			$segs = explode('-', $name, 4);

			if(count($segs) > 3)
			{
				$name = $segs[3];
			}

		} else {
			$pos = strpos($name, ':');
			$name = substr($name, ($pos===FALSE)? 0 : $pos+1);
		}

		$name = str_replace('-', ' ', $name);
		$name = str_replace('_', ' ', $name);

		// assumes that root folders need uppercase first
		if(! $prefix)
			$name = ucfirst($name);

		return $name;
	}

	public function clean_name($map, $prefix = null)
	{
		$new_map = array();
		$temp_key = '';

		foreach ($map as $key => $value) {
			// kalo keynya _title, value pasti string
			if($key == '_title'){
				$new_map['_title'] = $this->guess_name($value, $prefix);
			} 
			// kalo keynya _file biarkan
			elseif($key == '_file') {
				$new_map['_file'] = $value;
			}
			// kalo keynya bukan _title, value pasti array
			else {
				// simpan nama key baru sementara
				$pos = strpos($key, ':');
				$temp_key = substr($key, ($pos===FALSE)? 0 : $pos+1);

				// clean name lagi buat value array
				$new_map[$temp_key] = $this->clean_name($value, $prefix);
			}
		}

		return $new_map;
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

	public function is_posts_prefix($prefix)
	{
		if(strpos($prefix, ':')){
			$segs = explode(":", $prefix);
			$prefix = $segs[1];
		}

		if($prefix == $this->CI->config->item('post_folder') or $prefix == $this->CI->config->item('post_folder').'/')
			return true;
	}

}