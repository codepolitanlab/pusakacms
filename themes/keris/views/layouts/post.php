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
				<?php print_r($posts); ?>
			</div>
			<div class="col-md-4">
				
			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>
</body>
</html>