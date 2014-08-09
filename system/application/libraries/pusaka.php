<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pusaka Library
 *
 * All methods used in Pusaka Core
 *
 * @package		Pusaka
 * @author		Toni Haryanto (@toharyan)
 * @copyright	Copyright (c) 2014, Nyankod
 * @license		http://pusakacms.nyankod.com/license
 * @link		http://pusakacms.nyankod.com
 */
class Pusaka {

	var $CI;
	var $level 			= 1;
	var $ul_class 		= 'nav';
	var $li_class 		= '';
	var $a_class 		= '';
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
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	// --------------------------------------------------------------------

	/**
	 * Generate Navigation
	 *
	 * @access	public
	 * @param	string	starting folder
	 * @param	int 	navigation depth
	 * @param	string 	ul class
	 * @param	string 	li class
	 * @param	string 	active class applied in active li and a
	 * @return	string
	 */

	function get_nav($prefix = null, $depth = 3)
	{
		// init variable
		$folder = CONTENT_FOLDER.'/'.$prefix;
		$new_map = array();

		// sort by newest post for posts entry
		if($prefix == $this->CI->config->item('post_folder')){
			$map = directory_map($folder);
			foreach ($map as $value) {
				if($this->is_valid_ext($value))
					$new_map[$prefix.$this->remove_extension($value)] = $this->guess_name($this->remove_date($value));
			}

			if ($this->remove_index === TRUE AND isset($new_map['index']))
					unset($new_map['index']);

			asort($new_map);
		} else
			$new_map = $this->_dig_navfile($prefix, $depth, 1, true);

		// bulid the list
		return $new_map;
	}

	// --------------------------------------------------------------------

	/**
	 * Generate Navigation
	 *
	 * @access	public
	 * @param	string	starting folder
	 * @param	int 	navigation depth
	 * @param	string 	ul class
	 * @param	string 	li class
	 * @param	string 	active class applied in active li and a
	 * @return	string
	 */

	function generate_nav($prefix = null, $depth = 3, $ul_class = null, $li_class = null, $active_class = null)
	{
		// set variable
		$folder = CONTENT_FOLDER.'/'.$prefix;

		if($ul_class) $this->ul_class = $ul_class;
		if($li_class) $this->li_class = $li_class;
		if($active_class) $this->active_class = $active_class;

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
			$new_map = $this->_dig_navfile($prefix, $depth);

		// bulid the list
		return $this->_build_list($new_map, ($prefix)? $prefix.'/' : '');
	}

	// --------------------------------------------------------------------

	/**
	 * Sync navigation from content
	 *
	 * @access	public
	 * @param	string	starting folder
	 * @return	void
	 */
	function sync_nav($prefix = null)
	{
		header("Content-Type:text/plain");

		if(!$prefix) $prefix = CONTENT_FOLDER;
		
		$map = directory_map($prefix, 1);

		$new_map = array();
		foreach ($map as $file)
			if($file != $this->navfile and $file != 'index.html')
				$new_map[] = $this->remove_extension($file);
	
		$json = (array) json_decode(read_file($prefix.'/'.$this->navfile));
		$json_simpled = array_keys($json);
		// print_r($json_simpled);

		// add the new content to menu
		$diff = array_diff($new_map, $json_simpled);
		if(count($diff) > 0){
			foreach ($diff as $value){	
				$json += array($this->remove_extension($value) => $this->guess_name($value));
				echo "menu synced for new content $prefix/$value\n";
			}

			// make sure it is writablle
			if(! write_file($prefix.'/'.$this->navfile, str_replace(array("{",",","}"), array("{\n\t",",\n\t","\n}"),json_encode($json)), "w")){
				echo "please set content folder writable.\n";
				exit;
			}
		}

		// remove the deleted content to menu
		$new_map[] = 'index';
		$rev_diff = array_diff($json_simpled, $new_map);
		$new_json = array();
		if(count($rev_diff) > 0){
			foreach ($json as $key => $value)
				if(! in_array($key, $rev_diff))
					$new_json += array($key => $value);

			// make sure it is writablle
			if(! write_file($prefix.'/'.$this->navfile, str_replace(array("{",",","}"), array("{\n\t",",\n\t","\n}"),json_encode($new_json)), "w")){
				echo "please set content folder writable.\n";
				exit;
			}
			else
				echo "menu updated for folder $prefix/\n";
		}

		// do for the child folders
		foreach ($new_map as $folder)
			if(is_dir($prefix.'/'.$folder))
				$this->sync_nav($prefix.'/'.$folder);
	}

