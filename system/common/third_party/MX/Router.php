<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/third_party/MX/Router.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Router extends CI_Router
{
	public $module;
	
	public function fetch_module() 
	{
		return $this->module;
	}
	
	public function _validate_request($segments) 
	{
		$segments = parent::_validate_request($segments);
	
		if ( ! empty($segments) && empty($this->directory))
		{
			/* locate module controller */
			if ($located = $this->locate($segments)) 
			{
				return $located;
			}
			
			/* set the 404_override controller module path */
			$this->_set_module_path($this->routes['404_override']);
		}
		
		return $segments;
	}
	
	public function _set_default_controller()
	{ 	
		if (empty($this->directory))
		{ 
			/* set the default controller module path */
			$this->_set_module_path($this->default_controller);
		}

		parent::_set_default_controller();
	}
	
	/** Locate the controller **/
	public function locate($segments) 
	{
		$ext = $this->config->item('controller_suffix').EXT;
		
		/* use module route if available */
		if (isset($segments[0]) && $routes = Modules::parse_routes($segments[0], implode('/', $segments)))
		{
			$segments = $routes;
		}
	
		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);

		/* check modules */
		foreach (Modules::$locations as $location => $offset) 
		{
			/* module exists? */
			if (is_dir($source = $location.$module.'/controllers/')) 
			{
				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';

				/* module sub-controller exists? */
				if($directory && is_file($source.ucfirst($directory).$ext)) 
				{
					return array_slice($segments, 1);
				}
					
				/* module sub-directory exists? */
				if($directory && is_dir($source.$directory.'/')) 
				{
					$source .= $directory.'/'; 
					$this->directory .= $directory.'/';

					/* module sub-directory controller exists? */
					if($controller && is_file($source.ucfirst($controller).$ext))	
					{
						return array_slice($segments, 2);
					}
				}
	 			
				/* module controller exists? */			
				if(is_file($source.ucfirst($module).$ext)) 
				{
					return $segments;
				}
			}
		}
		
		/* application controller exists? */			
		if (is_file(APPPATH.'controllers/'.ucfirst($module).$ext)) 
		{
			return $segments;
		}
        
		/* application sub-directory controller exists? */
		if($directory && is_file(APPPATH.'controllers/'.$module.'/'.ucfirst($directory).$ext)) 
		{
			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}

		/* application sub-sub-directory controller exists? */
		if($directory && $controller && 
			is_file(APPPATH.'controllers/'.$module.'/'.$directory.'/'.ucfirst($controller).$ext)) 
		{
			$this->directory = $module.'/'.$directory.'/';
			return array_slice($segments, 2);
		}
	}

	/* set module path */
	public function _set_module_path(&$_route)
	{
		if ( ! empty($_route))
		{
			// Are module/controller/method segments being specified?
			$sgs = sscanf($_route, '%[^/]/%[^/]/%s', $module, $class, $method);
		
			// set the module/controller directory location if found
			if ($this->locate(array($module, $class)))
			{
				//reset to class/method 
				switch ($sgs)
				{
					case 1:	$_route = $module.'/index';
							return;
					case 2: $_route = $module.'/'.$class;
							return;
					case 3: $_route = $class.'/'.$method;
							return;
				}
			}
		}
	}

	public function set_class($class) 
	{   
		$class = $class.$this->config->item('controller_suffix');
		parent::set_class($class);
	}
}