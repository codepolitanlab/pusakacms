<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header'); ?>

	<div class="container">		
		<div class="row">
			<div class="col-md-12 the-content">
				<h1><?php echo get_field('title'); ?></h1>
				
				<?php echo $template['body']; ?>
			</div>
		</div>
	</div>
	
	<?php get_partial('footer'); ?>
</body>
</html>