	// --------------------------------------------------------------------

	/**
	 * dig navigation json file
	 *
	 * @access	private
	 * @param	string	starting folder
	 * @param	int		navigation depth
	 * @param	int		current nav level
	 * @return	array
	 */
	function _dig_navfile($prefix = null, $depth = 9, $level = 1, $simple_array = false)
	{
		if($prefix) $prefix .= '/';

		if($level <= $depth){

			if(file_exists(CONTENT_FOLDER.'/'.$prefix.$this->navfile)) {
				$new_map = array();

				$map = json_decode(read_file(CONTENT_FOLDER.'/'.$prefix.$this->navfile));

				if($simple_array){
					foreach ($map as $key => $value) {
						if(is_dir(CONTENT_FOLDER.'/'.$prefix.$key))
							$new_map[$prefix.$key] = $this->_dig_navfile($prefix.$key, $depth, $level+1, $simple_array);

						$new_map[$prefix.$key]['_title'] = $value;
					}
				} else {	
					foreach ($map as $key => $value) {
						if(is_dir(CONTENT_FOLDER.'/'.$prefix.$key))
							$new_map[$key] = $this->_dig_navfile($prefix.$key, $depth, $level+1);

						$new_map[$key]['_title'] = $value;
					}
				}

				return $new_map;

			} else {
				// get derectory map
				$map = directory_map(FCPATH.CONTENT_FOLDER.'/'.$prefix, 1);

				$for_json = array();
				$new_map = array();

				//simpan sebagai nav.json
				foreach ($map as $file) {
					if($this->is_valid_ext(CONTENT_FOLDER.'/'.$prefix.'/'.$file))
						$for_json[$this->remove_extension($file)] = $this->guess_name($file);
				}

				if ($this->remove_index === TRUE AND isset($for_json['index']))
					unset($for_json['index']);

				write_file(CONTENT_FOLDER.'/'.$prefix.'/'.$this->navfile, str_replace(array("{",",","}"), array("{\n\t",",\n\t","\n}"),json_encode($for_json)));

				if($simple_array){
					foreach ($for_json as $key => $value) {
						if(is_dir(CONTENT_FOLDER.'/'.$prefix.$key))
							$new_map[$prefix.$key] = $this->_dig_navfile($prefix.$key, $depth, $level+1, $simple_array);

						$new_map[$prefix.$key]['_title'] = $value;
					}
				} else {
					foreach ($for_json as $key => $value) {
						if(is_dir(CONTENT_FOLDER.'/'.$prefix.$key))
							$new_map[$key] = $this->_dig_navfile($prefix.$key, $depth, $level+1);

						$new_map[$key]['_title'] = $value;
					}
				}

				return $new_map;
			}
		}

		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * build html list
	 *
	 * @access	private
	 * @param	array	array tree
	 * @param	string	starting folder
	 * @return	string
	 */
	function _build_list($tree, $prefix = '')
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

				// echo uri_string().' > '.$prefix.$key."<br>\n\n";

				if (is_array($value))
				{
					// set active for match link
					if(uri_string() == $prefix.$key) $active = true;

					// set active for upper link
					if(strstr(uri_string(), $prefix.$key)) $active = true;

					if (array_key_exists('_title', $value)) {
						// don't use index term
						$newkey = ($key == 'index')? 'index/' : $key.'/';

						$li .= "<a href='".site_url($prefix.$newkey)."' ".($active ? "class='".$this->current_class."'" : "").">${value['_title']}</a>";
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

	// --------------------------------------------------------------------------

	/**
	 * Guess Name
	 *
	 * Takes a file name and attempts to generate
	 * a human-readble name from it.
	 *
	 * @access	public
	 * @param	string 	file name
	 * @param	string 	starting folder to indicate is it blog post or else
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
	 * @param	string 	file name
	 * @return	string	file name without extension
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
	 * Check a valid extension file
	 *
	 * @access	public
	 * @param	string 	path/to/filename.ext
	 * @return	bool	true if it is a valid extension
	 */
	public function is_valid_ext($filepath)
	{
		if(is_file($filepath)){
			$part = pathinfo($filepath);
			if(! in_array($part['extension'], $this->allowed_ext))
				return false;

		}
		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * Remove the date from a file name
	 *
	 * @access	public
	 * @param	string 	filename
	 * @return	string	filename without date
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