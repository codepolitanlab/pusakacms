<div class="row heading">
	<div class="col-md-6">
		<h1>POSTS</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/posts/sync"><span class="fa fa-refresh"></span> Sync Posts</a>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/posts/new"><span class="fa fa-plus-circle"></span> Create new posts</a>
		</div>
	</div>
</div>

<?php if($posts['total'] > 0): ?>
<ul class="content-list nav">
	<?php foreach ($posts['entries'] as $post): ?>
	<li>
		<div class="list-desc">
			<h3><a><?php echo $post['title']; ?></a></h3>
			<small><a href="<?php echo site_url($post['url']); ?>" target="_blank"><span class="fa fa-external-link"></span> <?php echo site_url($post['url']); ?></a></small>
			<div class="labels">
				<?php foreach ($post['labels'] as $label): ?>
					<a href="<?php echo site_url('panel/posts/'.$label); ?>"><label class="label label-success"><?php echo $label; ?></label></a>
				<?php endforeach; ?>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="option">
						<a href="#"><span class="fa fa-calendar"></span> <?php echo date("F d, Y", strtotime($post['date'])); ?></a>
					</div>
				</div>
				<div class="col-md-6 align-right">
					<div class="option">
						<a href="<?php echo site_url('panel/posts/edit?post='.$post['url']); ?>" class="edit"><span class="fa fa-edit"></span> Edit</a>
						<a href="<?php echo site_url('panel/posts/delete?post='.$post['file']); ?>" class="remove"><span class="fa fa-times"></span> Delete</a>
					</div>
				</div>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>