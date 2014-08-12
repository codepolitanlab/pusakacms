<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header'); ?>

	<div class="container">		
		<div class="row">
			<div class="col-md-12">
				<?php print_r($posts); ?>
			</div>
		</div>
	</div>

	<?php get_partial('footer'); ?>
</body>
</html>