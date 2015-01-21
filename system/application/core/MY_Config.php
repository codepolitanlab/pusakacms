<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require APPPATH."libraries/MX/Config.php";

class MY_Config extends MX_Config 
{
	/**
	 * Site URL
	 * Returns base_url . index_page [. uri_string]
	 *
	 * @param	mixed	the URI string or an array of segments
	 * @return	string
	 */
	public function site_url($uri = '', $protocol = NULL)
	{
		$base_url = $this->slash_item('base_url');

		if (isset($protocol))
		{
			$base_url = $protocol.substr($base_url, strpos($base_url, '://'));
		}

		$site_slug = SITE_SLUG.'/';

		include APPPATH.'config/pusaka.php';
		$domain = $_SERVER['HTTP_HOST'];

		if($domain != $config['localhost_domain'] && $domain != $config['subsite_domain'])
			$site_slug = '';

		if (empty($uri))
		{
			return $base_url.$this->item('index_page').$site_slug;
		}

		$uri = $this->_uri_string($uri);

		if ($this->item('enable_query_strings') === FALSE)
		{
			$suffix = ($this->item('url_suffix') === FALSE) ? '' : $this->item('url_suffix');

			if ($suffix !== '' && ($offset = strpos($uri, '?')) !== FALSE)
			{
				$uri = substr($uri, 0, $offset).$suffix.substr($uri, $offset);
			}
			else
			{
				$uri .= $suffix;
			}

			return $base_url.$this->slash_item('index_page').$site_slug.$uri;
		}
		elseif (strpos($uri, '?') === FALSE)
		{
			$uri = '?'.$uri;
		}

		return $base_url.$this->item('index_page').$site_slug.$uri;
	}
}