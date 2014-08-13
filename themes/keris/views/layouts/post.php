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

				<article class="the-content">
					<h1><?php echo $post['title']; ?></h1>

					<div class="content">
						<?php echo $post['content']; ?>
					</div>

					<div class="cat">
						tags: 
						<?php foreach ($post['labels'] as $label): ?>
							<span class="label label-info"><?php echo anchor(POST_TERM.'/label/'.$label, $label); ?></span>
						<?php endforeach; ?>
					</div>
				</article>

			</div>
			<div class="col-md-3">
				
			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>
</body>
</html>