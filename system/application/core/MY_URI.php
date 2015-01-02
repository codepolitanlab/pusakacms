<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_URI extends CI_URI {

	/**
	 * Detects the URI
	 *
	 * This function will detect the URI automatically
	 * and fix the query string if necessary.
	 * 
	 * this is extension for multisite
	 *
	 * @return	string
	 */
	protected function _detect_uri()
	{
		if ( ! isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']))
		{
			return '';
		}

		include APPPATH.'config/pusaka.php';
		
		$domain = $_SERVER['HTTP_HOST'];

		// if it's localhost, then make uri begin from segment 2
		if($domain == $config['localhost_domain']){
			
			if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) === 0)
			{
				$uri = substr($_SERVER['REQUEST_URI'], strlen($_SERVER['SCRIPT_NAME'].'/'.SITE_SLUG));
			}
			elseif (strpos($_SERVER['REQUEST_URI'], dirname($_SERVER['SCRIPT_NAME'])) === 0)
			{
				$uri = substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['SCRIPT_NAME']).'/'.SITE_SLUG.'/'));
			}
			else
			{
				$uri = $_SERVER['REQUEST_URI'].'/'.SITE_SLUG;
			}

		}

		// if subfolder base multisite chosen
		elseif($domain == $config['subsite_domain']){

			if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) === 0)
			{
				$uri = substr($_SERVER['REQUEST_URI'], strlen($_SERVER['SCRIPT_NAME'].'/'.SITE_SLUG));
			}
			elseif (strpos($_SERVER['REQUEST_URI'], dirname($_SERVER['SCRIPT_NAME'])) === 0)
			{
				$uri = substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['SCRIPT_NAME']).'/'.SITE_SLUG));
			}
			else
			{
				$uri = $_SERVER['REQUEST_URI'].'/'.SITE_SLUG;
			}

		} else {
			if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) === 0)
			{
				$uri = substr($_SERVER['REQUEST_URI'], strlen($_SERVER['SCRIPT_NAME']));
			}
			elseif (strpos($_SERVER['REQUEST_URI'], dirname($_SERVER['SCRIPT_NAME'])) === 0)
			{
				$uri = substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['SCRIPT_NAME'])));
			}
			else
			{
				$uri = $_SERVER['REQUEST_URI'];
			}
		}

		// This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
		// URI is found, and also fixes the QUERY_STRING server var and $_GET array.
		if (strpos($uri, '?/') === 0)
		{
			$uri = substr($uri, 2);
		}

		$parts = explode('?', $uri, 2);
		$uri = $parts[0];
		if (isset($parts[1]))
		{
			$_SERVER['QUERY_STRING'] = $parts[1];
			parse_str($_SERVER['QUERY_STRING'], $_GET);
		}
		else
		{
			$_SERVER['QUERY_STRING'] = '';
			$_GET = array();
		}

		if ($uri === '/' OR empty($uri))
		{
			return '/';
		}

		$uri = parse_url('pseudo://hostname/'.$uri, PHP_URL_PATH);

		// Do some final cleaning of the URI and return it
		return str_replace(array('//', '../'), '/', trim($uri, '/'));
	}
}