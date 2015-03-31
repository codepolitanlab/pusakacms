<!DOCTYPE html>
<html lang="en"> 
<head>
	<?php get_partial('metadata'); ?>
</head>
<body class="panel-dashboard-wrapper">
	<?php get_partial('header'); ?>
	<div class="container">
		<div class="row wrapper">
			<div class="col-md-12">		
				<div class="content">
					<?php get_partial('alerts'); ?>
					
					<?php echo $template['body']; ?>
				</div>
			</div>
		</div>
	</div>

	<?php get_partial('scripts'); ?>
</body>
</html>