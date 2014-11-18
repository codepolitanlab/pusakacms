<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>

	<!-- MAIN WRAPPER -->
	<div class="main-wrapper" data-spy="scroll" data-target=".collapse">


		<!-- HEADER -->
		<header class="home-header">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-6">
						<div class="jumbo-lead">

							<h1 class="margin-lg-bottom">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</h1>

							<a href="#" class="btn btn-default btn-lg">Download</a>

						</div>
					</div>
				</div>
			</div>
		</header>
		<!-- END: HEADER -->


		<!-- MAIN CONTENT -->
		<div class="home-content">
			<div class="container">
				<?php echo $template['body']; ?>
			</div>
		</div>
		<!-- END: MAIN CONTENT -->



		<footer class="home-footer text-center">
			<div class="container">
				Copyright &copy; Nyankod. Powered by PusakaCMS. All rights reserved. 
			</div>
		</div>


	</div>
	<!-- END: MAIN WRAPPER -->


	<!-- JavaScript -->
	<script src="<?php echo get_theme_url() ?>/assets/js/jquery.min.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/classie.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/script.js"></script>
</body>
</html>