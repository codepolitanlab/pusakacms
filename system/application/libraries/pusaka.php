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
	var $navfile		= "index.json";
	var $allowed_ext	= array('md');

	var $post_per_page;

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

	function get_pages_tree($prefix = null, $depth = 5)
	{
		// init variable
		$new_map = array();

		$new_map = $this->_dig_navfile($prefix, $depth, 1, true);

		// bulid the list
		return $new_map;
	}

	function get_raw_posts_tree()
	{
		$new_map = array();

		$map = directory_map(POST_FOLDER);
		foreach ($map as $value) {
			if($this->is_valid_ext($value))
				$new_map[$this->remove_extension($value)] = $this->guess_name($this->remove_date($value));
		}

		if ($this->remove_index === TRUE)
			unset($new_map['index']);

		asort($new_map);

		// bulid the list
		return $new_map;
	}

	function get_flatnav($map = array(), $prefix = "")
	{
		if(empty($map))
			$map = $this->get_pages_tree();

		$new_map = array();

		foreach ($map as $link => $content) {
			if($link != '_title')
				$new_map[$link] = $prefix.' '.$content['_title'];
	
			if(count($content) > 1)
				$new_map += $this->get_flatnav($content, $prefix.'—');
		}
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
		$folder = PAGE_FOLDER.'/'.$prefix;

		if($ul_class) $this->ul_class = $ul_class;
		if($li_class) $this->li_class = $li_class;
		if($active_class) $this->active_class = $active_class;

		$new_map = array();

		// sort by newest post for posts entry
		if($prefix == POST_TERM){
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
		if(!empty($new_map))
			return $this->_build_list($new_map, ($prefix)? $prefix.'/' : '');

		return false;
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

			if(file_exists(PAGE_FOLDER.'/'.$prefix.$this->navfile)) {
				$new_map = array();

				$map = json_decode(file_get_contents(PAGE_FOLDER.'/'.$prefix.$this->navfile));

				if($simple_array){
					foreach ($map as $key => $value) {
						if(is_dir(PAGE_FOLDER.'/'.$prefix.$key))
							$new_map[$prefix.$key] = $this->_dig_navfile($prefix.$key, $depth, $level+1, $simple_array);

						$new_map[$prefix.$key]['_title'] = $value;
					}
				} else {	
					foreach ($map as $key => $value) {
						if(is_dir(PAGE_FOLDER.'/'.$prefix.$key))
							$new_map[$key] = $this->_dig_navfile($prefix.$key, $depth, $level+1);

						$new_map[$key]['_title'] = $value;
					}
				}

				return $new_map;

			} else {
				// get derectory map
				$map = directory_map(FCPATH.PAGE_FOLDER.'/'.$prefix, 1);

				if(!$map) return false;

				$for_json = array();
				$new_map = array();

				//simpan sebagai nav.json
				foreach ($map as $file) {
					if($this->is_valid_ext(PAGE_FOLDER.'/'.$prefix.'/'.$file) && $file !== 'index.md')
						$for_json[$this->remove_extension($file)] = $this->guess_name($file);
				}

				if ($this->remove_index === TRUE AND isset($for_json['index']))
					unset($for_json['index']);

				write_file(PAGE_FOLDER.'/'.$prefix.'/'.$this->navfile, json_encode($for_json, JSON_PRETTY_PRINT));

				if($simple_array){
					foreach ($for_json as $key => $value) {
						if(is_dir(PAGE_FOLDER.'/'.$prefix.$key))
							$new_map[$prefix.$key] = $this->_dig_navfile($prefix.$key, $depth, $level+1, $simple_array);

						$new_map[$prefix.$key]['_title'] = $value;
					}
				} else {
					foreach ($for_json as $key => $value) {
						if(is_dir(PAGE_FOLDER.'/'.$prefix.$key))
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
	 * Sync navigation from content
	 *
	 * @access	public
	 * @param	string	starting folder
	 * @return	void
	 */
	function sync_nav($prefix = null)
	{
		$output = '';

		if($prefix == POST_TERM){
			// get derectory map
			$map = directory_map(POST_FOLDER, 1);

			$tree = array();

			//simpan sebagai nav.json
			foreach ($map as $file) {
				// change dash in date to slash
				$segs = explode("-", $file, 4);
				if(count($segs) > 3)
					$newkey = $this->remove_extension(implode("/", $segs));
				else
					$newkey = $this->remove_extension($file);

				if($file != $this->navfile && $file != 'index.html' && $this->is_valid_ext(POST_FOLDER.'/'.$file))
					$tree[POST_TERM.'/'.$newkey] = $this->guess_name($file, POST_TERM);
			}

			krsort($tree);
			if(! write_file(POST_FOLDER.'/'.$this->navfile, json_encode($tree, JSON_PRETTY_PRINT)))
				$output .= "unable to write ".$this->navfile."\n";
			else
				$output .= "post index synced.";
			
		} else {

			if(!$prefix) $prefix = PAGE_FOLDER;

			$map = directory_map($prefix, 1);

			$new_map = array();
			foreach ($map as $file)
				if($file != $this->navfile && $file != 'index.md' && $file != 'index.html')
					$new_map[] = $this->remove_extension($file);

				$json = json_decode(file_get_contents($prefix.'/'.$this->navfile), true);
				$json_simpled = array_keys($json);

				// add the new content to menu
				$diff = array_diff($new_map, $json_simpled);
				if(count($diff) > 0){
					foreach ($diff as $value){	
						$json += array($this->remove_extension($value) => $this->guess_name($value));
						$output .= "menu synced for new content $prefix/$value\n";
					}

					// make sure it is writablle
					if(! write_file($prefix.'/'.$this->navfile, json_encode($json, JSON_PRETTY_PRINT))) {
						$output .= "please set content folder writable.\n";
						exit;
					}
				}

			// remove the deleted content to menu
			$new_map = array_merge($new_map, array('index', POST_TERM)); // set the undelete
			$rev_diff = array_diff($json_simpled, $new_map);
			$new_json = array();
			if(count($rev_diff) > 0){
				foreach ($json as $key => $value)
					if(! in_array($key, $rev_diff))
						$new_json += array($key => $value);

				// make sure it is writablle
					if(! write_file($prefix.'/'.$this->navfile, json_encode($new_json, JSON_PRETTY_PRINT), "w")){
						$output .= "please set content folder writable.\n";
						exit;
					}
					else
						$output .= "menu updated for folder $prefix/\n";
				}

			// do for the child folders
			foreach ($new_map as $folder)
				if(is_dir($prefix.'/'.$folder))
					$output .= $this->sync_nav($prefix.'/'.$folder);

		}
		
		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Sync post label
	 *
	 * @access	public
	 * @param	string	starting folder
	 * @return	void
	 */
	function sync_label()
	{
		// get all post
		$posts = $this->get_posts(null, 'all');
		$labels = array();

		// get all labels for each post
		foreach ($posts['entries'] as $post) {
			foreach ($post['labels'] as $label) {
				$labels[trim($label)][] = $post['url'];
			}
		}

		// delete all labels first
		delete_files(LABEL_FOLDER);
		write_file(LABEL_FOLDER.'/index.md', 'Directory access forbidden.');

		// rewrite label indexes
		$output = '';
		foreach ($labels as $label => $url) {
			if(write_file(LABEL_FOLDER.'/'.$label.'.json', json_encode($url, JSON_PRETTY_PRINT)))
				$output .= "Label $label list updated.\n";
			else
				$output .= "Label $label fail update. Please make content/labels/ folder writtable.\n";
		}

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * get all blog post data tree
	 *
	 * @access	public
	 * @return	array
	 */
	function get_posts_tree($sort = 'asc')
	{
		// if post.json has been
		if(file_exists(POST_FOLDER.'/'.$this->navfile)) {
			$tree = json_decode(file_get_contents(POST_FOLDER.'/'.$this->navfile), true);

		} else {
			// get derectory map
			$map = directory_map(POST_FOLDER, 1);

			$tree = array();

			//simpan sebagai nav.json
			foreach ($map as $file) {
				// change dash in date to slash
				$segs = explode("-", $file, 4);
				if(count($segs) > 3)
					$newkey = $this->remove_extension(implode("/", $segs));
				else
					$newkey = $this->remove_extension($file);

				if($file != $this->navfile && $file != 'index.md' && $this->is_valid_ext(POST_FOLDER.'/'.$file))
					$tree[POST_TERM.'/'.$newkey] = $this->guess_name($file, POST_TERM);
			}

			write_file(POST_FOLDER.'/'.$this->navfile, json_encode($tree, JSON_PRETTY_PRINT));
		}

		if($sort == 'desc')
			krsort($tree);
		else
			ksort($tree);

		return $tree;
	}

	// --------------------------------------------------------------------

	/**
	 * get blog posts
	 *
	 * @access	private
	 * @param	string	category, null for get all
	 * @param	int		page number
	 * @return	array
	 */
	function get_posts($category = null, $page = 1, $sort = 'desc', $parse = true)
	{
		// I don't know why this line of code cannot affected if put in __construct
		$this->set_post_per_page();

		$posts = array();

		if($category && $category != 'all'){
			$file = file_get_contents(LABEL_FOLDER.'/'.$category.'.json');
			if(empty($file)) return false;
			$map = json_decode($file, true);
			$begin = ($page - 1) * $this->post_per_page;
			$limit = $this->post_per_page;
			$new_map = ($page != 'all') ? array_slice($map, $begin, $limit) : $map;

			foreach ($new_map as $url) {
				if($post = $this->get_post($url, $parse))
					$posts['entries'][] = ($post);
			}
			$posts['total'] = count($map);
		} else {
			$map = $this->get_posts_tree($sort);
			$begin = ($page - 1) * $this->post_per_page;
			$limit = $this->post_per_page;
			$new_map = ($page != 'all') ? array_slice($map, $begin, $limit) : $map;
			
			foreach ($new_map as $url => $title) {
				if($post = $this->get_post($url, $parse))
					$posts['entries'][] = ($post);
			}
			$posts['total'] = count($map);
		}

		return $posts;
	}

	function set_post_per_page($post_per_page = false)
	{
		$this->post_per_page = $this->CI->config->item('post_per_page')
								? $this->CI->config->item('post_per_page')
								: 10;

		if($post_per_page)
			$this->post_per_page = $post_per_page;

		return $this->post_per_page;
	}

	function post_pagination($total, $label = false, $uri = false, $page_segment = 3, $layout_options = array())
	{
		// I don't know why this line of code cannot affected if put in __construct
		$this->set_post_per_page();

		// create pagination
		$this->CI->load->library('pagination');

		// if $uri not set, assume it is for default frontend post
		if(! $uri){
			$config['base_url'] = site_url(POST_TERM);
			
			if($label)
				$config['base_url'] .= '/label/'.$label;
			else
				$config['base_url'] .= '/p/';

			$config['uri_segment'] = ($label) ? $page_segment + 1 : $page_segment;

		} else {
			$config['base_url'] = site_url($uri);
			$config['uri_segment'] = $page_segment;
		}


		$config['total_rows'] = $total;
		$config['per_page'] = $this->post_per_page; 
		$config['use_page_numbers'] = TRUE;

		// layouting
		$config['first_link'] = '&lt;&lt; First';
		$config['last_link'] = 'Last &gt;&gt;';

		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '<li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$config['next_link'] = 'Next &gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt; Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';

		// override layout
		if(count($layout_options) > 0){
			foreach ($layout_option as $key => $value) {
				$config[$key] = $value;
			}
		}

		$this->CI->pagination->initialize($config); 
		return $this->CI->pagination->create_links();
	}

	// --------------------------------------------------------------------

	/**
	 * get detail blog post
	 *
	 * @access	private
	 * @param	string	category, null for get all
	 * @param	int		page number
	 * @return	array
	 */
	function get_post($url = null, $parse = true)
	{
		$segs = explode("/", $url);
		array_shift($segs);
		$date = $segs[0].'-'.$segs[1].'-'.$segs[2];
		$filename = implode("-", $segs);
		$ext = 'html';

		foreach ($this->allowed_ext as $the_ext) {
			if(is_file(POST_FOLDER.'/'.$filename.'.'.$the_ext)){
				$filename .= '.'.$the_ext;
				$ext = $the_ext;
				break;
			}
		}

		$file = file_get_contents(POST_FOLDER.'/'.$filename);

		if(!empty($file)){
			$post = explode("{:", $file);
			array_shift($post);
			
			$new_post = array(
				'title' => $this->guess_name($filename, POST_TERM), 
				'date' => $date,
				'file' => $filename
			);

			foreach ($post as $elm) {
				$segs = preg_split("/( :} | :}|:} |:})/", $elm, 2);

				// set meta to config
				if(in_array(trim($segs[0]), array('meta_keywords', 'meta_description', 'author')))
					$this->CI->config->set_item(trim($segs[0]), trim($segs[1]));

				if(trim($segs[0]) == 'labels')
					$new_post[trim($segs[0])] = preg_split("/(\s,\s|\s,|,\s)/", $segs[1]);

				elseif(trim($segs[0]) == 'content' && $parse)
				{
					$Parsedown = new Parsedown();
					$new_post[trim($segs[0])] = $Parsedown->setBreaksEnabled(true)->text($segs[1]);
				}
				else
					$new_post[trim($segs[0])] = trim($segs[1]);

				$new_post['url'] = $url;
			}

			// print_r($new_post);
			return $new_post;
		}

		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * get detail page
	 *
	 * @access	private
	 * @param	string	category, null for get all
	 * @param	int		page number
	 * @return	array
	 */
	function get_page($url = null, $parse = true)
	{
		if(file_exists(PAGE_FOLDER.$url.'.md')) 
			$file = file_get_contents(PAGE_FOLDER.$url.'.md');
		elseif(file_exists(PAGE_FOLDER.$url.'/index.md')) 
			$file = file_get_contents(PAGE_FOLDER.$url.'/index.md');
		else
			return false;


		if(!empty($file)){
			$page = explode("{:", $file);
			array_shift($page);
			
			$page_arr = array('url' => $url);
			
			$file_segment = explode('/', $url);
			if(count($url) > 0){
				$page_arr['slug'] = array_pop($file_segment);
				if(count($url) > 0)
					$page_arr['parent'] = implode('/', $file_segment);
			}

			if($parse){	
				foreach ($page as $elm) {
					$segs = preg_split("/( :} | :}|:} |:})/", $elm, 2);

					// set meta to config
					if(in_array(trim($segs[0]), array('meta_keywords', 'meta_description', 'author')))
						$this->CI->config->set_item(trim($segs[0]), trim($segs[1]));

					if(trim($segs[0]) == 'labels')
						$page_arr[trim($segs[0])] = preg_split("/(\s,\s|\s,|,\s)/", $segs[1]);

					elseif(trim($segs[0]) == 'content')
					{
						$Parsedown = new Parsedown();
						$page_arr[trim($segs[0])] = $Parsedown->setBreaksEnabled(true)->text($segs[1]);
					}
					else
						$page_arr[trim($segs[0])] = trim($segs[1]);
				}
			} else {
				foreach ($page as $elm) {
					$segs = preg_split("/( :} | :}|:} |:})/", $elm, 2);
					$page_arr[trim($segs[0])] = trim($segs[1]);
				}
			}

			return $page_arr;
		}

		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * get post label list
	 *
	 * @access	private
	 * @return	array
	 */
	function get_labels()
	{
		$labels = directory_map(LABEL_FOLDER, 1);

		$list = array();
		foreach ($labels as $label) {
			if($label != 'index.md')
				$list[POST_TERM.'/label/'.strtolower($this->remove_extension($label))] = strtolower($this->remove_extension($label));
		}
		return $list;
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

		if($prefix == POST_TERM.'/')
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
					if(strstr(uri_string(), '/'.$prefix.$newkey)) $active = true;

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
					if(strstr(uri_string(), $prefix.$key.'/')) $active = true;

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

		if($prefix == POST_TERM){
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