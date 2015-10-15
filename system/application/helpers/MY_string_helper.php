<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('strposa'))
{
    function strposa($haystack, $needle, $offset=0) {
        if(!is_array($needle)) $needle = array($needle);
        foreach($needle as $query) {
            if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
        }
        return false;
    }
}

if (! function_exists('replace_pusaka_brackets'))
{
	function replace_pusaka_brackets($content)
	{
		return str_replace(array("{:", ":}"), array("&#123;:", ":&#125;"), $content);
	}
}