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
	var $curr_depth		= 2;
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
	 * scan page folders
	 *
	 * @access	public
	 * @param	array	array of page map, used for recursive
	 * @param	string 	parent url
	 * @return	array 	structured page map
	 */

	function scan_pages($map = false, $prefix = '', $depth = 5)
	{
		if(!$map)
			$map = directory_map(PAGE_FOLDER, $depth);
		
		$new_map = array();
		foreach ($map as $folder => $file){
			if($file != 'index.json' && $file != 'index.md' && $file != 'index.html'){

				if(is_array($file)){
					$slug = $this->remove_extension($folder);
					$content = array(
						'title' => $this->guess_name($folder),
						'url' => $prefix.$slug,
						'children' => $this->scan_pages($file, $prefix.$slug.'/'),
						);
				} else {
					$slug = $this->remove_extension($file);
					$content = array(
						'title' => $this->guess_name($file),
						'url' => $prefix.$slug,
						);
				}

				if($this->is_use_builder($prefix.$slug))
					$content['builder'] = true;

				$new_map[$slug] = $content;
			}
		}

		return $new_map;
	}

	function move_page($prevslug, $slug, $source, $dest)
	{
		// page move to another folder
		if($source != $dest) {
			// if it is move to subpage, not to root
			if(!empty($dest)) { 
				// if parent still as standalone file (not in folder)
				if(file_exists(PAGE_FOLDER.$dest.'.md')) {
					// create folder and move the parent inside
					mkdir(PAGE_FOLDER.$dest, 0775);
					rename(PAGE_FOLDER.$dest.'.md', PAGE_FOLDER.$dest.'/index.md');

					// create index.html file
					copy(PAGE_FOLDER.'index.html', PAGE_FOLDER.$dest.'/index.html');
				}
			}
		}

		// move to new location
		if(is_dir(PAGE_FOLDER.$prevslug))
			rename(PAGE_FOLDER.$prevslug, PAGE_FOLDER.$dest.'/'.$slug);
		else
			rename(PAGE_FOLDER.$prevslug.'.md', PAGE_FOLDER.$dest.'/'.$slug.'.md');


		// if file left the empty folder, not from the root
		if(!empty($source) && $filesleft = glob(PAGE_FOLDER.$source.'/*')){
			// if there are only index.html, index.md
			if(count($filesleft) <= 2){
				// move to upper parent
				$this->raise_page($source);
			}
		}
	}

	function raise_page($source)
	{
		$parent_subparent_arr = explode("/", $source);
		$parent_name = array_pop($parent_subparent_arr);
		$parent_subparent = implode("/", $parent_subparent_arr);
		rename(PAGE_FOLDER.$source.'/index.md', PAGE_FOLDER.$parent_subparent.'/'.$parent_name.'.md');

		unlink(PAGE_FOLDER.$source.'/index.html');
		rmdir(PAGE_FOLDER.$source);
	}

	// --------------------------------------------------------------------

	/**
	 * get pages tree form page index file
	 *
	 * @access	public
	 * @param	array	array of page map, used for recursive
	 * @param	string 	parent url
	 * @return	array 	structured page map
	 */

	function get_pages_tree($prefix = false)
	{
		if(! file_exists(PAGE_FOLDER.'/'.$this->navfile))
			$this->sync_page();

		$map = json_decode(file_get_contents(PAGE_FOLDER.'/'.$this->navfile), true);

		// bulid the list
		return $map;
	}

	// --------------------------------------------------------------------

	/**
	 * Sync page index
	 *
	 * @access	public
	 * @return	array 	message
	 */
	function sync_page()
	{
		if(! file_exists(PAGE_FOLDER.'/'.$this->navfile))
			write_file(PAGE_FOLDER.'/'.$this->navfile, json_encode(array(), JSON_PRETTY_PRINT));

		$output = array('status' => 'success', 'message' => 'Everything already synced.');

		if(!is_writable(PAGE_FOLDER))
			$output = array('status' => 'error', 'message' => "Page folder is not writable. Make it writable first.\n");

		// get current directory map
		$map = $this->scan_pages();

		// get the old page index
		$from_file = json_decode(file_get_contents(PAGE_FOLDER.'/'.$this->navfile), true);

		// add new item to index
		$merge_diff = array_merge_recursive($from_file, $map);

		// remove unused item from index
		$new_index = array_intersect_assoc_recursive($merge_diff, $map);

		// make sure it is writablle
		if(! write_file(PAGE_FOLDER.'/'.$this->navfile, json_encode($new_index, JSON_PRETTY_PRINT), "w")){
			$output = array('status' => 'error', 'message' => "Page index file ".$this->navfile." is not writable. Make it writable first.\n");
		}
		else
			$output = array('status' => 'success', 'message' => "Page index synced.\n");

		return $output;
	}

	// --------------------------------------------------------------------

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

	// --------------------------------------------------------------------

	function get_flatnav($map = array(), $prefix = "")
	{
		if(empty($map))
			$map = $this->get_pages_tree();

		$new_map = array();

		foreach ($map as $link => $content) {
			$new_map[$content['url']] = $prefix.' '.$content['title'];

			if(isset($content['children']))
				$new_map += $this->get_flatnav($content['children'], $prefix.'—');
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

	function generate_nav($prefix = null, $options = array())
	{
		// set variable
		$folder = PAGE_FOLDER.'/'.$prefix;

		$new_map = $this->get_pages_tree($prefix);

		// bulid the list
		if(!empty($new_map))
			return $this->_build_list($new_map, ($prefix)? $prefix : '', $options);

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
	function _build_list($tree, $prefix = false, $options = array())
	{
		$default = array(
			'depth' => 3,
			'li_class' => '',
			'li_attr' => '',
			'a_class' => '',
			'a_attr' => '',
			'has_children_li_class' => '',
			'has_children_li_attr' => '',
			'has_children_a_class' => 'dropdown-toggle',
			'has_children_a_attr' => 'role="button"',
			'active_class' => 'active',
			'ul_children_class' => 'dropdown-menu',
			'ul_children_attr' => 'role="menu"'
			);
		$opt = array_merge($default, $options);

		if($prefix)
			$arr = $tree[$prefix]['children'];
		else
			$arr = $tree;

		$li = '';

		foreach ($arr as $slug => $page)
		{
			$active = '';

			if (is_array($page))
			{
				// set active for match link
				if(uri_string() == $page['url']) $active = ' '.$opt['active_class'];
				// set active for upper link
				if(strstr(uri_string(), $page['url'].'/')) $active = ' '.$opt['active_class'];

				$has_children_li_class = '';
				$has_children_a_attr = '';
				$has_children_li_attr = '';
				$has_children_a_attr = '';

				if(isset($page['children'])){
					$has_children_li_class = ' '.$opt['has_children_li_class'];
					$has_children_a_attr = ' '.$opt['has_children_a_class'];
					$has_children_li_attr = ' '.$opt['has_children_li_attr'];
					$has_children_a_attr = ' '.$opt['has_children_a_attr'];
				}

				$li .= '<li class="'.$opt['li_class'].$has_children_li_class.$active.'" '.$opt['li_attr'].$has_children_li_attr.'>';
				$li .= '<a class="'.$opt['a_class'].$has_children_a_attr.$active.'" '.$opt['a_attr'].$has_children_a_attr.' href="'.site_url($page['url']).'">'.$page['title'].'</a>';
				if(isset($page['children'])){
					$li .= '<ul class="'.$opt['ul_children_class'].'" '.$opt['ul_children_attr'].'>';
					$li .= $this->_build_list($page['children'], false, $opt);
					$li .= '</ul>';
				}
				$li .= '</li>';

				// $li .= "<a href='".site_url($page['url'])."' ".($active ? "class='".$this->current_class."'" : "").">{$page['title']}</a>";

				// if(isset($page['children']))
				// 	$li .= $this->_build_list($page['children']);

				// $ul .= strlen($li) ? "<li".($active ? " class='".$this->current_class."'" : "").">$li</li>" : '';
			}
		}

		return $li;
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
		if(isset($posts['entries'])){
			foreach ($posts['entries'] as $post) {
				if(isset($post['labels'])){
					foreach ($post['labels'] as $label) {
						$labels[trim($label)][] = $post['url'];
					}
				}
			}
		}

		// delete all labels first
			delete_files(LABEL_FOLDER);
			write_file(LABEL_FOLDER.'/index.md', 'Directory access forbidden.');

		// rewrite label indexes
			$output = array();
			foreach ($labels as $label => $url) {
				if(write_file(LABEL_FOLDER.'/'.$label.'.json', json_encode($url, JSON_PRETTY_PRINT)))
					$output = array('status' => 'success', 'message' => "Label list updated.\n");
				else
					$output = array('status' => 'error', 'message' => "Some labels failed to update. Please make content/labels/ folder writable.\n");
			}

			return $output;
		}

		public function get_layouts($theme = false)
		{
			$layouts = $this->CI->template->get_layouts($theme);
			$list = array();
			foreach ($layouts as $layout) {
				if(substr($layout, 0, 1) == "_")
					array_push($list, $layout);
			}

			return $list;
		}

	// --------------------------------------------------------------------

	/**
	 * get all blog post data tree
	 *
	 * @access	public
	 * @return	array
	 */
	function get_posts_tree($sort = 'asc', $site_slug = false)
	{
		$file_location = POST_FOLDER.'/'.$this->navfile;
		if($site_slug)
			$file_location = SITE_FOLDER.$site_slug.'/content/posts/'.$this->navfile;

		if(! file_exists($file_location))
			$this->sync_post($site_slug);

		$tree = json_decode(file_get_contents($file_location), true);

		if($sort == 'asc')
			ksort($tree);
		else
			krsort($tree);

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
	function get_posts($category = null, $page = 1, $sort = 'desc', $parse = true, $site_slug = false)
	{
		if(!$site_slug) $site_slug = SITE_SLUG;

		// I don't know why this line of code cannot affected if put in __construct
		$this->set_post_per_page();

		$posts = array();

		// get post list from label index
		if($category && $category != 'all'){
			if(! file_exists(LABEL_FOLDER.$category.'.json')) {
				$posts = array(
					'entries' => array(),
					'total' => 0
					);

				return $posts;
			}

			$file = file_get_contents(LABEL_FOLDER.$category.'.json');
			if(empty($file)) return false;
			$map = json_decode($file, true);
			$begin = ($page - 1) * $this->post_per_page;
			$limit = $this->post_per_page;
			$new_map = ($page != 'all') ? array_slice($map, $begin, $limit) : $map;

			foreach ($new_map as $url) {
				if($post = $this->get_post($url, $parse, true, false, $site_slug))
					$posts['entries'][] = $post;
			}
			$posts['total'] = count($map);

		// get post list from post index
		} else {
			$map = $this->get_posts_tree($sort, $site_slug);
			$begin = ($page - 1) * $this->post_per_page;
			$limit = $this->post_per_page;
			$new_map = ($page != 'all') ? array_slice($map, $begin, $limit) : $map;
			
			$posts['entries'] = array();
			foreach ($new_map as $postlist) {
				if($post = $this->get_post($postlist['url'], $parse, true, false, $site_slug))
					$posts['entries'][] = $post;
			}
			$posts['total'] = count($map);
		}

		return $posts;
	}

	// --------------------------------------------------------------------

	/**
	 * get detail blog post
	 *
	 * @access	private
	 * @param	string	post url
	 * @param	bool	parse content and intro or not
	 * @param	bool	set content to intro or not
	 * @return	array
	 */
	function get_post($url = null, $parse = true, $content_to_intro = true, $by_filename = false, $site_slug = false)
	{
		if(! $site_slug) $site_slug = SITE_SLUG;
		
		$post_folder = ($site_slug == SITE_SLUG)
						? POST_FOLDER
						: SITE_FOLDER.$site_slug.'/'.$this->CI->config->item('post_folder');

		$post_db = new Nyankod\JsonFileDB($post_folder);
		$post_db->setTable('index');

		// if post get by filename
		if($by_filename){
			$the_post = $post_db->select('filename', $url);
			$postslug = url_title($this->guess_name($url, POST_TERM));

		} else {
			$segs = explode("/", $url);
			$postslug = $segs[count($segs)-1];

			// url must have 4 segment (blog/yyyy/mm/dd/slug)
			if(count($segs) != 5)
				return false;
			
			$the_post = $post_db->select('url', $url);
		}


		if(empty($the_post) || ! file_exists($post_folder.$the_post['filename']))
			return false;

		$file = file_get_contents($post_folder.$the_post['filename']);
		if(!empty($file)){
			$post = explode("{:", $file);
			array_shift($post);
			
			$new_post = array(
				'date' => $the_post['date'],
				'file' => $the_post['filename']
				);

			foreach ($post as $elm) {
				$segs = preg_split("/( :} | :}|:} |:})/", $elm, 2);

				if(trim($segs[0]) == 'labels'){
					$new_post[trim($segs[0])] = preg_split("/(\s,\s|\s,|,\s|,)/", $segs[1]);
					continue;
				}

				if((trim($segs[0]) == 'content' || trim($segs[0]) == 'intro') && $parse)
				{
					$Parsedown = new Parsedown();
					$new_post[trim($segs[0])] = $Parsedown->setBreaksEnabled(true)->text($segs[1]);
				}
				else
					$new_post[trim($segs[0])] = trim($segs[1]);

				$new_post['url'] = $url;
			}

			if(!isset($new_post['intro']) && $content_to_intro)
				$new_post['intro'] = $new_post['content'];

			if(!isset($new_post['slug']))
				$new_post['slug'] = $postslug;


			// print_r($new_post);
			return $new_post;
		}

		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * Sync post index
	 *
	 * @access	public
	 * @param	string	starting folder
	 * @return	void
	 */
	function sync_post($site_slug = false)
	{
		$post_folder = POST_FOLDER;
		if($site_slug)
			$post_folder = SITE_FOLDER.$site_slug.'/content/posts';

		if(! file_exists($post_folder.'/'.$this->navfile))
			write_file($post_folder.'/'.$this->navfile, json_encode(array(), JSON_PRETTY_PRINT));

		$output = array('status' => 'success', 'message' => 'Everything already synced.');

		// get derectory map
		$map = directory_map($post_folder, 1);

		$tree = array();
		foreach ($map as $file) {
			if(in_array($file, array('index.json', 'index.html'))) continue;
			$temp = $this->create_post_attributes($file);
			$tree[$temp['date']] = $temp;
		}
		krsort($tree);

		if(! write_file($post_folder.'/'.$this->navfile, json_encode($tree, JSON_PRETTY_PRINT)))
			$output = array('status' => 'error', 'message' => "Post index file ".$this->navfile." is not writable. Make it writable first then sync post index.\n");
		else
			$output = array('status' => 'success', 'message' => "post index synced.\n");

		return $output;
	}

	function create_post_attributes($file)
	{
		// change dash in date to slash
		$segs = explode("-", $file, 6);
		$date = $segs[0].'-'.$segs[1].'-'.$segs[2].'-'.$segs[3].'-'.$segs[4];

		if(count($segs) > 5)
			$newkey = $this->remove_extension(implode("/", $segs));
		else
			$newkey = $this->remove_extension($file);

		if($file != $this->navfile && $file != 'index.html' && $this->is_valid_ext(POST_FOLDER.'/'.$file))
			return array(
				"filename" => $file,
				"url" => POST_TERM.'/'.$this->remove_extension($segs[0].'/'.$segs[1].'/'.$segs[2].'/'.$segs[5]),
				"date" => $segs[0].'-'.$segs[1].'-'.$segs[2].' '.$segs[3].':'.$segs[4]
				);

		return false;
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
			$config['base_url'] = site_url().POST_TERM;
			
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

		return rtrim($name, '/');
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
		if(is_string($file)){
			$segs = explode('.', $file, 2);
			if(count($segs) > 1)
			{
				array_pop($segs);
				$file = implode('.', $segs);
			}
		}


		return rtrim($file, '/');
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
		$segs = explode('-', $filename, 6);

		if(count($segs) > 5)
		{
			$filename = $segs[5];
		}

		return $filename;
	}

	function register_domain($new_domain, $old_domain = false, $site_slug = false)
	{
		// if new domain already exist, warn user
		if($new_domain != $old_domain && file_exists(SITE_FOLDER.'_domain/'.$new_domain.'.conf')){
			$site_slug = read_file(SITE_FOLDER.'_domain/'.$new_domain.'.conf');
			$this->CI->session->set_flashdata('error', 'Domain already used with site slug '.$site_slug);
			return false;
		}

		//this means request come from outside module
		if(! $site_slug) 
			$site_slug = SITE_SLUG;

		// delete previous domain if it is updating
		if($old_domain !== FALSE && ! empty($old_domain) && file_exists(SITE_FOLDER.'_domain/'.$old_domain.'.conf')){
			$site_slug = read_file(SITE_FOLDER.'_domain/'.$old_domain.'.conf');

			// delete old domain
			if(!unlink(SITE_FOLDER.'_domain/'.$old_domain.'.conf'))
				show_error('cnnot delete file');
		}
		
		// create new
		if(write_file(SITE_FOLDER.'_domain/'.$new_domain.'.conf', $site_slug))
			return true;
		else
			show_error('cannot write domain configuration file. Make sure folder sites/_domain/ is writable.');

		return false;
	}

	function is_use_builder($file)
	{
		if($page = $this->get_page($file))
		{
			if(isset($page['builder']) && $page['builder'])
				return true;
		}

		return false;
	}

}