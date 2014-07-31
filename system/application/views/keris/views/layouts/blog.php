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
				<?php echo $template['body']; ?>
			</div>
			<div class="col-md-4">
				<?php get_partial('sidebar'); ?>
			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>
</body>
</html>