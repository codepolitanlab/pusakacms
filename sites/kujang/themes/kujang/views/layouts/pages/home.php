<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>

	<div class="main-wrapper" data-spy="scroll" data-target=".collapse">
		<?php echo $template['body']; ?>
	</div>

	<script src="<?php echo get_theme_url() ?>/assets/js/jquery.min.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/classie.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/script.js"></script>
</body>
</html>