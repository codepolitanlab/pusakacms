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
			{site_url}
			</div>
		</div>
	</div>{current_url}

	<?php get_partial('footer'); ?>
</body>
</html>