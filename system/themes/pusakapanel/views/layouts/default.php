<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<div class="row wrapper">
		<div class="col-md-1 side-panel">
			<?php get_partial('header'); ?>
			<?php get_partial('sidebar'); ?>
		</div>
		<div class="col-md-11">
			<div class="content">
				<?php echo $template['body']; ?>
			</div>
		</div>
	</div>
</body>
</html>