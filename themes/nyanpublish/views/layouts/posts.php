<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header'); ?>

	<div class="container">		
		<div class="row">
			<div class="col-md-9">
				
				<?php foreach ($posts as $post): ?>
				<article class="the-content">
					<h1><?php echo anchor($post['url'], $post['title']); ?></h1>

					<span class="date">Diposkan hari Senin, 20 Jan 2014</span>
					<span class="cat">
						tags: 
						<?php foreach ($post['labels'] as $label): ?>
							<span><?php echo anchor(POST_TERM.'/label/'.$label, $label); ?></span>
						<?php endforeach; ?>
					</span>

					<div class="content">
						<?php echo $post['content']; ?>
					</div>
					
				</article>
				<?php endforeach; ?>

			</div>

			<div class="col-md-3">
				
			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>
</body>
</html>