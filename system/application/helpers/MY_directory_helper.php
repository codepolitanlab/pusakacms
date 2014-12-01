<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('recurse_copy'))
{
    function recurse_copy($src,$dst) { 
        $dir = opendir($src);
        
        if(!file_exists($dst))
            mkdir($dst, 0755, true); 

        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    recurse_copy($src . '/' . $file, $dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file, $dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 
    }
}