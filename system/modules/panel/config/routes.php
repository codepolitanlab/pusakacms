<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['panel/pages/new']	= "panel/new_page";
$route['panel/pages/edit/(:any)']	= "panel/edit_page/$1";
$route['panel/pages/delete/(:any)']	= "panel/delete_page/$1";

$route['panel/posts/new']	= "panel/new_post";
$route['panel/posts/edit/(:any)']	= "panel/edit_post/$1";
$route['panel/posts/delete/(:any)']	= "panel/delete_post/$1";

$route['panel/users/new']	= "panel/new_user";
$route['panel/users/edit/(:any)']	= "panel/edit_user/$1";
$route['panel/users/delete/(:any)']	= "panel/delete_user/$1";

$route['panel/login']	= "auth/login";
$route['panel/logout']	= "auth/logout";