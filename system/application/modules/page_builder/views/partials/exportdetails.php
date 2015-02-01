<div class="optionPane export">
	
	<h6>Site Assets</h6>
	
	<?php foreach( $data['assetFolders'] as $folder ):?>
	<label class="checkbox" for="checkbox1">
		<input type="checkbox" value="<?php echo $folder;?>" id="" name="assetFolders[]" data-toggle="checkbox">
	  	<?php echo $folder;?>
	</label>
	<?php endforeach;?>
	
</div><!-- /.optionPane -->

<div class="optionPane export">
	
	<h6>Site Pages</h6>
	
	<?php foreach( $data['pages'] as $page ):?>
	<label class="checkbox" for="checkbox1">
		<input type="checkbox" value="<?php echo $page->pages_name;?>" id="" name="pages" data-toggle="checkbox">
	  	<?php echo $page->pages_name;?>
	</label>
	<?php endforeach;?>
	
</div><!-- /.optionPane -->