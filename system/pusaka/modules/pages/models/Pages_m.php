<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Symfony\Component\Yaml\Yaml;

class Pages_m extends MY_Model {

	function save_page($page)
	{
		$page_content = $page['content'];
		unset($page['content']);

		$page_slug = url_title($page['slug'], '-', true);
		unset($page['slug']);

		$file_content = "";

		// set page fields
		foreach ($page as $key => $value) {
			if($value){
				$file_content .= $key.": ".$value."\n";
			}
		}
		// add content separator
		$file_content .= "---\n";
		$file_content .= $page_content;

		if(write_file(PAGE_FOLDER.$page_slug.'.md', $file_content))
		{
			$this->pusaka->sync_page();
			return true;
		} else {
			return false;
		}
	}

	function update_page($page, $prevpage)
	{
		$file_content = "";

		// we don't want to save parent data
		$parent = $page['parent'];
		unset($page['parent']);

		// set page_slug for folder name
		$page_slug = url_title($page['slug'], '-', true);
		unset($page['slug']);

		// set page_content to be saved separated
		$page_content = $page['content'];
		unset($page['content']);

		// move page
		$this->pusaka->move_page($prevpage['slug'], $page_slug, $prevpage['parent'], $parent);

		// if file not existed, then it must be in its folder
		// if(! file_exists(PAGE_FOLDER.$parent.'/'.$page_slug.'.md'))
		// 	$page_slug .= '/index';

		// update page content
		if(! write_file(PAGE_FOLDER.$parent.'/'.$page_slug.'/content.md', $page_content, 'w+'))
		{
			error_log("Writing content.md failed on ". PAGE_FOLDER.$parent.'/'.$page_slug);
			return false;
		}

		// update page variables
		if(! write_file(PAGE_FOLDER.$parent.'/'.$page_slug.'/index.yml', Yaml::dump($page, 1), 'w+'))
		{
			error_log("Writing index.yml failed on ". PAGE_FOLDER.$parent.'/'.$page_slug);
			return false;
		}

		return $this->pusaka->sync_page();
	}

}