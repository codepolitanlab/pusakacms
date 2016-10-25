<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_m extends MY_Model {

	function save_page($page)
	{
		$page_content = $page['content'];
		unset($page['content']);

		$slug = url_title($page['slug'], '-', true);
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

		// if it is placed as subpage
		// if(!empty($page['parent'])) { 
		// 	// if parent still as standalone file (not in folder)
		// 	if(file_exists(PAGE_FOLDER.$page['parent'].'.md')) {
		// 			// create folder and move the parent inside
		// 		mkdir(PAGE_FOLDER.$page['parent'], 0775);
		// 		rename(PAGE_FOLDER.$page['parent'].'.md', PAGE_FOLDER.$page['parent'].'/index.md');

		// 			// create index.html file
		// 		copy(PAGE_FOLDER.'index.html', PAGE_FOLDER.$page['parent'].'/index.html');
		// 	}
		// }

		if(write_file(PAGE_FOLDER.$slug.'.md', $file_content))
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

		$slug = url_title($page['slug'], '-', true);
		unset($page['slug']);

		$page_content = $page['content'];
		unset($page['content']);

		// set page fields
		foreach ($page as $key => $value) {
			if($value){
				$file_content .= $key.": ".$value."\n";
			}
		}
		// add content separator
		$file_content .= "---\n";
		$file_content .= $page_content;

		// move page
		$this->pusaka->move_page($prevpage['slug'], $slug, $prevpage['parent'], $parent);

		// if file not existed, then it must be in its folder
		if(! file_exists(PAGE_FOLDER.$parent.'/'.$slug.'.md'))
			$slug .= '/index';

		// update page content
		if(write_file(PAGE_FOLDER.$parent.'/'.$slug.'.md', $file_content, 'w+'))
		{
			$this->pusaka->sync_page();
			return true;
		} else {
			return false;
		}
	}

}