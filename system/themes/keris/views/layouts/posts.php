<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header_blog'); ?>

	<div class="container">		
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<?php if($label): ?>
					<h1>Post dengan label "<?php echo $label; ?>"</h1><hr>
				<?php endif; ?>
				
				<div class="content-wrapper">
					<?php if(isset($posts['entries']) && !empty($posts['entries'])): ?>
						
						<?php foreach ($posts['entries'] as $post): ?>
							<article class="the-content">
								<h1><?php echo anchor($post['url'], $post['title']); ?></h1>

								<span class="date"><i class="glyphicon glyphicon-calendar"></i> <?php echo date("d F Y", strtotime($post['date'])); ?></span>
								<span class="cat">
									<i class="glyphicon glyphicon-tags"></i>
									<?php foreach ($post['labels'] as $label): ?>
										<span><?php echo anchor(POST_TERM.'/label/'.$label, $label); ?></span>
									<?php endforeach; ?>
								</span>

								<div class="content">
									<?php echo $post['content']; ?>
								</div>

							</article>
						<?php endforeach; ?>
					
					<?php else: ?>
						<article>
							<p>Belum ada posting.</p>
						</article>
					<?php endif; ?>
				</div>

					<ul class="pagination">
						<?php echo $this->pusaka->pagination($posts['total'], $label); ?>
					</ul>

				</div>

				<!--<div class="col-md-3">
					<?php /*get_partial('post_sidebar'); */ ?>
				</div>-->
			</div>
		</div>


		<div class="footer-link text-center">
			<a href="#">Doc</a> <a href="#">Github</a> <a href="#">Fork</a> 
		</div>
		<?php get_partial('footer'); ?>
	</body>
	</html>