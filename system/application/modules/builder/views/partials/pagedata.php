<form class="form-horizontal" role="form" id="pageSettingsForm" action="<?php echo site_url('sites/updatePageData')?>">

	<input type="hidden" name="siteID" id="siteID" value="<?php echo $siteData->sites_id?>">
	<input type="hidden" name="pageID" id="pageID" value="<?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_id; }?>">
	<input type="hidden" name="pageName" id="pageName" value="">
	
	<div class="optionPane">
						
		<div class="form-group">
			<label for="name" class="col-sm-3 control-label"><?php echo $this->lang->line('modal_pagesettings_pagetitle')?>:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="pageData_title" name="pageData_title" placeholder="Page title" value="<?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_title; }?>">
			</div>
		</div>
		
		<div class="form-group">
			<label for="name" class="col-sm-3 control-label"><?php echo $this->lang->line('modal_pagesettings_pagedescription')?>:</label>
			<div class="col-sm-9">
				<textarea class="form-control" id="pageData_metaDescription" name="pageData_metaDescription" placeholder="Page meta description"><?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_meta_description; }?></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label for="name" class="col-sm-3 control-label"><?php echo $this->lang->line('modal_pagesettings_pagekeywords')?>:</label>
			<div class="col-sm-9">
				<textarea class="form-control" id="pageData_metaKeywords" name="pageData_metaKeywords" placeholder="Page meta keywords"><?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_meta_keywords; }?></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label for="name" class="col-sm-3 control-label"><?php echo $this->lang->line('modal_pagesettings_pageheaderincludes')?>:</label>
			<div class="col-sm-9">
				<textarea class="form-control" id="pageData_headerIncludes" name="pageData_headerIncludes" rows="7" placeholder="Additional code you'd like to include in the <head> section"><?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_header_includes; }?></textarea>
			</div>
		</div>
		
	</div><!-- /.optionPane -->
	
</form>