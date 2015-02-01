<div class="clearfix">
	<a href="#" class="close"><span class="fui-cross-inverted"></span></a>
	<?php if( $data['data']['siteSettings_ftpPath'] != "/" ):?>
		
		<?php
			$temp = explode("/", $data['data']['siteSettings_ftpPath']);
			
			array_pop($temp);
			
			$path = implode("/", $temp);
		?>
			
		<a href="<?php echo ( $path == '')? "/" : $path; ?>" class="back link"><span class="fui-arrow-left"></span> <?php echo $this->lang->line('ftplist_uponelevel')?></a>
	
	<?php endif;?>
</div>
<ul>
	<?php foreach($data['list'] as $item):?>
		
		<?php
			if( $item[0] != '.' ): //filter out hidden items
		?>
		
		<?php $path_parts= pathinfo($item);?>
		
		<?php if (isset($path_parts["extension"])):?>
			<li><a><span class="fui-document"></span>&nbsp; <?php echo $item;?></a></li>
		<?php else:?>
			<li><a href="<?php echo $item;?>" class="link"><span class="fui-folder"></span>&nbsp; <?php echo $item;?></a></li>
		<?php endif;?>
		
		<?php endif;?>
		
	<?php endforeach;?>
	
	<!--<li><a href="#" class="link"><span class="fui-folder"></span>&nbsp; Folder Two</a></li>
	<li><a href="#" class="link"><span class="fui-folder"></span>&nbsp; Folder Three</a></li>
	<li><a><span class="fui-document"></span>&nbsp; FileOne.html</a></li>
	<li><a><span class="fui-document"></span>&nbsp; FileTwo.html</a></li>
	<li><a><span class="fui-document"></span>&nbsp; FileThree.html</a></li>-->
</ul>