<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Template Class
 *
 * Build your CodeIgniter pages much easier with partials, breadcrumbs, layouts and themes
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Philip Sturgeon
 * @license			http://philsturgeon.co.uk/code/dbad-license
 * @link			http://getsparks.org/packages/template/show
 */
class Template
{
	private $_module = '';
	private $_controller = '';
	private $_method = '';

	private $_theme = NULL;
	private $_theme_path = NULL;
	private $_layout = FALSE; // By default, dont wrap the view with anything
	private $_layout_subdir = ''; // Layouts and partials will exist in views/layouts
	// but can be set to views/foo/layouts with a subdirectory

	private $_title = '';
	private $_metadata = array();

	private $_js = array();
	private $_css = array();

	private $_partials = array();
	
	private $_layout_folder = 'layouts/';
	private $_partial_folder = 'partials/';

	private $_breadcrumbs = array();

	private $_title_separator = ' | ';

	private $_parser_enabled = TRUE;
	private $_parser_body_enabled = FALSE;
	private $_lexparser;
	private $_callback_helpers = FALSE;

	private $_theme_locations = array();
	private $_asset_locations = array();

	private $_is_mobile = FALSE;

	// Minutes that cache will be alive for
	private $cache_lifetime = 0;

	private $_ci;

	private $_data = array();

	private $supported_files = array('md');
	private $fields = array();

	/**
	 * Constructor - Sets Preferences
	 *
	 * The constructor can be passed an array of config values
	 */
	function __construct($config = array())
	{
		$this->_ci =& get_instance();

		if ( ! empty($config))
		{
			$this->initialize($config);
		}

		if($this->_parser_enabled){
			$this->_lexparser = new Lex\Parser();
		}

		log_message('debug', 'Template Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if ($key == 'theme' AND $val != '')
			{
				$this->set_theme($val);
				continue;
			}

			$this->{'_'.$key} = $val;
		}

		// No locations set in config?
		if ($this->_theme_locations === array())
		{
			// Let's use this obvious default
			$this->_theme_locations = array(WWW_FOLDER.'public/themes/');
		}

		// No asset locations set in config?
		if ($this->_asset_locations === array())
		{
			// Let's use this obvious default
			$this->_asset_locations = array(APPPATH.'views/');
		}
		
		// Theme was set
		if ($this->_theme)
		{
			$this->set_theme($this->_theme);
		}

		// If the parse is going to be used, best make sure it's loaded
		if ($this->_parser_enabled === TRUE)
		{
			$this->_ci->load->library('parser');
		}

		// Modular Separation / Modular Extensions has been detected
		if (method_exists( $this->_ci->router, 'fetch_module' ))
		{
			$this->_module 	= $this->_ci->router->fetch_module();
		}

		// What controllers or methods are in use
		$this->_controller	= $this->_ci->router->fetch_class();
		$this->_method 		= $this->_ci->router->fetch_method();

		// Load user agent library if not loaded
		// $this->_ci->load->library('user_agent');

		// We'll want to know this later
		// $this->_is_mobile	= $this->_ci->agent->is_mobile();
	}

	// --------------------------------------------------------------------

	/**
	 * Magic Get function to get data
	 *
	 * @access	public
	 * @param	  string
	 * @return	mixed
	 */
	public function __get($name)
	{
		return isset($this->_data[$name]) ? $this->_data[$name] : NULL;
	}

	// --------------------------------------------------------------------

	/**
	 * Magic Set function to set data
	 *
	 * @access	public
	 * @param	  string
	 * @return	mixed
	 */
	public function __set($name, $value)
	{
		$this->_data[$name] = $value;
	}

	// --------------------------------------------------------------------

