<?php
if(! empty($pages)):
foreach($pages as $uri => $content):
if($uri != '_title'): ?>
<li>
	<div class="list-desc">
		<h3>
			<span style="color:#ddd;font-size:23px"><span class="fa fa-align-justify"></span></span>
			<?php echo $content['_title']; ?>
		</h3>
		<small><a href="<?php echo site_url($uri); ?>" target="_blank"><span class="fa fa-external-link"></span> <?php echo site_url($uri); ?></a></small>
		<div class="row">
			<div class="col-md-6">
				<div class="option">
					<?php if(count($content) > 1): ?>
						<a href="#" class="expand"><span class="fa fa-caret-right"></span> Expand</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-6 align-right">			
				<div class="option">
					<a href="<?php echo site_url('panel/pages/edit?page='.$uri); ?>" class="edit"><span class="fa fa-edit"></span> Edit</a>
					<a href="<?php echo site_url('panel/pages/new?parent='.$uri); ?>" class="add"><span class="fa fa-plus"></span> Create subpage</a>
					<a href="<?php echo site_url('panel/pages/delete?page='.$uri); ?>" class="remove"><span class="fa fa-times"></span> Delete</a>
				</div>
			</div>
		</div>
	</div>
	<?php if(count($content) > 1): ?>
		<ul class="nav children">
			<?php echo Modules::run('panel/_page_list', $content); ?>
		</ul>
	<?php endif; ?>
</li>
<?php endif; endforeach; endif; ?>