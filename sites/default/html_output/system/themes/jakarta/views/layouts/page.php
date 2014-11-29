<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header'); ?>

	<div class="blog-content blog-detail">
		<div class="container">		
			<div class="row">
				<div class="col-md-10 col-md-offset-1">

					<article class="the-content">
						<h1><?php echo get_field('title'); ?></h1>
						
						<?php echo $template['body']; ?>
					</article>

				</div>
			
			</div>
		</div>
	</div>
	
	<?php get_partial('footer'); ?>
</body>
</html>