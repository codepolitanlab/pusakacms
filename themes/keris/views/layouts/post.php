<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header'); ?>

	<div class="container">		
		<div class="row">
			<div class="col-md-6 col-md-offset-1">
				<h1><?php echo $post['title']; ?></h1>

				<div class="content">
					<?php echo $post['content']; ?>
				</div>
				
				<div class="cat">
					tags: 
					<?php foreach ($post['categories'] as $category): ?>
						<span class="label label-info"><?php echo anchor(POST_TERM.'/label/'.$category, $category); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="col-md-4">
				
			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>
</body>
</html>