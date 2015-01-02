<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| localhost domain
|--------------------------------------------------------------------------
|
| Domain in localhost for checking it is in a localhost so 
| we can put site slug after it. Default to 'localhost'
|
*/
$config['localhost_domain'] = 'localhost';

/*
|--------------------------------------------------------------------------
| live domain
|--------------------------------------------------------------------------
|
| Domain in live server to enable subsite mode, example 'yoursite.com'.
| If it is set, your site domain will become http://yoursite.com/siteslug/
| and so your multisite.
| Default to false.
|
*/
$config['subsite_domain'] = false;

/*
|--------------------------------------------------------------------------
| post term
|--------------------------------------------------------------------------
|
| what term you want to use to represent post slug
|
*/
$config['post_term'] = 'blog';

/*
|--------------------------------------------------------------------------
| content folders
|--------------------------------------------------------------------------
|
| content folders path relatives to each site folder
|
*/
$config['page_folder'] = 'content/pages/';
$config['post_folder'] = 'content/posts/';
$config['label_folder'] = 'content/labels/';
$config['nav_folder'] = 'content/navs/';
