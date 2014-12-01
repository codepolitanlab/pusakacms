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

					<div class="content-wrapper">

						<?php if($label): ?>
						<h2>Post dengan label "<?php echo $label; ?>"</h2><hr>
						<?php endif; ?>
						
						<?php if(isset($posts['entries']) && !empty($posts['entries'])): ?>

							<?php foreach ($posts['entries'] as $post): ?>
							<article class="the-content">
								<h2><?php echo anchor($post['url'], $post['title']); ?></h2>

								<span class="date"><?php echo date("d F Y", strtotime($post['date'])); ?></span>
								
								<?php if(isset($post['labels'])): ?>	
									<span class="cat">
										<?php foreach ($post['labels'] as $postlabel): ?>
											<span><?php echo anchor(POST_TERM.'/label/'.$postlabel, $postlabel); ?></span>
										<?php endforeach; ?>
									</span>
								<?php endif; ?>

								<div class="content">
									<?php echo $post['intro']; ?>
								</div>
								
							</article>
							<?php endforeach; ?>

						<?php else: ?>

							<article>
								<p>No article here Jou..</p>
							</article>

						<?php endif; ?>

					</div>



					<ul class="pagination">
						<?php echo $this->pusaka->post_pagination($posts['total'], $label); ?>
					</ul>


				</div>
			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>


</body>
</html>