	/**
	 * Set data using a chainable metod. Provide two strings or an array of data.
	 *
	 * @access	public
	 * @param	  string
	 * @return	mixed
	 */
	public function set($name, $value = NULL)
	{
		// Lots of things! Set them all
		if (is_array($name) OR is_object($name))
		{
			foreach ($name as $item => $value)
			{
				$this->_data[$item] = $value;
			}
		}

		// Just one thing, set that
		else
		{
			$this->_data[$name] = $value;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Build the entire HTML output combining partials, layouts and views.
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function view($view, $data = array(), $return = FALSE)
	{
		// Set whatever values are given. These will be available to all view files
		is_array($data) OR $data = (array) $data;

		// Merge in what we already have with the specific data
		$this->_data = array_merge($this->_data, $data);

		// We don't need you any more buddy
		unset($data);

		if (empty($this->_title))
		{
			$this->_title = $this->_guess_title();
		}

		// Output template variables to the template
		$template['title']       = $this->_title;
		$template['breadcrumbs'] = $this->_breadcrumbs;
		$template['metadata']    = implode("\n\t\t", $this->_metadata);
		$template['js']          = implode("\n\t\t", $this->_js);
		$template['css']         = implode("\n\t\t", $this->_css);
		$template['partials']    = array();

		// Assign by reference, as all loaded views will need access to partials
		$this->_data['template'] =& $template;


		foreach ($this->_partials as $name => $partial)
		{
			// We can only work with data arrays
			is_array($partial['data']) OR $partial['data'] = (array) $partial['data'];

			// If it uses a view, load it
			if (isset($partial['view']))
			{
				$template['partials'][$name] = $this->_find_view($partial['view'], $partial['data'], FALSE);
			}

			// Otherwise the partial must be a string
			else
			{
				if ($this->_parser_enabled === TRUE)
				{
					// $partial['string'] = $this->_lexparser->parse($partial['string'], $this->_data + $partial['data'], array($this, '_lex_callback'));
					$partial['string'] = $partial['string'];
				}

				$template['partials'][$name] = $partial['string'];
			}
		}

		// Disable sodding IE7's constant cacheing!!
		$this->_ci->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->_ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->_ci->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->_ci->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$this->_ci->output->set_header('Pragma: no-cache');

		// Let CI do the caching instead of the browser
		$this->_ci->output->cache($this->cache_lifetime);

		// Test to see if this file
		$this->_body = $this->_find_view($view, array(), $this->_parser_body_enabled);

		// Want this file wrapped with a layout file?
		if ($this->_layout)
		{
			// Added to $this->_data['template'] by refference
			$template['body'] = $this->_body;

			// Find the main body and 3rd param means parse if its a theme view (only if parser is enabled)
			$this->_body =  self::_load_view($this->_layout_folder.$this->_layout, $this->_data, FALSE, self::_find_view_folder());
		}

		// Want it returned or output to browser?
		if ( ! $return)
		{
			$this->_ci->output->set_output($this->_body);
		}

		return $this->_body;
	}
	
	/**
	 * Build the entire HTML output of markdown content
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function view_content($view, $data = array(), $return = FALSE)
	{
		// Set whatever values are given. These will be available to all view files
		is_array($data) OR $data = (array) $data;

		// Merge in what we already have with the specific data
		$this->_data = array_merge($this->_data, $data);

		// We don't need you any more buddy
		unset($data);

		if (empty($this->_title))
		{
			$this->_title = $this->_guess_title();
		}
		
		// Output template variables to the template
		$template['title']       = $this->_title;
		$template['breadcrumbs'] = $this->_breadcrumbs;
		$template['metadata']    = implode("\n\t\t", $this->_metadata);
		$template['js']          = implode("\n\t\t", $this->_js);
		$template['css']         = implode("\n\t\t", $this->_css);
		$template['partials']    = array();

		// Assign by reference, as all loaded views will need access to partials
		$this->_data['template'] =& $template;

		// Disable sodding IE7's constant cacheing!!
		$this->_ci->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->_ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->_ci->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->_ci->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$this->_ci->output->set_header('Pragma: no-cache');

		// Let CI do the caching instead of the browser
		$this->_ci->output->cache($this->cache_lifetime);

		// Test to see if this file
		$this->_body = $this->_find_content($view, $this->_data, $this->_parser_body_enabled);

		// Want this file wrapped with a layout file?
		if ($this->_layout)
		{
			// Added to $this->_data['template'] by refference
			$template['body'] = $this->_body;

			// Find the main body and 3rd param means parse if its a theme view (only if parser is enabled)
			$this->_body =  self::_load_view($this->_layout_folder.$this->_layout, $this->_data, $this->_parser_enabled, self::_find_view_folder());
		}

		// Want it returned or output to browser?
		if ( ! $return)
		{
			$this->_ci->output->set_output($this->_body);
		}

		return $this->_body;
	}

	/**
	 * Build the entire HTML output combining partials, layouts and views.
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function view_block($blockname, $data = array(), $return = FALSE)
	{
		// Set whatever values are given. These will be available to all view files
		is_array($data) OR $data = (array) $data;

		// Merge in what we already have with the specific data
		$this->_data = array_merge($this->_data, $data);

		// We don't need you any more buddy
		unset($data);

		if (empty($this->_title))
		{
			$this->_title = $this->_guess_title();
		}

		// Output template variables to the template
		$template['title']       = $this->_title;
		$template['breadcrumbs'] = $this->_breadcrumbs;
		$template['metadata']    = implode("\n\t\t", $this->_metadata);
		$template['js']          = implode("\n\t\t", $this->_js);
		$template['css']         = implode("\n\t\t", $this->_css);
		$template['partials']    = array();

		// Assign by reference, as all loaded views will need access to partials
		$this->_data['template'] =& $template;

		// Disable sodding IE7's constant cacheing!!
		$this->_ci->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->_ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->_ci->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->_ci->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$this->_ci->output->set_header('Pragma: no-cache');

		// Let CI do the caching instead of the browser
		$this->_ci->output->cache($this->cache_lifetime);

		if(! file_exists(SITE_PATH.'content/blocks/'.$blockname.'.html'))
			show_404();

		// Test to see if this file
		$this->_body = file_get_contents(SITE_PATH.'content/blocks/'.$blockname.'.html');

		// Want this file wrapped with a layout file?
		if ($this->_layout)
		{
			// Added to $this->_data['template'] by refference
			$template['body'] = $this->_body;

			// Find the main body and 3rd param means parse if its a theme view (only if parser is enabled)
			$this->_body =  self::_load_view($this->_layout_folder.$this->_layout, $this->_data, FALSE, self::_find_view_folder());
		}

		// Want it returned or output to browser?
		if ( ! $return)
		{
			$this->_ci->output->set_output($this->_body);
		}

		return $this->_body;
	}

	/**
	 * Set the title of the page
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	public function title()
	{
		// If we have some segments passed
		if (func_num_args() >= 1)
		{
			$title_segments = func_get_args();
			$this->_title = implode($this->_title_separator, $title_segments);
		}

		return $this;
	}


	/**
	 * Put extra javascipt, css, meta tags, etc before all other head data
	 *
	 * @access	public
	 * @param	 string	$line	The line being added to head
	 * @return	void
	 */
	public function prepend_metadata($line)
	{
		array_unshift($this->_metadata, $line);
		return $this;
	}


	/**
	 * Put extra javascipt, css, meta tags, etc after other head data
	 *
	 * @access	public
	 * @param	 string	$line	The line being added to head
	 * @return	void
	 */
	public function append_metadata($line)
	{
		$this->_metadata[] = $line;
		return $this;
	}


	/**
	 * Set metadata for output later
	 *
	 * @access	public
	 * @param	  string	$name		keywords, description, etc
	 * @param	  string	$content	The content of meta data
	 * @param	  string	$type		Meta-data comes in a few types, links for example
	 * @return	void
	 */
	public function set_metadata($name, $content, $type = 'meta')
	{
		$name = htmlspecialchars(strip_tags($name));
		$content = htmlspecialchars(strip_tags($content));

		// Keywords with no comments? ARG! comment them
		if ($name == 'keywords' AND ! strpos($content, ','))
		{
			$content = preg_replace('/[\s]+/', ', ', trim($content));
		}

		switch($type)
		{
			case 'meta':
			$this->_metadata[$name] = '<meta name="'.$name.'" content="'.$content.'" />';
			break;

			case 'link':
			$this->_metadata[$content] = '<link rel="'.$name.'" href="'.$content.'" />';
			break;
		}

		return $this;
	}

	/**
	 * Set js for output later
	 *
	 * @access	public
	 * @param	  string	$js		jquery.js from theme | files::script.js from files module 
	 * @return	void
	 */
	public function set_js($file)
	{
		$part = explode("::", $file);

		if(isset($part[1]))
			switch($part[0]){
				case 'plugins':
				$url = base_url().'plugins/'.$part[1]; break;
				default:
				$url = $this->module->module_asset_location($part[0], '/assets/js/'.$part[1]); break;
			}
			else
				$url = base_url().$this->_theme_path.'assets/js/'.$part[0];

			$this->_js[$file] = '<script src="'.$url.'"></script>';

			return $this;
		}

	/**
	 * Set css for output later
	 *
	 * @access	publics
	 * @param	  string	$file		style.css from theme | files::style.css from files module
	 * @param	  string	$media		both, screen, print
	 * @return	void
	 */
	public function set_css($file, $media = 'both')
	{
		$part = explode("::", $file);

		if(isset($part[1]))
			switch($part[0]){
				case 'plugins':
				$url = base_url().'plugins/'.$part[1]; break;
				default:
				$url = $this->module->module_asset_location($part[0], '/assets/css/'.$part[1]); break;
			}
			else
				$url = base_url().$this->_theme_path.'assets/css/'.$part[0];

			$this->_css[$file] = '<link rel="stylesheet" type="text/css" href="'.$url.'"'.(($media != 'both')? ' media="'.$media.'"': '').' />';

			return $this;
		}


	/**
	 * Which theme are we using here?
	 *
	 * @access	public
	 * @param	string	$theme	Set a theme for the template library to use
	 * @return	void
	 */
	public function set_theme($theme = NULL)
	{
		$this->_theme = $theme;
		foreach ($this->_theme_locations as $location)
		{
			if ($this->_theme AND file_exists($location.$this->_theme))
			{
				$this->_theme_path = rtrim($location.$this->_theme.'/');
				break;
			}
		}

		return $this;
	}

	/**
	 * Get the current theme
	 *
	 * @access public
	 * @return string	The current theme
	 */
	public function get_theme()
	{
		return $this->_theme;
	}

	/**
	 * Get the current theme path
	 *
	 * @access	public
	 * @return	string The current theme path
	 */
	public function get_theme_path($theme = false)
	{
		if(! $theme)
			return $this->_theme_path;
		else 
		{
			$path = false;

			foreach ($this->_theme_locations as $location)
			{
				if ($this->_theme AND file_exists($location.$theme))
				{
					$path = rtrim($location.$theme.'/');
					break;
				}
			}

			return $path;
		}
	}

	/**
	 * Get the current theme path
	 *
	 * @access	public
	 * @return	string The current theme path
	 */
	public function get_asset_locations()
	{
		return $this->_asset_locations;
	}


	/**
	 * Which theme layout should we using here?
	 *
	 * @access	public
	 * @param	string	$view
	 * @return	void
	 */
	public function set_layout($view, $_layout_subdir = '')
	{
		$this->_layout = $view;

		$_layout_subdir AND $this->_layout_subdir = $_layout_subdir;

		return $this;
	}

	/* Which is layout placed?
	 *
	 * @access	public
	 * @param	string	$view
	 * @return	void
	 */
	public function set_layout_folder($folder = 'layouts')
	{
		$this->_layout_folder = !empty($folder) ? $folder.'/' : '';

		return $this;
	}

	/* Which is partial placed?
	 *
	 * @access	public
	 * @param	string	$view
	 * @return	void
	 */
	public function set_partial_folder($folder = '')
	{
		$this->_partial_folder = !empty($folder) ? $folder.'/' : '';

		return $this;
	}

	/**
	 * Set a view partial
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	boolean
	 * @return	void
	 */
	public function set_partial($name, $view, $data = array())
	{
		$this->_partials[$name] = array('view' => $this->_partial_folder.$view, 'data' => $data);
		return $this;
	}

	/**
	 * Set a view partial
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	boolean
	 * @return	void
	 */
	public function inject_partial($name, $string, $data = array())
	{
		$this->_partials[$name] = array('string' => $string, 'data' => $data);
		return $this;
	}


	/**
	 * Helps build custom breadcrumb trails
	 *
	 * @access	public
	 * @param	string	$name		What will appear as the link text
	 * @param	string	$url_ref	The URL segment
	 * @return	void
	 */
	public function set_breadcrumb($name, $uri = '')
	{
		$this->_breadcrumbs[] = array('name' => $name, 'uri' => $uri );
		return $this;
	}

	/**
	 * Set a the cache lifetime
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	boolean
	 * @return	void
	 */
	public function set_cache($minutes = 0)
	{
		$this->cache_lifetime = $minutes;
		return $this;
	}


	/**
	 * enable_parser
	 * Should be parser be used or the view files just loaded normally?
	 *
	 * @access	public
	 * @param	 string	$view
	 * @return	void
	 */
	public function enable_parser($bool)
	{
		$this->_parser_enabled = $bool;
		return $this;
	}

	/**
	 * enable_parser_body
	 * Should be parser be used or the body view files just loaded normally?
	 *
	 * @access	public
	 * @param	 string	$view
	 * @return	void
	 */
	public function enable_parser_body($bool)
	{
		$this->_parser_body_enabled = $bool;
		return $this;
	}

	/**
	 * theme_locations
	 * List the locations where themes may be stored
	 *
	 * @access	public
	 * @param	 string	$view
	 * @return	array
	 */
	public function theme_locations()
	{
		return $this->_theme_locations;
	}

	/**
	 * add_theme_location
	 * Set another location for themes to be looked in
	 *
	 * @access	public
	 * @param	 string	$view
	 * @return	array
	 */
	public function add_theme_location($location)
	{
		$this->_theme_locations[] = $location;
	}

	/**
	 * theme_exists
	 * Check if a theme exists
	 *
	 * @access	public
	 * @param	 string	$view
	 * @return	array
	 */
	public function theme_exists($theme = NULL)
	{
		$theme OR $theme = $this->_theme;

		foreach ($this->_theme_locations as $location)
		{
			if (is_dir($location.$theme))
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * get_layouts
	 * Get all current layouts (if using a theme you'll get a list of theme layouts)
	 *
	 * @access	public
	 * @param	 string	$view
	 * @return	array
	 */
	public function get_layouts($theme = false)
	{
		$layouts = array();

		foreach(glob(self::_find_view_folder($theme).$this->_layout_folder.'*.*') as $layout)
		{
			$layouts[] = pathinfo($layout, PATHINFO_BASENAME);
		}

		return $layouts;
	}


	/**
	 * get_layouts
	 * Get all current layouts (if using a theme you'll get a list of theme layouts)
	 *
	 * @access	public
	 * @param	 string	$view
	 * @return	array
	 */
	public function get_theme_layouts($theme = NULL)
	{
		$theme OR $theme = $this->_theme;

		$layouts = array();

		foreach ($this->_theme_locations as $location)
		{
			// Get special web layouts
			if( is_dir($location.$theme.'/views/web/'.$this->_layout_folder) )
			{
				foreach(glob($location.$theme . '/views/web/'.$this->_layout_folder.'*.*') as $layout)
				{
					$layouts[] = pathinfo($layout, PATHINFO_BASENAME);
				}
				break;
			}

			// So there are no web layouts, assume all layouts are web layouts
			if(is_dir($location.$theme.'/views/'.$this->_layout_folder))
			{
				foreach(glob($location.$theme . '/views/'.$this->_layout_folder.'*.*') as $layout)
				{
					$layouts[] = pathinfo($layout, PATHINFO_BASENAME);
				}
				break;
			}
		}

		return $layouts;
	}

	/**
	 * layout_exists
	 * Check if a theme layout exists
	 *
	 * @access	public
	 * @param	 string	$view
	 * @return	array
	 */
	public function layout_exists($layout)
	{
		// If there is a theme, check it exists in there
		if ( ! empty($this->_theme) AND in_array($layout, self::get_theme_layouts()))
		{
			return TRUE;
		}

		// Otherwise look in the normal places
		return file_exists(self::_find_view_folder().$this->_layout_folder . $layout . self::_ext($layout));
	}

	// get page fields
	function get_fields($field = false){
		if($field)
			return isset($this->fields[$field]) ? $this->fields[$field] : "";

		return $this->fields;
	}

	/**
	 * load_view
	 * Load views from theme paths if they exist.
	 *
	 * @access	public
	 * @param	string	$view
	 * @param	mixed	$data
	 * @return	array
	 */
	public function load_view($view, $data = array(), $parse = FALSE)
	{
		return $this->_find_view($view, (array)$data, $parse);
	}

	// find layout files, they could be mobile or web
	private function _find_view_folder($theme = false)
	{
		if ($this->_ci->load->get_var('template_views'))
		{
			return $this->_ci->load->get_var('template_views');
		}

		// Base view folder
		$view_folder = APPPATH.'views/';

		if(!$theme){	
			// Using a theme? Put the theme path in before the view folder
			if ( ! empty($this->_theme))
			{
				$view_folder = $this->_theme_path.'views/';
			}
		} else {
			// this used only to get view folder with specified theme
			foreach ($this->_theme_locations as $location)
			{
				if (file_exists($location.$theme))
				{
					$view_folder = rtrim($location.$theme.'/').'views/';
					break;
				}
			}
		}

		// Would they like the mobile version?
		if ($this->_is_mobile === TRUE AND is_dir($view_folder.'mobile/'))
		{
			// Use mobile as the base location for views
			$view_folder .= 'mobile/';
		}

		// Use the web version
		else if (is_dir($view_folder.'web/'))
		{
			$view_folder .= 'web/';
		}

		// Things like views/admin/web/view admin = subdir
		if ($this->_layout_subdir)
		{
			$view_folder .= $this->_layout_subdir.'/';
		}

		// If using themes store this for later, available to all views
		// otherwise we only want to get list of layouts
		if(! $theme)
			$this->_ci->load->vars('template_views', $view_folder);
		
		return $view_folder;
	}

	// A module view file can be overriden in a theme
	private function _find_view($view, array $data, $parse_view = FALSE)
	{
		// Only bother looking in themes if there is a theme
		if ( ! empty($this->_theme))
		{
			foreach ($this->_theme_locations as $location)
			{
				$theme_views = array(
					$this->_theme . '/views/modules/' . $this->_module . '/' . $view,
					$this->_theme . '/views/' . $view
					);

				foreach ($theme_views as $theme_view)
				{
					if (file_exists($location . $theme_view . self::_ext($theme_view)))
					{
						return self::_load_view($theme_view, $this->_data + $data, $parse_view, $location);
					}
				}
			}
		}

		// Not found it yet? Just load, its either in the module or root view
		return self::_load_view($view, $this->_data + $data, $parse_view);
	}

	private function _load_view($view, array $data, $parse_view = FALSE, $override_view_path = NULL)
	{
		// Sevear hackery to load views from custom places AND maintain compatibility with Modular Extensions
		if ($override_view_path !== NULL)
		{
			if ($this->_parser_enabled === TRUE AND $parse_view === TRUE)
			{
				$this->_ci->load->vars($data);

				// Load it directly, bypassing $this->load->view() as ME resets _ci_view
				$content = $this->_ci->load->file($override_view_path.$view.self::_ext($view), TRUE);

				// parse content
				$content = $this->_lexparser->parse($content, $data, array($this, '_lex_callback'));
			}

			else
			{
				$this->_ci->load->vars($data);
				
				// Load it directly, bypassing $this->load->view() as ME resets _ci_view
				$content = $this->_ci->load->file(
					$override_view_path.$view.self::_ext($view),
					TRUE
					);
			}
		}

		// Can just run as usual
		else
		{
			// Grab the content of the view (parsed or loaded)
			$content = ($this->_parser_enabled === TRUE AND $parse_view === TRUE)

				// Parse that bad boy
			? $this->_lexparser->parse($this->_ci->load->view($view, $data, true), $data, array($this, '_lex_callback'))

				// None of that fancy stuff for me!
			: $this->_ci->load->view($view, $data, TRUE);
		}

		return $content;
	}

	// search content file
	private function _find_content($view, $data = array(), $parse_view = TRUE)
	{
		$file_ext = NULL;

		// check if the view has extension
		$file_elems = array_slice(explode('.', $view), 0, 2);

		if(count($file_elems) == 2)
		{
			$file_ext = $file_elems[1];
			$file_path = $view;
		}
		else
		{
			foreach ($this->supported_files as $ext)
			{
				if (file_exists($view . '.' . $ext))
				{
					$file_ext = $ext;
					$file_path = $view . '.' . $ext;
					break;
				}
			}

			// if not found, probably because it is a folder, not file
			if(! $file_ext)
			{
				foreach ($this->supported_files as $ext)
				{
					if(file_exists($view . '/index.' . $ext))
					{
						$file_ext = $ext;
						$file_path = $view . '/index.' . $ext;
						break;
					}
				}
			}
		}

		// if still not found
		if(! $file_ext)
			show_404();

		return self::_load_content($file_path, $file_ext, $data, $parse_view);
	}

	private function _load_content($view, $ext, $data = array(), $parse_view = TRUE)
	{
		$file = file_get_contents($view);

		$content_part = explode("{:", $file);
		array_shift($content_part);

		// if user set fields
		if(count($content_part) > 1){
			foreach ($content_part as $elm) {
				$segs = preg_split("/( :} | :}|:} |:})/", $elm, 2);

				if($this->_ci->session->userdata(SITE_SLUG.'_role') != 'admin'){
					if(trim($segs[0]) == 'role'){
						$roles = preg_split("/(\s,\s|\s,|,\s|,|\n)/", $segs[1]);
						if(! in_array($this->_ci->session->userdata(SITE_SLUG.'_role'), $roles)) show_404();
					}
				}

				if(trim($segs[0]) == 'title')
					$this->_ci->config->set_item('page_title', trim($segs[1]).' - '.$this->_ci->config->item('page_title'));

				// set meta to config
				if(in_array(trim($segs[0]), array('meta_description', 'author')))
					$this->_ci->config->set_item(trim($segs[0]), trim($segs[1]));
				if(in_array(trim($segs[0]), array('meta_keywords')))
					$this->_ci->config->set_item(trim($segs[0]), trim($segs[1]) . ', '.$this->_ci->config->item('meta_keywords'));

				if(trim($segs[0]) == 'layout')
					$this->set_layout(trim($segs[1]));

				elseif(trim($segs[0]) == 'content'){
					// parse content first with lex parser
					if ($this->_parser_enabled === TRUE AND $parse_view === TRUE)
						$content = $this->_lexparser->parse(trim($segs[1]), $data, array($this, '_lex_callback'));

					$Parsedown = new Parsedown();
					$content = $Parsedown->setBreaksEnabled(true)->text($content);
				
				} else
					$this->fields[trim($segs[0])] = trim($segs[1]);
			}
		} else {
			// parse content first with lex parser
			if ($this->_parser_enabled === TRUE AND $parse_view === TRUE)
				$content = $this->_lexparser->parse($file, $data, array($this, '_lex_callback'));

			$Parsedown = new Parsedown();
			$content = $Parsedown->setBreaksEnabled(true)->text($content);
		}

		return $content;
	}

	private function _guess_title()
	{
		$this->_ci->load->helper('inflector');

		// Obviously no title, lets get making one
		$title_parts = array();

		// If the method is something other than index, use that
		if ($this->_method != 'index')
		{
			$title_parts[] = $this->_method;
		}

		// Make sure controller name is not the same as the method name
		if ( ! in_array($this->_controller, $title_parts))
		{
			$title_parts[] = $this->_controller;
		}

		// Is there a module? Make sure it is not named the same as the method or controller
		if ( ! empty($this->_module) AND ! in_array($this->_module, $title_parts))
		{
			$title_parts[] = $this->_module;
		}

		// Glue the title pieces together using the title separator setting
		$title = humanize(implode($this->_title_separator, $title_parts));

		return $title;
	}

	private function _ext($file)
	{
		return pathinfo($file, PATHINFO_EXTENSION) ? '' : '.php';
	}

	// callback function for lex parser
	// for this time, we use it for call helper only
	function _lex_callback($name, $attributes, $content)
	{
		$plugin_name = explode(".", $name);
		$return = '';

		if(count($plugin_name) >= 2){

			// callback from plugin first
			if(file_exists(PLUGIN_FOLDER.$plugin_name[0].'.php')){
				include_once PLUGIN_FOLDER.$plugin_name[0].'.php';
				$classname = $plugin_name[0].'_plugin';
				$plugin = new $classname();
				$data = call_user_func_array(array($plugin, $plugin_name[1]), $attributes);

				if(is_array($data))
					$return .= $this->_lexparser->parse($content, $data, array($this, '_lex_callback'));
				else
					$return .= $data;
			}

			// if system allows to callback from helpers function, do it
			if(empty($return) && $this->_callback_helpers){
				if($plugin_name[0] == 'func' && function_exists($plugin_name[1])){
					$data = call_user_func_array($plugin_name[1], $attributes);

					if(is_array($data))
						$return .= $this->_lexparser->parse($content, $data, array($this, '_lex_callback'));
					else
						$return .= $data;
				}
			}
		}

		return ($return)?$return:false;
	}

	// parse content from outside library
	function parse_content($content, $data = false)
	{
		return $this->_lexparser->parse($content, $data, array($this, '_lex_callback'));
	}

}

// END Template class