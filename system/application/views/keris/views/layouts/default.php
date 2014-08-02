<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header'); ?>

	<div class="container">		
		<div class="row">
			<div class="col-md-3 col-md-offset-1">
				<?php get_partial('sidebar'); ?>
			</div>
			<div class="col-md-7 the-content">
				<?php echo $template['body']; ?>
			</div>
		</div>
	</div>
	
	<?php get_partial('footer'); ?>
</body>
</html>