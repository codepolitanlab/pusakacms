<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	
	<header class="blog-header">
		<div class="nav-right">
			<a href="#" class="btn btn-primary">Contact</a>
		</div>
		<h1><a href="#"><?php echo site_config('site_name'); ?></a></h1>
		<div class="blog-desc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam</div>
	</header>

	<div class="container">		
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<?php if($label): ?>
				<h2>Post dengan label "<?php echo $label; ?>"</h2><hr>
				<?php endif; ?>
				
				<?php foreach ($posts['entries'] as $post): ?>
				<article class="the-content">
					<h2><?php echo anchor($post['url'], $post['title']); ?></h2>

					<span class="date"><i class="glyphicon glyphicon-calendar"></i> <?php echo date("d F Y", strtotime($post['date'])); ?></span>
					<span class="cat">
						<i class="glyphicon glyphicon-tags"></i> 
						<?php foreach ($post['labels'] as $post_label): ?>
							<span><?php echo anchor(POST_TERM.'/label/'.$post_label, $post_label); ?></span>
						<?php endforeach; ?>
					</span>
					<span class="comment-count"><i class="glyphicon glyphicon-comment"></i> <a href="<?php echo site_url($post['url'].'#disqus_thread'); ?>">Komentari</a></span>

					<div class="content">
						<?php echo $post['content']; ?>
					</div>
					
				</article>
				<?php endforeach; ?>

			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>


</body>
</html>