<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Get nav area
* 
* @param String $area 	nav area
* @return Array links in $area file
*/
if ( ! function_exists('get_nav'))
{
	function get_nav($area = false){
		if(!$area) return "hohoho";

		if(file_exists(NAV_FOLDER.$area.'.json'))
			return $area = json_decode(file_get_contents(NAV_FOLDER.$area.'.json'), true);

		return false;
	}
}

if ( ! function_exists('generate_pagenav'))
{
	function generate_pagenav($page = false, $options = array())
	{
		$ci = &get_instance();
		return $ci->pusaka->generate_nav($page, $options);
	}
}


if ( ! function_exists('generate_nav'))
{
	function generate_nav($area = false, $options = array())
	{
		if(!$area) return false;

		if(is_string($area))
			$data = get_nav($area);
		else
			$data = $area;

		$default = array(
			'depth' => 3,
			'li_class' => '',
			'li_attr' => '',
			'a_class' => '',
			'a_attr' => '',
			'has_children_li_class' => '',
			'has_children_li_attr' => '',
			'has_children_a_class' => 'dropdown-toggle',
			'has_children_a_attr' => 'data-toggle="dropdown" role="button"',
			'active_class' => 'active',
			'ul_children_class' => 'dropdown-menu',
			'ul_children_attr' => 'role="menu"'
		);

		$opt = array_merge($default, $options);

		$navstring = '';

		foreach ($data as $link) {
			// $active = uri_string() == $link['url'] ? ' '.$opt['active_class'] : '';
			$active = strstr('/'.uri_string(), '/'.$link['url']) ? ' '.$opt['active_class'] : '';
			
			$has_children_li_class = '';
			$has_children_a_attr = '';
			$has_children_li_attr = '';
			$has_children_a_attr = '';

			if(isset($link['children'])){
				$has_children_li_class = ' '.$opt['has_children_li_class'];
				$has_children_a_attr = ' '.$opt['has_children_a_class'];
				$has_children_li_attr = ' '.$opt['has_children_li_attr'];
				$has_children_a_attr = ' '.$opt['has_children_a_attr'];
			}
			
			$url = $link['source'] == 'uri' ? site_url($link['url']) : $link['source'].$link['url'];

			$navstring .= '<li class="'.$opt['li_class'].$has_children_li_class.$active.'" '.$opt['li_attr'].$has_children_li_attr.'>';
			$navstring .= '<a class="'.$opt['a_class'].$has_children_a_attr.$active.'" '.$opt['a_attr'].$has_children_a_attr.' href="'.$url.'" target="'.$link['target'].'">'.$link['title'].'</a>';
			if(isset($link['children'])){
				$navstring .= '<ul class="'.$opt['ul_children_class'].'" '.$opt['ul_children_attr'].'>';
				$navstring .= generate_nav($link['children'], $opt);
				$navstring .= '</ul>';
			}
			$navstring .= '</li>';
		}

		return $navstring;
	}
}