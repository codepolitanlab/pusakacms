<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	
	<?php get_partial('header'); ?>


	<div class="blog-content">
		<div class="container">		
			<div class="row">
				<div class="col-md-10 col-md-offset-1">

					<?php if($label): ?>
					<h2>Post dengan label "<?php echo $label; ?>"</h2><hr>
					<?php endif; ?>
					
					<?php foreach ($posts['entries'] as $post): ?>
					<article class="the-content">
						<h2><?php echo anchor($post['url'], $post['title']); ?></h2>

						<span class="date"><?php echo date("d F Y", strtotime($post['date'])); ?></span>
						<span class="cat">
							<?php foreach ($post['labels'] as $post_label): ?>
								<span><?php echo anchor(POST_TERM.'/label/'.$post_label, $post_label); ?></span>
							<?php endforeach; ?>
						</span>

						<div class="content">
							<?php echo $post['content']; ?>
						</div>
						
					</article>
					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>


</body>
</html>