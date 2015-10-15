<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header'); ?>

	<div class="container">		
		<div class="row">
			<div class="col-md-3">
				<div class="sidebar">
					<ul class="nav nav-pills nav-stacked">
						<?php echo $this->pusaka->generate_nav($this->uri->segment(1), array("depth" => 5, "li_class" => "list", "ul_children_class" => "nav nav-pills nav-stacked")); ?>
					</ul>
				</div>
			</div>
			<div class="col-md-9 the-content">
				<h1><?php echo get_field('title'); ?></h1>
				
				<?php echo $template['body']; ?>
			</div>
		</div>
	</div>
	
	<?php get_partial('footer'); ?>
</body>
</html>