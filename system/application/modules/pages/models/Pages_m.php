<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_m extends MY_Model {

	function save_page($page)
	{
		$file_content = "";

		// set content
		foreach ($page as $key => $value) {
			if($value){
				$value = replace_pusaka_brackets($value);
				
				if($key == 'slug')
					$file_content .= "{: ".$key." :} ".strtolower(url_title($value))."\n";
				else
					$file_content .= "{: ".$key." :} ".$value."\n";
			}
		}

			// if it is placed as subpage
		if(!empty($page['parent'])) { 
				// if parent still as standalone file (not in folder)
			if(file_exists(PAGE_FOLDER.$page['parent'].'.md')) {
					// create folder and move the parent inside
				mkdir(PAGE_FOLDER.$page['parent'], 0775);
				rename(PAGE_FOLDER.$page['parent'].'.md', PAGE_FOLDER.$page['parent'].'/index.md');

					// create index.html file
				copy(PAGE_FOLDER.'index.html', PAGE_FOLDER.$page['parent'].'/index.html');
			}
		}

		if(write_file(PAGE_FOLDER.$page['parent'].'/'.$page['slug'].'.md', $file_content))
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

		// set content
		foreach ($page as $key => $value) {
			if($value){
				$value = replace_pusaka_brackets($value);
				
				if($key == 'slug')
					$file_content .= "{: ".$key." :} ".strtolower(url_title($value))."\n";
				else
					$file_content .= "{: ".$key." :} ".$value."\n";
			}
		}

		// move page
		$this->pusaka->move_page($prevpage['slug'], $page['slug'], $prevpage['parent'], $parent);

		if(! file_exists(PAGE_FOLDER.$parent.'/'.$page['slug'].'.md'))
			$page['slug'] .= '/index';

		// update page content
		if(write_file(PAGE_FOLDER.$parent.'/'.$page['slug'].'.md', $file_content, 'w+'))
		{
			$this->pusaka->sync_page();
			return true;
		} else {
			return false;
		}
	}

}