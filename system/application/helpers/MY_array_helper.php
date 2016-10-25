<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('debug_array'))
{
    function debug_r($array) { 
        echo '<pre style="font-size:12px;">';
        print_r($array);
        echo '</pre>';
    }
}